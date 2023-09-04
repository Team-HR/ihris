<?php
require "../_connect.db.php";

if(isset($_POST['Scolor'])){

	$prrList = $_POST["prrList"];
	$Scolor = $_POST["Scolor"];
	$sql = "UPDATE `prrlist` SET `stages` = '$Scolor' WHERE `prrlist`.`prrlist_id` ='$prrList'";
	$sql = $mysqli->query($sql);
	if(!$sql){
		echo $mysqli->error;
	}else{
		echo 1;
	}
}else{

	$prrList = $_POST['prrList'];
	$empId = $_POST['empId'];
	$prr_id = $_POST['prr_id'];
	$appraisalType = addslashes($_POST['appraisalType']);
	$appraisalDate = $_POST['appraisalDate'];
	$numericalRating = $_POST['numericalRating'];
	$adjectiveRate = $_POST['adjectiveRate'];
	$remarks = addslashes($_POST['remarks']);
	$comments = addslashes($_POST['comments']);
	$DataSub = addslashes($_POST['DataSub']);

	if ($prrList==0) {
		$sql="INSERT INTO `prrlist`
					(`prrlist_id`,
						 `prr_id`,
						 `employees_id`,
						 `date_submitted`,
						 `appraisal_type`,
						 `date_appraised`,
						 `numerical`,
						 `adjectival`,
						 `remarks`,
						 `comments`)
		VALUES
		(NULL, '$prr_id', '$empId', '$DataSub', '$appraisalType', '$appraisalDate', '$numericalRating', '$adjectiveRate', '$remarks', '$comments')";
	}else{

		$sql = "UPDATE `prrlist` SET
		`date_submitted`='$DataSub',
		`appraisal_type` = '$appraisalType',
		`date_appraised` = '$appraisalDate',
		`numerical` = '$numericalRating',
		`adjectival` = '$adjectiveRate',
		`remarks` = '$remarks',
		`comments` = '$comments'
		WHERE `prrlist_id` = '$prrList'";

	}
	$mysqli->query($sql);
}

?>
