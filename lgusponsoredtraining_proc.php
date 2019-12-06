<?php
require_once "_connect.db.php";

if (isset($_POST["load"])) {
	$act_id = $_POST["act_id"];
	$sql = "SELECT * FROM `ldactivities` WHERE `act_id` = '$act_id'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	$year = $row["year"];
	$allocatedBudget = $row["allocatedBudget"];

	$sql = "SELECT * FROM `ldactivitieslist` WHERE `act_id` = '$act_id'";
	$result = $mysqli->query($sql);
	$paxTotal = 0;
	$budgetTotal = 0;
	if ($result->num_rows == 0) {
		?>
		<tr>
			<td colspan="10" style="text-align: center; color: lightgrey;">No Data</td>
		</tr>
		<?php
	}
	$count = 1;
	while ($row = $result->fetch_assoc()) {
		$row_id = $row["row_id"];
		$activityProcess = $row["activityProcess"];
		$accountablePerson = $row["accountablePerson"];
		$daysNum = $row["daysNum"];
		$paxNum = $row["paxNum"];
		$paxTotal += $paxNum;
		$venue = $row["venue"];
		$date = $row["date"];
		$budget = $row["budget"];
		$budgetTotal += $budget;
		$expectedOutputs = $row["expectedOutputs"];
		$remarks = $row["remarks"];
		?>
		<tr>
			<td><?php echo $count++;?></td>
			<td><?php echo $activityProcess;?></td>
			<td><?php echo $accountablePerson;?></td>
			<td><?php echo $daysNum;?></td>
			<td><?php echo $paxNum;?></td>
			<td><?php echo $venue;?></td>
			<td><?php echo $date;?></td>
			<td><?php echo "&#8369;".number_format($budget,2,".",",");?></td>
			<td><?php echo $expectedOutputs;?></td>
			<td><?php echo $remarks;?></td>
			<td class="noprint">
				<div class="ui icon basic mini buttons">
					<button onclick="editFunc('<?php echo $row_id;?>')" title="Quick Edit" class="ui button"><i class="edit outline icon"></i></button>
					<button onclick="deleteFunc('<?php echo $row_id;?>')" title="Delete" class="ui button"><i class="trash alternate outline icon"></i></button>
				</div>
			</td>
		</tr>
		<?php
	}
	?>
<!-- 	<tr>
		<td colspan="10"><button class="ui mini fluid green button noprint" onclick="addNew('<?php echo $act_id;?>')">Add</button></td>
	</tr> -->
	<tr style="text-align: right;">
		<th colspan="4">TOTAL NO. OF EMPLOYEES WITH L&D INTERVENTION:</th>
		<th><?php echo $paxTotal;?></th>
		<th colspan="2">TOTAL AMOUNT:</th>
		<th><?php echo "&#8369;".number_format($budgetTotal,2,".",",");?></th>
		<th>RUNNING BALANCE:</th>
		<th><?php 
		$runningBal = $allocatedBudget-$budgetTotal;
		echo "&#8369;".number_format($runningBal,2,".",",");
		?>
		</th>
	</tr>
<?php
} 

elseif (isset($_POST["loadBudget"])) {
	$act_id = $_POST["act_id"];
	$sql = "SELECT `allocatedBudget` FROM `ldactivities` WHERE `act_id` = '$act_id'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	$allocatedBudget = $row["allocatedBudget"];
	echo number_format($allocatedBudget,2,".",",");
}

elseif (isset($_POST["loadYear"])) {
	$act_id = $_POST["act_id"];
	$sql = "SELECT `year` FROM `ldactivities` WHERE `act_id` = '$act_id'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	$year = $row["year"];
	echo $year;
}

elseif (isset($_POST["editAllocatedBudget"])) {
	$act_id = $_POST["act_id"];
	$allocatedBudget = $_POST["allocatedBudget"];
	if (!is_numeric($allocatedBudget)) {
		$moneyChar = array("₱",",","Php","P","p","Php.","P.","p.");
		$allocatedBudget = str_replace($moneyChar, "", $allocatedBudget);
	}
	$sql = "UPDATE `ldactivities` SET `allocatedBudget` = '$allocatedBudget' WHERE `ldactivities`.`act_id` = '$act_id'";
	$mysqli->query($sql);
}

elseif (isset($_POST["addNew"])) {
	$act_id = $_POST["act_id"];
	$activityProcess = addslashes($_POST["activityProcess"]);
	$accountablePerson = addslashes($_POST["accountablePerson"]);
	$daysNum = $_POST["daysNum"];
	$paxNum = $_POST["paxNum"];
	$venue = addslashes($_POST["venue"]);
	$date = $_POST["date"];
	$budget = $_POST["budget"];
	$expectedOutputs = addslashes($_POST["expectedOutputs"]);
	$remarks = addslashes($_POST["remarks"]);

	$sql = "INSERT INTO `ldactivitieslist` (`row_id`, `act_id`, `activityProcess`, `accountablePerson`, `daysNum`, `paxNum`, `venue`, `date`, `budget`, `expectedOutputs`, `remarks`) VALUES (NULL, '$act_id', '$activityProcess', '$accountablePerson', '$daysNum', '$paxNum', '$venue', '$date', '$budget', '$expectedOutputs', '$remarks')";
	$mysqli->query($sql);
}

elseif (isset($_POST["deleteFunc"])) {
	$row_id = $_POST["row_id"];
	$sql = "DELETE FROM `ldactivitieslist` WHERE `ldactivitieslist`.`row_id` = '$row_id'";
	$mysqli->query($sql);
}

elseif (isset($_POST["loadInit"])) {
	$row_id = $_POST["row_id"];
	$sql = "SELECT * FROM `ldactivitieslist` WHERE `row_id` = '$row_id'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	$activityProcess = $row["activityProcess"];
	$accountablePerson = $row["accountablePerson"];
	$daysNum = $row["daysNum"];
	$paxNum = $row["paxNum"];
	$venue = $row["venue"];
	$date = $row["date"];
	$budget = $row["budget"];
	$expectedOutputs = $row["expectedOutputs"];
	$remarks = $row["remarks"];

	$json = array('activityProcess' => $activityProcess,'accountablePerson' => $accountablePerson,'daysNum' => $daysNum,'paxNum' => $paxNum,'venue' => $venue,'date' => $date,'budget' => $budget,'expectedOutputs' => $expectedOutputs,'remarks' => $remarks);

	echo json_encode($json);
}

elseif (isset($_POST["editFunc"])) {
	$row_id = $_POST["row_id"];
	$activityProcess = addslashes($_POST["activityProcess"]);
	$accountablePerson = addslashes($_POST["accountablePerson"]);
	$daysNum = $_POST["daysNum"];
	$paxNum = $_POST["paxNum"];
	$venue = addslashes($_POST["venue"]);
	$date = $_POST["date"];
	$budget = $_POST["budget"];
	$expectedOutputs = addslashes($_POST["expectedOutputs"]);
	$remarks = addslashes($_POST["remarks"]);
	$sql = "UPDATE `ldactivitieslist` SET `activityProcess`='$activityProcess',`accountablePerson`='$accountablePerson',`daysNum`='$daysNum',`paxNum`='$paxNum',`venue`='$venue',`date`='$date',`budget`='$budget',`expectedOutputs`='$expectedOutputs',`remarks`='$remarks' WHERE `row_id`= '$row_id'";
	$mysqli->query($sql);
}

?>
