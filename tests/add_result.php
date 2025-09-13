<?php
// File: tuition/tests/add_result.php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'instructor') {
    header('Location: ' . BASE_URL . 'login.php');
    exit();
}
require_once('../db/config.php');

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_test_result'])) {
    $sid = $_POST['sid'];
    $test_name = $_POST['test_name'];
    $test_date = $_POST['test_date'];
    $score = $_POST['score'];

    if ($score < 1 || $score > 10) {
        $error = "Score must be between 1 and 10.";
    } else {
        $stmt = $conn->prepare("INSERT INTO tests (sid, test_name, test_date, score) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $sid, $test_name, $test_date, $score);
        if ($stmt->execute()) {
            $success = "Test result added successfully.";
        } else {
            $error = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Test Result - Vedha Tuition Centre</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
</head>

<body>
    <?php include('../header.php'); ?>
    <?php include('../sidebar.php'); ?>

    <div class="main-content">
        <h1>Add Test Result</h1>
        <?php if ($success): ?>
            <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>
        <?php if ($error): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <div class="section-container">
            <form action="add_result.php" method="post">
                <label for="sid">Student ID:</label>
                <input type="number" id="sid" name="sid" required>
                <label for="test_name">Test Name:</label>
                <input type="text" id="test_name" name="test_name" required>
                <label for="test_date">Test Date:</label>
                <input type="date" id="test_date" name="test_date" required>
                <label for="score">Score (1-10):</label>
                <input type="number" id="score" name="score" min="1" max="10" required>
                <button type="submit" name="add_test_result">Add Result</button>
            </form>
        </div>
    </div>
</body>

</html>