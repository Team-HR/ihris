<?php
/* Set internal character encoding to UTF-8 */
// mb_internal_encoding("UTF-8");
date_default_timezone_set("Asia/Manila");

$host = "localhost";
$user = "root";
$password = "";
$database = "hristest";
$connect = mysqli_connect($host, $user, $password, $database);


$mysqli = new mysqli($host, $user, $password, $database);
$mysqli->set_charset("utf8");
 /**
  * 
  */
 class Database extends mysqli
 {
 	
 	private $host = "localhost";
	private $user = "root";
	private $password = "";
	private $database = "hristest";
 	
 	function __construct()
 	{
 		# code...
 		
 	}




 }