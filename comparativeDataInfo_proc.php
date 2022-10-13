<?php
require '_connect.db.php';
require 'libs/Department.php';
$department = new Department();
if (isset($_POST["load"])) {
	$rspvac_id = $_POST["rspvac_id"];
	$sql = "SELECT * FROM `rsp_vacant_positions` WHERE `rspvac_id` = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("i", $rspvac_id);
	$stmt->execute();
	// $stmt->store_result();	
	$stmt->bind_result($rspvac_id, $position, $itemNo, $sg, $office, $dateVacated, $dateOfInterview, $education, $training, $experience, $eligibility, $datetime_added);
	$stmt->fetch();
	if (!$itemNo) {
		$itemNo = "---";
	} else {
		$itemNo = $itemNo;
	}
	$data = array(
		"rspvac_id" => $rspvac_id,
		"position" => $position,
		"itemNo" => $itemNo,
		"sg" => $sg,
		"office" => $department->getDepartment($office),
		"dateVacated" => $dateVacated,
		"education" => unserialize($education),
		"training" => unserialize($training),
		"experience" => unserialize($experience),
		"eligibility" => unserialize($eligibility)
	);
	$stmt->close();
	echo json_encode($data);
} elseif (isset($_POST["initload"])) {
	$rspvac_id = $_POST["rspvac_id"];
	$sql = "SELECT `rspcomp_id`, `rsp_comparative`.`applicant_id`, `name`,`age`,`gender`,`num_years_in_gov`,`years_of_service_gov`,`years_of_service_priv`,`civil_status`,`education`,`training`,`experience`,`eligibility`,`awards`,`records_infractions`, `remarks` FROM `rsp_applicants` LEFT JOIN `rsp_comparative`ON `rsp_comparative`.`applicant_id` = `rsp_applicants`.`applicant_id` WHERE `rspvac_id` = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("i", $rspvac_id);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result(
		$rspcomp_id,
		$applicant_id,
		$name,
		$age,
		$gender,
		$num_years_in_gov,
		$years_of_service_gov,
		$years_of_service_priv,
		$civil_status,
		$education,
		$training,
		$experience,
		$eligibility,
		$awards,
		$records_infractions,
		$remarks
	);
	$data = [];

	while ($stmt->fetch()) {
		$data[] = [
			"rspcomp_id" => $rspcomp_id,
			"checklist_exist" => check_if_exist($mysqli, $rspcomp_id),
			"id" => $applicant_id,
			"name" => $name,
			"age" => $age,
			"gender" => $gender,
			"civil_status" => $civil_status,
			"education" => $education,
			"years_of_service_gov" => json_decode($years_of_service_gov) ? json_decode($years_of_service_gov) : [],
			"years_of_service_priv" => json_decode($years_of_service_priv) ? json_decode($years_of_service_priv) : [],
			"experiences" => json_decode($experience) ? json_decode($experience) : [],
			"trainings" => json_decode($training) ? json_decode($training) : [],
			"eligibilities" => json_decode($eligibility) ? json_decode($eligibility) : [],
			"awards" => json_decode($awards) ? json_decode($awards) : [],
			"record_of_infractions" => json_decode($records_infractions) ? json_decode($records_infractions) : [],
			"remarks" => $remarks
		];
	}
	echo json_encode($data);
} elseif (isset($_POST["addEditApplicant"])) {
	$rspvac_id = $_POST["rspvac_id"];
	$applicant = $_POST["applicant"];

	$applicant_id = $applicant["id"];
	$name = $applicant["name"];

	if (!$name) return false;
	$name = $mysqli->real_escape_string($name);

	$age = $applicant["age"];
	$age = $mysqli->real_escape_string($age);

	$gender = $applicant["gender"];
	$gender = $mysqli->real_escape_string($gender);

	$civil_status = $applicant["civil_status"];
	$civil_status = $mysqli->real_escape_string($civil_status);

	$education = $applicant["education"];
	$education = $mysqli->real_escape_string($education);

	$years_of_service_gov = $applicant["years_of_service_gov"];
	$years_of_service_gov = removeEmptyElementfromYearsOfService($years_of_service_gov);

	if (count($years_of_service_gov) > 0) {
		$years_of_service_gov = $mysqli->real_escape_string(json_encode($years_of_service_gov));
	} else {
		$years_of_service_gov = NULL;
	}

	$years_of_service_priv = $applicant["years_of_service_priv"];
	$years_of_service_priv = removeEmptyElementfromYearsOfService($years_of_service_priv);
	if (count($years_of_service_priv) > 0) {
		$years_of_service_priv = $mysqli->real_escape_string(json_encode($years_of_service_priv));
	} else {
		$years_of_service_priv = NULL;
	}

	$experiences = $applicant["experiences"];
	$experiences = removeEmptyElementfromExperiences($experiences);
	if (count($experiences) > 0) {
		$experiences = $mysqli->real_escape_string(json_encode($experiences));
	} else {
		$experiences = NULL;
	}

	$trainings = $applicant["trainings"];
	$trainings = removeEmptyElementfromArray($trainings);
	if (count($trainings) > 0) {
		$trainings = $mysqli->real_escape_string(json_encode($trainings));
	} else {
		$trainings = NULL;
	}

	$eligibilities = $applicant["eligibilities"];
	$eligibilities = removeEmptyElementfromArray($eligibilities);
	if (count($eligibilities) > 0) {
		$eligibilities = $mysqli->real_escape_string(json_encode($eligibilities));
	} else {
		$eligibilities = NULL;
	}

	$awards = $applicant["awards"];
	$awards = removeEmptyElementfromArray($awards);
	if (count($awards) > 0) {
		$awards = $mysqli->real_escape_string(json_encode($awards));
	} else {
		$awards = NULL;
	}

	$record_of_infractions = $applicant["record_of_infractions"];
	$record_of_infractions = removeEmptyElementfromArray($record_of_infractions);
	if (count($record_of_infractions) > 0) {
		$record_of_infractions = $mysqli->real_escape_string(json_encode($record_of_infractions));
	} else {
		$record_of_infractions = NULL;
	}

	$remarks = $applicant["remarks"];
	$remarks = $remarks ? $mysqli->real_escape_string($remarks) : NULL;

	if (!$applicant_id) {
		//add new applicant
		$sql = "INSERT INTO `rsp_applicants`(`name`, `age`, `gender`, `civil_status`,`education`, `training`, `years_of_service_gov`, `years_of_service_priv`, `experience`, `eligibility`, `awards`, `records_infractions`, `remarks`) VALUES ('$name','$age','$gender','$civil_status','$education','$trainings','$years_of_service_gov','$years_of_service_priv','$experiences','$eligibilities','$awards','$record_of_infractions','$remarks')";
		$mysqli->query($sql);
		$applicant_id = $mysqli->insert_id;
		$sql = "INSERT INTO `rsp_comparative`(`rspvac_id`, `applicant_id`) VALUES ('$rspvac_id','$applicant_id')";
		$mysqli->query($sql);
	} else {
		//update applicant
		$sql = "UPDATE `rsp_applicants` SET `name` = '$name', `age` = '$age', `gender` = '$gender', `civil_status` = '$civil_status',`education` = '$education', `training` = '$trainings', `years_of_service_gov` = '$years_of_service_gov', `years_of_service_priv` = '$years_of_service_priv', `experience` = '$experiences', `eligibility` = '$eligibilities', `awards` = '$awards', `records_infractions` = '$record_of_infractions', `remarks` = '$remarks' WHERE `applicant_id` = '$applicant_id';";
		$mysqli->query($sql);
	}

	echo json_encode("success");
} elseif (isset($_POST["unlistApplicant"])) {
	$rspvac_id = $_POST["rspvac_id"];
	$applicant_id = $_POST["applicant_id"];
	$sql = "DELETE FROM `rsp_comparative` WHERE`rspvac_id` = ? AND `applicant_id` = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("ii", $rspvac_id, $applicant_id);
	$stmt->execute();
	$stmt->close();
} elseif (isset($_POST["loadList_DELETE"])) {
	$rspvac_id = $_POST["rspvac_id"];
	// $rspvac_id = 7;

	$sql = "SELECT `rspcomp_id`, `rsp_comparative`.`applicant_id`, `name`,`age`,`gender`,`num_years_in_gov`,`civil_status`,`education`,`training`,`experience`,`eligibility`,`awards`,`records_infractions` FROM `rsp_applicants` LEFT JOIN `rsp_comparative`ON `rsp_comparative`.`applicant_id` = `rsp_applicants`.`applicant_id` WHERE `rspvac_id` = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("i", $rspvac_id);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result(
		$rspcomp_id,
		$applicant_id,
		$name,
		$age,
		$gender,
		$num_years_in_gov,
		$civil_status,
		$education,
		$training,
		$experience,
		$eligibility,
		$awards,
		$records_infractions
	);

	if ($stmt->num_rows === 0) {
?>
		<tr>
			<td colspan="13" style="color: lightgrey; text-align: center; padding: 20px;"><i>No Applicants!</i></td>
		</tr>
		<?php
	} else {
		$counter = 1;
		while ($stmt->fetch()) {
		?>
			<tr style="vertical-align: top;">
				<td><?= $counter++; ?></td>
				<td>
					<a href="checklist.php?rspcomp_id=<?= $rspcomp_id ?>" class="ui button basic icon"><i class="icon list ol <?= (check_if_exist($mysqli, $rspcomp_id) ? 'green' : 'red') ?> "></i></a>
				</td>
				<td><?= $name; ?></td>
				<td><?= $age ?></td>
				<td><?= $gender ?></td>
				<td style="white-space: nowrap;"><?= createYosList($num_years_in_gov) ?></td>
				<td><?= $civil_status ?></td>
				<td><?= $education ?></td>
				<td><?= createList(unserialize($training)) ?></td>
				<td><?= createList(unserialize($experience), false) ?></td>
				<td><?= createList(unserialize($eligibility)) ?></td>
				<td><?= createList(unserialize($awards)) ?></td>
				<td><?= createList(unserialize($records_infractions)) ?></td>
				<td class="noprint" style="width: 50px;">

					<div class="ui mini basic icon buttons">
						<button class="ui positive button" title="Edit" onclick="editApplicant(<?= $applicant_id ?>)"><i class="icon edit"></i></button>
						<div class="or"></div>
						<button class="ui negative button" title="Delete" onclick="deleteEntry(<?= $rspcomp_id ?>)"><i class="icon trash"></i></button>
					</div>

				</td>
			</tr>
<?php
		}
	}
}

