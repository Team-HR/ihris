<?php

require_once "_connect.db.php";

if (isset($_POST["saveEdit"])) {
	$inputs = $_POST["inputs"];

	$employees_id = $inputs["employees_id"];
	$lastName = mb_convert_case($inputs["lastName"], MB_CASE_UPPER);
	$firstName = mb_convert_case($inputs["firstName"], MB_CASE_UPPER);
	$middleName = mb_convert_case($inputs["middleName"], MB_CASE_UPPER);
	$extName = mb_convert_case($inputs["extName"], MB_CASE_UPPER);

	$employmentStatus = $inputs["employmentStatus"];
	// $department_id = $inputs["department_id"];
	$position_id = $inputs["position_id"];

	$temp_date_of_appointment = $inputs["temp_date_of_appointment"];
	$date = new DateTime($temp_date_of_appointment);
	$date->modify('+1 year');
	$formattedDate = $date->format('Y-m-d');
	$temp_due_for_renewal = $formattedDate;
	$temp_dates_renewed = json_encode($inputs["temp_dates_renewed"]);

	$res;

	if (!$employees_id) {
		$sql = "INSERT INTO `employees`(`employees_id`, `firstName`, `lastName`, `middleName`, `extName`, `status`, `employmentStatus`, `position_id`, `temp_date_of_appointment`, `temp_due_for_renewal`, `temp_dates_renewed`) VALUES (NULL,'$firstName','$lastName','$middleName','$extName','ACTIVE','$employmentStatus', '$position_id','$temp_date_of_appointment','$temp_due_for_renewal','$temp_dates_renewed')";
		$res = $mysqli->query($sql);
	} else {
		$sql = "UPDATE `employees` SET `firstName` = '$firstName', `lastName` = '$lastName', `middleName` = '$middleName', `extName` = '$extName', `employmentStatus` = '$employmentStatus', `position_id` = '$position_id', `temp_date_of_appointment` = '$temp_date_of_appointment', `temp_due_for_renewal` = '$temp_due_for_renewal', `temp_dates_renewed` = '$temp_dates_renewed' WHERE `employees_id` = '$employees_id'";
		$res = $mysqli->query($sql);
	}

	echo json_encode($sql);
} elseif (isset($_POST["getDepartments"])) {
	$data = [];
	$sql = "SELECT * FROM `department` ORDER BY `department` ASC";
	$res = $mysqli->query($sql);
	while ($row = $res->fetch_assoc()) {
		$data[] = $row;
	}
	echo json_encode($data);
} elseif (isset($_POST["getPositions"])) {
	$data = [];
	$sql = "SELECT * FROM `positiontitles` ORDER BY `position` ASC";
	$res = $mysqli->query($sql);
	while ($row = $res->fetch_assoc()) {
		$data[] = $row;
	}
	echo json_encode($data);
} elseif (isset($_POST["getPersonnel"])) {
	$data = [];
	$sql = "SELECT * FROM `employees` WHERE `employmentStatus` = 'TEMPORARY' OR `employmentStatus` = 'PROBATIONARY' ORDER BY `lastName` ASC";
	$res = $mysqli->query($sql);
	while ($row = $res->fetch_assoc()) {

		$row["temp_date_of_appointment_formatted"] = formatDate($row["temp_date_of_appointment"]);
		$row["temp_due_for_renewal_formatted"] = formatDate($row["temp_due_for_renewal"]);
		$row["positionTitle"] = getPositionTitle($mysqli, $row["position_id"]);
		$row["temp_dates_renewed"] = json_decode($row["temp_dates_renewed"]);
		$data[] = $row;
	}
	echo json_encode($data);
}

function getPositionTitle($mysqli, $position_id)
{
	$sql = "SELECT * FROM `positiontitles` WHERE `position_id` = '$position_id'";
	$res = $mysqli->query($sql);
	if ($row = $res->fetch_assoc()) {
		return $row;
	}
	return null;
}

function formatDate($date_raw)
{
	$date = $date_raw;
	return date('F j, Y', strtotime($date));
}
// 
