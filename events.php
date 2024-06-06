<?php
ob_start(); // Start output buffering
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}

include ('includes/header.php');

// Function to sanitize input data
function sanitizeInput($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectmanagement";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for adding an event
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {
        $title = sanitizeInput($_POST['title']);
        $description = sanitizeInput($_POST['description']);
        $start_datetime = sanitizeInput($_POST['start_datetime']);
        $end_datetime = sanitizeInput($_POST['end_datetime']);
        $location = sanitizeInput($_POST['location']);

        $insert_query = "INSERT INTO Events (title, description, start_datetime, end_datetime, location) VALUES ('$title', '$description', '$start_datetime', '$end_datetime', '$location')";

        if ($conn->query($insert_query) === TRUE) {
            $_SESSION['status'] = "Event added successfully";
        } else {
            $_SESSION['status'] = "Error: " . $insert_query . "<br>" . $conn->error;
        }

        header("Location: events.php");
        exit();
    }

    // Handle update event
    if ($_POST['action'] == 'update') {
        $event_id = intval($_POST['event_id']);
        $title = sanitizeInput($_POST['title']);
        $description = sanitizeInput($_POST['description']);
        $start_datetime = sanitizeInput($_POST['start_datetime']);
        $end_datetime = sanitizeInput($_POST['end_datetime']);
        $location = sanitizeInput($_POST['location']);

        $update_query = "UPDATE Events SET 
                            title='$title', 
                            description='$description', 
                            start_datetime='$start_datetime', 
                            end_datetime='$end_datetime', 
                            location='$location'
                        WHERE event_id=$event_id";

        if ($conn->query($update_query) === TRUE) {
            $_SESSION['status'] = "Event updated successfully";
        } else {
            $_SESSION['status'] = "Error updating event: " . $conn->error;
        }

        header("Location: events.php");
        exit();
    }

    // Handle delete event
    if ($_POST['action'] == 'delete') {
        $event_id = intval($_POST['event_id']);

        $delete_query = "DELETE FROM Events WHERE event_id = $event_id";

        if ($conn->query($delete_query) === TRUE) {
            $_SESSION['status'] = "Event deleted successfully";
        } else {
            $_SESSION['status'] = "Error: " . $delete_query . "<br>" . $conn->error;
        }

        header("Location: events.php");
        exit();
    }
}