function removeEmptyElementfromArray($arr)
{
	foreach ($arr as $key => $value) {
		if (empty($value)) {
			array_splice($arr, $key, 1);
		}
	}

	return $arr;
}

function removeEmptyElementfromYearsOfService($arr)
{
	foreach ($arr as $key => $value) {
		if (empty($value["status"]) && empty($value["num_years"])) {
			array_splice($arr, $key, 1);
		}
	}

	return $arr;
}

function removeEmptyElementfromExperiences($arr)
{
	foreach ($arr as $key => $value) {
		if (empty($value["title"]) && empty($value["company"])) {
			array_splice($arr, $key, 1);
		}
	}

	return $arr;
}


function createList($arr, $bool = true)
{
	// return json_encode($arr);
	$list = "";
	if ($arr) {
		if ($bool) {
			foreach ($arr as $value) {
				$list .= "* $value<br>";
			}
		} else {
			if (count($arr) > 0) {
				usort($arr, function ($item1, $item2) {
					return $item2[3] <=> $item1[3];
				});
			}
			foreach ($arr as $key => $value) {
				$dates = "";
				if ($value[4] == "-00-00") {
					$value[4] = null;
				}
				if (!$value[3] && !$value[4]) {
					$dates = "(Dates not indicated)";
				} elseif (!$value[3] && $value[4]) {
					$dates = "(To: " . formatDate($value[4]) . ")";
				} elseif ($value[3] && !$value[4]) {
					$dates = "(From: " . formatDate($value[3]) . " to Present)";
				} else {
					$dates = "(" . formatDate($value[3]) . " - " . formatDate($value[4]) . ")";
				}
				$list .= "* <b>$value[2]</b> <i>as</i>  <span style='color:#025214; font-weight: bold;'>$value[0]</span> $dates<br>";
			}
		}
	} else {
		$list .= "* NONE";
	}
	return $list;
}


function createYosList($serial)
{

	$arr = unserialize($serial);

	$list = "";
	$counter = 0;
	foreach ($arr as $index => $value) {
		if ($value) {
			$list .= "* " . $index . ": $value<br>";
		} else {
			$counter++;
		}
	}
	if ($counter === count($arr)) {
		$list = "* NONE";
	}
	return $list;
}


function formatDate($numeric_date)
{
	// return "test";
	$date_exploded = explode("-", $numeric_date);

	if ($date_exploded[1] == "00" && $date_exploded[2] == "00") {
		return $date_exploded[0];
	} elseif ($date_exploded[2] == "00") {
		$date = new DateTime($numeric_date);
		$date->modify('+1 day');
		$strDate = $date->format('M Y');
		return $strDate;
	} else {
		$date = new DateTime($numeric_date);
		// $date->modify('+1 day');
		$strDate = $date->format('M d, Y');
		return $strDate;
	}
}

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
?>