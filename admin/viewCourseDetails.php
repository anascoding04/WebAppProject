<?php

include('../php/check_login.php');

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

<h1>Course Details</h1>


<h2>Course Date: <span id="courseDate"></span></h2>
<h2>Course Duration: <span id="courseDuration"></span></h2>
<h2>Max Attendees: <span id="maxAttendees"></span></h2>
<h2>Description: <span id="courseDescription"></span></h2>

<button id="edit-button" class="launch-button">Edit Details</button>

</body>
</html>


<script>
    function back() {
        // Redirect to the constructed URL
        window.location.href = './viewCourses.php';
    }

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
                    }
                },
                error: function(xhr, status, error) {
                    console.log("hi");
                    console.error('Error:', error);
                }
            });
        }

        // Get the ID from the URL query string
        var urlParams = new URLSearchParams(window.location.search);
        var ID = urlParams.get('ID');
        // Fetch user details when the page loads
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


</script>