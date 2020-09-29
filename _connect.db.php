<?php
date_default_timezone_set("Asia/Manila");

$host = "localhost";
$user = "admin";
$password = "your-preferred-password";
$database = "ihris";
$connect = mysqli_connect($host, $user, $password, $database);


$mysqli = new mysqli($host, $user, $password, $database);
$mysqli->set_charset("utf8");
