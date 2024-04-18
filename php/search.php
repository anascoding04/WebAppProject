<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    // Get the value entered in the search bar
    $searchValue = $_GET['search'];

    // Set search value in session
    $_SESSION['searchValue'] = $searchValue;

    // Echo the search result message
    echo "Results for: " . htmlspecialchars($searchValue);
}
?>
