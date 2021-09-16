<?php
require_once '_connect.db.php';

$sql = "SELECT * FROM `employees`";
$result1 = $mysqli->query($sql);
$json = array();
$inside_json = array();
while ($row = $result1->fetch_assoc()) {
	$dateSurveyed = null;
	$status = "";
	$employees_id = $row["employees_id"];
	// check if the employee has already completed the survey start
	$sql2 = "SELECT  * FROM `competency` WHERE `employees_id` = '$employees_id'";
	$result2 = $mysqli->query($sql2);
	if ($result2->num_rows != 0) {
		$row2 = $result2->fetch_assoc();
		$datetime = $row2["datetime"];
		$dateSurveyed = dateToStr($datetime);
		$status = " --- Already completed the survey! on $dateSurveyed";
	}
	// check if the employee has already completed the survey end

	if (!empty($row['extName'])) {
		$extName = ", " . $row['extName'];
	} else {
		$extName = "";
	}

	$fullName = $row['firstName'] . " " . $row['middleName'] . " " . $row['lastName'] . $extName . $status;
	$department_id = $row["department_id"];
	$department = "";
	if ($department_id) {
		$result = $mysqli->query("SELECT * FROM  `department` WHERE `department_id` = '$department_id'");
		$rowDeptName = $result->fetch_assoc();
		$department = $rowDeptName["department"];
	}

	$inside_json = array(
		'dateSurveyed' => $dateSurveyed,
		'employees_id' => $employees_id,
		'department' => strtoupper($department),
		'value' => $fullName
	);
	array_push($json, $inside_json);
	// $json[$fullName] = $row["department_id"];
}
echo json_encode($json);
// if (isset($_POST["getDepartment"])) {
// } else {
// 	echo json_encode($json);
// }

function dateToStr($numeric_date)
{
	$date = new DateTime($numeric_date);
	$strDate = $date->format('F d, Y - h:m A');
	return $strDate;
}