// Fetch all events
$events_query = "SELECT * FROM Events ORDER BY start_datetime ASC";
$events_result = $conn->query($events_query);
?>
<div class="container  md-4">
    <div class="card shadow border border-0">
        <div class="row align-items-center mb-3">
            <div class="col">
                <h4 class="card-title">Our Events</h4>
            </div>
            <div class="col-auto ms-auto">
                <button type="button" class="btn btn-outline-info" data-bs-toggle="modal"
                    data-bs-target="#addEventModal">Add Event</button>
            </div>
        </div>

        <!-- Add Event Modal -->
        <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addEventModalLabel">Add Event</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="events.php">
                        <div class="modal-body">
                            <input type="hidden" name="action" value="add">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="title" name="title"
                                    placeholder="Event Title" required>
                                <label for="title">Event Title</label>
                            </div>
                            <div class="form-floating mb-3">
                                <textarea class="form-control" id="description" name="description"
                                    placeholder="Description" rows="3"></textarea>
                                <label for="description">Description</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="datetime-local" class="form-control" id="start_datetime"
                                    name="start_datetime" required>
                                <label for="start_datetime">Start Date & Time</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="datetime-local" class="form-control" id="end_datetime" name="end_datetime"
                                    required>
                                <label for="end_datetime">End Date & Time</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="location" name="location"
                                    placeholder="Location">
                                <label for="location">Location</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Event</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 mb-4">
        <?php while ($event = $events_result->fetch_assoc()): ?>
            <div class="col mb-4">
                <div class="card shadow border-0 h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"style="color: var(--primary-color);"><?php echo htmlspecialchars($event['title']); ?></h5>
                        <p class="card-text"style="color: var(--primary-color);"><?php echo htmlspecialchars($event['description']); ?></p>
                        <p class="small  mb-1" style="color: var(--secondary-color);">
                            <?php
                            // Format start and end dates
                            $start_date = date('M d', strtotime($event['start_datetime']));
                            $end_date = date('M d', strtotime($event['end_datetime']));
                            $date_display = ($start_date === $end_date) ? $start_date : "$start_date - $end_date";
                            echo htmlspecialchars($date_display);
                            ?>
                        </p>
                        <p class="small text-success mb-1"><?php echo htmlspecialchars($event['location']); ?></p>
                        <div class="mt-auto">
                            <div class="accordion accordion-flush" id="accordion<?php echo $event['event_id']; ?>">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading<?php echo $event['event_id']; ?>">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $event['event_id']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $event['event_id']; ?>">
                                            Actions
                                        </button>
                                    </h2>
                                    <div id="collapse<?php echo $event['event_id']; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $event['event_id']; ?>" data-bs-parent="#accordion<?php echo $event['event_id']; ?>">
                                        <div class="accordion-body">
                                            <div class="row w-100">
                                                <!-- Update Event Button -->
                                                <div class="col-12 mb-2">
                                                    <button type="button" class="btn btn-link text-success btn-sm w-100" data-bs-toggle="modal" data-bs-target="#updateEventModal<?php echo $event['event_id']; ?>">
                                                        <i class="bi bi-pencil-square" style="font-size: 20px;"></i> Edit
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row w-100">
                                                <!-- Delete Event Form -->
                                                <div class="col-12">
                                                    <form method="POST" action="events.php" class="d-inline w-100">
                                                        <input type="hidden" name="action" value="delete">
                                                        <input type="hidden" name="event_id" value="<?php echo $event['event_id']; ?>">
                                                        <button type="submit" class="btn btn-link text-danger btn-sm w-100">
                                                            <i class="bi bi-trash" style="font-size: 20px;"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
                        <!-- Update Event Modal -->
                        <div class="modal fade" id="updateEventModal<?php echo $event['event_id']; ?>" tabindex="-1"
                            aria-labelledby="updateEventModalLabel<?php echo $event['event_id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateEventModalLabel<?php echo $event['event_id']; ?>">
                                            Update Event</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form method="POST" action="events.php">
                                        <div class="modal-body">
                                            <input type="hidden" name="action" value="update">
                                            <input type="hidden" name="event_id" value="<?php echo $event['event_id']; ?>">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control"
                                                    id="title<?php echo $event['event_id']; ?>" name="title"
                                                    value="<?php echo htmlspecialchars($event['title']); ?>" required>
                                                <label for="title<?php echo $event['event_id']; ?>">Event Title</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <textarea class="form-control"
                                                    id="description<?php echo $event['event_id']; ?>" name="description"
                                                    rows="3"><?php echo htmlspecialchars($event['description']); ?></textarea>
                                                <label
                                                    for="description<?php echo $event['event_id']; ?>">Description</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="datetime-local" class="form-control"
                                                    id="start_datetime<?php echo $event['event_id']; ?>"
                                                    name="start_datetime"
                                                    value="<?php echo date('Y-m-d\TH:i', strtotime($event['start_datetime'])); ?>"
                                                    required>
                                                <label for="start_datetime<?php echo $event['event_id']; ?>">Start Date &
                                                    Time</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="datetime-local" class="form-control"
                                                    id="end_datetime<?php echo $event['event_id']; ?>" name="end_datetime"
                                                    value="<?php echo date('Y-m-d\TH:i', strtotime($event['end_datetime'])); ?>"
                                                    required>
                                                <label for="end_datetime<?php echo $event['event_id']; ?>">End Date &
                                                    Time</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control"
                                                    id="location<?php echo $event['event_id']; ?>" name="location"
                                                    value="<?php echo htmlspecialchars($event['location']); ?>"
                                                    placeholder="Location">
                                                <label for="location<?php echo $event['event_id']; ?>">Location</label>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Update Event</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>


        <?php include ('includes/footer.php');
        ob_end_flush(); // Flush output buffer and send content to browser
        ?>
        <style>
            @media (max-width: 575.98px) {
                .events-table tbody tr {
                    display: flex;
                    flex-direction: column;
                    align-items: flex-start;
                }

                .events-table tbody tr td {
                    width: 100%;
                    display: block;
                }

                .events-table tbody tr td button {
                    margin-bottom: 5px;
                    /* Adjust as needed */
                }
            }

            @media (min-width: 576px) {
                .events-table tbody tr td {
                    width: auto;
                    display: table-cell;
                }
            }
        </style>