<?php
require_once "_connect.db.php";
?>

<?php
if(isset($_POST["load"])){
$sql = "SELECT * FROM `plantillas_test` LEFT JOIN `department` ON `plantillas_test`.`department_id` = `department`.`department_id`  
									LEFT JOIN `positiontitles` ON `plantillas_test`.`position_title` = `positiontitles`.`position_id` 
									LEFT JOIN `employees` ON `plantillas_test`.`incumbent` = `employees`.`employees_id` 
															
			ORDER BY `id` DESC";	
$result = $mysqli->query($sql);
echo $mysqli->error;
$counter = 0;
while ($row = $result->fetch_assoc()) {
	
		
	$sql2 = "SELECT * FROM  `setup_salary_adjustments` WHERE `schedule` = '$row[schedule]' and active = '1'";
			$sql2 = $mysqli->query($sql2);
			$sql2 = $sql2 ->fetch_assoc();


	$sql3 = "SELECT * FROM  `setup_salary_adjustments_setup` WHERE `parent_id` = '$sql2[id]' AND `salary_grade`='$row[salaryGrade]' AND `step_no`='$row[level]' ";
	$sql3 = $mysqli->query($sql3);
	$sql3 = $sql3 ->fetch_assoc();
	echo $mysqli->error;

	$counter++;
	$id = $row["id"];
	$schedule = $row["schedule"];
	$item_no = $row["item_no"];
	$page_no = $row["page_no"];
	$position= addslashes($row["position"]);

	$firstName	=	$row["firstName"];
		$lastName	=	$row["lastName"];
		
		if ($row["middleName"] == "") {
			$middleName = "";
		} else {
			$middleName	= $row["middleName"];
			$middleName = $middleName[0].".";
		}

		$extName	=	strtoupper($row["extName"]);
		$exts = array('JR','SR');

		if (in_array(substr($extName,0,2), $exts)) {
			$extName = " ";

		} else {
			$extName = " ".$extName;
		}

		if (!$lastName) {
				$lastName = "<i style='color:grey'>Vacant</i>";
		}	

		$fullname = (" $firstName $middleName $lastName ").$extName;//$lastName.", ".$firstName." ".$middleName." ".$extName;
		


	$functional_title = addslashes($row["functional"]);
		if (!$functional_title) {
			$functional_title = "<i style='color:grey'>N/A</i>";
		}

	$level = $row["level"];
	$category = $row["category"];
	$sg = $row["salaryGrade"];
	$department = $row["department"];

	$reason_of_vacancy = $row["reason_of_vacancy"];
	$other = $row["other"];
	if (!$reason_of_vacancy || $other ) {
			$reason_of_vacancy || $other = "<i style='color:grey'>N/A</i>";
		}


	$vacated_by = addslashes($row["vacated_by"]);
		if (!$vacated_by) {
			$vacated_by = "<i style='color:grey'>N/A</i>";
		}
?>
	<tr id="<?php echo $id."row";?>" style="text-align:center">
		<td><a href="plantilla_detail.php?id=<?php echo $id;?>" title="View Plantilla Details"><i class="green book icon"></td>
		<td><?php echo $item_no;?></td>
		<td><?php  echo $page_no;?></td>
		<td><?php echo $position;?></td>
		<td><?php echo $functional_title;?></td>
		<td><?php echo $category[0];?></td>
		<td><?php echo $level;?></td>
		<td><?php echo $sg;?></td>
		<td>P<?php echo $sql3['monthly_salary'];?>.00</td>
		<td><?php  echo $department?></td>
		<td><?php  echo $fullname?></td>
		<td><?php  echo $reason_of_vacancy?><?php  echo $other?></td>
		<td><?php  echo $vacated_by?></td>
		<td class=" align">
			<!---- <i class="icon edit" onclick="editModalFunc()" style="margin-right: 5px;" title="Edit Detail"></i>---->
			<i class="icon trash" onclick="deleteRow('<?php echo $id; ?>')" style="margin-right: 5px;" title="Delete"></i>
			
		</td>
	</tr>
<?php
	}
}
// load ends here
elseif (isset($_POST["addPlantilla"])) {
	$item_no = $_POST["item_no"];
	$page_no = $_POST["page_no"];
	$department = addslashes($_POST["department"]);
	$office = $_POST["office"];
	$position = addslashes($_POST["position"]);
	$step = $_POST["step"];
	$incumbent = $_POST["incumbent"];
	$reason_of_vacancy = $_POST["reason_of_vacancy"];
	$other = $_POST["other"];
	$vacated_by = $_POST["vacated_by"];
	$original_appointment = $_POST["original_appointment"];
	$last_promotion = $_POST["last_promotion"];
	$casual_promotion = $_POST["casual_promotion"];
	$supervisor = $_POST["supervisor"];	
	$schedule = $_POST["schedule"];	
	$abolish = $_POST["abolish"];

		$sql = "INSERT INTO `plantillas_test` (`id`, 
												`item_no`, 
												`page_no`, 
												`department_id`,
												`office_id`,
												`position_id`,
												`position_title`,
												`step`,
												`schedule`,
												`incumbent`, 
												 `reason_of_vacancy`, 
												 `other`,
												 `vacated_by`, 
												 `original_appointment`, 
												 `last_promotion`,
												 `casual_promotion`,
												 `supervisor`, 
												 `abolish`, 
												 `timestamp_created`, 
												 `timestamp_updated`) 

				VALUES (NULL, '$item_no', '$page_no', '$department', '$office',  '$position', '$step', '$incumbent', '$reason_of_vacancy', '$other', '$vacated_by', '$original_appointment', '$last_promotion', '$casual_promotion', '$supervisor', '$schedule', '$abolish',NULL, NULL)";
					$mysqli->query($sql);



}



// deleteRow Start
elseif (isset($_POST["deleteData"])) {
	$id = $_POST["id"];
	$sql = "DELETE FROM `plantillas_test` WHERE `plantillas_test`.`id` = '$id'";
	$mysqli->query($sql);
}


elseif (isset($_POST["editModalFunc"])) {
	$id = $_POST["id"];
	$position = addslashes($_POST["position"]);
	$incumbent = addslashes($_POST["incumbent"]);
	$item_no = $_POST["item_no"];
	$department = $_POST["department"];
	$step = $_POST["step"];
	$sql = "UPDATE `plantillas_test` SET `position` = '$position_id',`incumbent` = '$incumbent', `item_no` = '$item_no', `department` = '$department_id', `step` = '$step' WHERE `id` = '$id'";
	$mysqli->query($sql);
	echo "#".$id."row";
}
// deleteRow End
?>