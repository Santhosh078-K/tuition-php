<?php
// File: tuition/tests/view_results.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}
// FIX: Include the config file to define BASE_URL
require_once('../db/config.php');
require_once('../header.php');
require_once('../sidebar.php');

// Fetch all test results
$sql = "SELECT t.*, s.sname, s.pmail FROM tests t JOIN std_info s ON t.sid = s.sid";
$result = mysqli_query($conn, $sql);

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Test Results</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .test-results-table {
            width: 100%;
            overflow-x: auto;
        }

        .test-results-table table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            box-shadow: 0 5px 10px rgb(0 0 0 / 10%);
            border-radius: 12px;
            overflow: hidden;
            font-size: 16px;
        }

        .test-results-table table th,
        .test-results-table table td {
            text-align: left;
            padding: 15px 20px;
        }

        .test-results-table table th {
            background-color: var(--green);
            color: #010701;
            font-weight: bold;
        }

        .test-results-table table tr:nth-child(even) {
            background-color: #eeeeee;
        }

        .email-btn {
            background-color: var(--blue);
            color: var(--white);
            border: none;
            border-radius: 8px;
            padding: 8px 15px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .email-btn:hover {
            background-color: var(--btn-hover-blue);
        }
    </style>
</head>

<div class="main-content">
    <h1>View Test Results</h1>
    <div class="content-card">
        <div class="test-results-table">
            <table>
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Test Name</th>
                        <th>Test Date</th>
                        <th>Score</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['sname']); ?></td>
                                <td><?php echo htmlspecialchars($row['test_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['test_date']); ?></td>
                                <td><?php echo htmlspecialchars($row['score']); ?></td>
                                <td>
                                    <button class="email-btn" onclick="emailTestResult('<?php echo htmlspecialchars($row['sname']); ?>', '<?php echo htmlspecialchars($row['test_name']); ?>', '<?php echo htmlspecialchars($row['test_date']); ?>', '<?php echo htmlspecialchars($row['score']); ?>', '<?php echo htmlspecialchars($row['pmail']); ?>')">Email Result</button>
                                </td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="5">No test results found.</td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chatbot Floating Button -->
<div class="chatbot-button" onclick="toggleChat()">
    <i class="fas fa-robot"></i>
</div>

<!-- Chatbot Container -->
<div id="chatbot-container" class="chatbot-container">
    <div class="chatbot-header">
        Gemini Chatbot
        <span onclick="toggleChat()">&times;</span>
    </div>
    <div class="chatbot-messages" id="chatbot-messages">
        <div class="chat-message bot">Hello! How can I help you with your tuition management today?</div>
    </div>
    <div class="chatbot-input">
        <input type="text" id="chat-input" placeholder="Type your message...">
        <button id="send-btn"><i class="fas fa-paper-plane"></i></button>
    </div>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/script.js"></script>

<script>
    function emailTestResult(studentName, testName, testDate, score, parentEmail) {
        Swal.fire({
            title: 'Send Test Result?',
            text: `Send the result for ${studentName}'s test to ${parentEmail}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#008332',
            cancelButtonColor: '#b13935',
            confirmButtonText: 'Yes, send it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Here you would make an AJAX call to a new PHP file to send the email
                // This is a placeholder for demonstration.
                // You would need to create a new file, e.g., 'send_test_results.php'
                $.ajax({
                    type: "POST",
                    url: "../db/send_test_results.php", // <-- This file needs to be created
                    data: {
                        sname: studentName,
                        tname: testName,
                        tdate: testDate,
                        score: score,
                        pmail: parentEmail,
                        action: 'send_test_result'
                    },
                    success: function(response) {
                        if (response === '1') {
                            Swal.fire(
                                'Sent!',
                                'The test result email has been sent.',
                                'success'
                            );
                        } else {
                            Swal.fire(
                                'Failed!',
                                'An error occurred while sending the email. Please check your SMTP configuration.',
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'Could not connect to the server.',
                            'error'
                        );
                    }
                });
            }
        });
    }
</script>