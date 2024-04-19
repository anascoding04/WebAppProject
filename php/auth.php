<?php

require("_connect.php");

if (!isset($_POST['txtUser']) || !isset($_POST['txtPass']))
{
    die("Incorrect details");
}

$captcha = $_POST['token'];
$secretKey = '6Ld0KZ4pAAAAAAkMdj4K12rJu1bEOO16PDXbu2Oa';
$reCAPTCHA = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha)));

var_dump($reCAPTCHA);

if ($reCAPTCHA->score <= 0.3)
{
    die("You are a bot!");
}

$ID = $_POST['txtUser'];
$password = $_POST['txtPass'];
$type = $_POST['type'];

if ($type == 'employee'){
    $SQL = "SELECT * FROM `Employees` WHERE `ID` = ? ";
} else if ($type == 'admin') {
    $SQL = "SELECT * FROM `Admin` WHERE `ID` = ?";
}


//Prepares the SQL statement for execution.
$stmt = mysqli_prepare($connect, $SQL);

//Binds the ID to the prepared statement as parameters.
mysqli_stmt_bind_param($stmt, 's', $ID);

//Executes the prepared query.
mysqli_stmt_execute($stmt);

//Gets the result set from the prepared statement.
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 1)
{
    $USER = mysqli_fetch_assoc($result);

    if (password_verify($password, $USER['Password']))
    {
        // echo "Welcome to the system " . $USER['firstName'];

        session_start();
        if ($type == 'employee'){
            $_SESSION['employee_loggedin'] = true;
            $_SESSION['admin_loggedin'] = false;
        } else if ($type == 'admin') {
            $_SESSION['admin_loggedin'] = true;
            $_SESSION['employee_loggedin'] = false;
        }
        
        $_SESSION['ID'] = $USER['ID'];
        $_SESSION['FirstName'] = $USER['FirstName'];

        // header("Location: ../dashboard.php");

        echo "true";

        exit;
    }
}

die("Invalid email or password.");

?>