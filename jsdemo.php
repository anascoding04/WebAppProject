<?php

// Restart/start the session
session_start();

// Check if the user is logged in as they will have this value.
if (!isset($_SESSION['userID']))
{
    die("Invalid, you are not logged in.");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>jQuery Demo</title>
</head>

<body>
    <h1 id="title">Welcome to the website!</h1>
    <button id="btnChangeText">Change the Text</button>

    <hr>

    <form id="hash-form">
        <input type="text" name="hash_input" placeholder="Value to Hash" />
        <button type="submit">Hash!</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>

        $('#btnChangeText').click(function () {
            $('#title').text("Hello, world!");
        });

        $('#hash-form').submit(function (e) {
            e.preventDefault();

            $.ajax({
                url: "./hash.php",
                type: "POST",
                data: $('#hash-form').serialize(),
                success: function (res) {
                    $('#title').text(res);
                }
            });
        });

    </script>
</body>

</html>