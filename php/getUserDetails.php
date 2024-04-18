<?php
require("_connect.php");

// Check if the ID parameter is set
if (isset($_GET['ID'])) {
    $ID = $_GET['ID'];

    // Prepare and execute the SQL query to fetch user details by ID
    $SQL = "SELECT * FROM Employees WHERE ID = ?";
    $stmt = mysqli_prepare($connect, $SQL);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $ID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        // Check if the result contains any rows
        if (mysqli_num_rows($result) > 0) {
            // Fetch user details
            $row = mysqli_fetch_assoc($result);
            
            // Return user details as JSON data
            echo json_encode($row);
        } else {
            echo json_encode(array('error' => 'User not found.'));
        }

        // Close statement and database connection
        mysqli_stmt_close($stmt);
        mysqli_close($connect);
    } else {
        echo json_encode(array('error' => 'Error in preparing SQL statement.'));
    }
} else {
    echo json_encode(array('error' => 'ID parameter is missing.'));
}
?>
