<?php
require("_connect.php");

// Check if the form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $courseName = $_POST['courseName'];
    $courseDate = $_POST['courseDate'];
    $courseDuration = $_POST['courseDuration'];
    $maxAttendees = $_POST['maxAttendees'];
    $availableSeats = $_POST['availableSeats'];
    $courseDescription = $_POST['courseDescription'];

    // Validate and sanitize the data as needed

    // Prepare and execute the SQL query to insert course details into the database
    $SQL = "INSERT INTO Course (CourseName, CourseDate, CourseDuration, MaxAttendees, AvailableSeats, CourseDescription) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connect, $SQL);
    mysqli_stmt_bind_param($stmt, 'ssssss', $courseName, $courseDate, $courseDuration, $maxAttendees, $availableSeats, $courseDescription);
    mysqli_stmt_execute($stmt);

    // Check if the insert was successful
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        // Insert successful
        $response = array('success' => true, 'message' => 'Course added successfully.');
        echo json_encode($response);
    } elseif (mysqli_stmt_affected_rows($stmt) == 0) {
        // Insert failed
        $response = array('success' => false, 'message' => 'Empty field(s).');
        echo json_encode($response);
    } else {
        // Insert failed
        $response = array('success' => false, 'message' => 'Failed to add course.');
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
