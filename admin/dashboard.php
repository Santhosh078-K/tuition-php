<?php
// File: tuition/admin/dashboard.php
require_once('../db/config.php');
include('../templates/header.php'); // Correct path to template

// Authentication and Authorization check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ' . BASE_URL . 'login.php');
    exit();
}
?>

<?php include('../templates/sidebar.php'); // Correct path to template 
?>

<!-- Page Content -->
<div id="page-content-wrapper">
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
        <div class="d-flex align-items-center">
            <i class="fas fa-align-left text-dark fs-4 me-3" id="menu-toggle"></i>
            <h2 class="fs-2 m-0">Admin Dashboard</h2>
        </div>
    </nav>

    <div class="container-fluid px-4">
        <h3 class="fs-4 mb-3">Welcome, Admin!</h3>
        <p>From here you can manage instructors, view comprehensive reports, and oversee all tuition activities.</p>
        <!-- Add Admin-specific widgets here -->
    </div>
</div>
<!-- /#page-content-wrapper -->

<?php include('../templates/footer.php'); // Correct path to template 
?>