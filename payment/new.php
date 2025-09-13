<?php
// File: tuition/payment/new.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'login.php');
    exit();
}
require_once('../db/config.php');

$result = mysqli_query($conn, "SELECT * FROM std_info ORDER BY sname");
$students = [];
while ($row = mysqli_fetch_assoc($result)) {
    $students[] = $row;
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_payment'])) {
    $sid = mysqli_real_escape_string($conn, $_POST['sid']);
    $pamt = mysqli_real_escape_string($conn, $_POST['pamt']);
    $psrc = mysqli_real_escape_string($conn, $_POST['psrc']);
    $ptxnid = mysqli_real_escape_string($conn, $_POST['ptxnid']);
    $pdate = mysqli_real_escape_string($conn, $_POST['pdate']);

    $stmt = $conn->prepare("INSERT INTO txn (sid, pamt, psrc, ptxnid, pdate) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $sid, $pamt, $psrc, $ptxnid, $pdate);
    if ($stmt->execute()) {
        $success = "Payment added successfully.";
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
    <title>New Payment - Vedha Tuition Centre</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
</head>

<body>
    <?php include('../header.php'); ?>
    <?php include('../sidebar.php'); ?>
    <div class="main-content">
        <h1>Add New Payment</h1>
        <?php if ($success): ?>
            <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>
        <?php if ($error): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <div class="section-container">
            <form action="new.php" method="post">
                <div class="form-group">
                    <label for="sid">Student</label>
                    <select id="sid" name="sid" required>
                        <option value="">Select a student</option>
                        <?php foreach ($students as $student): ?>
                            <option value="<?php echo htmlspecialchars($student['sid']); ?>"><?php echo htmlspecialchars($student['sname']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="pamt">Amount (₹)</label>
                    <input type="number" id="pamt" name="pamt" required>
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
                <button type="submit" name="add_payment">Add Payment</button>
            </form>
        </div>
    </div>
</body>

</html>