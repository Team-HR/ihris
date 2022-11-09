<?php
require "../_connect.db.php";

if (isset($_POST['Scolor'])) {

	$prrList = $_POST["prrList"];
	$Scolor = $_POST["Scolor"];
	$sql = "UPDATE `prrlist` SET `stages` = '$Scolor' WHERE `prrlist`.`prrlist_id` ='$prrList'";
	$sql = $mysqli->query($sql);
	if (!$sql) {
		echo $mysqli->error;
	} else {
		echo 1;
	}
} else {
	$prrList = $_POST['prrList'];
	$empId = $_POST['empId'];
	$prr_id = $_POST['prr_id'];
	$appraisalType = $mysqli->real_escape_string($_POST['appraisalType']);
	$appraisalDate = $_POST['appraisalDate'];
	$date_submitted = $_POST['date_submitted'];
	// $numericalRating = $_POST['numericalRating'];
	// $adjectiveRate = $_POST['adjectiveRate'];
	$remarks = addslashes($_POST['remarks']);
	// $comments = addslashes($_POST['comments']);

	if ($prrList == 0) {
		$sql = "INSERT INTO `prrlist`
					(`prrlist_id`,
						 `prr_id`,
						 `employees_id`,
						 `date_submitted`,
						 `appraisal_type`,
						 `date_appraised`,
						 `remarks`)
		VALUES
		(NULL, '$prr_id', '$empId', '$date_submitted', '$appraisalType', '$appraisalDate', '$remarks')";
	} else {

		$sql = "UPDATE `prrlist` SET
		`appraisal_type` = '$appraisalType',
		`remarks` = '$remarks',
		`comments` = '$comments'
		WHERE `prrlist_id` = '$prrList'";

		$period_id = get_period_id($mysqli, $prr_id);
		if ($period_id) {
			$sql_spm_performancereviewstatus = "UPDATE `spms_performancereviewstatus` SET `dateAccomplished` = '$date_submitted', `panelApproved` = '$appraisalDate' WHERE `employees_id` = '$empId' AND `period_id` = '$period_id'";
			$mysqli->query($sql_spm_performancereviewstatus);
		}
	}
	$mysqli->query($sql);
}

function get_period_id($mysqli, $prr_id)
{
	$year = "SELECT * from prr where prr_id='$prr_id'";
	$year = $mysqli->query($year);
	$year = $year->fetch_assoc();
	$period = $year['period'];
	$year = $year['year'];
	# get period id
	$sql = "SELECT `mfoperiod_id` FROM `spms_mfo_period` WHERE `month_mfo` = '$period' AND `year_mfo` = '$year';";
	$res = $mysqli->query($sql);
	# mfoperiod_id
	$period_id = $res->fetch_assoc()["mfoperiod_id"];

	return $period_id;
}
