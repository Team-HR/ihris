<?php
require_once "_connect.db.php";

if (isset($_POST["load"])) {
	$personneltrainings_id = $_POST["personneltrainings_id"];
	$sql = "SELECT * FROM `personneltrainings` WHERE `personneltrainings_id` = '$personneltrainings_id'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	// get training
	$training_id = $row["training_id"];
	$sql1 = "SELECT * FROM `trainings` WHERE `training_id` = '$training_id'";
	$result1 = $mysqli->query($sql1);
	$row1 = $result1->fetch_assoc();
	$training = $row1["training"];

	$training = strtoupper($training);
	$startDate = $row["startDate"];
	$endDate = $row["endDate"];
	$numHours = $row["numHours"];
	$venue = $row["venue"];
	$remarks = $row["remarks"];
	$timeStart = $row["timeStart"];
	$timeEnd = $row["timeEnd"];
	if (!$timeStart) {
		$timeStart = "08:00:00";
	}
	if (!$timeEnd) {
		$timeEnd = "17:00:00";
	}

	$json = array(
		'training' => $training,
		'startDate' => $startDate,
		'endDate' => $endDate,
		'startDateFormatted' => formatDate($startDate),
		'endDateFormatted' => formatDate($endDate),
		'numHours' => $numHours,
		'venue' => $venue,
		'remarks' => $remarks,
		'timeStart' => $timeStart,
		'timeEnd' => $timeEnd,
		'timeStartFormatted' => formatTime($timeStart),
		'timeEndFormatted' => formatTime($timeEnd)
	);

	echo json_encode($json);
} elseif (isset($_POST["edit"])) {
	$personneltrainings_id = $_POST["personneltrainings_id"];
	$training = addslashes($_POST["training"]);
	// check first i-*f training is already in trainings
	$sql = "SELECT * FROM `trainings` WHERE `training` = '$training'";
	$result = $mysqli->query($sql);
	// if none add
	if ($result->num_rows == 0) {
		$training = strtoupper($training);
		$sql = "INSERT INTO `trainings` (`training`, `dateAdded`) VALUES ('$training', '$dateAdded')";
		$mysqli->query($sql);
	}
	// get training_id
	$training = strtoupper($training);
	$sql = "SELECT `training_id` FROM `trainings` WHERE `training` = '$training'";
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


	$editQueries = $_POST["editQueries"];

	$sql = "UPDATE `personneltrainings` SET `training_id` = '$training_id', `startDate` = '$startDate', `endDate` = '$endDate', `numHours` = '$numHours', `venue` = '$venue', `remarks` = '$remarks', `timeStart` = '$timeStart', `timeEnd` = '$timeEnd' WHERE `personneltrainings`.`personneltrainings_id` = '$personneltrainings_id'";
	$mysqli->query($sql);

	foreach ($editQueries as $sql) {
		$mysqli->query($sql);
	}
}

 elseif (isset($_POST["loadPersonnelList"])) {
		$personneltrainings_id  = $_POST["personneltrainings_id"];
		$sql = "SELECT * FROM `department` WHERE `department_id` IN (SELECT DISTINCT `department_id` FROM `employees` WHERE `employees_id` IN (SELECT `employees_id` FROM `personneltrainingslist` WHERE `personneltrainings_id` = '$personneltrainings_id')) ORDER BY `department` ASC";
		$result = $mysqli->query($sql);
		while ($row = $result->fetch_assoc()) {
			$department_id = $row["department_id"];
			$department = $row["department"];
?>

			<li style="float: left; list-style: outside none none; padding-right: 50px; width: 50%;"><b><?php echo strtoupper($department); ?></b>
			<ol>

<?php
			$sql1 = "SELECT * FROM `employees` WHERE `employees_id` IN (SELECT `employees_id` FROM `personneltrainingslist` WHERE `personneltrainings_id` = '$personneltrainings_id') AND `department_id` = '$department_id' ORDER BY `lastName` ASC";
			$result1 = $mysqli->query($sql1);
			if ($result1->num_rows == 0) {
				?>
				<li><i style="color: lightgrey;">N/A</i> </li>
				<?php
			}
			while ($row1 = $result1->fetch_assoc()) {
				$lastName = $row1["lastName"];
				$firstName = $row1["firstName"];
				$middleName = $row1["middleName"];
				$extName = $row1["extName"];

				$fullName = $lastName.", ".$firstName." ".$middleName." ".$extName;
?>

				<li><?php echo mb_convert_case($fullName,MB_CASE_TITLE, "UTF-8");?></li>
<?php
			}
?>
			</ol>
		</li>
<?php
		}
} elseif (isset($_POST["loadListAdded"])) {
	$personneltrainings_id = $_POST["personneltrainings_id"];
	$sql = "SELECT * FROM `employees` WHERE `employees_id` IN (SELECT `employees_id` FROM `personneltrainingslist` WHERE `personneltrainings_id` = '$personneltrainings_id')";
	$result = $mysqli->query($sql);
	while ($row = $result->fetch_assoc()) {
				$employees_id = $row["employees_id"];
				$lastName = $row["lastName"];
				$firstName = $row["firstName"];
				$middleName = $row["middleName"];
				$extName = $row["extName"];
				$fullName = $lastName.", ".$firstName." ".$middleName." ".$extName;
?>
	<div id="<?php echo $employees_id;?>" class="item">
		<div class="right floated content">
		  <button onclick="removeFromList('<?php echo $employees_id;?>')" class="ui icon basic mini button"><i class="icon times"></i></button>
		</div>
		<div class="content"><?php echo $fullName;?></div>
  </div>
<?php
	}
} elseif (isset($_POST["loadListToAdd"])) {
	$personneltrainings_id = $_POST["personneltrainings_id"];
	$sql = "SELECT * FROM `employees` WHERE `employees_id` NOT IN (SELECT `employees_id` FROM `personneltrainingslist` WHERE `personneltrainings_id` = '$personneltrainings_id') ORDER BY `lastName` ASC";
	$result = $mysqli->query($sql);
	while ($row = $result->fetch_assoc()) {
				$employees_id = $row["employees_id"];
				$lastName = $row["lastName"];
				$firstName = $row["firstName"];
				$middleName = $row["middleName"];
				$extName = $row["extName"];
				$fullName = $lastName.", ".$firstName." ".$middleName." ".$extName."<br>";
?>
	<div id="<?php echo $employees_id;?>" class="item">
    <div class="right floated content">
      <button onclick="addToList('<?php echo $employees_id;?>')" class="ui icon basic mini button"><i class="icon add"></i></button>
    </div>
    <div class="content"><?php echo $fullName; ?></div>
  </div>

<?php
	}
} elseif (isset($_POST["getAssessmentText"])) {
	$personneltrainingseval_id = $_POST["personneltrainingseval_id"];
	$assessment_ = $_POST["assessment_"];
	$sql = "SELECT `assessment_$assessment_` FROM `personneltrainingseval` WHERE `personneltrainingseval_id` = '$personneltrainingseval_id'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	echo $assessment_text = htmlentities($row["assessment_$assessment_"]);

} elseif (isset($_POST["editAss"])) {
	$personneltrainingseval_id = $_POST["personneltrainingseval_id"];
	$assessment_ = $_POST["assessment_"];
	$assessment_text = $_POST["assessment_text"];
	$assessment_text = addslashes($assessment_text);
	$sql = "UPDATE `personneltrainingseval` SET `assessment_$assessment_` = '$assessment_text' WHERE `personneltrainingseval`.`personneltrainingseval_id` = '$personneltrainingseval_id'";
	$mysqli->query($sql);
} elseif (isset($_POST["loadAssess"])) {
	$personneltrainings_id =$_POST["personneltrainings_id"];
?>
			<div class="field">
				<label>1.) What was the high point of the whole learning experience?</label>

