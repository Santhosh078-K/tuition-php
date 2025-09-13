<?php
// File: tuition/db/send_test_results.php
include 'config.php';

if (isset($_POST['action']) && $_POST['action'] == 'send_test_result') {
    $studentName = $_POST['sname'];
    $testName = $_POST['tname'];
    $testDate = $_POST['tdate'];
    $score = $_POST['score'];
    $parentEmail = $_POST['pmail'];

    // Define the email subject and body
    $subject = "Test Result for " . $studentName;
    $body = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <style>
            body { font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333; padding: 20px; }
            .container { max-width: 600px; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
            h2 { color: #161D6F; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
            th { background-color: #98DED9; }
            .footer { margin-top: 20px; font-size: 0.8em; text-align: center; color: #777; }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>Test Result Update for ' . htmlspecialchars($studentName) . '</h2>
            <p>Dear Parent,</p>
            <p>We are pleased to share the latest test result for your child, ' . htmlspecialchars($studentName) . '.</p>
            <table>
                <thead>
                    <tr>
                        <th>Test Name</th>
                        <th>Test Date</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>' . htmlspecialchars($testName) . '</td>
                        <td>' . htmlspecialchars($testDate) . '</td>
                        <td>' . htmlspecialchars($score) . '</td>
                    </tr>
                </tbody>
            </table>
            <p>If you have any questions, please feel free to contact us.</p>
            <p>Thank you,</p>
            <p>The Celesta Campus Team</p>
        </div>
        <div class="footer">
            <p>&copy; ' . date("Y") . ' Celesta Campus</p>
        </div>
    </body>
    </html>';

    // Set the email headers
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $headers .= 'From: CelestaCampus <celestacampus.team@gmail.com>' . "\r\n";

    // Send the email and return a response
    if (mail($parentEmail, $subject, $body, $headers)) {
        echo '1'; // Success
    } else {
        echo '0'; // Failure
    }
} else {
    echo '0'; // Invalid action or missing data
}
