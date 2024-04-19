<?php
require("_connect.php");

// Check if courseID parameter is set in the GET request
if (isset($_GET['ID'])) {
    // Get the value of courseID from the GET request
    $courseID = $_GET['ID'];

    // Prepare the SQL statement
    $SQL = "SELECT * FROM Employees
            INNER JOIN Enrolment ON Employees.ID = Enrolment.EmployeeID
            WHERE Enrolment.CourseID = ?";
    
    $stmt = mysqli_prepare($connect, $SQL);
    mysqli_stmt_bind_param($stmt, 'i', $courseID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if there are any results
    if ($result && mysqli_num_rows($result) > 0) {
        // Initialize variable to store buttons HTML
        $buttonsHTML = '';

        // Generate HTML for each employee found
        while ($row = mysqli_fetch_assoc($result)) {
            $firstName = $row['FirstName'];
            $lastName = $row['LastName'];
            $ID = $row['ID'];
            // Generate button with onclick event to show employee details
            $buttonsHTML .= "<button class='user-button' data-id='$ID' onclick='showUserDetails(\"$ID\")'>$firstName $lastName</button>";
        }

        // Output the generated buttons HTML
        echo $buttonsHTML;
    } else {
        // Output message if no users found
        echo "No users found for this course.";
    }

    // Free result and close statement
    mysqli_free_result($result);
    mysqli_stmt_close($stmt);
} else {
    // Output message if courseID parameter is not set
    echo "No course specified.";
}

// Close the database connection
mysqli_close($connect);
?>
