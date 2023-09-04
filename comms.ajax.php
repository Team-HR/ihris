<?php
require_once "_connect.db.php";

if(isset($_GET['getData'])){
    $data = [];
    $sql = "SELECT * FROM `comms` ORDER BY id DESC";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
        $row['control_number'] = "HRMO-".getYearOnly($row['date_received'])."-".str_pad((string)$row['id'], 5, "0", STR_PAD_LEFT);
        $row['date_received'] = dateToStr($row['date_received']);
        $row['start_date'] = dateToStr($row['start_date']);
        $row['end_date'] = dateToStr($row['end_date']);
        $row['departments_involved'] = getDepartmentsInvolved($mysqli,$row['id']);
        $row['personnels_involved'] = getEmployeesInvolved($mysqli,$row['id']);
        $row['type'] = mb_convert_case($row['type'], MB_CASE_TITLE, "UTF-8");
        $data[] = $row;
    }
	echo json_encode($data);
	
} elseif (isset($_GET['showData'])) {
	$id = $_GET['id'];
	$data = [];
	$sql = "SELECT * FROM `comms` WHERE `id` = '$id'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	$row['control_number'] = "HRMO-".getYearOnly($row['date_received'])."-".str_pad((string)$row['id'], 5, "0", STR_PAD_LEFT);
	$row['date_received'] = dateToStr($row['date_received']);
        // $row['start_date'] = dateToStr($row['start_date']);
        // $row['end_date'] = dateToStr($row['end_date']);
		$row['department_ids_involved'] = getDepartmentIdsInvolved($mysqli,$row['id']);
		$row['departments_involved'] = getDepartmentsInvolved($mysqli,$row['id']);
        $row['personnels_involved'] = getEmployeesInvolved($mysqli,$row['id']);
        // $row['type'] = mb_convert_case($row['type'], MB_CASE_TITLE, "UTF-8");

	$data = $row;
	echo json_encode($data);
} elseif (isset($_GET['getDepartments'])) {
	$data = [];
	$sql = "SELECT * FROM department ORDER BY department ASC";
	$result = $mysqli->query($sql);
	while ($row = $result->fetch_assoc()) {
		$data[] = $row;
	}
	echo json_encode($data);
} elseif (isset($_GET['getTypes'])) {
	$data = [];
	$sql = "SELECT DISTINCT `type` FROM comms ORDER BY `type` ASC";
	$result = $mysqli->query($sql);
	while ($row = $result->fetch_assoc()) {
		$row['name'] = mb_convert_case($row['type'], MB_CASE_TITLE, "UTF-8");
		if (!empty($row['type'])) $data[] = $row;
	}
	echo json_encode($data);	
}

function getDepartmentsInvolved($mysqli,$controlNumber){
	$sql = "SELECT `department_id` FROM `requestandcomslist_dept` WHERE `controlNumber` = '$controlNumber'"; 
	$result = $mysqli->query($sql);

	$departments_involved = array();
	while ($row = $result->fetch_assoc()) {
        // array_push($department_ids, $row["department_id"]);
        $result = $mysqli->query("SELECT `department` FROM `department` WHERE `department_id` = '{$row['department_id']}'");
        $row = $result->fetch_assoc();
        $departments_involved[] = $row["department"];
	}
	return $departments_involved;
}

function getDepartmentIdsInvolved($mysqli,$controlNumber){
	$sql = "SELECT `department_id` FROM `requestandcomslist_dept` WHERE `controlNumber` = '$controlNumber'"; 
	$result = $mysqli->query($sql);

	$departments_ids_involved = array();
	while ($row = $result->fetch_assoc()) {
        $departments_ids_involved[] = $row['department_id'];
	}
	return $departments_ids_involved;
}

function getEmployeesInvolved($mysqli,$controlNumber){
	$sql = "SELECT `controlNumber`,`requestandcomslist`.`employees_id`,`others`,`firstName`,`middleName`,`lastName`,`extName` FROM `requestandcomslist` 
	LEFT JOIN `employees` 
	ON `requestandcomslist`.`employees_id` = `employees`.`employees_id`
	WHERE `controlNumber` = '$controlNumber'"; 
    $result = $mysqli->query($sql);
    
	$employees = [];
	while ($row = $result->fetch_assoc()) {
		$employees_id = $row["employees_id"];
		$lastName = mb_convert_case($row["lastName"], MB_CASE_TITLE, "UTF-8");
		$firstName = mb_convert_case($row["firstName"], MB_CASE_TITLE, "UTF-8");
		$middleName = mb_convert_case($row["middleName"], MB_CASE_TITLE, "UTF-8");
		$extName = $row["extName"];
		$fullName = "$lastName, $firstName $middleName $extName";
		$others = $row["others"];

		if ($employees_id) {
			$employees[] = $fullName;
		} elseif (!$employees_id) {
			$employees[] = mb_convert_case($others, MB_CASE_TITLE, "UTF-8");
        }
        
	}

	return $employees;
}

function getYearOnly($numeric_date){
	$date = new DateTime($numeric_date);
	$year = $date->format('Y');
	return $year;
}

function dateToStr($numeric_date){
	$date = new DateTime($numeric_date);
	$strDate = $date->format('M d Y');
	return $strDate;
}

function dateToStrComplete($numeric_date){
	$date = new DateTime($numeric_date);
	$strDate = $date->format('F d, Y');
	return $strDate;
}

