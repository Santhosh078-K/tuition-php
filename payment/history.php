<?php
// File: tuition/payment/history.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'login.php');
    exit();
}
require_once('../db/config.php');

$sql = "SELECT t.*, s.sname FROM txn t JOIN std_info s ON t.sid = s.sid ORDER BY t.pdate DESC";
$result = mysqli_query($conn, $sql);
$transactions = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $transactions[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History - Vedha Tuition Centre</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
</head>

<body>
    <?php include('../header.php'); ?>
    <?php include('../sidebar.php'); ?>

    <div class="main-content">
        <h1>Payment History</h1>
        <?php if (empty($transactions)): ?>
            <p>No payments found.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Amount (₹)</th>
                        <th>Payment Source</th>
                        <th>Transaction ID</th>
                        <th>Payment Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $txn): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($txn['sname']); ?></td>
                            <td>₹ <?php echo htmlspecialchars($txn['pamt']); ?></td>
                            <td><?php echo htmlspecialchars($payment[$txn['psrc']]); ?></td>
                            <td><?php echo htmlspecialchars($txn['ptxnid']); ?></td>
                            <td><?php echo htmlspecialchars($txn['pdate']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>

</html>