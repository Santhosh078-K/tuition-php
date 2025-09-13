<?php
// File: tuition/report/session.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'login.php');
    exit();
}
require_once('../db/config.php');

$reports = [];
$sql = "SELECT r.*, s.sname FROM report r JOIN std_info s ON r.sid = s.sid ORDER BY r.scdate DESC";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $reports[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Reports - Vedha Tuition Centre</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
</head>

<body>
    <?php include('../header.php'); ?>
    <?php include('../sidebar.php'); ?>

    <div class="main-content">
        <h1>Session Reports</h1>
        <div class="section-container">
            <?php if (empty($reports)): ?>
                <p>No session reports found.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Topic Taken</th>
                            <th>Homework</th>
                            <th>Private Comments</th>
                            <th>Public Comments</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reports as $report): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($report['sname']); ?></td>
                                <td><?php echo htmlspecialchars($report['scdate']); ?></td>
                                <td><?php echo htmlspecialchars($report['scstatus']); ?></td>
                                <td><?php echo htmlspecialchars($report['takenTopic']); ?></td>
                                <td><?php echo htmlspecialchars($report['HWork']); ?></td>
                                <td><?php echo htmlspecialchars($report['pvtComment']); ?></td>
                                <td><?php echo htmlspecialchars($report['pubComment']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>