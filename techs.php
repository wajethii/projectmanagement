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

<div class="container mt-2">
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
            <div class="card-title d-flex justify-content-between align-items-center">
                <h4>Technicians</h4>
                <button type="button" class="btn btn-outline-info" data-bs-toggle="modal"
                    data-bs-target="#addTechnicianModal">
                    Add Technician
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-hover border-0" id="techniciansTable">
                        <thead>
                            <tr>

                                <th scope="col">Photo</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">Department</th>
                                <th scope="col">OT</th>
                                <th scope="col">Wages</th>
                                <th scope="col">Contract</th>
                                <th scope="col">Status</th>
                                <th scope="col">Documents</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "projectmanagement";

                            $conn = new mysqli($servername, $username, $password, $dbname);

                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            $sql = "SELECT tech_id, image, full_name, technicians.department_id, overtime_hours, wages, contract_length, documents, status, department_name 
                            FROM technicians 
                            LEFT JOIN departments ON technicians.department_id = departments.department_id";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td><img src='" . $row["image"] . "' alt='Image' width='40' height='40' rounded></td>";
                                    echo "<td>" . $row["full_name"] . "</td>";
                                    echo "<td>" . $row["department_name"] . "</td>";
                                    echo "<td>" . $row["overtime_hours"] . "</td>";
                                    echo "<td>" . $row["wages"] . "</td>";
                                    echo "<td>" . $row["contract_length"] . "</td>";

                                    echo "<td>" . $row["status"] . "</td>";
                                    echo "<td><a href='" . htmlspecialchars($row["documents"]) . "' target='_blank' class='btn btn-link text-danger'>
                                    <i class='bi bi-file-earmark-pdf-fill' style='font-size: 20px;'></i>
                                    </a></td>";

                                    echo '<td><button class="btn btn-link text-success" data-bs-toggle="modal" data-bs-target="#EditTechModal" data-id="' . $row["tech_id"] . '" data-name="' . $row["full_name"] . '" data-department="' . $row["department_name"] . '" data-overtime="' . $row["overtime_hours"] . '" data-wages="' . $row["wages"] . '" data-contract="' . $row["contract_length"] . '" data-status="' . $row["status"] . '"><i class="bi bi-pencil-square" style="font-size: 20px;"></i></button></td>';

                                    echo '<td><form action="techs_.php" method="post"><button type="submit" name="delete_tech_btn" value="' . $row["tech_id"] . '" class="btn btn-link text-danger"><i class="bi bi-trash" style="font-size: 20px;"></i></button></form></td>';

                                }
                            } else {
                                echo "<tr><td colspan='10'>No technicians found</td></tr>";
                            }

                            $conn->close();
                            ?>
                        </tbody>


                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal for adding a technician -->
