<?php

include('./php/check_login_employee.php');

$courseID = $_GET['courseID'];
$courseName = $_GET['courseName'];
$courseDate = $_GET['courseDate'];
$courseDuration = $_GET['courseDuration'];
$maxAttendees = $_GET['maxAttendees'];
$availableSeats = $_GET['availableSeats'];
$courseDescription = $_GET['courseDescription'];

$type = $_GET['courseType'];

$employeeID = $_SESSION['ID'];

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
        .remove-button {
            display: block;
            width: 100%;
            max-width: 200px;
            margin: 0 auto;
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
        .remove-button:hover { 
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

<h1><?php echo $courseName; ?></h1>

<?php
// Check if the course type is enrolled
if ($type === "enrolled") {
    echo '<button class="remove-button">Drop Out Of Course</button>';
} else {
    // Display button for not enrolled course
    echo '<button class="launch-button">Enroll to Course</button>';
}
?>

<div class="about">
    <p><strong>About: </strong><p><?php echo $courseDescription; ?></p>
</div>



<h2>Duration (Hours): <span style="display: inline-block;">
    <p><?php echo $courseDuration; ?></p>
</span></h2>

<h2>Available Spaces: <span style="display: inline-block;">
    <p><?php echo $availableSeats; ?></p>
</span></h2>


</body>
</html>


<script>
    function back() {
        // Redirect to the constructed URL
        window.location.href = './dashboard.php';
    }

</script>


<script>

    $(document).ready(function() {
            // Add click event listener to the "Enroll to Course" button
            $('.launch-button').click(function() {
            // Get the course ID
            var courseID = <?php echo json_encode($courseID); ?>;
            var employeeID = <?php echo json_encode($employeeID); ?>;
            
            // Send AJAX request to PHP script to enroll the user
            $.ajax({
                url: './php/enrollToCourse.php',
                type: 'POST',
                data: { courseID: courseID, employeeID: employeeID },
                success: function(response) {
                    // Parse JSON response
                    var responseData = JSON.parse(response);
                    // Check if enrollment was successful
                    if (responseData.success) {
                        // Show success message
                        alert('Enrollment successful!');
                        // Optionally, reload the page or redirect to another page
                        window.location.href = 'allCourses.php';
                    } else {
                        // Enrollment failed, handle the error
                        if (responseData.error === 'Course full.') {
                            // Show a message indicating that the course is full
                            alert('Sorry, the course is full.');
                        } else {
                            // Show a generic error message
                            alert('An error occurred: ' + responseData.error);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error('Error:', error);
                }
            });
        });




            $('.remove-button').click(function() {
                // Get the course ID
                var courseID = <?php echo json_encode($courseID); ?>;
                var employeeID = <?php echo json_encode($employeeID); ?>;
                
                if (confirm("Are you sure you want to drop out?")) {
                // Send AJAX request to PHP script to enroll the user
                $.ajax({
                    url: './php/removeFromCourse.php',
                    type: 'POST',
                    data: { courseID: courseID, employeeID: employeeID },
                    success: function(response) {
                        // Handle success response
                        console.log(response);
                        // For example, you can reload the page or show a success message
                        window.location.href = 'allCourses.php'
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error('Error:', error);
                        }
                    });
                }
            });
        });

</script>



    