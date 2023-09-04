<?php
require '_connect.db.php';

if (isset($_POST['saveData'])) {
	$data = serialize($_POST['data']);
	$rspcomp_id = $_POST['rspcomp_id'];
	$date_signed = $_POST['date_signed'];
	$date_signed  = $date_signed ? $date_signed : null;
	if (check_if_exist($mysqli, $rspcomp_id)) {
		// update if existing
		// $stmt = $mysqli->prepare("UPDATE `rsp_comp_checklist` SET `data` = ?, `date_signed` = ? WHERE `rsp_comp_checklist`.`rspcomp_id` = ?");
		// $stmt->bind_param("ssi", $data, $date_signed, $rspcomp_id);
		if ($date_signed) {
			$sql = "UPDATE `rsp_comp_checklist` SET `data` = '$data', `date_signed` = '$date_signed'  WHERE `rsp_comp_checklist`.`rspcomp_id` = $rspcomp_id";
		} else {
			$sql = "UPDATE `rsp_comp_checklist` SET `data` = '$data' WHERE `rsp_comp_checklist`.`rspcomp_id` = $rspcomp_id";
		}
	} else {
		// insert if not existing
		// $stmt = $mysqli->prepare("INSERT INTO `rsp_comp_checklist` (`rspcomp_id`, `data`, `date_signed`) VALUES (?,?, ?)");
		// $stmt->bind_param("iss", $rspcomp_id, $data, $date_signed);
		if ($date_signed) {
			$sql = "INSERT INTO `rsp_comp_checklist` (`rspcomp_id`, `data`, `date_signed`) VALUES ($rspcomp_id, '$data','$date_signed')";
		} else {
			$sql = "INSERT INTO `rsp_comp_checklist` (`rspcomp_id`, `data`) VALUES ($rspcomp_id, '$data')";
		}
	}
	// $stmt->execute();
	// $stmt->close();
	$mysqli->query($sql);

	echo json_encode($date_signed);
}

// if (isset($_POST['fetchData'])) {
// 	$rspcomp_id = $_POST['rspcomp_id'];

// 	$sql = "SELECT *, `rsp_vacant_positions`.`education` AS `education_cri`, `rsp_vacant_positions`.`experience` AS `experience_cri`,`rsp_vacant_positions`.`training` AS `training_cri`, `rsp_vacant_positions`.`eligibility` AS `eligibility_cri` FROM `rsp_comparative` JOIN  `rsp_vacant_positions` ON `rsp_comparative`.`rspvac_id` = `rsp_vacant_positions`.`rspvac_id` JOIN `rsp_applicants` ON `rsp_comparative`.`applicant_id` = `rsp_applicants`.`applicant_id` WHERE `rsp_comparative`.`rspcomp_id`=$rspcomp_id";
// 	$result = $mysqli->query($sql);
// 	$row = $result->fetch_assoc();

// 	$name = $row['name'];
// 	$positiontitle = $row['positiontitle'];
// 	$education_cri = $row['education_cri'];
// 	$experience_cri = $row['experience_cri'];
// 	$training_cri = $row['training_cri'];
// 	$eligibility_cri = $row['eligibility_cri'];

// 	// check if rscomp_id has already a checklist
// 	$printReady = 'false';
// 	$sql = "SELECT * FROM `rsp_comp_checklist` WHERE `rspcomp_id` = $rspcomp_id";
// 	$result = $mysqli->query($sql);
// 	$row = $result->fetch_assoc();
// 	$data = array();
// 	if ($result->num_rows>0) {
// 	  $data = unserialize($row['data']);
// 	  $printReady = 'true';
// 	}

// 	$json = array(
// 		'name' => $name,
// 		'positiontitle' => $positiontitle,
// 		'education_cri' => $education_cri,
// 		'experience_cri' => $experience_cri,
// 		'training_cri' => $training_cri,
// 		'eligibility_cri' => $eligibility_cri,
// 		'data' => $data,
// 		'printReady' => $printReady
// 	);

// 	echo json_encode($json);

// }


function check_if_exist($mysqli, $rspcomp_id)
{
	// check if rspcomp_id has already a checklist
	$exist = false;
	$sql = "SELECT * FROM `rsp_comp_checklist` WHERE `rspcomp_id` = $rspcomp_id";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	if ($result->num_rows > 0) {
		$exist = true;
	}

	return $exist;
}
