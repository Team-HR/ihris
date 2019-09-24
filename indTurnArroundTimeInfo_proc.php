<?php
require '_connect.db.php';
require 'libs/Department.php';
require 'libs/DateCompactor.php';

$dateCompactor = new DateCompactor;
$department = new Department();
if (isset($_POST["load"])) {

	$rspvac_id = $_POST["rspvac_id"];
	$sql = "SELECT * FROM `rsp_vacant_positions` WHERE `rspvac_id` = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("i",$rspvac_id);
	$stmt->execute();
	// $stmt->store_result();	
	$stmt->bind_result($rspvac_id,$position, $itemNo, $sg,$office,$dateVacated,$dateOfInterview,$education,$training,$experience,$eligibility,$datetime_added);
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

} elseif (isset($_POST["loadList"])){
	$rspvac_id = $_POST["rspvac_id"];
	$sql = "SELECT `rspcomp_id`, `rsp_comparative`.`applicant_id`, `name`,`age`,`gender`,`num_years_in_gov`,`civil_status`,`education`,`training`,`experience`,`eligibility`,`awards`,`records_infractions` FROM `rsp_applicants` LEFT JOIN `rsp_comparative`ON `rsp_comparative`.`applicant_id` = `rsp_applicants`.`applicant_id` WHERE `rspvac_id` = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("i",$rspvac_id);
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


$num_rows = $stmt->num_rows;
	if ($num_rows === 0) {
?>
<tr>
	<td colspan="13" style="color: lightgrey; text-align: center; padding: 20px;"><i>No Applicants!</i></td>
</tr>
<?php
	} else {
$counter = 0;
	while ($stmt->fetch()) {
		$counter++;
		if ($counter===1) {
			// require 'jquery_datepick_5.1.0/datePicker.php';
?>


<tr style="vertical-align: top; text-align: center;">
	<td><?=$counter;?></td>
	<td style="white-space: nowrap;"><?=$name?></td>
	<td rowspan="<?=$num_rows?>"><div class="dateContainer"></div></td> 
	<td rowspan="<?=$num_rows?>"><div class="dateContainer"></div></td>
	<td rowspan="<?=$num_rows?>"><div class="dateContainer"></div></td>
	<td rowspan="<?=$num_rows?>"><div class="dateContainer"></div></td>
	<td rowspan="<?=$num_rows?>"><div class="dateContainer"></div></td>
	<td rowspan="<?=$num_rows?>"><div class="dateContainer"></div></td>
	<td rowspan="<?=$num_rows?>"><div class="dateContainer"></div></td>
	<td rowspan="<?=$num_rows?>"><div class="dateContainer"></div></td>
	<td rowspan="<?=$num_rows+1?>" style="vertical-align: middle; font-weight: bold;" class="totalDays"></td>
	<td rowspan="<?=$num_rows+1?>" style="vertical-align: middle; font-weight: bold;" class="costOfSourcing"></td>
</tr>
<?php
	} else {
?>
<tr style="vertical-align: top;">
	<td><?=$counter;?></td>
	<td style="white-space: nowrap;"><?=$name;?></td>
</tr>
<?php
			}
		}
	}

?>
<tr style="text-align: center; font-weight: bold;">
	<td></td>
	<td>Total</td>
	<td class="numDays"></td>
	<td class="numDays"></td>
	<td class="numDays"></td>
	<td class="numDays"></td>
	<td class="numDays"></td>
	<td class="numDays"></td>
	<td class="numDays"></td>
	<td class="numDays"></td>
</tr>
<?php

}


