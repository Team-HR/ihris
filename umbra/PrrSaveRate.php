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
	$numericalRating = $_POST['numericalRating'];
	$adjectiveRate = $_POST['adjectiveRate'];
	$remarks = $mysqli->real_escape_string($_POST['remarks']);
	$comments = $mysqli->real_escape_string($_POST['comments']);
	$DataSub = $mysqli->real_escape_string($_POST['DataSub']);

	if ($prrList == 0) {
		$sql = "INSERT INTO `prrlist`
					(`prrlist_id`,
						 `prr_id`,
						 `employees_id`,s
						 `date_submitted`,
						 `appraisal_type`,
						 `date_appraised`,
						 `numerical`,
						 `adjectival`,
						 `remarks`,
						 `comments`)
		VALUES
		(NULL, '$prr_id', '$empId', '$DataSub', '$appraisalType', '$appraisalDate', '$numericalRating', '$adjectiveRate', '$remarks', '$comments')";
	} else {
		$DataSub = $DataSub ? $DataSub : "";
		$appraisalType = $appraisalType ? $appraisalType : "";
		$appraisalDate = $appraisalDate ? $appraisalDate : "";
		$numericalRating = $numericalRating ? $numericalRating : "";
		$adjectiveRate = $adjectiveRate ? $adjectiveRate : "";
		$remarks = $remarks ? $remarks : "";
		$comments = $comments ? $comments : "";

		$sql = "UPDATE `prrlist` SET
		`date_submitted`='$DataSub',
		`appraisal_type` = '$appraisalType',
		`date_appraised` = '$appraisalDate',
		`numerical` = '$numericalRating',
		`adjectival` = '$adjectiveRate',
		`remarks` = '$remarks',
		`comments` = '$comments'
		WHERE `prrlist_id` = '$prrList'";

		# date_appraised update also date certified in spm_performancereviewstatus
		// $date_approved
		// $period_id = getSpmsMfoPeriodId($mysqli, $prr_id);

		$sql2 = "UPDATE spms_performancereviewstatus SET approved = '$date_approved' WHERE employees_id = $empId AND period_id = '$period_id'";

		if ($empId && $period_id) {
			$mysqli->query($sql2);
		}
	}
	$mysqli->query($sql);
}


function getSpmsMfoPeriodId($mysqli, $prr_id)
{
	$sql = "SELECT * FROM prr WHERE `prr_id` = '$prr_id'";
	$res = $mysqli->query($sql);
	$prr = $res->fetch_assoc();
	$month_mfo = $prr["period"];
	$year_mfo = $prr["year"];
	$sql = "SELECT * FROM `spms_mfo_period` WHERE `month_mfo` = '$month_mfo' AND `year_mfo` = '$year_mfo'";
	$res = $mysqli->query($sql);
	if ($period = $res->fetch_assoc()) {
		return $period["mfoperiod_id"];
	}
	return false;
}
