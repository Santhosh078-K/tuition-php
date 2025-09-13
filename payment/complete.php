<?php
// File: tuition/payment/complete.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'login.php');
    exit();
}
require_once('../db/config.php');

$bill_id = isset($_GET['bid']) ? $_GET['bid'] : null;

$bill = null;
if ($bill_id) {
    $stmt = $conn->prepare("SELECT b.*, s.sname FROM bill b JOIN std_info s ON b.sid = s.sid WHERE b.bid = ?");
    $stmt->bind_param("s", $bill_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $bill = $result->fetch_assoc();
    }
    $stmt->close();
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['complete_payment'])) {
    $ubid = mysqli_real_escape_string($conn, $_POST['ubid']);
    $ramt = mysqli_real_escape_string($conn, $_POST['ramt']);
    $psrc = mysqli_real_escape_string($conn, $_POST['psrc']);
    $ptxnid = mysqli_real_escape_string($conn, $_POST['ptxnid']);
    $pdate = mysqli_real_escape_string($conn, $_POST['pdate']);

    $stmt = $conn->prepare("UPDATE bill SET complete = 1, ramt = ?, psrc = ?, ptxnid = ?, pdate = ? WHERE ubid = ?");
    $stmt->bind_param("ssssi", $ramt, $psrc, $ptxnid, $pdate, $ubid);
    if ($stmt->execute()) {
        $success = "Bill payment marked as complete successfully.";
    } else {
        $error = "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Payment - Vedha Tuition Centre</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
</head>

<body>
    <?php include('../header.php'); ?>
    <?php include('../sidebar.php'); ?>

    <div class="main-content">
        <h1>Complete Bill Payment</h1>
        <?php if ($success): ?>
            <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>
        <?php if ($error): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <?php if ($bill): ?>
            <div class="section-container">
                <h2>Bill Details</h2>
                <p><strong>Bill ID:</strong> <?php echo htmlspecialchars($bill['bid']); ?></p>
                <p><strong>Student Name:</strong> <?php echo htmlspecialchars($bill['sname']); ?></p>
                <p><strong>Bill Amount:</strong> ₹ <?php echo htmlspecialchars($bill['pamt']); ?></p>
                <p><strong>Due Date:</strong> <?php echo htmlspecialchars($bill['due']); ?></p>
                <hr>
                <form action="complete.php" method="post">
                    <input type="hidden" name="ubid" value="<?php echo htmlspecialchars($bill['ubid']); ?>">
                    <div class="form-group">
                        <label for="ramt">Received Amount (₹)</label>
                        <input type="number" id="ramt" name="ramt" required>
                    </div>
                    <div class="form-group">
                        <label for="psrc">Payment Source</label>
                        <select id="psrc" name="psrc" required>
                            <?php foreach ($payment as $value => $label): ?>
                                <option value="<?php echo htmlspecialchars($value); ?>"><?php echo htmlspecialchars($label); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ptxnid">Transaction ID</label>
                        <input type="text" id="ptxnid" name="ptxnid" required>
                    </div>
                    <div class="form-group">
                        <label for="pdate">Payment Date</label>
                        <input type="date" id="pdate" name="pdate" required>
                    </div>
                    <button type="submit" name="complete_payment">Mark as Paid</button>
                </form>
            </div>
        <?php else: ?>
            <p>Bill not found.</p>
        <?php endif; ?>
    </div>
</body>

</html>