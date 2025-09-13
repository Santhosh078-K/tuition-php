<?php
session_start();
require_once 'db/config.php';

// Define the base URL to ensure correct asset loading and redirection
if (!defined('BASE_URL')) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    // This dynamically finds the root 'tuition' folder path
    $script_name = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
    $project_root = preg_replace('/(admin|students|db|templates|assets)\/?.*$/', '', $script_name);
    define('BASE_URL', $protocol . $host . $project_root);
}

// If user is already logged in, redirect them to the dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'dashboard.php');
    exit();
}

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check in admins table first
    $sql_admin = "SELECT * FROM admins WHERE username = '$username'";
    $result_admin = mysqli_query($conn, $sql_admin);

    if (mysqli_num_rows($result_admin) == 1) {
        $row = mysqli_fetch_assoc($result_admin);
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = 'admin';
            // **FIXED**: Redirect using the full BASE_URL
            header("Location: " . BASE_URL . "dashboard.php");
            exit();
        } else {
            $error = "Invalid credentials. Please try again.";
        }
    } else {
        // If not an admin, check in instructors table
        $sql_instructor = "SELECT * FROM instructors WHERE username = '$username'";
        $result_instructor = mysqli_query($conn, $sql_instructor);
        if (mysqli_num_rows($result_instructor) == 1) {
            $row = mysqli_fetch_assoc($result_instructor);
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = 'instructor';
                // **FIXED**: Redirect using the full BASE_URL
                header("Location: " . BASE_URL . "dashboard.php");
                exit();
            } else {
                $error = "Invalid credentials. Please try again.";
            }
        } else {
            $error = "Invalid credentials. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Vedha Tuition Centre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="<?php echo BASE_URL; ?>assets/img/favicon.png" type="image/png">
</head>

<body class="login-body">
    <div class="login-container">
        <div class="text-center mb-4">
            <img src="<?php echo BASE_URL; ?>assets/img/logo.png" alt="Logo" class="mb-3" style="width: 70px;">
            <h2 class="text-white fw-bold">Welcome Back</h2>
            <p class="text-white-50">Sign in to access the management portal</p>
        </div>
        <form method="post" action="">
            <?php if ($error): ?>
                <div class="alert alert-danger bg-danger text-white border-0 py-2 small"><?php echo $error; ?></div>
            <?php endif; ?>
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-login w-100 py-2 fw-bold text-white">LOGIN</button>
        </form>
    </div>
</body>

</html>