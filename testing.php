<?php
	require "_connect.db.php";
	
	$sql = "SELECT * FROM `department`";
	$json = array(
		"success"=>true,
		"results"=> array()
	);
	$stmt = $mysqli->prepare($sql);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($department_id,$department);
	
	while ($stmt->fetch()) {
		// echo $department_id." ".$department."<br>";
		$inside_results = array(
			"name" => $department,
			"value" => $department_id,
			"text" => $department
		);
		array_push($json["results"], $inside_results);
	}

	// var_dump($json);	
	echo json_encode($json);
?>