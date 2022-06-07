<?php
require_once "_connect.db.php";

if (isset($_POST["load"])) {
	$year = $_POST["year"];
	if ($year == "all" || $year == "") {
		$sql = "SELECT * FROM `personneltrainings` ORDER BY `startDate` DESC";
	} else {
		$sql = "SELECT * FROM `personneltrainings` WHERE year(`startDate`) = '$year' ORDER BY `startDate` DESC";
	}
	$result = $mysqli->query($sql);
	$counter = 0;
	// $counter = $result->num_rows;
	while ($row = $result->fetch_assoc()) {
		$counter++;
		$personneltrainings_id = $row["personneltrainings_id"];
		// get training name start
		$training_id = $row["training_id"];
		$sql2 = "SELECT `training` FROM `trainings` WHERE `training_id` = '$training_id'";
		$result2 = $mysqli->query($sql2);
		$row2 = $result2->fetch_assoc();
		$training = addslashes($row2["training"]);
		// get training name end
		$startDate = $row["startDate"];
		$endDate = $row["endDate"];
		$numHours = $row["numHours"];
		$venue = $row["venue"];
		$remarks = $row["remarks"];
?>
		<tr id="<?php echo "row" . $personneltrainings_id; ?>">
			<td>(<?php echo $counter; ?>)</td>
			<td><?php echo $training; ?></td>
			<td><?php echo formatDate($startDate); ?></td>
			<td><?php echo formatDate($endDate); ?></td>
			<td><?php echo $numHours; ?></td>
			<td><?php echo $venue; ?></td>
			<td><?php
				if (!$remarks) {
					$remarks = "<i style='color: lightgrey;'>N/A</i>";
				}
				echo $remarks;
				?></td>
			<!-- <td>
				geNumberOfParticipants($mysqli, $personneltrainings_id)
			</td> -->
			<td>
				<?= geNumberOfRespondents($mysqli, $personneltrainings_id) ?>
			</td>
			<td>
				<div class="ui icon basic mini buttons">
					<a href="personneltrainingspreview.php?personneltrainings_id=<?php echo $personneltrainings_id; ?>" title="Open" class="ui button"><i class="folder open outline icon"></i></a>
					<button onclick="editFunc('<?= $personneltrainings_id; ?>')" title="Quick Edit" class="ui button"><i class="edit outline icon"></i></button>
					<button onclick="deleteFunc('<?php echo $personneltrainings_id; ?>')" title="Delete" class="ui button"><i class="trash alternate outline icon"></i></button>
				</div>
			</td>
		</tr>
	<?php

	}
} elseif (isset($_POST["addTraining"])) {
	$training = addslashes($_POST["training"]);
	$startDate = $_POST["startDate"];
	$endDate = $_POST["endDate"];
	$numHours = $_POST["numHours"];
	$venue = addslashes($_POST["venue"]);
	$remarks = addslashes($_POST["remarks"]);
	$timeStart = $_POST["timeStart"];
	$timeEnd = $_POST["timeEnd"];
	$dateD = date('Y-m-d H:m:s');
	// check first if training is already in trainings
	$sql = "SELECT * FROM `trainings` WHERE `training` = '$training'";
	$result = $mysqli->query($sql);
	// if none add
	if ($result->num_rows == 0) {
		// $training = strtoupper($training);
		$sql = "INSERT INTO `trainings` (`training`, `dateAdded`) VALUES ('$training', '$dateD')";
		$mysqli->query($sql);
	}
	// get training_id
	$sql = "SELECT `training_id` FROM `trainings` WHERE `training` = '$training'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	$training_id = $row["training_id"];

	//insert to personneltrainings
	$sql = "INSERT INTO `personneltrainings` (`training_id`, `dateD`, `startDate`, `endDate`, `numHours`, `venue`, `remarks`,`timeStart`,`timeEnd`) VALUES ('$training_id', '$dateD', '$startDate', '$endDate', '$numHours', '$venue', '$remarks', '$timeStart', '$timeEnd')";
	$mysqli->query($sql);
	$personneltrainings_id = $mysqli->insert_id;
	$addQueries = $_POST["addQueries"];

	foreach ($addQueries as $employees_id) {
		$dateAdded = date('Y-m-d H:m:s');
		$sql = "INSERT INTO `personneltrainingslist` (`dateAdded`, `personneltrainings_id`, `employees_id`) VALUES ('$dateAdded', '$personneltrainings_id', '$employees_id')";
		$mysqli->query($sql);
	}
} elseif (isset($_POST["deleteTraining"])) {
	$personneltrainings_id = $_POST["personneltrainings_id"];
	$sql1 = "DELETE FROM `personneltrainings` WHERE `personneltrainings`.`personneltrainings_id` = '$personneltrainings_id'";
	$sql2 = "DELETE FROM `personneltrainingslist` WHERE `personneltrainingslist`.`personneltrainings_id` = '$personneltrainings_id'";
	$sql3 = "DELETE FROM `personneltrainingseval` WHERE `personneltrainingseval`.`personneltrainings_id` = '$personneltrainings_id'";

	$mysqli->query($sql1);
	$mysqli->query($sql2);
	$mysqli->query($sql3);
} elseif (isset($_POST["editTraining"])) {
	$personneltrainings_id = $_POST["personneltrainings_id"];
	$training = addslashes($_POST["training"]);
	// check first if training is already in trainings
	$sql = "SELECT * FROM `trainings` WHERE `training` = '$training'";
	$result = $mysqli->query($sql);
	// if none add
	if ($result->num_rows === 0) {
		$dateAdded = date('Y-m-d H:m:s');
		// $training = strtoupper($training);
		$sql = "INSERT INTO `trainings` (`training`, `dateAdded`) VALUES ('$training', '$dateAdded')";
		$mysqli->query($sql);
	}
	// get training_id
	// $training = strtoupper($training);
	$sql = "SELECT `training_needs_analysis_entries` FROM `department_id` WHERE `department` = '$department'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	$training_id = $row["training_id"];

	$startDate = $_POST["startDate"];
	$endDate = $_POST["endDate"];
	$numHours = $_POST["numHours"];
	$venue = addslashes($_POST["venue"]);
	$remarks = addslashes($_POST["remarks"]);
	$timeStart = $_POST["timeStart"];
	$timeEnd = $_POST["timeEnd"];
	$sql = "UPDATE `personneltrainings` SET `training_id` = '$training_id', `startDate` = '$startDate', `endDate` = '$endDate', `numHours` = '$numHours', `venue` = '$venue', `remarks` = '$remarks', `timeStart` = '$timeStart', `timeEnd` = '$timeEnd' WHERE `personneltrainings`.`personneltrainings_id` = '$personneltrainings_id'";
	$mysqli->query($sql);

} elseif (isset($_POST["loadListToAdd"])) {
	$sql = "SELECT * FROM `employees` ORDER BY `lastName` ASC";
	$result = $mysqli->query($sql);
	while ($row = $result->fetch_assoc()) {
		$employees_id = $row["employees_id"];
		$lastName = $row["lastName"];
		$firstName = $row["firstName"];
		$middleName = $row["middleName"];
		$extName = $row["extName"];
		$fullName = $lastName . ", " . $firstName . " " . $middleName . " " . $extName . "<br>";
	?>
		<div id="<?php echo $employees_id; ?>" class="item">
			<div class="right floated content">
				<button onclick="addToList('<?php echo $employees_id; ?>')" class="ui icon basic mini button"><i class="icon add"></i></button>
			</div>
			<div class="content"><?php echo $fullName; ?></div>
		</div>

	<?php
	}
} elseif (isset($_POST["loadListToAdd_cal"])) {
	$sql = "SELECT * FROM `employees` WHERE `status` = 'ACTIVE' ORDER BY `lastName` ASC";
	$result = $mysqli->query($sql);
	while ($row = $result->fetch_assoc()) {
		$employees_id = $row["employees_id"];
		$lastName = $row["lastName"];
		$firstName = $row["firstName"];
		$middleName = $row["middleName"];
		$extName = $row["extName"];
		$fullName = $lastName . ", " . $firstName . " " . $middleName . " " . $extName . "<br>";
	?>
		<div id="cal<?php echo $employees_id; ?>" class="item">
			<div class="right floated content">
				<button onclick="addToList_cal('<?php echo $employees_id; ?>')" class="ui icon basic mini button"><i class="icon add"></i></button>
			</div>
			<div class="content"><?php echo $fullName; ?></div>
		</div>

<?php
	}
} elseif (isset($_POST["get_data"])) {
	$personneltrainings_id = $_POST["personneltrainings_id"];
	$sql = "SELECT * FROM `personneltrainings` LEFT JOIN `trainings` ON `trainings`.`training_id` = `personneltrainings`.`training_id` WHERE `personneltrainings`.`personneltrainings_id` = '$personneltrainings_id'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();

	$timeStart = $row["timeStart"];
	$timeEnd = $row["timeEnd"];

	if (!$timeStart) {
		$timeStart = "08:00:00";
	}

	if (!$timeEnd) {
		$timeEnd = "17:00:00";
	}

	$json = array(
		'training' => $row["training"],
		'startDate' => $row["startDate"],
		'endDate' => $row["endDate"],
		'numHours' => $row["numHours"],
		'venue' => $row["venue"],
		'remarks' => $row["remarks"],
		'timeStart' => $timeStart,
		'timeEnd' => $timeEnd
	);
	echo json_encode($json);
}
// vue api start
elseif (isset($_POST["init_load"])) {
	$year = $_POST["year"];
	if ($year == "all" || $year == "") {
		$sql = "SELECT * FROM `personneltrainings` ORDER BY `startDate` DESC";
	} else {
		$sql = "SELECT * FROM `personneltrainings` WHERE year(`startDate`) = '$year' ORDER BY `startDate` DESC";
	}
	$result = $mysqli->query($sql);
	// $counter = 0;
	// $counter = $result->num_rows;
	$data = array();
	while ($row = $result->fetch_assoc()) {
		// $counter++;
		$personneltrainings_id = $row["personneltrainings_id"];
		$training_id = $row["training_id"];
		$sql2 = "SELECT `training` FROM `trainings` WHERE `training_id` = '$training_id'";
		$result2 = $mysqli->query($sql2);
		$row2 = $result2->fetch_assoc();
		$training = addslashes($row2["training"]);
		$startDate = formatDate($row["startDate"]);
		$endDate = formatDate($row["endDate"]);
		$numHours = $row["numHours"];
		$venue = $row["venue"];
		$remarks = $row["remarks"];
		$numberOfRespondents = geNumberOfRespondents($mysqli, $personneltrainings_id);


		$datum = array(
			"personneltrainings_id" => $personneltrainings_id,
			"training_id" => $training_id,
			"training" => $training,
			"startDate" => $startDate,
			"endDate" => $endDate,
			"numHours" => $numHours,
			"venue" => $venue,
			"remarks" => $remarks,
			"numberOfRespondents" => $numberOfRespondents
		);

		$data[] = $datum;
	}

	$withRespondents = array();
	$noRespondents = array();
	foreach ($data as $item) {
		if ($item["numberOfRespondents"] > 0) {
			$withRespondents[] = $item;
		} else {
			$noRespondents[] = $item;
		}
	}

	echo json_encode(array(
		"withRespondents" => $withRespondents,
		"noRespondents" => $noRespondents
	));
	
}
// vue api end


function formatDate($numeric_date)
{
	if (!$numeric_date) return NULL;
	$date = new DateTime($numeric_date);
	$strDate = $date->format('F d, Y');
	return $strDate;
}


function geNumberOfParticipants($mysqli, $personneltrainings_id)
{
	$sql = "SELECT COUNT(`employees_id`) AS `participants` FROM `personneltrainingslist` WHERE `personneltrainings_id` = '$personneltrainings_id'";
	$result = $mysqli->query($sql);
	$count = 0;
	$row = $result->fetch_assoc();
	$count = $row['participants'];
	return $count;
}

function geNumberOfRespondents($mysqli, $personneltrainings_id)
{
	$sql = "SELECT COUNT(`personneltrainings_id`) AS `respondents` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id'";
	$result = $mysqli->query($sql);
	$count = 0;
	$row = $result->fetch_assoc();
	$count = $row['respondents'];

	if (!$count) {
		return 0;
	}

	return $count;
}


?>