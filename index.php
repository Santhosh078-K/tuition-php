<?php
// File: tuition/index.php (Public Homepage)
// This file does NOT start a session or check for login.

// Define BASE_URL for asset loading
if (!defined('BASE_URL')) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $script_name = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
    define('BASE_URL', $protocol . $host . rtrim($script_name, '/') . '/');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vedha Tuition Centre - Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="<?php echo BASE_URL; ?>assets/img/favicon.png" type="image/png">
</head>

<body class="homepage-body">

    <div class="hero-section">
        <div class="container text-center">
            <img src="<?php echo BASE_URL; ?>assets/img/logo.png" alt="Logo" class="hero-logo mb-4">
            <h1 class="display-3 fw-bold text-white">Unlock Your Potential with Vedha</h1>
            <p class="lead text-white-50 mx-auto" style="max-width: 600px;">
                Personalized, expert-led tuition designed to help students excel academically and build confidence for a bright future.
            </p>
            <a href="login.php" class="btn btn-lg btn-start-glowing mt-4">
                Get Started <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>A

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>