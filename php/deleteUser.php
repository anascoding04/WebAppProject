<?php
require("_connect.php");

// Check if the form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user ID
    $ID = $_POST['ID'];

    // Prepare and execute the SQL query to delete the user from the database
    $SQL = "DELETE FROM Employees WHERE ID=?";
    $stmt = mysqli_prepare($connect, $SQL);
    mysqli_stmt_bind_param($stmt, 'i', $ID);
    mysqli_stmt_execute($stmt);

    // Check if the deletion was successful
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        // Deletion successful
        $response = array('success' => true, 'message' => 'User deleted successfully.');
        echo json_encode($response);
    } else {
        // Deletion failed
        $response = array('success' => false, 'message' => 'Failed to delete user.');
        echo json_encode($response);
    }

    // Close statement
    mysqli_stmt_close($stmt);
} else {
    // Invalid request method
    $response = array('success' => false, 'message' => 'Invalid request method.');
    echo json_encode($response);
}

// Close the database connection
mysqli_close($connect);
?>
