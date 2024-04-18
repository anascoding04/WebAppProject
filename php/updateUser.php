<?php
require("_connect.php");

// Check if the form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $ID = $_POST['ID'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $jobTitle = $_POST['jobTitle'];
    $accessLevel = $_POST['accessLevel'];

    // Validate and sanitize the data as needed

    // Prepare and execute the SQL query to update user details in the database
    $SQL = "UPDATE Employees SET FirstName=?, LastName=?, Email=?, Password=?, JobTitle=?, AccessLevel=? WHERE ID=?";
    $stmt = mysqli_prepare($connect, $SQL);
    mysqli_stmt_bind_param($stmt, 'ssssssi', $firstName, $lastName, $email, $password, $jobTitle, $accessLevel, $ID);
    mysqli_stmt_execute($stmt);

    // Check if the update was successful
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        // Update successful
        $response = array('success' => true, 'message' => 'User details updated successfully.');
        echo json_encode($response);
    } elseif (mysqli_stmt_affected_rows($stmt) == 0) {
        // Update failed
        $response = array('success' => false, 'message' => 'No changes have been made.');
        echo json_encode($response);
    } else {
        // Update failed
        $response = array('success' => false, 'message' => 'Failed to update user details.');
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
