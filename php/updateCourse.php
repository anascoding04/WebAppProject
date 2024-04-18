<?php
require("_connect.php");

// Check if the form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $courseID = $_POST['ID'];
    $courseName = $_POST['courseName'];
    $courseDate = $_POST['courseDate'];
    $courseDuration = $_POST['courseDuration'];
    $maxAttendees = $_POST['maxAttendees'];
    $availableSeats = $_POST['availableSeats'];
    $courseDescription = $_POST['courseDescription'];

    // Validate and sanitize the data as needed

    // Prepare and execute the SQL query to update course details in the database
    $SQL = "UPDATE Course SET CourseName=?, CourseDate=?, CourseDuration=?, MaxAttendees=?, AvailableSeats=?, CourseDescription=? WHERE CourseID=?";
    $stmt = mysqli_prepare($connect, $SQL);
    mysqli_stmt_bind_param($stmt, 'ssssssi', $courseName, $courseDate, $courseDuration, $maxAttendees, $availableSeats, $courseDescription, $courseID);
    mysqli_stmt_execute($stmt);

    // Check if the update was successful
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        // Update successful
        $response = array('success' => true, 'message' => 'Course details updated successfully.');
        echo json_encode($response);
    } elseif (mysqli_stmt_affected_rows($stmt) == 0) {
        // Update failed
        $response = array('success' => false, 'message' => 'No changes have been made.');
        echo json_encode($response);
    } else {
        // Update failed
        $response = array('success' => false, 'message' => 'Failed to update course details.');
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
