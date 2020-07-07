<?php
require_once "_connect.db.php";

if(isset($_POST["load"])){
	$data = array();
	$sql = "SELECT
	* 
	FROM
	`plantillas_test`
	LEFT JOIN `department` ON `plantillas_test`.`department_id` = `department`.`department_id`
	LEFT JOIN `positiontitles` ON `plantillas_test`.`position_id` = `positiontitles`.`position_id`
	LEFT JOIN `employees` ON `plantillas_test`.`incumbent` = `employees`.`employees_id` 
	WHERE
	`incumbent` = '' OR `incumbent` IS NULL
	AND
	`abolish` IS NULL
	ORDER BY
	`positiontitles`.`position` ASC";

$result = $mysqli->query($sql);
// echo $mysqli->error;
while ($row = $result->fetch_assoc()) {
		$datum = array(
			"id" => $row["id"],
			"item_no" => $row["item_no"],
			"page_no" => $row["page_no"],
			"position" => $row["position"],
			"functional" => $row["functional"],
			"department" => $row["department"],
			"vacated_by" => $row["vacated_by"]
		);
		$data[] = $datum;
	}

	echo json_encode($data);
}
elseif (isset($_POST["publish"])) {
	$plantilla_id = $_POST["plantilla_id"];
	echo json_encode("HELLO".$plantilla_id);
}

?>