<?php
require("_connect.php");


$courseID = $_GET['courseID'];

$SQL = "SELECT * FROM Course
        WHERE Course.CourseID = ?";

$stmt = mysqli_prepare($connect, $SQL);

// Check if the prepared statement was created successfully
if (!$stmt) {
    die("Error in preparing SQL statement: " . mysqli_error($connect));
}

// Bind parameters
mysqli_stmt_bind_param($stmt, 's', $EmployeeID);

// Execute the prepared query
mysqli_stmt_execute($stmt);

// Get the result set from the prepared statement
$result = mysqli_stmt_get_result($stmt);

if ($result) {
    
    // Check if the user is enrolled in any courses
    if (mysqli_num_rows($result) > 0) {
        // Generate HTML for course buttons
        while ($row = mysqli_fetch_assoc($result)) {
            $courseID = $row['CourseID'];
            $courseName = $row['CourseName'];
            $courseDate = $row['CourseDate'];
            $courseDuration = $row['CourseDuration'];
            $maxAttendees = $row['MaxAttendees'];
            $availableSeats = $row['AvailableSeats'];
            $courseDescription = $row['CourseDescription'];

            redirectToCourse($courseID, $courseName, $courseDate, $courseDuration, $maxAttendees, $availableSeats, $courseDescription);
        }
    } else {
        // Display message if the user is not enrolled in any courses
        $courseButtonsHTML = 'You are currently not enrolled in any courses';
    }

    // Close the result set
    mysqli_free_result($result);
} else {
    // Error handling if query execution fails
    $courseButtonsHTML = 'Error fetching courses: ' . mysqli_error($connect);
}

// Close the prepared statement
mysqli_stmt_close($stmt);

// Close the database connection
mysqli_close($connect);

?>


<script>
    // JavaScript function to redirect to a specified course page with courseID as a query parameter
    function redirectToCourse(courseID, courseName, courseDate, courseDuration, maxAttendees,
                                availableSeats, courseDescription) {
        // Construct the URL with the courseID as a query parameter
        var coursePage = './courseDetails.php?courseID=' + courseID + '&courseName=' + courseName + '&courseDate=' + courseDate + '&courseDuration=' + courseDuration + '&maxAttendees=' + maxAttendees + '&availableSeats=' + availableSeats + '&courseDescription=' + courseDescription;
        // Redirect to the constructed URL
        window.location.href = coursePage; // Use coursePage variable here
    }
</script>

