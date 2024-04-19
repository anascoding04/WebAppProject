<?php

include('../php/check_login_admin.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
        .delete-button {
            display: block;
            width: 100%;
            max-width: 150px;
            margin: 20px auto 0;
            padding: 15px;
            background-color: #ff0808;
            border: 1px solid #dddddd;
            border-radius: 5px;
            text-align: center;
            font-size: 20px;
            color: #333333;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .delete-button:hover { 
            background-color: #fa6969;
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

<h1 id="courseName"></h1>


<h2>Course Date: <span id="courseDate"></span></h2>
<h2>Course Duration (Hours): <span id="courseDuration"></span></h2>
<h2>Max Attendees: <span id="maxAttendees"></span></h2>
<h2>Description: <span id="courseDescription"></span></h2>

<button id="edit-button" class="launch-button">Edit Details</button>
<button id="view-users-button" class="launch-button">View Users</button>

<!-- Container to display enrolled users -->
<div id="enrolled-users-container"></div>

<button id="delete-button" class="delete-button">Delete Course</button>

</body>
</html>


<script>
    function back() {
        // Redirect to the constructed URL
        window.location.href = './viewCourses.php';
    }

    var course_name;
    var urlParams = new URLSearchParams(window.location.search);
    var ID = urlParams.get('ID');

    $(document).ready(function() {
        // Function to fetch user details when the page loads
        function fetchCourseDetails(ID) {
            $.ajax({
                url: '../php/adminCourseDetails.php',
                type: 'GET',
                data: { ID: ID }, // Send ID as a query parameter
                dataType: 'json', // Specify JSON data type
                success: function(response) {
                    // Check if response contains error
                    if (response.error) {
                        console.error(response.error);
                    } else {
                        // Populate user details in HTML elements
                        $('#courseName').text(response.CourseName);
                        $('#courseDate').text(response.CourseDate);
                        $('#courseDuration').text(response.CourseDuration);
                        $('#maxAttendees').text(response.MaxAttendees);
                        $('#availableSeats').text(response.AvailableSeats);
                        $('#courseDescription').text(response.CourseDescription);

                        course_name = $('#courseName').text();
                    }
                },
                error: function(xhr, status, error) {
                    console.log("hi");
                    console.error('Error:', error);
                }
            });
        }

      
        if (ID) {
            fetchCourseDetails(ID);
        } else {
            console.error('ID parameter is missing.');
        }
        });

        
    // Function to redirect to the edit page for editing user details
    function editCourseDetails(ID) {
        window.location.href = 'editCourseDetails.php?ID=' + ID;
    }

    // Add click event listener to the edit button
    $('#edit-button').click(function() {
        // Get the ID from the URL query string
        var urlParams = new URLSearchParams(window.location.search);
        var ID = urlParams.get('ID');
        // Redirect to the edit page with the ID parameter
        editCourseDetails(ID);
    });

    // Remove course functionality
    $('#delete-button').click(function() {
        if (confirm("Are you sure you want to remove this course?")) {
            $.ajax({
                url: '../php/deleteCourse.php',
                type: 'POST',
                data: { ID: ID },
                dataType: 'json',
                success: function(response) {
                    console.log(response.message);
                    window.location.href = './viewCourses.php';
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }
    });

    console.log(course_name)
    // Function to handle viewing enrolled users
    $('#view-users-button').click(function() {
        window.location.href = 'viewEnrolledUsers.php?ID=' + ID + '&courseName=' + course_name;
    });



</script>