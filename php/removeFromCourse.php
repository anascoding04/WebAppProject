<?php
// Include the database connection file or any necessary setup files
require("_connect.php");

// Check if the required parameters are set in the POST request
if (isset($_POST['employeeID']) && isset($_POST['courseID'])) {
    // Retrieve the employeeID and courseID from the POST request
    $employeeID = $_POST['employeeID'];
    $courseID = $_POST['courseID'];

    // Prepare the SQL statement to delete the enrollment record
    $deleteEnrollmentSQL = "DELETE FROM Enrolment WHERE EmployeeID = ? AND CourseID = ?";
    $deleteEnrollmentStmt = mysqli_prepare($connect, $deleteEnrollmentSQL);

    // Bind parameters and execute the statement
    mysqli_stmt_bind_param($deleteEnrollmentStmt, 'ii', $employeeID, $courseID);
    $success = mysqli_stmt_execute($deleteEnrollmentStmt);

    // Check if the deletion was successful
    if ($success) {
        echo json_encode(array('success' => true, 'message' => 'Successfully removed from the course.'));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Failed to remove from the course.'));
    }

    // Close the statement
    mysqli_stmt_close($deleteEnrollmentStmt);
} else {
    // Output an error message if the required parameters are not set
    echo json_encode(array('success' => false, 'message' => 'Missing parameters.'));
}

// Close the database connection
mysqli_close($connect);
?>
