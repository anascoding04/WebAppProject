<?php

include('./php/check_login.php');

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
    </style>
</head>
<body>

<header>
    <button class="menu-button">All Courses</button>
    <button id="logout-btn" class="menu-button">Logout</button>
</header>

<h1>My Courses</h1>

<?php include('./php/getCourseDetails.php'); ?>
<div id="course-buttons">
    <?php echo $courseButtonsHTML; ?>
</div>


<div class="footer">
    <a href="#">View all available courses</a>
</div>


<script>

    $(document).ready(function() {
        // Logout button click event
        $('#logout-btn').click(function() {
            // Send AJAX request to logout.php
            $.ajax({
                url: './php/logout.php',
                type: 'GET',
                success: function() {
                    // Redirect to the login page
                    window.location.href = 'index.php';
                },
                error: function(xhr, status, error) {
                    console.error('Logout error:', error);
                }
            });
        });
    });

</script>

</body>
</html>

