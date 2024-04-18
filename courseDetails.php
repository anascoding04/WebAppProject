<?php

include('./php/check_login.php');

$courseID = $_GET['courseID'];
$courseName = $_GET['courseName'];
$courseDate = $_GET['courseDate'];
$courseDuration = $_GET['courseDuration'];
$maxAttendees = $_GET['maxAttendees'];
$availableSeats = $_GET['availableSeats'];
$courseDescription = $_GET['courseDescription'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #84d1cd;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #21868a;
            color: #ffffff;
            padding: 20px;
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }
        h1 {
            margin: 30px 0;
            text-align: center;
            font-size: 60px;
        }
        h2 {
            margin: 10px 0;
            text-align: center;
            font-size: 25px;
        }
        p {
            margin: 0;
            padding: 0;
            max-width: 800px; /* Limit the width of the paragraph */
            text-align: center; /* Adjust as needed */
            font-size: 24px; /* Adjust as needed */
            font-weight: normal
        }
        .menu-button {
            display: inline-block;
            width: 100%;
            max-width: 110px;
            margin: 0;
            padding: 5px;
            background-color: #ebf5f4;
            border: 1px solid #dddddd;
            border-radius: 5px;
            text-align: center;
            font-size: 16px;
            color: #333333;
            transition: background-color 0.3s ease;
            margin-left: 10px; 
        }
        .launch-button {
            display: block;
            width: 100%;
            max-width: 200px;
            margin: 0 auto;
            padding: 15px;
            background-color: #ebf5f4;
            border: 1px solid #dddddd;
            border-radius: 5px;
            text-align: center;
            font-size: 20px;
            color: #333333;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .launch-button:hover { 
            background-color: #a6e1e3;
        }
        .menu-button:hover { 
            background-color: #a6e1e3;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
        }
        .about {
            white-space: pre-wrap;
            word-wrap: break-word;
            max-width: 800px; /* Limit the width of the paragraph */
            margin: 0 auto; /* Center the container horizontally */
            text-align: justify; /* Justify the text */
            font-size: 24px; /* Adjust as needed */
            line-height: 1.5; /* Adjust as needed */
            font-weight: normal;
        }

    </style>
</head>
<body>


<header>
    <button class="menu-button" onclick="back()">Back</button>
</header>

<h1><?php echo $courseName; ?></h1>

<button class="launch-button">Launch Course</button>

<div class="about">
    <p><strong>About: </strong><p><?php echo $courseDescription; ?></p>
</div>



<h2>Duration: <span style="display: inline-block;">
    <p><?php echo $courseDuration; ?></p>
</span></h2>

<h2>Course Capacity: <span style="display: inline-block;">
    <p><?php echo $maxAttendees; ?></p>
</span></h2>


</body>
</html>


<script>
    function back() {
        // Redirect to the constructed URL
        window.location.href = './dashboard.php';
    }
</script>