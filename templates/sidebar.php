<?php
// File: tuition/templates/sidebar.php
// Note: BASE_URL is defined in header.php
?>
<div class="bg-dark" id="sidebar-wrapper">
    <div class="sidebar-heading text-center py-4 text-white fs-4 fw-bold text-uppercase border-bottom">
        <a href="<?php echo BASE_URL; ?>index.php" class="text-white text-decoration-none">
             Vedha Tuition
        </a>
    </div>
    <div class="list-group list-group-flush my-3">
        <a href="<?php echo BASE_URL; ?>index.php" class="list-group-item list-group-item-action bg-transparent text-white active"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
        
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="<?php echo BASE_URL; ?>admin/manage_instructors.php" class="list-group-item list-group-item-action bg-transparent text-white fw-light"><i class="fas fa-chalkboard-teacher me-2"></i>Instructors</a>
        <?php endif; ?>

        <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'instructor'])): ?>
            <a href="<?php echo BASE_URL; ?>students/student.php" class="list-group-item list-group-item-action bg-transparent text-white fw-light"><i class="fas fa-user-graduate me-2"></i>Students</a>
            <a href="<?php echo BASE_URL; ?>schedule/daily.php" class="list-group-item list-group-item-action bg-transparent text-white fw-light"><i class="fas fa-calendar-alt me-2"></i>Schedule</a>
            <a href="<?php echo BASE_URL; ?>report/form.php" class="list-group-item list-group-item-action bg-transparent text-white fw-light"><i class="fas fa-chart-bar me-2"></i>Reports</a>
            <a href="<?php echo BASE_URL; ?>tests/add_result.php" class="list-group-item list-group-item-action bg-transparent text-white fw-light"><i class="fas fa-plus-square me-2"></i>Add Result</a>
            <a href="<?php echo BASE_URL; ?>tests/view_results.php" class="list-group-item list-group-item-action bg-transparent text-white fw-light"><i class="fas fa-poll me-2"></i>View Results</a>
            <a href="<?php echo BASE_URL; ?>billing/new.php" class="list-group-item list-group-item-action bg-transparent text-white fw-light"><i class="fas fa-file-invoice-dollar me-2"></i>Billing</a>
            <a href="<?php echo BASE_URL; ?>payment/new.php" class="list-group-item list-group-item-action bg-transparent text-white fw-light"><i class="fas fa-credit-card me-2"></i>Payments</a>
        <?php endif; ?>

        <a href="<?php echo BASE_URL; ?>logout.php" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i class="fas fa-power-off me-2"></i>Logout</a>
    </div>
</div>
