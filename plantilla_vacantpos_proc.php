<?php
require_once "_connect.db.php";

if(isset($_POST["load"])){
	$data = array();
	$sql = "SELECT
	*,
	`plantillas`.`id` AS plantillas_id,
	`publications`.`plantilla_id` AS inPublication
FROM
	`plantillas`
	LEFT JOIN `department` ON `plantillas`.`department_id` = `department`.`department_id`
	LEFT JOIN `positiontitles` ON `plantillas`.`position_id` = `positiontitles`.`position_id`
	LEFT JOIN `qualification_standards` ON `plantillas`.`position_id` = `qualification_standards`.`position_id`
	LEFT JOIN `employees` ON `plantillas`.`incumbent` = `employees`.`employees_id` 
	LEFT JOIN `publications` ON `plantillas`.`id` = `publications`.`plantilla_id`
WHERE
	`incumbent` = '' 
	OR `incumbent` IS NULL 
	AND `abolish` IS NULL
ORDER BY
	`positiontitles`.`position` ASC";

$result = $mysqli->query($sql);
// echo $mysqli->error;
while ($row = $result->fetch_assoc()) {
		$id = $row["plantillas_id"];
		$datum = array(
			"id" => $id,
			"isPublished" => !empty($row["inPublication"])?true:false,
			"item_no" => $row["item_no"],
			"page_no" => "",
			"position" => $row["position"],
			"functional" => $row["functional"],
			"department" => $row["department"],
			"education" => $row["education"],
			"experience" => $row["experience"],
			"training" => $row["training"],
			"eligibility" => $row["eligibility"],
			"vacated_by" => $row["vacated_by"]
		);
		// $index = 'pla'.$id;
		$data['id_'.$id] = $datum;
	}

	echo json_encode($data);
}

elseif (isset($_POST["publish"])) {
	$plantilla_id = $_POST["plantilla_id"];
	$sql = "INSERT INTO `publications` (`plantilla_id`, `date_created`, `date_updated`) VALUES (?, current_timestamp(), current_timestamp())";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('i',$plantilla_id);
	$stmt->execute();
	echo json_encode($stmt->error_list);
}

elseif (isset($_POST["restore"])) {
	$plantilla_id = $_POST["plantilla_id"];
	$sql = "DELETE FROM `publications` WHERE `publications`.`plantilla_id` = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('i',$plantilla_id);
	$stmt->execute();
	echo json_encode($stmt->error_list);
}

// elseif (isset($_POST["checkIfPublished"])) {
// 	$plantilla_id = $_POST["plantilla_id"];
// 	$sql = "SELECT * FROM `publications` WHERE `plantilla_id` = ?";
// 	$stmt = $mysqli->prepare($sql);
// 	$stmt->bind_param('i', $plantilla_id);
// 	$stmt->execute();
// 	$stmt->store_result();
// 	$num_rows = $stmt->num_rows;
	
// 	echo json_encode('num_rows');
	
// }

?>