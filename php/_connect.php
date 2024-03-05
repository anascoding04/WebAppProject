<?php

$host = "plesk.remote.ac";
$database = "WS372743_WAD";
$username = "WS372743_WAD";
$password = "Zqxf97!37";

$connect = mysqli_connect($host, $username, $password, $database);

if (!$connect) die("Unable to connect to the database.");