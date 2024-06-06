<?php
include 'dbcon.php';
session_start();

// Function to sanitize input data
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Check if the form is submitted for deleting a technician
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_tech_btn'])) {
    // Retrieve technician ID from form data
    $tech_id = sanitizeInput($_POST['delete_tech_btn']);

    // Delete technician from the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projectmanagement";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $delete_query = "DELETE FROM technicians WHERE tech_id = $tech_id";

    if ($conn->query($delete_query) === TRUE) {
        $_SESSION['status'] = "Technician info deleted successfully!";
    } else {
        $_SESSION['status'] = "Error: Technician info not deleted.";
    }

    $conn->close();
    header("Location: techs.php");
    exit();
}


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if tech_id is provided, indicating an update operation
    if (isset($_POST['tech_id'])) {
        // Get and sanitize input data
        $tech_id = $_POST['tech_id'];
        $full_name = sanitizeInput($_POST['full_name']);
        $department_id = sanitizeInput($_POST['department']);
        $overtime_hours = sanitizeInput($_POST['overtime_hours']);
        $wages = sanitizeInput($_POST['wages']);
        $contract_length = sanitizeInput($_POST['contract_length']);
        $status = sanitizeInput($_POST['status']);

        // Upload image
        $image = '';
        if ($_FILES['image']['size'] > 0) {
            $target_dir = "uploads";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = $target_file;
            } else {
                $_SESSION['status'] = "Error uploading image.";
                header("Location: techs.php");
                exit();
            }
        }

        // Upload PDF document
        $documents = '';
        if ($_FILES['documents']['size'] > 0) {
            $target_dir = "uploads";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . basename($_FILES["documents"]["name"]);
            if (move_uploaded_file($_FILES["documents"]["tmp_name"], $target_file)) {
                $documents = $target_file;
            } else {
                $_SESSION['status'] = "Error uploading document.";
                header("Location: techs.php");
                exit();
            }
        }

        // Update the technician in the database
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $update_query = "UPDATE technicians SET  
                            image='$image',
                            full_name='$full_name', 
                            department_id='$department_id', 
                            overtime_hours='$overtime_hours', 
                            wages='$wages', 
                            contract_length='$contract_length',
                            documents='$documents',  
                            status='$status' 
                        WHERE tech_id=$tech_id";

        if ($conn->query($update_query) === TRUE) {
            $_SESSION['status'] = "Technician updated successfully";
        } else {
            $_SESSION['status'] = "Error updating technician: " . $conn->error;
        }

        $conn->close();
        header("Location: techs.php");
        exit();
    } else {
        // Assuming it's an insertion operation

        // Check if all fields are provided
        if (
            isset($_POST['full_name']) && isset($_POST['department']) && isset($_POST['overtime_hours']) &&
            isset($_POST['wages']) && isset($_POST['contract_length']) && isset($_POST['status'])
        ) {
            // Get and sanitize input data
            $full_name = sanitizeInput($_POST['full_name']);
            $department_id = sanitizeInput($_POST['department']);
            $overtime_hours = sanitizeInput($_POST['overtime_hours']);
            $wages = sanitizeInput($_POST['wages']);
            $contract_length = sanitizeInput($_POST['contract_length']);
            $status = sanitizeInput($_POST['status']);

            // Upload image
            $image = '';
            if ($_FILES['image']['size'] > 0) {
                $target_dir = "uploads";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image = $target_file;
                } else {
                    $_SESSION['status'] = "Error uploading image.";
                    header("Location: techs.php");
                    exit();
                }
            }

            // Upload PDF document
            $documents = '';
            if ($_FILES['documents']['size'] > 0) {
                $target_dir = "uploads/documents/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $target_file = $target_dir . basename($_FILES["documents"]["name"]);
                if (move_uploaded_file($_FILES["documents"]["tmp_name"], $target_file)) {
                    $documents = $target_file;
                } else {
                    $_SESSION['status'] = "Error uploading document.";
                    header("Location: techs.php");
                    exit();
                }
            }

            // Insert the technician into the database
            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $insert_query = "INSERT INTO technicians (image, full_name, department_id, overtime_hours, wages, contract_length, documents, status) 
                             VALUES ('$image', '$full_name', $department_id, '$overtime_hours', '$wages', '$contract_length', '$documents', '$status')";

            if ($conn->query($insert_query) === TRUE) {
                $_SESSION['status'] = "Technician added successfully";
            } else {
                $_SESSION['status'] = "Error adding technician: " . $conn->error;
            }

            $conn->close();
            header("Location: techs.php");
            exit();
        } else {
            $_SESSION['status'] = "All fields are required";
            header("Location: techs.php");
            exit();
        }
    }
}
