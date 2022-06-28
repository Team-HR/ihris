<?php
date_default_timezone_set("Asia/Manila");

$host = "localhost";
$user = "root";
$password = "";
$database = "ihris";

$mysqli = new mysqli($host, $user, $password, $database);
$mysqli->set_charset("utf8");

// Connection for esib
$database = "hrnibai";
$mysqli2 = new mysqli($host, $user, $password, $database);
$mysqli2->set_charset("utf8");

// MYSQL ERROR REPORTING START
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
// MYSQL ERROR REPORTING END