<div class="ui tiny middle aligned selection list">
					<?php

						function getAssessments($index,$personneltrainings_id){
						require "_connect.db.php";
						$sql = "SELECT * FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id'";
						
						$result = $mysqli->query($sql);
						$nulls = 0;
						while ( $row = $result->fetch_assoc()) {
							
							$personneltrainingseval_id = $row["personneltrainingseval_id"];
							${"assessment_".$index} = $row["assessment_".$index];
							if (${"assessment_".$index} != null) {
								echo "<div onclick=\"editAssFunc('$personneltrainingseval_id','$index')\" class=\"item\"><div class=\"content\"><div id=\"assessment_$index$personneltrainingseval_id\" style=\"color: black; font-size: 12px;\">${"assessment_".$index}</div></div></div>";
							} else {
								$nulls++;
							}
						}
						if ($nulls == $result->num_rows) {
							echo "<div class=\"item\"><div class=\"content\"><div class=\"header mini\" style=\"color: lightgrey;\">N/A</div></div></div>";
						}
					}

					 getAssessments(1,$personneltrainings_id);
					?>
</div>
			</div>
			<div class="field">
				<label>2.) What major benefit/s you received from this training/workshop?</label>
					<div class="ui tiny middle aligned selection list">
					<?php
						getAssessments(2,$personneltrainings_id);
					?>
				</div>
			</div>
			<div class="field">
				<label>3.) In what specific ways this training/workshop can be improved?</label>
					<div class="ui tiny middle aligned selection list">
					<?php
						getAssessments(3,$personneltrainings_id);
					?>
				</div>
			</div>
			<div class="field">
				<label>4.) What other trainings you want HRMO to conduct to make you become more competent in your job?</label>
					<div class="ui tiny middle aligned selection list">
					<?php
						getAssessments(4,$personneltrainings_id);
					?>
				</div>
			</div>
			<div class="field">
				<label>5.) Other comments and suggestions:</label>
					<div class="ui tiny middle aligned selection list">
					<?php
						getAssessments(5,$personneltrainings_id);
					?>
				</div>
			</div>
<?php

}

// format date from numeric to string start
function formatDate($numeric_date){
	$date = new DateTime($numeric_date);
	$strDate = $date->format('F d, Y');
	return $strDate;
}
// format date from numeric to string end

function formatTime($numeric_time){
	$time = new DateTime($numeric_time);
	$strTime = $time->format('h:i A');
	return $strTime;
}

?>