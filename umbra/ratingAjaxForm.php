<?php

require "../_connect.db.php";

$view = "";

if (isset($_POST['prrList'])) {
	$prrList_id =  $_POST['prrList'];

	$prr_id = $_POST['prr_id']; //period id in prrlist

	$period_id = getSpmsMfoPeriodId($mysqli, $prr_id);
	$employees_id = $_POST['empId'];

	$file_status = getSpmsPerformanceReviewStatusData($mysqli, $period_id, $employees_id);


	$sqlName = "SELECT * from employees where employees_id = '$employees_id'";
	$resultName = $mysqli->query($sqlName);
	$rowName = $resultName->fetch_assoc();
	$sql = "SELECT * FROM prrlist where prrlist_id=$prrList_id";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	$EmpName = $rowName['lastName'] . " " . $rowName['firstName'] . " " . $rowName['middleName'] . " " . $rowName['extName'];
} else {
	$view = "<h4>Missing Cardinals</h4>";
}



function getSpmsPerformanceReviewStatusData($mysqli, $period_id, $employees_id)
{
	$sql = "SELECT * FROM `spms_performancereviewstatus` WHERE `period_id` = '$period_id' AND `employees_id` = '$employees_id'";
	$res = $mysqli->query($sql);
	if ($row = $res->fetch_assoc()) {
		return [
			'date_submitted' => $row['dateAccomplished'] ? convertDateSubmitted($row['dateAccomplished']) : '0000-00-00',
			'date_appraised' => $row['panelApproved'] ? convertDateAppraised($row['panelApproved']) : ($row['certify'] ? convertDateAppraised($row['certify']) : '0000-00-00'),
			'numerical' => $row['final_numerical_rating'],
			'adjectival' => getAdjectivalRating($row['final_numerical_rating'])
		];
	} else return null;
}

function getAdjectivalRating($final_numerical_rating)
{
	$final_adjectival_rating = "";
	if ($final_numerical_rating <= 5 && $final_numerical_rating > 4) {
		$final_adjectival_rating = "O";
	} elseif ($final_numerical_rating <= 4 && $final_numerical_rating > 3) {
		$final_adjectival_rating = "VS";
	} elseif ($final_numerical_rating <= 3 && $final_numerical_rating > 2) {
		$final_adjectival_rating = "S";
	} elseif ($final_numerical_rating <= 2 && $final_numerical_rating > 1) {
		$final_adjectival_rating = "U";
	}
	return $final_adjectival_rating;
}



function getSpmsMfoPeriodId($mysqli, $prr_id)
{
	$sql = "SELECT * FROM `prr` WHERE `prr`.`prr_id` = '$prr_id'";
	$res = $mysqli->query($sql);
	$period = "";
	$year = "";
	if ($row = $res->fetch_assoc()) {
		$period = $row["period"];
		$year = $row["year"];
	} else return null;

	if (!$period && !$year) return null;

	$sql = "SELECT * FROM `spms_mfo_period` WHERE `month_mfo` = '$period' AND `year_mfo` = '$year'";
	$res = $mysqli->query($sql);

	if ($row = $res->fetch_assoc()) {
		return $row["mfoperiod_id"];
	} else return null;
}


function convertDateSubmitted($date)
{
	$datetime = DateTime::createFromFormat('m/d/y', $date);
	return $datetime ? $datetime->format('Y-m-d') : '0000-00-00';
}

function convertDateAppraised($date)
{
	$datetime = DateTime::createFromFormat('d-m-Y', $date);
	return $datetime ? $datetime->format('Y-m-d') : '0000-00-00';
}

?>
<div class="header">
	<h3>Form</h3>
</div>
<div class="scrolling content">
	<form class="ui form" name="AddrateForm" onsubmit="return rateDataSave(this)">
		<div class="field">
			<label>First Name</label>
			<input type="text" value="<?= $EmpName ?>" readonly>
			<input type="hidden" name="prrList" value="<?= $_POST['prrList'] ?>" readonly>
			<input type="hidden" name="empId" value="<?= $_POST['empId'] ?>" readonly>
			<input type="hidden" name="prr_id" value="<?= $_POST['prr_id'] ?>" readonly>
		</div>
		<div class="field">
			<label>Data Submitted</label>
			<input type="Date" name="DataSub" value="<?= $file_status['date_submitted'] ?>">
		</div>
		<div class="fields">
			<div class="seven wide field">
				<label>Appraisal Type</label>
				<?php
				if ($row['appraisal_type']) {
				?>
					<input type="text" name="appraisalType" value="<?= $row['appraisal_type'] ?>">
				<?php
				} else {
				?>
					<input type="text" name="appraisalType" value="Semestral">
				<?php
				}
				?>
			</div>
			<div class="seven wide field">
				<label>Date Appraised</label>
				<input type="Date" name="appraisalDate" value="<?= $file_status['date_appraised'] ?>">
			</div>
		</div>
		<div class="fields">
			<div class="seven wide field">
				<label>Numerical Rating</label>
				<input type="text" name="numericalRating" value="<?= $file_status['numerical'] ?>" onkeyup="adrate(this)">
			</div>
			<div class="seven wide field">
				<label>Adjective Rating</label>
				<input type="text" id="adjectiveRate" name="adjectiveRating" value="<?= $file_status['adjectival'] ?>" readonly>
			</div>
		</div>
		<div class="field">
			<label>Remarks</label>
			<input type="text" name="remark" value="<?= $row['remarks'] ?>">
		</div>
		<div class="field">
			<label>Comments and Reccomendations</label>
			<!-- <input type="text" > -->
			<textarea name="comment"><?= $row['comments'] ?></textarea>
		</div>
		<div class="field">
			<div class="actions">
				<input class="ui primary button" type="Submit" name="remarks" value="Save">
				<div class="ui cancel button">Cancel</div>
			</div>
		</div>
	</form>
</div>
<!-- <div class="ui primary button">Save</div>	 -->