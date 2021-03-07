<?php

// Start or continue session
session_start();

// Check if user already logged in, if so then redirect to the dashboard
if (!isset($_SESSION['logged-in-user']) || empty($_SESSION['logged-in-user'])) {
    header("Location: login.php", true, 303);
    exit();
} else {
    header("Location: ../admin/dashboard.php", true, 303);
    exit();
}

?>
