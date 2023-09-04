<?php
require '_connect.db.php';
require 'libs/FormatDateTime.php';
require 'libs/Department.php';

$deparment = new Department;


if (isset($_POST["load"])) {
	$rspvac_id = $_POST["rspvac_id"];
	
	$sql = "SELECT * FROM `rsp_vacant_positions` WHERE `rspvac_id` = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("i",$rspvac_id);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($rspvac_id,$position,$sg,$office,$dateVacated,$education,$training,$experience,$eligibility,$datetime_added);
	$stmt->fetch();

	$data = array(
		"rspvac_id" => $rspvac_id,
		"position" => strtoupper($position),
		"sg" => $sg,
		"office" => $deparment->getDepartment($office),
		"dateVacated" => $dateVacated,
		"education" => unserialize($education),
		"training" => unserialize($training),
		"experience" => unserialize($experience),
		"eligibility" => unserialize($eligibility),
	);
	$stmt->close();
	
	$sql = "SELECT * FROM `rsp_applicants_profile`";
	$stmt = $mysqli->prepare($sql);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($rspapp_id,$rspvac_id,$name,$address,$age,$mobileNum,$school,$education,$remarks,$trainings,$company,$inclusiveDates,$position,$status,$eligibility);

	$view = "asd";
	while ($stmt->fetch()) {
		$view .= "<tr>";
		$view .= "<td>$name</td>";
		$view .= "<td>$address</td>";
		$view .= "<td>$age</td>";
		$view .= "<td>$mobileNum</td>";
		$view .= "<td>$school</td>";
		$view .= "<td>$education</td>";
		$view .= "<td>".viewList($trainings)."</td>";
		$view .= "<td></td>";
		$view .= "<td></td>";
		$view .= "<td></td>";
		$view .= "<td></td>";
		$view .= "<td>".viewList($eligibility)."</td>";
		$view .= "<td>$remarks</td>";
		$view .= "</tr>";
	}

	$data["view"] = $view;
	$stmt->close();
	
	echo json_encode($data);



}

elseif (isset($_POST["addNew"])) {
	$rspvac_id = $_POST["rspvac_id"];
	$data0 = $_POST["data0"];
	$data1 = $_POST["data1"];

	$name = $data0[0];
	$address = $data0[1];
	$age = $data0[2];
	$mobileNum = $data0[3];
	$school = $data0[4];
	$education = $data0[5];
	$remarks = $data0[6];
	
	$trainings = serialize($data1[0]);
	$experience = serialize($data1[1]);
	$eligibility = serialize($data1[2]);
	
	$sql = "INSERT INTO `rsp_applicants_profile` (`rspapp_id`,`rspvac_id`,`name`,`address`,`age`,`mobileNum`,`school`,`education`,`remarks`,`trainings`,`company`,`inclusiveDates`,`position`,`status`,`elig`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?,?,NULL, NULL, NULL, NULL, ?)";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("ississssss",$rspvac_id,$name,$address,$age,$mobileNum,$school,$education,$remarks,$trainings,$eligibility);
	$stmt->execute();
	$stmt->close();
}

	function viewList($arr){
		$str = "";
		if ($array = unserialize($arr)) {
			foreach ($array as $index => $value) {
				$str .= "* ".$value;
				if ((count($array)-1) !== $index) {
					$str .= "<br>";
				}
			}
			return  $str;
		} else {
			return "<i style='color:grey'>n/a</i>";
		}
	}
?>