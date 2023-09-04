<?php
require '_connect.db.php';
require 'libs/FormatDateTime.php';
require 'libs/Department.php';

if (isset($_POST["load"])) {
	
	$year = $_POST["yearState"];
	if ($year === "all") {
		$year = 0000;
		$sql = "SELECT * FROM `rsp_vacant_positions` WHERE year(`dateVacated`) != ?";
	} else {
		$sql = "SELECT * FROM `rsp_vacant_positions` WHERE year(`dateVacated`) = ?";
	}

	
	$deparmemt = new Department();
	$dateTime = new FormatDateTime();

	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("i", $year);

	
	
	
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($rspvac_id,$position,$sg,$office,$dateVacated,$education,$training,$experience,$eligibility,$datetime_added);
	$counter = 1;
	if ($stmt->num_rows === 0) {
?>

	<tr>
		<td colspan="10" style="color: grey; text-align: center; padding: 50px;"><i>No Vacant Positions Available</i> </td>
	</tr>

<?php
	}
	while ($stmt->fetch()) {
?>

	<tr>
		<td><?=$counter++?></td>
		<td><?=$position;?></td>
		<td><?=$sg;?></td>
		<td><?=$deparmemt->getDepartment($office)?></td>
		<td><?=viewList($education);?></td>
		<td><?=viewList($training);?></td>
		<td><?=viewList($experience);?></td>
		<td><?=viewList($eligibility);?></td>
		<td><?=$dateTime->formatDate($dateVacated);?></td>
		<td style="text-align: center; width: 150px;">
			<div class="ui mini icon basic buttons">
			  <button class="ui button" title="Delete" onclick="editFunc('<?=$rspvac_id?>')"><i class="edit icon"></i> Edit</button>
			  <!-- <button class="ui button" title="Delete"><i class="trash icon"></i> </button> -->
			  <button class="ui button" title="Delete" onclick="deleteFunc('<?=$rspvac_id?>')"><i class="trash icon"></i> Delete</button>
			</div>
		</td>
	</tr>

<?php
	}
// echo "</table>";
	$stmt->close();
	$mysqli->close();
}

elseif (isset($_POST["addNew"])) {
	$data0 = $_POST["data0"];
	$data1 = $_POST["data1"];

	$position = $data0[0];
	$sg = $data0[1];
	$office = $data0[2];
	$dateVacated = $data0[3];
	$education = serialize($data1[0]);
	$training = serialize($data1[1]);
	$experience = serialize($data1[2]);
	$eligibility = serialize($data1[3]);

	$sql = "INSERT INTO `rsp_vacant_positions` (`rspvac_id`, `positiontitle`, `sg`, `office`, `dateVacated`, `education`, `training`, `experience`, `eligibility`, `datetime_added`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";

	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("sissssss",$position,$sg,$office,$dateVacated,$education,$training,$experience,$eligibility);
	$stmt->execute();
	$stmt->close();
	$mysqli->close();
}

elseif (isset($_POST["getValues"])) {
	$rspvac_id = $_POST["rspvac_id"];
	$sql = "SELECT * FROM `rsp_vacant_positions` WHERE `rspvac_id` = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("i",$rspvac_id);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($rspvac_id,$position,$sg,$office,$dateVacated,$education,$training,$experience,$eligibility,$datetime_added);

	
	while ($stmt->fetch()) {
		$data = array($position,$sg,$office,$dateVacated,unserialize($education),unserialize($training),unserialize($experience),unserialize($eligibility));	
	}
	echo json_encode($data);

}

elseif(isset($_POST["editEntry"])){
	$rspvac_id = $_POST["id"];
	$data0 = $_POST["data0"];
	$data1 = $_POST["data1"];

	$position = $data0[0];
	$sg = $data0[1];
	$office = $data0[2];
	$dateVacated = $data0[3];
	$education = serialize($data1[0]);
	$training = serialize($data1[1]);
	$experience = serialize($data1[2]);
	$eligibility = serialize($data1[3]);

	$sql = "UPDATE `rsp_vacant_positions` SET `positiontitle`= ?,`sg`= ?,`office`= ?,`dateVacated`= ?,`education`= ?,`training`= ?,`experience`= ?,`eligibility`= ? WHERE `rspvac_id` = ?";

	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("sissssssi",$position,$sg,$office,$dateVacated,$education,$training,$experience,$eligibility,$rspvac_id);
	$stmt->execute();
	$stmt->close();
	$mysqli->close();
}

elseif (isset($_POST["deleteFunc"])) {
	$rspvac_id = $_POST["rspvac_id"];

	$sql = "DELETE FROM `rsp_vacant_positions` WHERE `rsp_vacant_positions`.`rspvac_id` = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("i",$rspvac_id);
	$stmt->execute();
	$stmt->close();
	$mysqli->close();
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
			echo  $str;
		} else {
			echo "<i style='color:grey'>n/a</i>";
		}
	}

?>
