<?php
require_once "_connect.db.php";

if (isset($_POST["loadProfile"])) {
	$json = array();
	$inside_json = array();

	$employees_id = $_POST["employees_id"];

	// $employees_id = 2158;
	$sql = "SELECT * FROM `employees` WHERE `employees_id` = '$employees_id'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	$status = $row["status"];
	if (!$status) {
		$status = "<i style='color:grey'>N/A</i>";
	}
	$employmentStatus = strtoupper($row["employmentStatus"]);
	if (!$employmentStatus) {
		$employmentStatus = "<i style='color:grey'>N/A</i>";
	}
	$gender = $row["gender"];
	if (!$gender) {
		$gender = "<i style='color:grey'>N/A</i>";
	}
	$natureOfAssignment = addslashes($row["natureOfAssignment"]);
	if (!$natureOfAssignment) {
		$natureOfAssignment = "<i style='color:grey'>N/A</i>";
	}
	$firstName	=	addslashes($row["firstName"]);
	$lastName	=	$row["lastName"];
	$middleName	=	addslashes($row["middleName"]);
	$extName	=	addslashes($row["extName"]);

	$fullname = $firstName . " " . $middleName . " " . $lastName . " " . $extName;
	// get department name start
	if ($status === "ACTIVE") {
		$statusDate = $row["dateActivated"];
	} elseif ($status === "INACTIVE") {
		$statusDate = $row["dateInactivated"];
	} else {
		$statusDate = "0000-00-00";
	}

	if ($statusDate == "0000-00-00") {
		$statusDateStr = "<i style='color:grey'>N/A</i>";
	} else {
		$statusDateStr = dateToStr($statusDate);
	}


	$department_id	=	$row["department_id"];
	$sql2 = "SELECT * FROM `department` WHERE `department_id` = '$department_id'";
	$result2 = $mysqli->query($sql2);
	$row2 = $result2->fetch_assoc();
	$department = $row2["department"];
	if (!$department) {
		$department = "<i style='color:grey'>N/A</i>";
	} else {
		$department = mb_convert_case($department, MB_CASE_UPPER, "UTF-8");
	}
	$position_id = $row["position_id"];
	$sql3 = "SELECT * FROM `positiontitles` WHERE `position_id` = '$position_id'";
	$result3 = $mysqli->query($sql3);
	$row3 = $result3->fetch_assoc();

	$position = isset($row3["position"]) ? mb_convert_case($row3["position"], MB_CASE_UPPER, "UTF-8") : "<i style='color:grey'>N/A</i>";
	$functional = isset($row3["functional"]) ? mb_convert_case($row3["functional"], MB_CASE_UPPER, "UTF-8") : "<i style='color:grey'>N/A</i>";
	$level = isset($row3["level"]) ? $row3["level"] : "<i style='color:grey'>N/A</i>";
	$category = isset($row3["category"]) ? strtoupper($row3["category"]) : "<i style='color:grey'>N/A</i>";
	$salaryGrade = isset($row3["salaryGrade"]) ? $row3["salaryGrade"] : "<i style='color:grey'>N/A</i>";
	// get position name start

	if ($row["dateIPCR"] !== '0000-00-00') {
		$dateIPCR = $row["dateIPCR"];
		$dateIPCRView = dateToStr($dateIPCR);
	} else {
		$dateIPCR = "0000-00-00";
		$dateIPCRView = "<i style='color:grey'>N/A</i>";
	}


	$inside_json = array(
		'employees_id' => $employees_id,
		'employees_id_padded' => str_pad($employees_id, 5, 0, STR_PAD_LEFT),
		'status' => strtoupper($status),
		'statusDate' => $statusDate,
		'dateIPCR' => $dateIPCR,
		'dateIPCRView' => $dateIPCRView,
		'statusDateStr' => $statusDateStr,
		'employmentStatus' => $employmentStatus,
		'gender' => $gender,
		'natureOfAssignment' => $natureOfAssignment,
		'fullname' => strtoupper($fullname),
		'firstName' => ucwords($firstName),
		'middleName' => ucwords($middleName),
		'lastName' => ucwords($lastName),
		'extName' => $extName,
		'department_id' => $department_id,
		'department' => $department,
		'position_id' => $position_id,
		'position' => $position . " " . $functional,
		'level' => $level,
		'category' => $category,
		'salaryGrade' => $salaryGrade
	);

	echo json_encode($inside_json);
} elseif (isset($_POST["update"])) {

	$employees_id = $_POST["employees_id"];
	$firstName = addslashes($_POST["firstName"]);
	$middleName = addslashes($_POST["middleName"]);
	$lastName = addslashes($_POST["lastName"]);
	$extName = addslashes($_POST["extName"]);
	$status = $_POST["status"];
	$statusDateVal = ($_POST["statusDate"] ? $_POST["statusDate"] : "0000-00-00");
	$dateIPCR = ($_POST["dateIPCR"] ? $_POST["dateIPCR"] : "0000-00-00");

	if ($status === "ACTIVE") {
		$statusDate = ",`dateActivated` = '$statusDateVal'";
	} elseif ($status === "INACTIVE") {
		$statusDate = ",`dateInactivated` = '$statusDateVal'";
	} else {
		$statusDate = "";
	}

	$gender = $_POST["gender"];
	$employmentStatus = $_POST["employmentStatus"];
	$natureOfAssignment = $_POST["natureOfAssignment"];
	$department_id = $_POST["department_id"];
	$position_id = $_POST["position_id"];

	echo $sql = "UPDATE `employees` SET `firstName`= '$firstName',`lastName`= '$lastName',`middleName`='$middleName',`extName`='$extName',`gender`='$gender',`employmentStatus`='$employmentStatus',`department_id`='$department_id',`position_id`='$position_id',`natureOfAssignment`='$natureOfAssignment', `status` = '$status', `dateIPCR` = '$dateIPCR' $statusDate WHERE `employees_id`= '$employees_id'";
	$mysqli->query($sql);
} elseif (isset($_POST["get_auth_user"])) {
	// echo json_encode("testing");
	$json = array();
	$inside_json = array();

	$employees_id = $_POST["employees_id"];

	// $employees_id = 2158;
	$sql = "SELECT * FROM `employees` WHERE `employees_id` = '$employees_id'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	$status = $row["status"];
	if (!$status) {
		$status = "";
	}
	$employmentStatus = strtoupper($row["employmentStatus"]);
	if (!$employmentStatus) {
		$employmentStatus = "";
	}
	$gender = $row["gender"];
	if (!$gender) {
		$gender = "";
	}
	$natureOfAssignment = addslashes($row["natureOfAssignment"]);
	if (!$natureOfAssignment) {
		$natureOfAssignment = "";
	}
	$firstName	=	addslashes($row["firstName"]);
	$lastName	=	$row["lastName"];
	$middleName	=	addslashes($row["middleName"]);
	$extName	=	addslashes($row["extName"]);

	$fullname = $firstName . " " . $middleName . " " . $lastName . " " . $extName;
	// get department name start
	if ($status === "ACTIVE") {
		$statusDate = $row["dateActivated"];
	} elseif ($status === "INACTIVE") {
		$statusDate = $row["dateInactivated"];
	} else {
		$statusDate = "0000-00-00";
	}

	if ($statusDate == "0000-00-00") {
		$statusDateStr = "";
	} else {
		$statusDateStr = dateToStr($statusDate);
	}


	$department_id	=	$row["department_id"];
	$sql2 = "SELECT * FROM `department` WHERE `department_id` = '$department_id'";
	$result2 = $mysqli->query($sql2);
	$row2 = $result2->fetch_assoc();
	$department = $row2["department"];
	if (!$department) {
		$department = "";
	} else {
		$department = mb_convert_case($department, MB_CASE_UPPER, "UTF-8");
	}
	$position_id = $row["position_id"];
	$sql3 = "SELECT * FROM `positiontitles` WHERE `position_id` = '$position_id'";
	$result3 = $mysqli->query($sql3);
	$row3 = $result3->fetch_assoc();
	$position = $row3["position"];
	if (!$position) {
		$position = "";
	} else {
		$position = mb_convert_case($position, MB_CASE_UPPER, "UTF-8");
	}
	$functional = $row3["functional"];
	if ($functional) {
		$functional = mb_convert_case($functional, MB_CASE_UPPER, "UTF-8");
	}
	$level = $row3["level"];
	if (!$level) {
		$level = "";
	} else {
		$level = $level;
	}
	$category = strtoupper($row3["category"]);
	if (!$category) {
		$category = "";
	}
	$salaryGrade = $row3["salaryGrade"];
	if (!$salaryGrade) {
		$salaryGrade = "";
	}
	// get position name start

	if ($row["dateIPCR"] !== '0000-00-00') {
		$dateIPCR = $row["dateIPCR"];
		$dateIPCRView = dateToStr($dateIPCR);
	} else {
		$dateIPCR = "0000-00-00";
		$dateIPCRView = "";
	}


	$inside_json = array(
		'employees_id' => $employees_id,
		'employees_id_padded' => str_pad($employees_id, 5, 0, STR_PAD_LEFT),
		'status' => strtoupper($status),
		'statusDate' => $statusDate,
		'dateIPCR' => $dateIPCR,
		'dateIPCRView' => $dateIPCRView,
		'statusDateStr' => $statusDateStr,
		'employmentStatus' => $employmentStatus,
		'gender' => $gender,
		'natureOfAssignment' => $natureOfAssignment,
		'fullname' => strtoupper($fullname),
		'firstName' => ucwords($firstName),
		'middleName' => ucwords($middleName),
		'lastName' => ucwords($lastName),
		'extName' => $extName,
		'department_id' => $department_id,
		'department' => $department,
		'position_id' => $position_id,
		'position' => $position . " " . $functional,
		'level' => $level,
		'category' => $category,
		'salaryGrade' => $salaryGrade
	);
	echo json_encode($inside_json);
}


function dateToStr($numeric_date)
{
	$date = new DateTime($numeric_date);
	$strDate = $date->format('F d, Y');

	return strtoupper($strDate);
}
