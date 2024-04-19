<?php

include('../php/check_login_admin.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
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
            margin: 30px 0;
            text-align: center;
            font-size: 36px;
        }
        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"], input[type="date"], input[type="number"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #21868a;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #18635e;
        }
    </style>
</head>
<body>

<header>
    <button class="menu-button" onclick="back()">Back</button>
</header>

<h1>Edit Course Details</h1>

<form id="edit-form">
    <label for="courseName">Course Name:</label>
    <input type="text" id="courseName" name="courseName" required>

    <label for="courseDate">Course Date:</label>
    <input type="date" id="courseDate" name="courseDate" required>

    <label for="courseDuration">Course Duration:</label>
    <input type="text" id="courseDuration" name="courseDuration" required>

    <label for="maxAttendees">Max Attendees:</label>
    <input type="number" id="maxAttendees" name="maxAttendees" required>

    <label for="availableSeats">Available Seats:</label>
    <input type="number" id="availableSeats" name="availableSeats" required>

    <label for="courseDescription">Course Description:</label>
    <textarea id="courseDescription" name="courseDescription" rows="5" required></textarea>

    <input type="submit" value="Save Changes">
</form>

<script>

    var urlParams = new URLSearchParams(window.location.search);
    var ID = urlParams.get('ID');

    function back() {
        // Redirect to the constructed URL
        window.location.href = './viewCourseDetails.php?ID=' + ID;
    }

    $(document).ready(function() {
        // Function to fetch course details when the page loads
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
                        // Populate course details in input fields
                        $('#courseName').val(response.CourseName);
                        $('#courseDate').val(response.CourseDate);
                        $('#courseDuration').val(response.CourseDuration);
                        $('#maxAttendees').val(response.MaxAttendees);
                        $('#availableSeats').val(response.AvailableSeats);
                        $('#courseDescription').val(response.CourseDescription);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        // Fetch course details when the page loads
        if (ID) {
            fetchCourseDetails(ID);
        } else {
            console.error('ID parameter is missing.');
        }

        // Submit form data when the form is submitted
        $('#edit-form').submit(function(event) {
            event.preventDefault(); // Prevent default form submission

            // Get form data
            var courseName = $('#courseName').val();
            var courseDate = $('#courseDate').val();
            var courseDuration = $('#courseDuration').val();
            var maxAttendees = $('#maxAttendees').val();
            var availableSeats = $('#availableSeats').val();
            var courseDescription = $('#courseDescription').val();

            // Send form data using AJAX
            $.ajax({
                url: '../php/updateCourse.php',
                type: 'POST',
                data: {
                    ID: ID,
                    courseName: courseName,
                    courseDate: courseDate,
                    courseDuration: courseDuration,
                    maxAttendees: maxAttendees,
                    availableSeats: availableSeats,
                    courseDescription: courseDescription
                },
                dataType: 'json',
                success: function(response) {
                    // Check if the update was successful
                    if (response.success) {
                        // Update successful
                        alert(response.message);
                        // Redirect to another page or perform other actions as needed
                        window.location.href = 'viewCourseDetails.php?ID=' + ID;
                    } else {
                        // Update failed
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    // Handle error appropriately
                }
            });
        });
    });

</script>

</body>
</html>
