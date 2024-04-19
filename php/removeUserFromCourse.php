<?php
require("_connect.php");

// Check if courseID and employeeID parameters are set in the POST request
if (isset($_POST['courseID'], $_POST['employeeID'])) {
    // Get the values of courseID and employeeID from the POST request
    $courseID = $_POST['courseID'];
    $employeeID = $_POST['employeeID'];

    // Prepare the SQL statement to delete the enrollment record
    $SQL = "DELETE FROM Enrolment WHERE CourseID = ? AND EmployeeID = ?";
    
    $stmt = mysqli_prepare($connect, $SQL);
    mysqli_stmt_bind_param($stmt, 'ii', $courseID, $employeeID);
    
    // Execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        // Check if any rows were affected
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            // Enrollment record successfully deleted
            echo json_encode(array('success' => true, 'message' => 'User removed from the course.'));
        } else {
            // No rows affected, meaning the user was not enrolled in the course
            echo json_encode(array('success' => false, 'message' => 'User was not enrolled in the course.'));
        }
    } else {
        // Error executing the statement
        echo json_encode(array('success' => false, 'message' => 'Error removing user from the course.'));
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // Output message if courseID or employeeID parameters are not set
    echo json_encode(array('success' => false, 'message' => 'Course ID or Employee ID not specified.'));
}

// Close the database connection
mysqli_close($connect);
?>
