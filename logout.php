<?php
// File: tuition/logout.php
session_start();
session_unset();
session_destroy();

// Define BASE_URL to ensure correct redirection
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$script_name = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
define('BASE_URL', $protocol . $host . rtrim($script_name, '/') . '/');

header('Location: ' . BASE_URL . 'login.php');
exit();
