<?php
require("_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ID = $_POST['ID'];

    $SQL = "DELETE FROM Course WHERE CourseID=?";
    $stmt = mysqli_prepare($connect, $SQL);
    mysqli_stmt_bind_param($stmt, 'i', $ID);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        $response = array('success' => true, 'message' => 'Course removed successfully.');
        echo json_encode($response);
    } else {
        $response = array('success' => false, 'message' => 'Failed to remove course.');
        echo json_encode($response);
    }

    mysqli_stmt_close($stmt);
} else {
    $response = array('success' => false, 'message' => 'Invalid request method.');
    echo json_encode($response);
}

mysqli_close($connect);
?>
