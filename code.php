<?php
include 'dbcon.php';
session_start();

// Function to sanitize input data
function sanitizeInput($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

// Check if the form is submitted for registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register_btn'])) {
    // Get and sanitize input data
    $username = sanitizeInput($_POST['username']);
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);

    // Check if all fields are provided
    if (empty($username) || empty($email) || empty($password)) {
        $_SESSION['status'] = "All fields are required";
        header("Location: register.php"); // Redirect to registration page
        exit();
    }

    // Check if the username or email already exists
    $check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $check_result = mysqli_query($conn, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        $_SESSION['status'] = "Username or email already exists";
        header("Location: register.php"); // Redirect to registration page
        exit();
    }

    // Insert the new user into the database
    $insert_query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    if (mysqli_query($conn, $insert_query)) {
        $_SESSION['status'] = "Registration successful";
        header("Location: users.php"); // Redirect to users page
        exit();
    } else {
        $_SESSION['status'] = "Error: " . $insert_query . "<br>" . mysqli_error($conn);
        header("Location: register.php"); // Redirect to registration page
        exit();
    }
}
// Check if the form is submitted for deleting multiple users
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_selected_btn'])) {
    if (!empty($_POST['user_ids'])) {
        $user_ids = $_POST['user_ids'];
        foreach ($user_ids as $user_id) {
            $delete_query = "DELETE FROM users WHERE user_id = $user_id";
            if (!mysqli_query($conn, $delete_query)) {
                $_SESSION['status'] = "Error: Some users were not deleted.";
                header("Location: users.php");
                exit();
            }
        }
        $_SESSION['status'] = "Selected users deleted successfully!";
    } else {
        $_SESSION['status'] = "No users selected for deletion.";
    }

    header("Location: users.php"); // Redirect back to users page
    exit();
}

// Check if the form is submitted for updating user info
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_btn'])) {
    // Retrieve form data
    $user_id = sanitizeInput($_POST['user_id']);
    $username = sanitizeInput($_POST['username']);
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);

    // Check if the username or email already exists
    $check_query = "SELECT * FROM users WHERE (username='$username' OR email='$email') AND user_id != $user_id";
    $check_result = mysqli_query($conn, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        // Username or email already exists
        $_SESSION['status'] = '<div class="alert alert-danger" role="alert">Username or email already exists</div>';
        mysqli_close($conn);
        header("Location: users.php");
        exit();
    }
// Update user data in the database
$update_query = "UPDATE users SET username='$username', email='$email', password='$password' WHERE user_id=$user_id"; // Removed hashing of password
if (mysqli_query($conn, $update_query)) {
    // Changes saved successfully
    $_SESSION['status'] = '<div class="alert alert-success" role="alert">Changes saved successfully!</div>';
} else {
    // Error occurred while saving changes
    $_SESSION['status'] = '<div class="alert alert-danger" role="alert">Error: Changes not saved.</div>';
}

// Close database connection
mysqli_close($conn);

// Redirect back to users.php
header("Location: users.php");
exit();
}

