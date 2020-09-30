<?php
date_default_timezone_set("Asia/Manila");

$host = "192.168.14.22";
$user = "pftomulto";
$password = "Duosone123";
$database = "ihris_test";
$connect = mysqli_connect($host, $user, $password, $database);


$mysqli = new mysqli($host, $user, $password, $database);
$mysqli->set_charset("utf8");
