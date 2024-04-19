<?php
// Include the database connection script
require("_connect.php");

// Check if both EmployeeID and CourseID are set in the POST request
if (isset($_POST['employeeID']) && isset($_POST['courseID'])) {
    // Get the values of EmployeeID and CourseID from the POST request
    $employeeID = $_POST['employeeID'];
    $courseID = $_POST['courseID'];

    // Prepare SQL statement to retrieve MaxAttendees and AvailableSeats
    $courseInfoSQL = "SELECT MaxAttendees, AvailableSeats FROM Course WHERE CourseID = ?";
    $courseInfoStmt = mysqli_prepare($connect, $courseInfoSQL);
    mysqli_stmt_bind_param($courseInfoStmt, 'i', $courseID);
    mysqli_stmt_execute($courseInfoStmt);
    mysqli_stmt_bind_result($courseInfoStmt, $maxAttendees, $availableSeats);
    mysqli_stmt_fetch($courseInfoStmt);
    mysqli_stmt_close($courseInfoStmt);

    // Check if there are available seats in the course
    if ($availableSeats > 0) {
        // Prepare the SQL statement to insert into the Enrolment table
        $enrollSQL = "INSERT INTO Enrolment (EmployeeID, CourseID) VALUES (?, ?)";
        $enrollStmt = mysqli_prepare($connect, $enrollSQL);
        mysqli_stmt_bind_param($enrollStmt, 'ii', $employeeID, $courseID);

        // Execute the statement
        if (mysqli_stmt_execute($enrollStmt)) {
            // Enrolment successful
            echo json_encode(array('success' => 'Enrolment successful.'));
            // Update AvailableSeats in the Course table
            $updatedSeats = $availableSeats - 1;
            $updateSeatsSQL = "UPDATE Course SET AvailableSeats = ? WHERE CourseID = ?";
            $updateSeatsStmt = mysqli_prepare($connect, $updateSeatsSQL);
            mysqli_stmt_bind_param($updateSeatsStmt, 'ii', $updatedSeats, $courseID);
            mysqli_stmt_execute($updateSeatsStmt);
            mysqli_stmt_close($updateSeatsStmt);
        } else {
            // Error in enrolment
            echo json_encode(array('error' => 'Error in enrolment: ' . mysqli_error($connect)));
        }

        // Close the statement
        mysqli_stmt_close($enrollStmt);
    } else {
        // Course is full
        echo json_encode(array('error' => 'Course full.'));
    }
} else {
    // Output message if either EmployeeID or CourseID parameter is not set
    echo json_encode(array('error' => 'Employee ID or Course ID not specified.'));
}

// Close the database connection
mysqli_close($connect);
?>
