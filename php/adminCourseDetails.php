<?php

require("_connect.php");

if (isset($_GET['ID'])) {
    $ID = $_GET['ID']; 
    $SQL = "SELECT * FROM Course
            WHERE Course.CourseID = ?";

    $stmt = mysqli_prepare($connect, $SQL); // Fix: Missing this line

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $ID); // Fix: Use $courseID instead of $ID
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo json_encode($row);
        } else {
            echo json_encode(array('error' => 'User not found.'));
        }

        mysqli_stmt_close($stmt);
        mysqli_close($connect);
    } else {
        echo json_encode(array('error' => 'Error in preparing SQL statement.'));
    }
}

?>