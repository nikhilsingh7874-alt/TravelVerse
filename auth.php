<?php
// auth.php — include at the top of every protected page
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.html');
    exit;
}

// Helper: current username
$currentUser = $_SESSION['username'] ?? 'Traveller';
?>
