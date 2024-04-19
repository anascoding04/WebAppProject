<?php

session_start();

// Check if the user is not logged in
if (!isset($_SESSION['admin_loggedin']) || $_SESSION['admin_loggedin'] !== true) {
    header('Location: index.php'); // Redirect to the login page
    exit;
}
?>
