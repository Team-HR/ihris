<?php
require 'libs/FormatDateTime.php';
require 'libs/Department.php';
require 'libs/DateCompactor.php';

class VacantPost
{
	private $mysqli;
	function __construct()
	{
		require '_connect.db.php';
		$this->mysqli = $mysqli;
	}


// START LOAD

	public function load($yr,$file){

	$year = $yr;
	$view = "";

	if ($year === "all") {
		$year = 1000;
		// $sql = "SELECT * FROM `rsp_vacant_positions` WHERE year(`dateVacated`) != ? ORDER BY `itemNo` ASC";
		$sql = "SELECT `rsp_vacant_positions`.`rspvac_id`, `positiontitle`, `itemNo`, `sg`, `office`, `dateVacated`, `dateOfInterview`, `education`, `training`, `experience`, `eligibility`, `datetime_added`,`itat0` FROM `rsp_vacant_positions` LEFT JOIN `rsp_indturnarroundtime` ON `rsp_vacant_positions`.`rspvac_id` = `rsp_indturnarroundtime`.`rspvac_id` WHERE year(`dateVacated`) != ? ORDER BY `rsp_indturnarroundtime`.`itat0` DESC";
	} else {
		// $sql = "SELECT * FROM `rsp_vacant_positions` WHERE year(`dateVacated`) = ? ORDER BY `itemNo` ASC";
		$sql = "SELECT `rsp_vacant_positions`.`rspvac_id`, `positiontitle`, `itemNo`, `sg`, `office`, `dateVacated`, `dateOfInterview`, `education`, `training`, `experience`, `eligibility`, `datetime_added`,`itat0` FROM `rsp_vacant_positions` LEFT JOIN `rsp_indturnarroundtime` ON `rsp_vacant_positions`.`rspvac_id` = `rsp_indturnarroundtime`.`rspvac_id` WHERE year(`dateVacated`) = ? ORDER BY `rsp_indturnarroundtime`.`itat0` DESC";
	}

	
	$deparment = new Department();
	$dateTime = new FormatDateTime();
	$dateCompactor = new DateCompactor;

	$stmt = $this->mysqli->prepare($sql);
	$stmt->bind_param("i", $year);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($rspvac_id,$position,$itemNo,$sg,$office,$dateVacated,$dateOfInterview,$education,$training,$experience,$eligibility,$datetime_added,$itat0);
	$counter = 1;
	if ($stmt->num_rows === 0) {

		$view = '
		<tr>
			<td colspan="11" style="color: grey; text-align: center; padding: 50px;"><i>No Vacant Positions Available</i> </td>
		</tr>
		';
	} else {

	}

	while ($stmt->fetch()) {
		$view .= '
			<tr>
		<td class="center aligned">'.$counter++.'</td>
		<td class="center aligned">
			<a class="ui mini icon basic button" title="Go to" href="'.$file.'?rspvac_id='.$rspvac_id.'"><i class="open folder'.($itat0?' green':' blue').' icon"></i></a>
		</td>
		<td>'.$position.'</td>
		<td class="center aligned" style="white-space: nowrap;">';

				if (!$itemNo) {
					$view .= "---";
				} else {
					$view .= $itemNo;
				}

		$view .= '</td>
		<td>'.$sg.'</td>
		<td>'.$deparment->getDepartment($office).'</td>
		<td>'.$this->viewList($education).'</td>
		<td>'.$this->viewList($training).'</td>
		<td>'.$this->viewList($experience).'</td>
		<td>'.$this->viewList($eligibility).'</td>
		<td class="center aligned">';


			if ($dateVacated !== "0000-00-00") {
				$view .= $dateTime->formatDate($dateVacated);
			} else {
				$view .= "---";
			}
		
		$view .= '</td>
		<td class="center aligned">';

			if ($dateOfInterview !== "0000-00-00") {
				$view .= $dateTime->formatDate($dateOfInterview);
			} else {
				$view .= "---";
			}
	
		$view .= '</td>
		<td>'.(unserialize($itat0)?$dateCompactor->compactDates(unserialize($itat0)):'---').'</td>
		<td class="center aligned" style="width: 50px;">

		<div class="ui mini basic icon buttons" >
		  <button class="ui positive button" title="Edit" onclick="editFunc(\''.$rspvac_id.'\')"><i class="icon edit"></i></button>
		  <div class="or"></div>
		  <button class="ui negative button" title="Delete" onclick="deleteFunc(\''.$rspvac_id.'\')"><i class="icon trash"></i></button>
		</div>

		</td>
			</tr>';
	}
	
		$stmt->close();
		return $view;
	}


// END LOAD



	public function addNew($data0,$data1){
		$data0 = $data0;
		$data1 = $data1;
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

		$stmt = $this->mysqli->prepare($sql);
		$stmt->bind_param("ssisssssss",$position,$itemNo,$sg,$office,$dateVacated,$dateOfInterview,$education,$training,$experience,$eligibility);
		$stmt->execute();
		$stmt->close();
	}

	public function getValues($rspvac_id){
		$rspvac_id = $rspvac_id;
		$sql = "SELECT * FROM `rsp_vacant_positions` WHERE `rspvac_id` = ?";
		$stmt = $this->mysqli->prepare($sql);
		$stmt->bind_param("i",$rspvac_id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($rspvac_id,$position,$itemNo,$sg,$office,$dateVacated,$dateOfInterview,$education,$training,$experience,$eligibility,$datetime_added);

		while ($stmt->fetch()) {
			$data = array($position,$itemNo,$sg,$office,$dateVacated,$dateOfInterview,unserialize($education),unserialize($training),unserialize($experience),unserialize($eligibility));	
		}
		$stmt->close();
		return json_encode($data);
	}

	public function editEntry($rspvac_id,$data0,$data1){
		$rspvac_id = $rspvac_id;
		$data0 = $data0;
		$data1 = $data1;

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

		$stmt = $this->mysqli->prepare($sql);
		$stmt->bind_param("ssisssssssi",$position, $itemNo, $sg,$office,$dateVacated,$dateOfInterview,$education,$training,$experience,$eligibility,$rspvac_id);
		$stmt->execute();
		$stmt->close();
	}

	public function deleteFunc($rspvac_id){
		$rspvac_id = $rspvac_id;
		$sql = "DELETE FROM `rsp_vacant_positions` WHERE `rsp_vacant_positions`.`rspvac_id` = ?";
		$stmt = $this->mysqli->prepare($sql);
		$stmt->bind_param("i",$rspvac_id);
		$stmt->execute();
		$stmt->close();
	}

	 private function viewList($arr){
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

}

?>
