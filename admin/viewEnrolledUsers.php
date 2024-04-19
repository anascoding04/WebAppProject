<?php

include('../php/check_login_admin.php');

$courseID = $_GET['ID'];
$courseName = $_GET['courseName'];

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

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            margin: 30px 0;
            text-align: center;
            font-size: 36px;
        }

        .menu-button {
            display: inline-block;
            width: 110px;
            padding: 10px;
            background-color: #ebf5f4;
            border: 1px solid #dddddd;
            border-radius: 5px;
            text-align: center;
            font-size: 16px;
            color: #333333;
            transition: background-color 0.3s ease;
            margin-left: 10px;
        }

        .menu-button:hover { 
            background-color: #a6e1e3;
        }

        .action-button {
            display: block;
            width: 100px;
            padding: 15px;
            margin: 20px auto 0;
            background-color: #ebf5f4;
            border: 1px solid #dddddd;
            border-radius: 5px;
            text-align: center;
            font-size: 14px;
            color: #333333;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .action-button:hover { 
            background-color: #a6e1e3;
        }

        #enrolled-users-container {
            margin-top: 20px;
        }

        .user-button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #ebf5f4;
            border: 1px solid #dddddd;
            border-radius: 5px;
            text-align: center;
            font-size: 18px;
            color: #333333;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .user-button:hover { 
            background-color: #a6e1e3;
        }


    </style>
</head>
<body>
    <header>
        <button class="menu-button" onclick="back()">Back</button>
    </header>
    <h1 id="courseName"></h1>

    <!-- Container to display enrolled users -->
    <div id="enrolled-users-container"></div>

    <script>

        var courseID = <?php echo json_encode($courseID); ?>;
        var courseName = <?php echo json_encode($courseName); ?>;

        function back() {
            // Redirect to the previous page
            window.history.back();
        }

        $(document).ready(function() {
            // Function to send AJAX request to fetch enrolled users
            function fetchEnrolledUsers(courseID, courseName) {
                $.ajax({
                    url: '../php/getEnrolledUsers.php', // Send AJAX request to the same page
                    type: 'GET',
                    data: { ID: courseID },
                    success: function(response) {
                        console.log(response.message);
                        // Optionally, update the UI with the response data
                        $('#enrolled-users-container').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }

            function removeUser(ID, courseID) {
                if (confirm("Are you sure you want to delete this user?")) {
                    $.ajax({
                        url: '../php/removeUserFromCourse.php', // Send AJAX request to the same page
                        type: 'POST',
                        data: { employeeID: ID, courseID: courseID },
                        success: function(response) {
                            console.log(response.message);
                            // Optionally, update the UI with the response data
                            $('#enrolled-users-container').html(response);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });

                }
            }

            $(document).on('click', '.user-button', function() {
                var ID = $(this).data('id'); // Get the user ID associated with the button
                removeUser(ID, courseID); // Call function to show user details
            });


            // Set the course name in the HTML
            $('#courseName').text(courseName);
            
            // Call the fetchEnrolledUsers function with the courseID and firstName
            if (courseID && courseName) {
                fetchEnrolledUsers(courseID, courseName);
            } else {
                console.error('courseID or courseName not found in URL.');
            }
        });
    </script>
    
</body>
</html>


