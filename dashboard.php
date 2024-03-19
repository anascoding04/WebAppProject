<?php

// Restart/start the session
session_start();

// Check if the user is logged in as they will have this value.
if (!isset($_SESSION['userID']))
{
    die("Invalid, you are not logged in.");
}

echo "Hello " . $_SESSION['firstName'];