elseif (isset($_POST["compactDates"])) {
	
	if (isset($_POST["datesAll"]) ) {
		$datesAll = $_POST["datesAll"];
	} else {
		$datesAll = array(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
	}
		$rspvac_id = $_POST["rspvac_id"];
		

		$sql = "UPDATE `rsp_indturnarroundtime` SET `itat0`=?,`itat1`=?,`itat2`=?,`itat3`=?,`itat4`=?,`itat5`=?,`itat6`=?,`itat7`=?,`timestamp`= CURRENT_TIMESTAMP WHERE `rspvac_id` = ?";

		$stmt = $mysqli->prepare($sql);
		
		foreach ($datesAll as $key => $value) {
			$datesAll[$key] = serialize($value);
		}

		$stmt->bind_param("ssssssssi",$datesAll[0],$datesAll[1],$datesAll[2],$datesAll[3],$datesAll[4],$datesAll[5],$datesAll[6],$datesAll[7],$rspvac_id);

		$stmt->execute();
	
	if (isset($_POST["dates"]) && $_POST["dates"]) {
		$dates = $_POST["dates"];
		echo $dateCompactor->compactDates($dates);
	} else {
		echo "<i style='color: lightgrey;'>N/A</i>";
	}
}

elseif (isset($_POST["getITATDates"])) {
	$rspvac_id = $_POST["rspvac_id"];

	$sql0 = "SELECT * FROM `rsp_indTurnArroundTime` WHERE `rspvac_id` = '$rspvac_id'";
	$result = $mysqli->query($sql0);
	if ($result->num_rows === 0) {
		$sql1 = "INSERT INTO `rsp_indTurnArroundTime` (`rsp_indTATid`, `rspvac_id`, `itat0`, `itat1`, `itat2`, `itat3`, `itat4`, `itat5`, `itat6`, `itat7`, `costOfSourcing`) VALUES (NULL, '$rspvac_id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
		$mysqli->query($sql1);
		$arr = array();
		for ($i=0; $i < 9; $i++) { 
			$arr[] = "";
		}
		echo json_encode($arr);
	} else {
 		$row = $result->fetch_assoc();
 		$arr = array(
 			!$row['itat0'] ? "" : unserialize($row['itat0']),
 			!$row['itat1'] ? "" : unserialize($row['itat1']),
 			!$row['itat2'] ? "" : unserialize($row['itat2']),
 			!$row['itat3'] ? "" : unserialize($row['itat3']),
 			!$row['itat4'] ? "" : unserialize($row['itat4']),
 			!$row['itat5'] ? "" : unserialize($row['itat5']),
 			!$row['itat6'] ? "" : unserialize($row['itat6']),
 			!$row['itat7'] ? "" : unserialize($row['itat7'])
		);
		echo json_encode($arr);
	}
}

elseif (isset($_POST["loadCos"])) {
	$rspvac_id = $_POST["rspvac_id"];
	$sql0 = "SELECT * FROM `rsp_indTurnArroundTime` WHERE `rspvac_id` = '$rspvac_id'";
	$result = $mysqli->query($sql0);
	$row = $result->fetch_assoc();
	echo !$row['costOfSourcing'] ? "" : $row['costOfSourcing'];
}

elseif (isset($_POST["saveCos"])) {

	$rspvac_id = $_POST["rspvac_id"];
	
	if (isset($_POST["cos"]) && $_POST["cos"] !== "N/A" && !empty($_POST["cos"])) {
		$cos = $_POST["cos"];
	} else {
		$cos = null;
	}

	$sql = "UPDATE `rsp_indturnarroundtime` SET `costOfSourcing` = ?,`timestamp`= CURRENT_TIMESTAMP WHERE `rspvac_id` = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("si",$cos,$rspvac_id);
		$stmt->execute();
}


function createList($arr,$bool = true){
	$list = "";
	if ($arr) {
		if ($bool) {
			foreach ($arr as $value) {
				$list .= "* $value<br>";
			}
		} else {
			foreach ($arr as $key => $value) {
				$dates = "";
				if (!$value[3] && !$value[4]) {
					$dates = "(Dates not indicated)";
				} elseif (!$value[3] && $value[4]) {
					$dates = "(To: ".formatDate($value[4]).")";
				} elseif ($value[3] && !$value[4]) {
					$dates = "(From: ".formatDate($value[3])." to Present)";
				} else {
					$dates = "(".formatDate($value[3]) ." - ".formatDate($value[4]).")";
				}
				$list .= "* <b>$value[2]</b> <i>as</i>  <span style='color:#025214; font-weight: bold;'>$value[0]</span> $dates<br>";

			}
		}
	} else {
		$list .= "* NONE";
	}
	return $list;
} 


function createYosList($serial){
	
	$arr = unserialize($serial);

	$list = "";
	$counter = 0;
	foreach ($arr as $index => $value) {
		if ($value) {
			$list .= "* ".$index.": $value<br>";
		} else {
			$counter++;
		}
	}
	if ($counter === 4) {
		$list = "* NONE";
	}	
	return $list;
}


function formatDate($numeric_date){
	 	$date = new DateTime($numeric_date);
	 	$strDate = $date->format('M d, Y');
		return $strDate;
	}
?>