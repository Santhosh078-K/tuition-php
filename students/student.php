<?php
// File: tuition/students/student.php
require_once('../db/config.php');
include('../templates/header.php'); // Corrected path to the template

// Authentication check
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'login.php');
    exit();
}

// Fetch students from the database using the correct column 'semailid'
$students_result = mysqli_query($conn, "SELECT sid, sname, smail, spno FROM std_info ORDER BY sid");
?>

<?php include('../templates/sidebar.php'); // Corrected path to the template 
?>

<!-- Page Content -->
<div id="page-content-wrapper">
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
        <div class="d-flex align-items-center">
            <i class="fas fa-align-left text-dark fs-4 me-3" id="menu-toggle"></i>
            <h2 class="fs-2 m-0">Students</h2>
        </div>
    </nav>

    <div class="container-fluid px-4">
        <div class="row my-5">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="fs-4 mb-3">Student List</h3>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal"><i class="fas fa-plus me-2"></i>Add New Student</button>
            </div>
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <table class="table table-hover rounded">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Fee (₹)</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($students_result && mysqli_num_rows($students_result) > 0): ?>
                                    <?php while ($row = mysqli_fetch_assoc($students_result)): ?>
                                        <tr>
                                            <td><?php echo isset($row['sid']) ? htmlspecialchars($row['sid']) : 'N/A'; ?></td>
                                            <td><?php echo isset($row['sname']) ? htmlspecialchars($row['sname']) : 'N/A'; ?></td>
                                            <td><?php echo isset($row['semailid']) ? htmlspecialchars($row['semailid']) : 'N/A'; ?></td>
                                            <td><?php echo isset($row['sphone']) ? htmlspecialchars($row['sphone']) : 'N/A'; ?></td>
                                            <td>₹ <?php echo isset($row['sfee']) ? number_format($row['sfee']) : '0'; ?></td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i></a>
                                                <a href="#" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                                <a href="#" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No students found. Add one to get started!</td>
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

<!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../db/action.php" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sname" class="form-label">Student Name</label>
                            <input type="text" class="form-control" id="sname" name="sname" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="semail" class="form-label">Student Email</label>
                            <input type="email" class="form-control" id="semail" name="semailid" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sphone" class="form-label">Student Phone</label>
                            <input type="tel" class="form-control" id="sphone" name="sphone">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="skype" class="form-label">Skype ID</label>
                            <input type="text" class="form-control" id="skype" name="skype">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pname" class="form-label">Parent Name</label>
                            <input type="text" class="form-control" id="pname" name="pname">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pemail" class="form-label">Parent Email</label>
                            <input type="email" class="form-control" id="pemail" name="pemail">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pphone" class="form-label">Parent Phone</label>
                            <input type="tel" class="form-control" id="pphone" name="pphone">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="course" class="form-label">Course</label>
                            <select class="form-select" id="course" name="course">
                                <option selected>Choose...</option>
                                <option>Grade 4</option>
                                <option>Grade 5</option>
                                <option>Algebra 1</option>
                                <option>Geometry</option>
                                <option>PreCalculus</option>
                                <!-- Add other courses here -->
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sfee" class="form-label">Fee (₹)</label>
                            <input type="number" class="form-control" id="sfee" name="sfee" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="doj" class="form-label">Date of Joining</label>
                            <input type="date" class="form-control" id="doj" name="doj" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="add_student" class="btn btn-primary">Save Student</button>
            </div>
            </form>
        </div>
    </div>
</div>

<?php include('../templates/footer.php'); // Corrected path to the template 
?>