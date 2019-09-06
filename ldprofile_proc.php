<?php
require_once "_connect.db.php";

if (isset($_POST["loadTable"])) {
	$year = $_POST["year"];

	if ($year == "" || $year == "all") {
		$sql = "SELECT * FROM `trainings` ORDER BY `training` ASC";
		$sort ="";
	} else {
		$sql = "SELECT * FROM `trainings` WHERE `training_id` IN (SELECT `training_id` FROM `personneltrainings` WHERE year(`startDate`) = '$year')";
		$sort =" AND year(`startDate`) = '$year'";
	}
	
	$result = $mysqli->query($sql);
	$counter = 0;
	$sumMales = 0;
	$sumFemales = 0;
	while ($row = $result->fetch_assoc()) {

		$training_id = $row["training_id"];
		$training = $row["training"];

		$sql1 = "SELECT * FROM `personneltrainings` WHERE `training_id` = '$training_id'".$sort." ORDER BY `startDate` DESC";
		
		$result1 = $mysqli->query($sql1);
	
		while ($row1 = $result1->fetch_assoc()) {
			$counter++;
			$personneltrainings_id = $row1["personneltrainings_id"];

			$sql2 = "SELECT `employees_id` FROM `employees` WHERE `gender` = 'MALE' AND `employees_id` IN (SELECT `employees_id` FROM `personneltrainingslist` WHERE `personneltrainings_id` = '$personneltrainings_id')";
			$result2 = $mysqli->query($sql2);
			$numOfMales = $result2->num_rows;
			$sumMales += $numOfMales;

			$sql2 = "SELECT `employees_id` FROM `employees` WHERE `gender` = 'FEMALE' AND `employees_id` IN (SELECT `employees_id` FROM `personneltrainingslist` WHERE `personneltrainings_id` = '$personneltrainings_id')";
			$result2 = $mysqli->query($sql2);
			$numOfFemales = $result2->num_rows;
			$sumFemales += $numOfFemales;

			$startDate = $row1["startDate"];
			$endDate = $row1["endDate"];
			$remarks = $row1["remarks"];

?>
<tr>
	<td><?php echo $counter;?></td>
	<td><?php echo $training;?></td>
	<td><?php echo dateToStr($startDate);?></td>
	<td><?php echo $remarks;?></td>
	<td><?php echo $numOfMales;?></td>
	<td><?php echo $numOfFemales;?></td>
</tr>

<?php
		}



	}
?>
<tr>
	<th colspan="4" style="text-align: right;">TOTAL:</th>
	<th><?php echo "$sumMales";?></th>
	<th><?php echo "$sumFemales";?></th>
</tr>
<?php

}


function dateToStr($numeric_date){
$date = new DateTime($numeric_date);
$strDate = $date->format('F d, Y');
return $strDate;
}

?>