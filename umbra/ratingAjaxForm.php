<?php

require "../_connect.db.php";

$view = "";

if (isset($_POST['prrList'])) {
	$prrList_id =  $_POST['prrList'];
	$sqlName = "SELECT * from employees where employees_id = '$_POST[empId]'";
	$resultName = $mysqli->query($sqlName);
	$rowName = $resultName->fetch_assoc();
	$sql = "SELECT * FROM prrlist where prrlist_id=$prrList_id";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	$EmpName = $rowName['lastName'] . " " . $rowName['firstName'] . " " . $rowName['middleName'] . " " . $rowName['extName'];
} else {
	$view = "<h4>Missing Cardinals</h4>";
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
			<input type="Date" name="date_submitted" value="<?= $row['date_submitted'] ?>">
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
				<input type="Date" name="appraisalDate" value="<?= $row['date_appraised'] ?>">
			</div>
		</div>
		<div class="fields">
			<div class="seven wide field">
				<label>Numerical Rating</label>
				<!-- <input type="text" name="numericalRating" value="<?= $row['numerical'] ?>" onkeyup="adrate(this)"> -->
				<input type="text" name="numericalRating" value="<?= $row['numerical'] ?>" readonly>
			</div>
			<div class="seven wide field">
				<label>Adjective Rating</label>
				<input type="text" id="adjectiveRate" name="adjectiveRating" value="<?= $row['adjectival'] ?>" readonly>
			</div>
		</div>
		<div class="field">
			<label>Remarks</label>
			<input type="text" name="remark" value="<?= $row['remarks'] ?>">
		</div>
		<div class="field">
			<label>Comments and Reccomendations</label>
			<!-- <input type="text" > -->
			<!-- <textarea name="comment" readonly><?= $row['comments'] ?></textarea> -->
			<p style="margin: 20px; margin-bottom: 100px;"><?= $row['comments'] ?></p>
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