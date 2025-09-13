<?php
// File: tuition/db/action.php
session_start();
require_once('config.php');

// FIX: Check if the 'action' key exists before using it
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case 'add':
            $sname = mysqli_real_escape_string($conn, $_POST['sname']);
            $course = mysqli_real_escape_string($conn, $_POST['course']);
            $smail = mysqli_real_escape_string($conn, $_POST['smail']);
            $spno = mysqli_real_escape_string($conn, $_POST['spno']);
            $skype = mysqli_real_escape_string($conn, $_POST['skype']);
            $pname = mysqli_real_escape_string($conn, $_POST['pname']);
            $pmail = mysqli_real_escape_string($conn, $_POST['pmail']);
            $ppno = mysqli_real_escape_string($conn, $_POST['ppno']);
            $tzone = mysqli_real_escape_string($conn, $_POST['tzone']);
            $ctry = mysqli_real_escape_string($conn, $_POST['ctry']);
            $fee = mysqli_real_escape_string($conn, $_POST['fee']);
            $doj = mysqli_real_escape_string($conn, $_POST['doj']);
            $note = mysqli_real_escape_string($conn, $_POST['note']);

            $sql = "INSERT INTO std_info (sname, course, smail, spno, skype, pname, pmail, ppno, tzone, ctry, fee, doj, note) VALUES ('$sname', '$course', '$smail', '$spno', '$skype', '$pname', '$pmail', '$ppno', '$tzone', '$ctry', '$fee', '$doj', '$note')";

            if (mysqli_query($conn, $sql)) {
                header("Location: ../students/student.php?success=Student added successfully");
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            break;

        case 'update':
            $sid = mysqli_real_escape_string($conn, $_POST['sid']);
            $sname = mysqli_real_escape_string($conn, $_POST['sname']);
            $course = mysqli_real_escape_string($conn, $_POST['course']);
            $smail = mysqli_real_escape_string($conn, $_POST['smail']);
            $spno = mysqli_real_escape_string($conn, $_POST['spno']);
            $skype = mysqli_real_escape_string($conn, $_POST['skype']);
            $pname = mysqli_real_escape_string($conn, $_POST['pname']);
            $pmail = mysqli_real_escape_string($conn, $_POST['pmail']);
            $ppno = mysqli_real_escape_string($conn, $_POST['ppno']);
            $tzone = mysqli_real_escape_string($conn, $_POST['tzone']);
            $ctry = mysqli_real_escape_string($conn, $_POST['ctry']);
            $fee = mysqli_real_escape_string($conn, $_POST['fee']);
            $doj = mysqli_real_escape_string($conn, $_POST['doj']);
            $note = mysqli_real_escape_string($conn, $_POST['note']);

            $sql = "UPDATE std_info SET sname='$sname', course='$course', smail='$smail', spno='$spno', skype='$skype', pname='$pname', pmail='$pmail', ppno='$ppno', tzone='$tzone', ctry='$ctry', fee='$fee', doj='$doj', note='$note' WHERE sid='$sid'";

            if (mysqli_query($conn, $sql)) {
                header("Location: ../students/student.php?success=Student updated successfully");
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            break;

        case 'delete':
            $sid = mysqli_real_escape_string($conn, $_POST['sid']);
            $sql = "DELETE FROM std_info WHERE sid='$sid'";
            if (mysqli_query($conn, $sql)) {
                echo "Student deleted successfully";
            } else {
                echo "Error deleting record: " . mysqli_error($conn);
            }
            break;

        case 'add_user':
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $role = mysqli_real_escape_string($conn, $_POST['role']);

            $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
            if (mysqli_query($conn, $sql)) {
                echo "User added successfully";
            } else {
                echo "Error adding user: " . mysqli_error($conn);
            }
            break;

        case 'add_test_result':
            $sid = mysqli_real_escape_string($conn, $_POST['sid']);
            $test_name = mysqli_real_escape_string($conn, $_POST['test_name']);
            $test_date = mysqli_real_escape_string($conn, $_POST['test_date']);
            $score = mysqli_real_escape_string($conn, $_POST['score']);

            $sql = "INSERT INTO tests (sid, test_name, test_date, score) VALUES ('$sid', '$test_name', '$test_date', '$score')";
            if (mysqli_query($conn, $sql)) {
                echo "Test result added successfully";
            } else {
                echo "Error adding test result: " . mysqli_error($conn);
            }
            break;

        default:
            echo "Invalid action";
            break;
    }
} else {
    // This block runs if 'action' key is not set, preventing the warning.
    echo "No action specified.";
}
