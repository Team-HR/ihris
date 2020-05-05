<?php
require '_connect.db.php';
require 'libs/FormatDateTime.php';
require 'libs/Department.php';
require 'libs/DateCompactor.php';


if (isset($_POST["load"])) {
	
	$year = $_POST["yearState"];
	if ($year === "all") {
		$year = 1000;
		// $sql = "SELECT * FROM `rsp_vacant_positions` WHERE year(`dateVacated`) != ? ORDER BY `positiontitle` ASC";
		$sql = "SELECT `rsp_vacant_positions`.*, `rsp_indturnarroundtime`.`itat0` FROM `rsp_vacant_positions` LEFT JOIN `rsp_indturnarroundtime` ON `rsp_vacant_positions`.`rspvac_id` = `rsp_indturnarroundtime`.`rspvac_id` WHERE year(`dateVacated`) != ? ORDER BY `rsp_indturnarroundtime`.`itat0` DESC";
	} else {
		// $sql = "SELECT * FROM `rsp_vacant_positions` WHERE year(`dateVacated`) = ? ORDER BY `positiontitle` ASC";
		$sql = "SELECT `rsp_vacant_positions`.*, `rsp_indturnarroundtime`.`itat0` FROM `rsp_vacant_positions` LEFT JOIN `rsp_indturnarroundtime` ON `rsp_vacant_positions`.`rspvac_id` = `rsp_indturnarroundtime`.`rspvac_id` WHERE year(`dateVacated`) = ? ORDER BY `rsp_indturnarroundtime`.`itat0` DESC";
	}

	
	$deparment = new Department();
	$dateTime = new FormatDateTime();
	$dateCompactor = new DateCompactor;

	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("i", $year);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($rspvac_id,$position,$itemNo,$sg,$office,$dateVacated,$dateOfInterview,$education,$training,$experience,$eligibility,$datetime_added,$pub_date);
	$counter = 1;
	if ($stmt->num_rows === 0) {
?>

	<tr>
		<td colspan="12" style="color: grey; text-align: center; padding: 50px;"><i>No Vacant Positions Available</i> </td>
	</tr>

<?php
	}
	while ($stmt->fetch()) {
?>

	<tr>
		<td class="center aligned"><?=$counter++?></td>
		<td class="center aligned">
			  <a class="ui mini icon button" title="Go to" href="comparativeDataInfo.php?rspvac_id=<?=$rspvac_id?>"><i class="open folder blue icon"></i></a>
		</td>
		<td><?=$position;?></td>
		<td class="center aligned" style="white-space: nowrap;">
			<?php 
				if (!$itemNo) {
					echo "---";
				} else {
					echo $itemNo;
				}
			?>
		</td>
		<td><?=$sg;?></td>
		<td><?=$deparment->getDepartment($office)?></td>
		<td><?=viewList($education);?></td>
		<td><?=viewList($training);?></td>
		<td><?=viewList($experience);?></td>
		<td><?=viewList($eligibility);?></td>
		<td class="center aligned">
		<?php
			if ($dateVacated !== "0000-00-00") {
				echo $dateTime->formatDate($dateVacated);
			} else {
				echo "---";
			}
		?></td>
		<td class="center aligned">
		<?php
			if ($dateOfInterview !== "0000-00-00") {
				echo $dateTime->formatDate($dateOfInterview);
			} else {
				echo "---";
			}
		?>
		</td>
		<td>
			<?=(unserialize($pub_date)?$dateCompactor->compactDates(unserialize($pub_date)):'---')?>
		</td>
		<td class="center aligned" style="width: 50px;">



<!-- 
			<div class="ui mini icon basic buttons">
			  <button class="ui button" title="Edit" onclick="editFunc('<?=$rspvac_id?>')"><i class="edit blue icon"></i></button>
			  <button class="ui button" title="Delete" onclick="deleteFunc('<?=$rspvac_id?>')"><i class="trash blue icon"></i></button>
			</div> -->

<div class="ui mini basic icon buttons" >
  <button class="ui positive button" title="Edit" onclick="editFunc('<?=$rspvac_id?>')"><i class="icon edit"></i></button>
  <div class="or"></div>
  <button class="ui negative button" title="Delete" onclick="deleteFunc('<?=$rspvac_id?>')"><i class="icon trash"></i></button>
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
	$itemNo = $data0[1];
	$sg = $data0[2];
	$office = $data0[3];
	$dateVacated = $data0[4];
	$dateOfInterview = $data0[5];
	$education = serialize($data1[0]);
	$training = serialize($data1[1]);
	$experience = serialize($data1[2]);
	$eligibility = serialize($data1[3]);

	$sql = "INSERT INTO `rsp_vacant_positions` (`rspvac_id`, `positiontitle`, `itemNo`, `sg`, `office`, `dateVacated`, `dateOfInterview`, `education`, `training`, `experience`, `eligibility`, `datetime_added`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";

	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("ssisssssss",$position,$itemNo,$sg,$office,$dateVacated,$dateOfInterview,$education,$training,$experience,$eligibility);
	$stmt->execute();
	$stmt->close();
}

elseif (isset($_POST["getValues"])) {
	$rspvac_id = $_POST["rspvac_id"];
	$sql = "SELECT * FROM `rsp_vacant_positions` WHERE `rspvac_id` = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("i",$rspvac_id);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($rspvac_id,$position,$itemNo,$sg,$office,$dateVacated,$dateOfInterview,$education,$training,$experience,$eligibility,$datetime_added);

	
	while ($stmt->fetch()) {
		$data = array($position,$itemNo,$sg,$office,$dateVacated,$dateOfInterview,unserialize($education),unserialize($training),unserialize($experience),unserialize($eligibility));	
	}
	echo json_encode($data);

}

elseif(isset($_POST["editEntry"])){
	$rspvac_id = $_POST["id"];
	$data0 = $_POST["data0"];
	$data1 = $_POST["data1"];

	$position = $data0[0];
	$itemNo = $data0[1];
	$sg = $data0[2];
	$office = $data0[3];
	$dateVacated = $data0[4];
	$dateOfInterview = $data0[5];
	$education = serialize($data1[0]);
	$training = serialize($data1[1]);
	$experience = serialize($data1[2]);
	$eligibility = serialize($data1[3]);

	$sql = "UPDATE `rsp_vacant_positions` SET `positiontitle`= ?, `itemNo`= ?, `sg`= ?,`office`= ?,`dateVacated`= ?,`dateOfInterview`= ?,`education`= ?,`training`= ?,`experience`= ?,`eligibility`= ? WHERE `rspvac_id` = ?";

	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("ssisssssssi",$position, $itemNo, $sg,$office,$dateVacated,$dateOfInterview,$education,$training,$experience,$eligibility,$rspvac_id);
	$stmt->execute();
	$stmt->close();
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

	function formatDate($numeric_date){
		if ($numeric_date) {
			$date = new DateTime($numeric_date);
		 	$strDate = $date->format('M d, Y');
			return $strDate;	
		}
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
?>