<form action="techs_.php" method="post" enctype="multipart/form-data"></form>
</form>
<div class="modal fade" id="addTechnicianModal" tabindex="-1" aria-labelledby="addTechnicianModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTechnicianModalLabel">Add Technician</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="techs_.php" method="post" enctype="multipart/form-data">
                    <div class="form-floating mb-3 m-2">
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                        <label for="image">Upload Image</label>
                    </div>
                    <div class="form-floating mb-3 m-2">
                        <input type="text" name="full_name" class="form-control" placeholder="Full Name" required>
                        <label for="full_name">Name</label>
                    </div>
                    <div class="form-floating mb-3 m-2">
                        <input type="number" name="contract_length" class="form-control"
                            placeholder="Contract Length (months)" required>
                        <label for="contract_length">Contract Length (months)</label>
                    </div>
                    <div class="form-floating mb-3 m-2">
                        <input type="number" step="0.01" name="wages" class="form-control" placeholder="Wages ($)"
                            required>
                        <label for="wages">Wages ($)</label>
                    </div>
                    <div class="form-floating mb-3 m-2">
                        <input type="number" name="overtime_hours" class="form-control" placeholder="Overtime Hours"
                            required>
                        <label for="overtime_hours">Overtime Hours</label>
                    </div>
                    <div class="form-floating mb-3 m-2">
                        <input type="file" name="documents" class="form-control" accept=".pdf" required>
                        <label for="documents">Upload Document</label>
                    </div>
                    <div class="form-floating mb-3 m-2">
                        <select class="form-select" id="status" name="status" aria-label="Floating label select "
                            required>
                            <option value="Active">Active</option>
                            <option value="On Leave">On Leave</option>
                        </select>
                        <label for="status">Status</label>
                    </div>
                    <div class="form-floating mb-3 m-2">
                        <select class="form-select" id="department" aria-label="floating label select" name="department"
                            required>
                            <?php
                            // Fetch departments from the database
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }
                            $dept_sql = "SELECT department_id, department_name FROM departments";
                            $dept_result = $conn->query($dept_sql);
                            if ($dept_result->num_rows > 0) {
                                while ($dept_row = $dept_result->fetch_assoc()) {
                                    echo "<option value='" . $dept_row["department_id"] . "'>" . $dept_row["department_name"] . "</option>";
                                }
                            } else {
                                echo "<option value=''>No departments available</option>";
                            }
                            $conn->close();
                            ?>
                        </select>
                        <label for="department">Department</label>
                    </div>
                    <div class="modal-footer m-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Technician</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</form>

<!-- Modal for editing a technician -->
<form action="techs_.php" method="post" enctype="multipart/form-data"></form>
</form>
<div class="modal fade" id="EditTechModal" tabindex="-1" aria-labelledby="EditTechModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditTechModalLabel">Update Technician</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="techs_.php" method="post" enctype="multipart/form-data">
                    <div class="form-floating mb-3 m-2">
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <label for="image">Upload Image</label>
                    </div>
                    <div class="form-floating mb-3 m-2">
                        <input type="text" name="full_name" class="form-control" placeholder="Full Name" required>
                        <label for="full_name">Name</label>
                    </div>
                    <div class="form-floating mb-3 m-2">
                        <input type="number" name="contract_length" class="form-control"
                            placeholder="Contract Length (months)" required>
                        <label for="contract_length">Contract Length (months)</label>
                    </div>
                    <div class="form-floating mb-3 m-2">
                        <input type="number" step="0.01" name="wages" class="form-control" placeholder="Wages ($)"
                            required>
                        <label for="wages">Wages ($)</label>
                    </div>
                    <div class="form-floating mb-3 m-2">
                        <input type="number" name="overtime_hours" class="form-control" placeholder="Overtime Hours"
                            required>
                        <label for="overtime_hours">Overtime Hours</label>
                    </div>
                    <div class="form-floating mb-3 m-2">
                        <input type="file" name="documents" class="form-control" accept=".pdf">
                        <label for="documents">Upload Document</label>
                    </div>
                    <div class="form-floating mb-3 m-2">
                        <select class="form-select" id="status" name="status" aria-label="Floating label select "
                            required>
                            <option value="Active">Active</option>
                            <option value="On Leave">On Leave</option>
                        </select>
                        <label for="status">Status</label>
                    </div>
                    <div class="form-floating mb-3 m-2">
                        <select class="form-select" id="department" aria-label="floating label select"
                            name="department">
                            <?php
                            // Fetch departments from the database
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }
                            $dept_sql = "SELECT department_id, department_name FROM departments";
                            $dept_result = $conn->query($dept_sql);
                            if ($dept_result->num_rows > 0) {
                                while ($dept_row = $dept_result->fetch_assoc()) {
                                    echo "<option value='" . $dept_row["department_id"] . "'>" . $dept_row["department_name"] . "</option>";
                                }
                            } else {
                                echo "<option value=''>No departments available</option>";
                            }
                            $conn->close();
                            ?>
                        </select>
                        <label for="department">Department</label>
                    </div>
                    <div class="modal-footer m-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</form>

<?php include ('includes/footer.php'); ?>