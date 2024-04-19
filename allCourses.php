<?php

include('./php/check_login_employee.php');

$EmployeeID = $_SESSION['ID'];

?>


<!DOCTYPE html>
<html lang="en">
<head>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

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
            justify-content: flex-end;
            align-items: center;
        }
        h1 {
            margin: 50px 0;
            text-align: center;
            font-size: 60px;
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
            margin-right: 10px; 
        }
        .course-button {
            display: block;
            width: 100%;
            max-width: 500px;
            margin: 30px auto;
            padding: 20px;
            background-color: #ebf5f4;
            border: 1px solid #dddddd;
            border-radius: 5px;
            text-align: center;
            font-size: 30px;
            color: #333333;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .course-button:hover { 
            background-color: #a6e1e3;
        }
        .menu-button:hover { 
            background-color: #a6e1e3;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
        }
        .enrolled-courses,
        .not-enrolled-courses {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<header>
    <button class="menu-button" onclick="back()">Back</button>
</header>

<h1>All Courses</h1>

<div class="enrolled-courses">
    <h2>Enrolled:</h2>
    <div id="enrolled-courses-container"></div>
</div>

<div class="not-enrolled-courses">
    <h2>Not Enrolled:</h2>
    <div id="not-enrolled-courses-container"></div>
</div>

<script>
    function back() {
        // Redirect to the constructed URL
        window.location.href = './dashboard.php';
    }

    $(document).ready(function() {
        var employeeID = <?php echo($EmployeeID) ?>

        $.ajax({
            url: './php/enrolledCourses.php',
            type: 'GET',
            data: { employeeID: employeeID },
            success: function(response) {
                // Parse the JSON string into a JavaScript object
                var data = JSON.parse(response);

                // Check if response contains enrolled and not enrolled courses
                if (data.enrolledCourses && data.notEnrolledCourses) {
                    // Display enrolled courses
                    var enrolledHTML = '';
                    data.enrolledCourses.forEach(function(course) {
                        enrolledHTML += '<div class="course-button enrolled" id="' + course.ID + '">' + course.Name + '</div>';
                    });
                    $('#enrolled-courses-container').html(enrolledHTML);

                    // Display not enrolled courses
                    var notEnrolledHTML = '';
                    data.notEnrolledCourses.forEach(function(course) {
                        notEnrolledHTML += '<div class="course-button not-enrolled" id="' + course.ID + '">' + course.Name + '</div>';
                    });
                    $('#not-enrolled-courses-container').html(notEnrolledHTML);
                } else {
                    console.error('Error: No enrolled or not enrolled courses found.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });



        $(document).on('click', '.course-button', function() {
            // Retrieve the course ID from the id attribute of the clicked button
            var courseID = $(this).attr('id');
            var courseType = $(this).hasClass('enrolled') ? 'enrolled' : 'notEnrolled';
            $.ajax({
                url: './php/adminCourseDetails.php',
                type: 'GET',
                data: { ID: courseID }, // Send ID as a query parameter
                dataType: 'json', // Specify JSON data type
                success: function(response) {
                    console.log("hi")
                    // Check if response contains error
                    if (response.error) {
                        console.error(response.error);
                    } else {
                        window.location.href = './courseDetails.php?courseID=' + response.CourseID + '&courseName=' + response.CourseName + '&courseDate=' + response.CourseDate + '&courseDuration=' + response.CourseDuration + '&maxAttendees=' + response.MaxAttendees + '&availableSeats=' + response.AvailableSeats + '&courseDescription=' + response.CourseDescription + '&courseType=' + courseType;
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });
    });
</script>

</body>
</html>
