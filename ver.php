<?php
session_start();

if (isset($_POST['login_btn'])) {
    require_once 'dbcon.php'; // Include your database connection file

    // Sanitize user inputs
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to check if the user exists with the provided email and password
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            // User exists, set session variables and redirect to dashboard.php
            $row = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            header('Location: dashboard.php');
            exit();
        } else {
            // User does not exist, show error message and redirect back to login.php
            $_SESSION['error_message'] = 'Incorrect email or password';
            header('Location: login.php');
            exit();
        }
    } else {
        // SQL query failed, show error message and redirect back to login.php
        $_SESSION['error_message'] = 'Error verifying user details';
        header('Location: login.php');
        exit();
    }
} else {
    // If login button was not pressed, redirect to login.php
    header('Location: login.php');
    exit();
}
?>
