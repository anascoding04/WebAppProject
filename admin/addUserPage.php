<?php

include('../php/check_login_admin.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Details</title>
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
        input[type="text"], input[type="email"], input[type="password"] {
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

<h1>Add User Details</h1>

<form id="edit-form">
    <label for="firstName">First Name:</label>
    <input type="text" id="firstName" name="firstName" required>

    <label for="lastName">Last Name:</label>
    <input type="text" id="lastName" name="lastName" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <label for="jobTitle">Job Title:</label>
    <input type="text" id="jobTitle" name="jobTitle">

    <label for="accessLevel">Access Level:</label>
    <input type="text" id="accessLevel" name="accessLevel">

    <input type="submit" value="Submit">
</form>


<script>
;

    function back() {
        // Redirect to the constructed URL
        window.location.href = './dashboard.php?ID=' + ID;
    }

    $(document).ready(function() {
   

        $('#edit-form').submit(function(event) {
        event.preventDefault(); // Prevent default form submission

        // Get form data
        var firstName = $('#firstName').val();
        var lastName = $('#lastName').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var jobTitle = $('#jobTitle').val();
        var accessLevel = $('#accessLevel').val();

        // Send form data using AJAX
        $.ajax({
            url: '../php/addUser.php',
            type: 'POST',
            data: {
                firstName: firstName,
                lastName: lastName,
                email: email,
                password: password,
                jobTitle: jobTitle,
                accessLevel: accessLevel
            },
            dataType: 'json',
            success: function(response) {
                // Check if the update was successful
                if (response.success) {
                    // Update successful
                    alert(response.message);
                    // Redirect to another page or perform other actions as needed
                    window.location.href = './dashboard.php'
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
