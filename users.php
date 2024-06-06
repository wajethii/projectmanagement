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

<body>
    <div class="container">
        <div class="card-title d-flex justify-content-between align-items-center m-4">
            <h4>Users</h4>
            <button type="button" class="btn-outline-info" data-bs-toggle="modal" data-bs-target="#AddUserModal">
                Add User
            </button>
        </div>
        <!-- Include the toast container -->
        <div class="toast-container">
            <?php
            // Check if there is a session status message
            if (isset($_SESSION['status'])) {
                echo $_SESSION['status'];
                // Unset the session status after displaying it
                unset($_SESSION['status']);
            }
            ?>
        </div>
        <div class="row">

            <div class="container mt-2">
                <form id="deleteForm" action="code.php" method="post">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col"><input type="checkbox" id="selectAll"></th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Password</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
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
                            $current_page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                            $offset = ($current_page - 1) * $records_per_page;

                            // Query to get total records
                            $total_records_query = "SELECT COUNT(*) AS total FROM users";
                            $total_records_result = $conn->query($total_records_query);
                            $total_records = $total_records_result->fetch_assoc()['total'];
                            $total_pages = ceil($total_records / $records_per_page);

                            // Query to get records for the current page
                            $sql = "SELECT user_id, username, email, password FROM users LIMIT $records_per_page OFFSET $offset";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo '<td><input type="checkbox" name="user_ids[]" value="' . $row["user_id"] . '"></td>';
                                    echo "<td>" . $row["username"] . "</td>";
                                    echo "<td>" . $row["email"] . "</td>";
                                    echo "<td>" . htmlspecialchars($row["password"]) . "</td>";
                                    echo '<td><button type="button" class="btn btn-link text-success" data-bs-toggle="modal" data-bs-target="#EditUserModal" data-id="' . $row["user_id"] . '" data-username="' . $row["username"] . '" data-email="' . $row["email"] . '" data-password="' . htmlspecialchars($row["password"]) . '"><i class="bi bi-pencil-square" style="font-size: 20px;"></i></button></td>';
                                    echo '<td><button type="submit" name="delete_btn" value="' . $row["user_id"] . '" class="btn btn-link text-danger"><i class="bi bi-trash" style="font-size: 20px;"></i></button></td>';
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>0 results</td></tr>";
                            }
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                    <button type="submit" name="delete_selected_btn" id="deleteSelectedBtn" class="btn btn-danger"
                        style="display:none;">Delete Selected</button>
                </form>

                <!-- Pagination controls -->
                <nav>
                    <ul class="pagination justify-content-center">
                        <?php if ($current_page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $current_page - 1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <?php if ($current_page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $current_page + 1; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>

            <!-- Edit User Modal -->
            <div class="modal fade" id="EditUserModal" tabindex="-1" aria-labelledby="EditUserModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="EditUserModalLabel">Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="code.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="user_id" id="editUserId">
                                <div class="form-floating mb-3">
                                    <input type="text" name="username" id="editUsername" class="form-control"
                                        placeholder="Username" required>
                                    <label for="editUsername">Username</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="email" name="email" id="editEmail" class="form-control"
                                        placeholder="Email" required>
                                    <label for="editEmail">Email</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="password" id="editPassword" class="form-control"
                                        placeholder="Password" required>
                                    <label for="editPassword">Password</label>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" name="update_btn" class="btn-outline-info btn-lg">Save
                                        Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add User Modal -->
            <div class="modal fade" id="AddUserModal" tabindex="-1" aria-labelledby="AddUserModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="AddUserModalLabel">Add User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="code.php" method="post" enctype="multipart/form-data">
                                <div class="form-floating mb-3">
                                    <input type="text" name="username" id="addUsername" class="form-control"
                                        placeholder="Username" required>
                                    <label for="addUsername">Username</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="email" name="email" id="addEmail" class="form-control"
                                        placeholder="Email" required>
                                    <label for="addEmail">Email</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" name="password" id="addPassword" class="form-control"
                                        placeholder="Password" required>
                                    <label for="addPassword">Password</label>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" name="register_btn" class="btn-info btn-lg">Add
                                        User</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <?php include ('includes/footer.php'); ?>

</body>

</html>