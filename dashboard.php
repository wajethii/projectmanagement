<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}

include ('includes/header.php');



// Database connection
$servername = "localhost";
$username = "root";
$db_password = ""; // Your database password
$dbname = "projectmanagement";

$conn = new mysqli($servername, $username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total clients
$totalClientsQuery = "SELECT COUNT(*) as total_clients FROM clients";
$totalClientsResult = $conn->query($totalClientsQuery);
$totalClients = $totalClientsResult->fetch_assoc()['total_clients'];

// Fetch total technicians
$totalTechniciansQuery = "SELECT COUNT(*) as total_technicians FROM technicians";
$totalTechniciansResult = $conn->query($totalTechniciansQuery);
$totalTechnicians = $totalTechniciansResult->fetch_assoc()['total_technicians'];

// Fetch total projects in progress (assuming the 'clients' table has a 'status' column for services)
$totalProjectsQuery = "SELECT COUNT(*) as total_projects FROM clients WHERE status = 'work in progress'";
$totalProjectsResult = $conn->query($totalProjectsQuery);
$totalProjects = $totalProjectsResult->fetch_assoc()['total_projects'];

// Fetch total amount charged
$totalAmountQuery = "SELECT SUM(amount_charged) as total_amount_charged FROM clients";
$totalAmountResult = $conn->query($totalAmountQuery);
$totalAmountCharged = $totalAmountResult->fetch_assoc()['total_amount_charged'];

// Fetch clients data
$clientsQuery = "SELECT * FROM clients";
$clientsResult = $conn->query($clientsQuery);
$clients = [];
if ($clientsResult->num_rows > 0) {
    while ($row = $clientsResult->fetch_assoc()) {
        $clients[] = $row;
    }
}
// Fetch events data
$eventQuery = "SELECT * FROM events";
$eventResult = $conn->query($eventQuery);
$events = [];

if ($eventResult->num_rows > 0) {
    while ($row = $eventResult->fetch_assoc()) {
        $events[] = $row;
    }
}

// Function to truncate text
function truncate_text($text, $max_length, $suffix = '...')
{
    if (strlen($text) > $max_length) {
        $text = substr($text, 0, $max_length - strlen($suffix)) . $suffix;
    }
    return $text;
}
// Fetch previous totals for percentage calculation (example values)
$prevTotalClients = 550; // Replace with actual previous total
$prevTotalTechnicians = 18; // Replace with actual previous total
$prevTotalProjects = 580; // Replace with actual previous total
$prevTotalAmountCharged = 550000; // Replace with actual previous total

// Calculate percentage increase
$clientIncrease = (($totalClients - $prevTotalClients) / $prevTotalClients) * 100;
$technicianIncrease = (($totalTechnicians - $prevTotalTechnicians) / $prevTotalTechnicians) * 100;
$projectIncrease = (($totalProjects - $prevTotalProjects) / $prevTotalProjects) * 100;
$amountIncrease = (($totalAmountCharged - $prevTotalAmountCharged) / $prevTotalAmountCharged) * 100;

// Close connection
$conn->close();
?>
<style>
    .card-title-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-title-row h5 {
        margin: 0;
    }

    .card-title-row a {
        color: var(--secondary-color);
    }

    .event-card:hover {
        /* Add your hover effect styles here */
        transform: translateY(-5px);
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        margin-bottom: 20px;
        /* Adjust the margin as needed */
    }
</style>

<div class="container mt-2">
    
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
        <!-- Clients Card -->
        <div class="col">
            <a href="clients.php" class="card-linkk">
                <div class="card shadow border border-0">
                    <div class="card-body">
                        <div class="card-title-row mb-2 mt-2">
                            <h5 class="card-title" style="color: var(--primary-color);">Total Clients</h5>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-briefcase-fill" viewBox="0 0 16 16" style="color: var(--primary-color);">
                                <path
                                    d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5" />
                                <path
                                    d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85z" />
                            </svg>
                        </div>
                        <h4 class="card-text" style="color: var(--primary-color);"><?php echo $totalClients; ?></h4>
                        <p class="card-text text-success"><?php echo number_format($clientIncrease, 2); ?>% increase</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Technicians Card -->
        <div class="col">
            <a href="techs.php" class="card-linkk">
                <div class="card shadow border border-0">
                    <div class="card-body">
                        <div class="card-title-row mb-2 mt-2">
                            <h5 class="card-title" style="color: var(--primary-color);">Total Employees</h5>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-people-fill" viewBox="0 0 16 16" style="color: var(--primary-color);">
                                <path
                                    d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h5.216zM4 8A3 3 0 1 0 4 2a3 3 0 0 0 0 6" />
                            </svg>
                        </div>
                        <h4 class="card-text" style="color: var(--primary-color);"><?php echo $totalTechnicians; ?></h4>
                        <p class="card-text text-success"><?php echo number_format($technicianIncrease, 2); ?>% increase
                        </p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Projects Card -->
        <div class="col">
            <a href="projects.php" class="card-linkk">
                <div class="card shadow border border-0">
                    <div class="card-body">
                        <div class="card-title-row mb-2 mt-2">
                            <h5 class="card-title" style="color: var(--primary-color);">Work in Progress</h5>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-graph-up" viewBox="0 0 16 16" style="color: var(--primary-color);">
                                <path fill-rule="evenodd"
                                    d="M0 0h1v15h15v1H0V0zm13.5 3a.5.5 0 0 1 .5.5v10a.5.5 0 0 1-1 0v-10a.5.5 0 0 1 .5-.5zm-2 4a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0v-6a.5.5 0 0 1 .5-.5zm-2 3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5zm-2-3a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0v-6a.5.5 0 0 1 .5-.5zm-2 3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5zm-2-2a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0v-5a.5.5 0 0 1 .5-.5z" />
                                <path d="M10 7.5l3-3 2 2.5V3h-2L11 4.5 8.5 7 4 10.5 1.5 8 1 8.5l3 3L10 7.5z" />
                            </svg>
                        </div>
                        <h4 class="card-text" style="color: var(--primary-color);"><?php echo $totalProjects; ?></h4>
                        <p class="card-text text-success"><?php echo number_format($projectIncrease, 2); ?>% increase
                        </p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Amount Charged Card -->
        <div class="col">
            <a href="#" class="card-linkk">
                <div class="card shadow border border-0">
                    <div class="card-body">
                        <div class="card-title-row mb-2 mt-2">
                            <h5 class="card-title" style="color: var(--primary-color);">Payments</h5>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-paypal" viewBox="0 0 16 16" style="color: var(--primary-color);">
                                <path
                                    d="M14.06 3.713c.12-1.071-.093-1.832-.702-2.526C12.628.356 11.312 0 9.626 0H4.734a.7.7 0 0 0-.691.59L2.005 13.509a.42.42 0 0 0 .415.486h2.756l-.202 1.28a.628.628 0 0 0 .62.726H8.14c.429 0 .793-.31.862-.731l.025-.13.48-3.043.03-.164.001-.007a.35.35 0 0 1 .348-.297h.38c1.266 0 2.425-.256 3.345-.91q.57-.403.993-1.005a4.94 4.94 0 0 0 .88-2.195c.242-1.246.13-2.356-.57-3.154a2.7 2.7 0 0 0-.76-.59l-.094-.061ZM6.543 8.82a.7.7 0 0 1 .321-.079H8.3c2.82 0 5.027-1.144 5.672-4.456l.003-.016q.326.186.548.438c.546.623.679 1.535.45 2.71-.272 1.397-.866 2.307-1.663 2.874-.802.57-1.842.815-3.043.815h-.38a.87.87 0 0 0-.863.734l-.03.164-.48 3.043-.024.13-.001.004a.35.35 0 0 1-.348.296H5.595a.106.106 0 0 1-.105-.123l.208-1.32z" />
                            </svg>
                        </div>
                        <h4 class="card-text" style="color: var(--primary-color);">
                            <?php echo number_format($totalAmountCharged, 0, '.', ','); ?>
                        </h4>
                        <p class="card-text text-success"><?php echo number_format($amountIncrease, 2); ?>% increase</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Clients List Section -->
    <div class="row g-8 row-gap-3 text-start mt-4">
        <div class="col-sm-6 col-md-8">
            <div class="card shadow border border-0">
                <div class="card-body">
                    <div class="card-title-row mb-2 mt-2">
                        <h5>Our Clients</h5>
                        <a href="clients.php" style="color: var(--primary-color);">View all <i class="bi bi-arrow-right"
                                style="width: 16px; height: 16px; font-size: 16px;"></i></a>
                    </div>
                    <table class="table table-borderless client-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody style="vertical-align: middle; color: var(--primary-color);">
                            <?php foreach ($clients as $client): ?>
                                <tr onclick="location.href='#';">
                                    <td><img src="<?php echo $client['image']; ?>" width="40" height="40"
                                            class="client-image" alt="Client Image"></td>
                                    <td><?php echo htmlspecialchars($client['name']); ?></td>
                                    <td><?php echo htmlspecialchars($client['services_required']); ?></td>
                                    <td><?php echo htmlspecialchars($client['status']); ?></td>
                                    <td><?php echo htmlspecialchars($client['amount_charged']); ?></td>
                                    <td><?php echo htmlspecialchars($client['contact_info']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">

            <!-- Event Details Section -->
            <div class="card shadow border border-0 p-2">
                <div class="card-body">
                    <div class="card-title-row row-gap-3 mb-4">
                        <h5>Our Events</h5>
                        <a href="events.php" style="color: var(--primary-color);">View all <i class="bi bi-arrow-right"
                                style="width: 16px; height: 16px; font-size: 16px;"></i></a>
                    </div>
                    <?php foreach ($events as $event): ?>
                        <div class="event-card">
                            <h6><?php echo htmlspecialchars($event['title']); ?></h6>
                            <?php
                            // Format start and end dates
                            $start_date = date('M d', strtotime($event['start_datetime']));
                            $end_date = date('M d', strtotime($event['end_datetime']));
                            $start_time = date('H:i', strtotime($event['start_datetime']));
                            $end_time = date('H:i', strtotime($event['end_datetime']));

                            // Check if event starts and ends on the same day
                            $date_display = ($start_date === $end_date) ? $start_date : "$start_date-$end_date";

                            // Format footer with remaining time
                            $start_timestamp = strtotime($event['start_datetime']);
                            $end_timestamp = strtotime($event['end_datetime']);
                            $remaining_seconds = $end_timestamp - time();
                            $remaining_days = floor($remaining_seconds / (60 * 60 * 24));
                            $remaining_hours = floor(($remaining_seconds % (60 * 60 * 24)) / (60 * 60));
                            $remaining_minutes = floor(($remaining_seconds % (60 * 60)) / 60);
                            $remaining_time = '';
                            if ($remaining_days > 0) {
                                $remaining_time .= $remaining_days . ' day(s) ';
                            }
                            if ($remaining_hours > 0) {
                                $remaining_time .= $remaining_hours . 'hr ';
                            }
                            if ($remaining_minutes > 0) {
                                $remaining_time .= $remaining_minutes . 'min';
                            }

                            // Truncate description
                            $truncated_description = truncate_text($event['description'], 100); // Adjust the maximum length as needed
                            ?>
                            <p class="mb-1 text-success" style="font-size: 14px;"><?php echo htmlspecialchars($date_display); ?></p>
                            <p><?php echo htmlspecialchars($truncated_description); ?></p>
                            <footer class="blockquote-footer" style="font-size: 14px;">
                                <?php echo htmlspecialchars($remaining_time); ?>
                            </footer>
                        </div>
                    <?php endforeach; ?>

                </div>






            </div>
        </div>
    </div>

    <?php include ('includes/footer.php'); ?>

    <!-- Add custom CSS to handle the layout changes -->
    <style>
        @media (max-width: 575.98px) {
            .client-table tbody tr {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
            }

            .client-table tbody tr td {
                width: 100%;
                display: block;
            }

            .client-image {
                margin-bottom: 10px;
            }
        }

        @media (min-width: 576px) {
            .client-table tbody tr td {
                width: auto;
                display: table-cell;
            }
        }
    </style>

    <?php include ('includes/footer.php'); ?>