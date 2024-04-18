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
        .menu-button:hover { 
            background-color: #a6e1e3;
        }
        .search-container {
            text-align: center;
            margin-top: 20px;
        }
        .search-bar {
            width: 50%;
            max-width: 400px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            margin-right: 10px;
        }
        .search-button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .search-button:hover {
            background-color: #45a049;
        }
        .name-button {
            display: block;
            width: 100%;
            max-width: 200px;
            margin: 20px auto;
            padding: 10px;
            background-color: #ebf5f4;
            border: 1px solid #dddddd;
            border-radius: 5px;
            text-align: center;
            font-size: 20px;
            color: #333333;
            transition: background-color 0.3s ease;
        }
        .name-button:hover { 
            background-color: #a6e1e3;
        }
        .add-button {
            display: block;
            width: 100%;
            max-width: 200px;
            margin: 20px auto;
            padding: 10px;
            background-color: #ebf5f4;
            border: 1px solid #dddddd;
            border-radius: 5px;
            text-align: center;
            font-size: 20px;
            color: #333333;
            transition: background-color 0.3s ease;
            position: absolute; /* Position the button absolutely */
            top: 200px; /* Position it 20px from the top */
            right: 70px; /* Position it 20px from the right */
        }
        .add-button:hover { 
            background-color: #a6e1e3;
        }
        .view-all-button {
            display: block;
            width: 100%;
            max-width: 150px;
            margin: 20px auto;
            padding: 10px;
            background-color: #ebf5f4;
            border: 1px solid #dddddd;
            border-radius: 5px;
            text-align: center;
            font-size: 15px;
            color: #333333;
            transition: background-color 0.3s ease;
            position: absolute; /* Position the button absolutely */
            top: 200px; /* Position it 20px from the top */
            right: 300px; /* Position it 20px from the right */
        }
        .view-all-button:hover { 
            background-color: #a6e1e3;
        }
    </style>
</head>
<body>

<header>
    <button class="menu-button" onclick="back()">Back</button>
</header>

<h1>Courses</h1>

<div class="search-container">
    <form id="search-form">
        <input type="text" id="search-input" placeholder="Search...">
        <button type="submit" class="search-button">Search</button>
    </form>
</div>

<div id="course-buttons">
    <!-- User details buttons will be displayed here -->
</div>

<div id="search-result">
    <!-- Search result will be displayed here -->
</div>

<button id="add-user-button" class="add-button">Add Course</button>

<button id="view-all-users-button" class="view-all-button">View All Courses</button>

<script>

    function back() {
            // Redirect to the constructed URL
            window.location.href = './dashboard.php';
        }
        
    $(document).ready(function() {
        $('#search-form').submit(function(event) {
            event.preventDefault(); // Prevent default form submission
            var searchValue = $('#search-input').val(); // Get search value
            fetchCourseDetails(searchValue); // Call function to fetch user details
        });

        // Function to fetch user details
        function fetchCourseDetails(searchValue) {
            $.ajax({
                url: '../php/getCourseNames.php',
                type: 'GET',
                data: { courseName: searchValue }, // Send search value as query parameter
                success: function(response) {
                    // Display user details buttons
                    $('#course-buttons').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }
        
        // Function to show user details when a button is clicked
        $(document).on('click', '.name-button', function() {
            var courseID = $(this).data('id'); // Get the user ID associated with the button
            showCourseDetails(courseID); // Call function to show user details
        });

        // Function to redirect to viewUserDetails.php page with user ID as parameter
        function showCourseDetails(courseID) {
            window.location.href = 'viewCourseDetails.php?ID=' + courseID;
        }

        $('#add-user-button').click(function() {
            // Redirect to the page where users can be added
            window.location.href = 'addCoursePage.php';
        });

        $('#courses-button').click(function() {
            // Redirect to the page where users can be added
            window.location.href = 'viewCourses.php';
        });

        $('#view-all-users-button').click(function() {
            $.ajax({
                url: '../php/getCourseNames.php',
                type: 'GET',
                data: { courseName: "all" }, // Send search value as query parameter
                success: function(response) {
                    // Display user details buttons
                    $('#course-buttons').html(response);
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




