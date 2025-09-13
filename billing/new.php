<?php
// File: tuition/billing/new.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'login.php');
    exit();
}
// The include path has been corrected to work from this subdirectory.
require_once('../db/config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Bill - Vedha Tuition Centre</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
</head>

<body>
    <?php include('../header.php'); ?>
    <?php include('../sidebar.php'); ?>
    <div class="main-content">
        <h1>New Bill</h1>
        <p>This is a placeholder page for the new billing functionality.</p>
    </div>
</body>

</html>