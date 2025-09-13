<?php
// File: tuition/admin/manage_instructors.php
require_once('../db/config.php');
include('../templates/header.php'); // Correct path to template

// Authentication and Authorization check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ' . BASE_URL . 'login.php');
    exit();
}

$message = '';
// Handle form submission for adding a new instructor
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_instructor'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (!empty($username) && !empty($password)) {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new instructor into the database
        $sql = "INSERT INTO instructors (username, password) VALUES ('$username', '$hashed_password')";
        if (mysqli_query($conn, $sql)) {
            $message = "<div class='alert alert-success'>Instructor added successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>Username and password cannot be empty.</div>";
    }
}

// Fetch all current instructors to display in the table
$instructors_result = mysqli_query($conn, "SELECT id, username FROM instructors ORDER BY id");
?>

<?php include('../templates/sidebar.php'); // Correct path to template 
?>

<!-- Page Content -->
<div id="page-content-wrapper">
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
        <div class="d-flex align-items-center">
            <i class="fas fa-align-left text-dark fs-4 me-3" id="menu-toggle"></i>
            <h2 class="fs-2 m-0">Manage Instructors</h2>
        </div>
    </nav>

    <div class="container-fluid px-4">
        <?php echo $message; // Display success or error messages here 
        ?>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="fs-4 mb-0">Add New Instructor</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" name="add_instructor" class="btn btn-primary">Add Instructor</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="fs-4 mb-0">Current Instructors</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Username</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($instructors_result && mysqli_num_rows($instructors_result) > 0): ?>
                                    <?php while ($row = mysqli_fetch_assoc($instructors_result)): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="2" class="text-center">No instructors found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /#page-content-wrapper -->

<?php include('../templates/footer.php'); // Correct path to template 
?>