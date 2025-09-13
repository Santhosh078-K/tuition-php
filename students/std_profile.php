<?php
// File: tuition/students/std_profile.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'login.php');
    exit();
}
require_once('../db/config.php');

$student = null;
if (isset($_GET['sid'])) {
    $sid = mysqli_real_escape_string($conn, $_GET['sid']);
    $sql = "SELECT * FROM std_info WHERE sid = '$sid'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $student = mysqli_fetch_assoc($result);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile - Vedha Tuition Centre</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
</head>

<body>
    <?php include('../header.php'); ?>
    <?php include('../sidebar.php'); ?>
    <div class="main-content">
        <?php if ($student) : ?>
            <h1>Student Profile: <?php echo htmlspecialchars($student['sname']); ?></h1>
            <div class="profile-container">
                <div class="profile-section">
                    <h2>Student Information</h2>
                    <p><strong>Student ID:</strong> <?php echo htmlspecialchars($student['sid']); ?></p>
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($student['sname']); ?></p>
                    <p><strong>Course:</strong> <?php echo htmlspecialchars($student['course']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($student['smail']); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($student['spno']); ?></p>
                    <p><strong>Skype ID:</strong> <?php echo htmlspecialchars($student['skype']); ?></p>
                </div>
                <div class="profile-section">
                    <h2>Parent Information</h2>
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($student['pname']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($student['pmail']); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($student['ppno']); ?></p>
                </div>
                <div class="profile-section">
                    <h2>Other Details</h2>
                    <p><strong>Timezone:</strong> <?php echo htmlspecialchars($timezones[$student['tzone']]); ?></p>
                    <p><strong>Country:</strong> <?php echo htmlspecialchars($student['ctry']); ?></p>
                    <p><strong>Fee:</strong> ₹ <?php echo htmlspecialchars($student['fee']); ?></p>
                    <p><strong>Date of Joining:</strong> <?php echo htmlspecialchars($student['doj']); ?></p>
                    <p><strong>Notes:</strong> <?php echo htmlspecialchars($student['note']); ?></p>
                </div>
            </div>
            <a href="javascript:history.back()" class="back-button">Go Back</a>
        <?php else : ?>
            <p>Student not found.</p>
        <?php endif; ?>
    </div>
</body>

</html>