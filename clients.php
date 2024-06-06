<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}

include ('includes/header.php');

?>


<style>
    .toast-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
    }
</style>

<body>
    <div class="container">
        <div class="toast-container">
            <?php
            if (isset($_SESSION['status'])) {
                echo $_SESSION['status'];
                unset($_SESSION['status']);
            }
            ?>
        </div>
        <div class="row">
            <div class="card border-0">
                <div class="card-body">
                    <div class="row align-items-center mb-3">
                        <div class="col">
                            <h6>Add a new client</h6>
                        </div>
                        <div class="col-auto ms-auto">
                            <button type="button" class="btn btn-outline-info" data-bs-toggle="modal"
                                data-bs-target="#AddClientModal">Add Client</button>
                        </div>
                    </div>

                    <table class="table border-0">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Contacts</th>
                                <th scope="col">Service Required</th>
                                <th scope="col">Completion</th>
                                <th scope="col">Payment</th>
                                <th scope="col">Status</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody style="vertical-align: middle; color: var(--primary-color);">
            <?php
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

            // Pagination logic
            $records_per_page = 10;  // Number of records to display per page
            $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($current_page - 1) * $records_per_page;

            // Query to get total records
            $total_records_query = "SELECT COUNT(*) AS total FROM Clients";
            $total_records_result = $conn->query($total_records_query);
            $total_records = $total_records_result->fetch_assoc()['total'];
            $total_pages = ceil($total_records / $records_per_page);

            // Query to get records for the current page
            $sql = "SELECT client_id, name, contact_info, services_required, projected_completion_date, amount_charged, pdf, status FROM Clients LIMIT $records_per_page OFFSET $offset";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["contact_info"] . "</td>";
                    echo "<td>" . $row["services_required"] . "</td>";
                    echo "<td>" . $row["projected_completion_date"] . "</td>";
                    echo "<td>" . $row["amount_charged"] . "</td>";
                    echo "<td>" . $row["status"] . "</td>";
                    echo '<td>
                    <button class="btn btn-link text-success" data-bs-toggle="modal" data-bs-target="#EditClientModal" 
                        data-id="' . $row["client_id"] . '" data-name="' . $row["name"] . '" 
                        data-contact="' . $row["contact_info"] . '" data-services="' . $row["services_required"] . '" 
                        data-completion="' . $row["projected_completion_date"] . '" data-amount="' . $row["amount_charged"] . '" 
                        data-docs="' . $row["pdf"] . '" data-status="' . $row["status"] . '">
                        <i class="bi bi-pencil-square" style="width: 20px; height: 20px; font-size: 20px;"></i>
                    </button>
                  </td>';
            echo '<td>
                    <form action="clients_.php" method="post">
                        <button type="submit" name="delete_client_btn" value="' . $row["client_id"] . '" class="btn btn-link text-danger">
                            <i class="bi bi-trash" style="width: 20px; height: 20px; font-size: 20px;"></i>
                        </button>
                    </form>
                  </td>';
            echo "</tr>";
            
                }
            } else {
                echo "<tr><td colspan='8'>0 results</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>

   
<!-- Pagination controls -->
<nav>
    <ul class="pagination justify-content-center">
        <?php if ($current_page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $current_page - 1; ?>" aria-label="Previous" style="color: var(--primary-color);">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>" style="color: var(--primary-color);">
                    <?php echo $i; ?>
                </a>
            </li>
        <?php endfor; ?>
        <?php if ($current_page < $total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $current_page + 1; ?>" aria-label="Next" style="color: var(--primary-color);">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>

    <!-- Add Client Modal -->
    <div class="modal fade" id="AddClientModal" tabindex="-1" aria-labelledby="AddClientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddClientModalLabel">Add Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="clients_.php" method="post" enctype="multipart/form-data">
                        <div class="form-floating mb-3 m-2">
                            <input type="text" name="name" class="form-control" placeholder="Client Name" required>
                            <label for="name">Client Name</label>
                        </div>
                        <div class="form-floating mb-3 m-2">
                            <input type="number" name="contact_info" class="form-control" placeholder="Contact Info"
                                required>
                            <label for="contact_info">Contact Info</label>
                        </div>
                        <div class="form-floating mb-3 m-2">
                            <textarea name="services_required" class="form-control" placeholder="Services Required"
                                required></textarea>
                            <label for="services_required">Services Required</label>
                        </div>
                        <div class="form-floating mb-3 m-2">
                            <input type="date" name="projected_completion_date" class="form-control" required>
                            <label for="projected_completion_date">Projected Completion Date</label>
                        </div>
                        <div class="form-floating mb-3 m-2">
                            <input type="number" name="amount_charged" class="form-control" placeholder="Amount Charged"
                                required>
                            <label for="amount_charged">Amount Charged</label>
                        </div>
                        <div class="form-floating mb-3 m-2">
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <label for="image">Upload Image</label>
                        </div>
                        <div class="form-floating mb-3 m-2">
                            <input type="file" name="pdf" class="form-control" accept=".pdf">
                            <label for="pdf">Upload PDF Document</label>
                        </div>
                        <div class="form-check mb-3 m-2">
                            <input class="form-check-input" type="radio" name="status" id="statusComplete"
                                value="Complete">
                            <label class="form-check-label" for="statusComplete">Complete</label>
                        </div>
                        <div class="form-check mb-3 m-2">
                            <input class="form-check-input" type="radio" name="status" id="statusInProgress"
                                value="Work in Progress" checked>
                            <label class="form-check-label" for="statusInProgress">Work in Progress</label>
                        </div>
                        <div class="modal-footer m-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Client</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Client Modal -->
    <div class="modal fade" id="EditClientModal" tabindex="-1" aria-labelledby="EditClientModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditClientModalLabel">Edit Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="clients_.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="client_id" id="editClientId">
                        <div class="form-floating mb-3">
                            <input type="text" name="name" id="editName" class="form-control" placeholder="Client Name"
                                required>
                            <label for="editName">Client Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" name="contact_info" id="editContactInfo" class="form-control"
                                placeholder="Contact Info" required>
                            <label for="editContactInfo">Contact Info</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea name="services_required" id="editServicesRequired" class="form-control"
                                placeholder="Services Required" required></textarea>
                            <label for="editServicesRequired">Services Required</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" name="projected_completion_date" id="editProjectedCompletionDate"
                                class="form-control" required>
                            <label for="editProjectedCompletionDate">Projected Completion Date</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" name="amount_charged" id="editAmountCharged" class="form-control"
                                placeholder="Amount Charged" required>
                            <label for="editAmountCharged">Amount Charged</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <label for="image">Upload Image</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="file" name="pdf" class="form-control" accept=".pdf">
                            <label for="pdf">Upload PDF Document</label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="status" id="editStatusComplete"
                                value="Complete">
                            <label class="form-check-label" for="editStatusComplete">Complete</label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="status" id="editStatusInProgress"
                                value="Work In Progress">
                            <label class="form-check-label" for="editStatusInProgress">In Progress</label>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php include ('includes/footer.php'); ?>