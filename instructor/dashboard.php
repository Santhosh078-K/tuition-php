<?php
// File: tuition/instructor/dashboard.php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'instructor') {
    header('Location: ' . BASE_URL . 'login.php');
    exit();
}
require_once('../db/config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Dashboard</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
</head>

<body>
    <?php include('../header.php'); ?>
    <?php include('../sidebar.php'); ?>

    <div class="main-content">
        <h1>Instructor Dashboard</h1>
        <p>Welcome, Instructor! Use the sidebar to manage your students and test results.</p>
    </div>
</body>

</html>