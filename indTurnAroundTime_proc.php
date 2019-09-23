<?php
require '_connect.db.php';
require 'libs/VacantPost.php';

$vacantPost = new VacantPost();

if (isset($_POST["load"])) {
	$year = $_POST["yearState"];
	$view = $vacantPost->load($year,"indTurnArroundTimeInfo.php");
	echo $view;
}

elseif (isset($_POST["addNew"])) {
	$data0 = $_POST["data0"];
	$data1 = $_POST["data1"];
	$vacantPost->addNew($data0,$data1);
}

elseif (isset($_POST["getValues"])) {
	$rspvac_id = $_POST["rspvac_id"];
	$values = $vacantPost->getValues($rspvac_id);
	echo $values;
}

elseif(isset($_POST["editEntry"])){
	$rspvac_id = $_POST["id"];
	$data0 = $_POST["data0"];
	$data1 = $_POST["data1"];
	$vacantPost->editEntry($rspvac_id,$data0,$data1);
}

elseif (isset($_POST["deleteFunc"])) {
	$rspvac_id = $_POST["rspvac_id"];
	$vacantPost->deleteFunc($rspvac_id);
}


?>
