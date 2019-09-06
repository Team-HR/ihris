<?php

require '_connect.db.php';


for ($i=0; $i < 1000; $i++) { 
	# code...
	echo getNames();

}


function getNames () {
require '_connect.db.php';
$sql = "SELECT * FROM `employees`";
$result = $mysqli->query($sql);
$view = "";
while ($row = $result->fetch_assoc()) {
	$lastName = $row["lastName"];
	$view .= $lastName;
}
	return $view;
}