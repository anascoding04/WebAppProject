<?php
require("_connect.php");

// Check if employeeID parameter is set in the GET request
if (isset($_GET['employeeID'])) {
    // Get the value of employeeID from the GET request
    $employeeID = $_GET['employeeID'];

    // Array to store enrolled courses
    $enrolledCourses = array();
    // Array to store not enrolled courses
    $notEnrolledCourses = array();

    // Prepare the SQL statement to retrieve all courses
    $coursesSQL = "SELECT * FROM Course";
    $coursesResult = mysqli_query($connect, $coursesSQL);

    // Check if there are any courses
    if ($coursesResult && mysqli_num_rows($coursesResult) > 0) {
        while ($course = mysqli_fetch_assoc($coursesResult)) {
            $courseID = $course['CourseID'];
            $courseName = $course['CourseName'];

            // Prepare the SQL statement to check if the employee is enrolled in the course
            $enrollmentSQL = "SELECT * FROM Enrolment WHERE CourseID = ? AND EmployeeID = ?";
            $enrollmentStmt = mysqli_prepare($connect, $enrollmentSQL);
            mysqli_stmt_bind_param($enrollmentStmt, 'ii', $courseID, $employeeID);
            mysqli_stmt_execute($enrollmentStmt);
            $enrollmentResult = mysqli_stmt_get_result($enrollmentStmt);

            if (mysqli_num_rows($enrollmentResult) > 0) {
                // Employee is enrolled in the course
                $enrolledCourses[] = array('ID' => $courseID, 'Name' => $courseName);
            } else {
                // Employee is not enrolled in the course
                $notEnrolledCourses[] = array('ID' => $courseID, 'Name' => $courseName);
            }

            // Close the statement
            mysqli_stmt_close($enrollmentStmt);
        }
    } else {
        // No courses found
        echo json_encode(array('error' => 'No courses found.'));
        exit;
    }

    // Return JSON response with enrolled and not enrolled courses
    echo json_encode(array('enrolledCourses' => $enrolledCourses, 'notEnrolledCourses' => $notEnrolledCourses));
} else {
    // Output message if employeeID parameter is not set
    echo json_encode(array('error' => 'Employee ID not specified.'));
}

// Close the database connection
mysqli_close($connect);
?>
