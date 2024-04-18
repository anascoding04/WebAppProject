<?php
require("_connect.php");

// Check if courseName parameter is set in the GET request
if (isset($_GET['courseName'])) {
    // Get the value of courseName from the GET request
    $courseName = $_GET['courseName'];

    if ($courseName == "all") {
        $SQL = "SELECT * FROM Course";
        $stmt = mysqli_prepare($connect, $SQL);
    } else {
        $SQL = "SELECT * FROM Course WHERE CourseName = ?";
        $stmt = mysqli_prepare($connect, $SQL);
        mysqli_stmt_bind_param($stmt, 's', $courseName);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if there are any results
    if ($result && mysqli_num_rows($result) > 0) {
        // Initialize variable to store buttons HTML
        $buttonsHTML = '';

        // Generate HTML for each course found
        while ($row = mysqli_fetch_assoc($result)) {
            $courseName = $row['CourseName'];
            $courseID = $row['CourseID'];
            // Generate button with onclick event to show course details
            $buttonsHTML .= "<button class='name-button' data-id='$courseID' onclick='showCourseDetails(\"$courseID\")'>$courseName</button>";
        }

        // Output the generated buttons HTML
        echo $buttonsHTML;
    } else {
        // Output message if no users found
        echo "No users found.";
    }

    // Free result and close statement
    mysqli_free_result($result);
    mysqli_stmt_close($stmt);
} else {
    // Output message if courseName parameter is not set
    echo "No user specified.";
}

// Close the database connection
mysqli_close($connect);
?>
