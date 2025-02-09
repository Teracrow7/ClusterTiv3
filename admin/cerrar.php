<?php
// Start the session
session_start();

// Clear all session variables
$_SESSION = [];

// Destroy the session
if (session_status() === PHP_SESSION_ACTIVE) {
    session_destroy();
}

// Ensure no caching for this page
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Redirect to the login page
header("Location: ./login.php");
exit;
?>
