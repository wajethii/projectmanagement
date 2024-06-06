<?php
session_start();

// Check if the form is submitted for deleting user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_client_btn'])) {
    // Retrieve user ID from form data
    $client_id = $_POST['delete_client_btn'];

    // Delete user from the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projectmanagement";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $delete_query = "DELETE FROM Clients WHERE client_id = $client_id";

    if ($conn->query($delete_query) === TRUE) {
        $_SESSION['status'] = "Client deleted successfully!";
    } else {
        $_SESSION['status'] = "Error: Client not deleted.";
    }

    $conn->close();
    header("Location: clients.php");
    exit();
}

// Function to sanitize input data
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if client_id is provided, indicating an update operation
    if (isset($_POST['client_id'])) {
        // Get and sanitize input data
        $client_id = $_POST['client_id'];
        $name = sanitizeInput($_POST['name']);
        $contact_info = sanitizeInput($_POST['contact_info']);
        $services_required = sanitizeInput($_POST['services_required']);
        $projected_completion_date = sanitizeInput($_POST['projected_completion_date']);
        $amount_charged = sanitizeInput($_POST['amount_charged']);
        $status = sanitizeInput($_POST['status']);

        // Upload image
        $image_path = '';
        if ($_FILES['image']['size'] > 0) {
            // Code to upload image
        }

        // Upload PDF document
        $pdf_path = '';
        if ($_FILES['pdf']['size'] > 0) {
            // Code to upload PDF document
        }

        // Update the client in the database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "projectmanagement";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $update_query = "UPDATE Clients SET 
                            name='$name', 
                            contact_info='$contact_info', 
                            services_required='$services_required', 
                            projected_completion_date='$projected_completion_date', 
                            amount_charged='$amount_charged', 
                            image='$image_path', 
                            pdf='$pdf', 
                            status='$status' 
                        WHERE client_id=$client_id";

        if ($conn->query($update_query) === TRUE) {
            $_SESSION['status'] = "Client updated successfully";
        } else {
            $_SESSION['status'] = "Error updating client: " . $conn->error;
        }

        $conn->close();
        header("Location: clients.php");
        exit();
    } else {
        // Assuming it's an insertion operation

        // Check if all fields are provided
        if (
            isset($_POST['name']) && isset($_POST['contact_info']) && isset($_POST['services_required']) &&
            isset($_POST['projected_completion_date']) && isset($_POST['amount_charged']) && isset($_POST['status'])
        ) {
            // Get and sanitize input data
            $name = sanitizeInput($_POST['name']);
            $contact_info = sanitizeInput($_POST['contact_info']);
            $services_required = sanitizeInput($_POST['services_required']);
            $projected_completion_date = sanitizeInput($_POST['projected_completion_date']);
            $amount_charged = sanitizeInput($_POST['amount_charged']);
            $status = sanitizeInput($_POST['status']);

            // Upload image
            $image_path = '';
            if ($_FILES['image']['size'] > 0) {
                // Code to upload image
            }

            // Upload PDF document
            $pdf_path = '';
            if ($_FILES['pdf']['size'] > 0) {
                // Code to upload PDF document
            }

            // Insert the client into the database
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "projectmanagement";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $insert_query = "INSERT INTO Clients (name, contact_info, services_required, projected_completion_date, amount_charged, image, pdf, status) VALUES ('$name', '$contact_info', '$services_required', '$projected_completion_date', '$amount_charged', '$image', '$pdf', '$status')";

            if ($conn->query($insert_query) === TRUE) {
                $_SESSION['status'] = "Client added successfully";
                $conn->close();
                header("Location: clients.php");
                exit();
            } else {
                $_SESSION['status'] = "Error: " . $insert_query . "<br>" . $conn->error;
                $conn->close();
                header("Location: clients.php");
                exit();
            }
        } else {
            $_SESSION['status'] = "All fields are required";
            header("Location: clients.php");
            exit();
        }
    }
}
