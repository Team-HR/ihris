<?php
require '_connect.db.php';
require 'libs/Department.php';
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
// $rspvac_id = 7;

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

	if ($stmt->num_rows === 0) {
?>
<tr>
	<td colspan="13" style="color: lightgrey; text-align: center; padding: 20px;"><i>No Applicants!</i></td>
</tr>
<?php
	} else {
$counter = 1;
	while ($stmt->fetch()) {
?>
<tr style="vertical-align: top;">
	<td><?=$counter++;?></td>
	<td>
		<a href="checklist.php?rspcomp_id=<?=$rspcomp_id?>" class="ui button basic icon"><i class="icon list ol <?=(check_if_exist($mysqli,$rspcomp_id)?'green':'red')?> "></i></a>
	</td>
	<td><?=$name;?></td>
	<td><?=$age?></td>
	<td><?=$gender?></td>
	<td style="white-space: nowrap;"><?=createYosList($num_years_in_gov)?></td>
	<td><?=$civil_status?></td>
	<td><?=$education?></td>
	<td><?=createList(unserialize($training))?></td>
	<td><?=createList(unserialize($experience),false)?></td>
	<td><?=createList(unserialize($eligibility))?></td>
	<td><?=createList(unserialize($awards))?></td>
	<td><?=createList(unserialize($records_infractions))?></td>
	<td class="noprint" style="width: 50px;">

<div class="ui mini basic icon buttons" >
  <button class="ui positive button" title="Edit" onclick="editApplicant(<?=$applicant_id?>)"><i class="icon edit"></i></button>
  <div class="or"></div>
  <button class="ui negative button" title="Delete" onclick="deleteEntry(<?=$rspcomp_id?>)"><i class="icon trash"></i></button>
</div>

	</td>
</tr>
<?php
		}
	}
}

elseif (isset($_POST["deleteEntry"])) {
	$rspcomp_id = $_POST["rspcomp_id"];
	$sql = "DELETE FROM `rsp_comparative` WHERE `rsp_comparative`.`rspcomp_id` = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("i",$rspcomp_id);
	$stmt->execute();
	$stmt->close();
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
	if ($counter === count($arr)) {
		$list = "* NONE";
	}	
	return $list;
}


function formatDate($numeric_date){
	 	$date = new DateTime($numeric_date);
	 	$strDate = $date->format('M d, Y');
		return $strDate;
}

function check_if_exist($mysqli,$rspcomp_id){
	// check if rspcomp_id has already a checklist
	$exist = false;
	$sql = "SELECT * FROM `rsp_comp_checklist` WHERE `rspcomp_id` = $rspcomp_id";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	if ($result->num_rows>0) {
	  $exist = true;
	}

	return $exist;

}
?>