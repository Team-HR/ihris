<?php
require_once "_connect.db.php";
?>

<?php
if(isset($_POST["load"])){
$sql = "SELECT *,`plantillas`.`position_id` AS `post_id` ,`plantillas`.`department_id` AS `dept_id` ,`plantillas`.`office_id` AS `of_id` ,`plantillas`.`schedule` AS `sched` 

										 FROM `plantillas` LEFT JOIN `department` ON `plantillas`.`department_id` = `department`.`department_id`  
										LEFT JOIN `positiontitles` ON `plantillas`.`position_id` = `positiontitles`.`position_id` 
										LEFT JOIN `employees` ON `plantillas`.`incumbent`= `employees`.`employees_id` 
			ORDER BY incumbent ASC";	

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
	

$sql4 = "SELECT * FROM  `plantillas` LEFT JOIN `employees` ON `plantillas`.`vacated_by`= `employees`.`employees_id` WHERE `vacated_by` ='$row[vacated_by]' ";
	$sql4 = $mysqli->query($sql4);
	$sql4 = $sql4 ->fetch_assoc();

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
			$middleName = $middleName[0]." ";
		}

		$extName	=	strtoupper($row["extName"]);
		$exts = array('JR','SR');

		if (in_array(substr($extName,0,2), $exts)) {
			$extName = " ";

		} else {
			$extName = " ".$extName;
		}
		
		if (!$lastName) {
			$lastName = "<i style='color:grey'>N/A</i>";
		}
		
		$fullname = (" $firstName $middleName $lastName ").$extName;

	
					

	$functional_title = addslashes($row["functional"]);
		if (!$functional_title) {
			$functional_title = "<i style='color:grey'>N/A</i>";
		}

		$incumbent =($row["incumbent"]);
		if ($incumbent ==  '' || $incumbent == 0) {
			$incumbent = "<a href='appointments.php?id=$id' class='ui mini positive button' title='Appoint Employee'>Appoint</a>";
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
		<td><a href="plantilla_detail.php?id=<?php echo $id;?>" title="View Plantilla Details"><i class=" open folder book icon"></td>
		<td><?=$item_no;?></td>
		<td><?=$page_no;?></td>
		<td><?=$position;?></td>
		<td><?=$functional_title;?></td>
		<td><?=$category?></td>
		<td><?=$level;?></td>
		<td><?=$sg;?></td>
		<td>P<?=$sql3['monthly_salary'];?>.00</td>
		<td><?=$department?></td>
		<td><?=$incumbent?></td>
		<td><?=$reason_of_vacancy?><?=$other?></td>
		<td><?=$sql4['firstName']?> <?=$sql4['middleName']?> <?=$sql4['lastName']?> <?=$sql4['extName']?></td>
		<td class=" align">

		<button class="ui mini positive button" title="Vacate" onclick="vacateRow(<?php echo $id;?>)" >Vacate</button>

		<!-- <div class="ui mini basic icon buttons" >
			  <button class="ui positive button" title="Edit"><i class="edit outline icon" title="Edit" style="cursor: pointer;" onclick="editRow('<?=$id?>',
																							'<?=$row["post_id"]?>',
																							'<?=$row["incumbent"]?>',
																							'<?=$row["dept_id"]?>',
																							'<?=$row["of_id"]?>',
																							'<?=$row["step"]?>',
																							'<?=$row["sched"]?>',
																							'<?=$row["item_no"]?>',
																							'<?=$row["page_no"]?>',
																							'<?=$row["original_appointment"]?>',
																							'<?=$row["last_promotion"]?>',
																							'<?=$row["casual_promotion"]?>',
																							'<?=$row["vacated_by"]?>',
																							'<?=$row["reason_of_vacancy"]?>',
																							'<?=$row["other"]?>',
																							'<?=$row["supervisor"]?>',
																							'<?=$row["abolish"]?>') "></i>
			</button>
			  <div class="or"></div>
			  <button class="ui negative button" title="Delete"><i class="trash alternate outline icon" style="cursor: pointer;"  onclick="deleteRow('<?php echo $id; ?>')" style="margin-right: 5px;" title="Delete"></i></button>
			</div>
		
		 -->

			
		</td>
	</tr>
<?php
	}
}
// load ends here
elseif (isset($_POST["addPlantilla"])) {
	$position = $_POST["position"];
	$incumbent = $_POST["incumbent"];
	$department = $_POST["department"];
	$office = $_POST["office"];
	$step = $_POST["step"];
	$schedule = $_POST["schedule"];
	$item_no = $_POST["item_no"];
	$page_no = $_POST["page_no"];
	$original_appointment = $_POST["original_appointment"];
	$casual_promotion = $_POST["casual_promotion"];
	$last_promotion = $_POST["last_promotion"];
	$vacated_by = $_POST["vacated_by"];
	$reason_of_vacancy = $_POST["reason_of_vacancy"];
	$other = $_POST["other"];
	$supervisor = $_POST["supervisor"];
	$abolish = $_POST["abolish"];


		$sql = "INSERT INTO `plantillas` (`id`, `item_no`, `page_no`, `department_id`, `office_id`, `position_id`, `step`, `schedule`, `incumbent`, `reason_of_vacancy`, `other`, `vacated_by`, `original_appointment`, `last_promotion`, `casual_promotion`, `supervisor`, `abolish`, `timestamp_created`, `timestamp_updated`)

				VALUES (NULL, '$item_no',  '$page_no', '$department', '$office', '$position', '$step', '$schedule', '$incumbent', '$reason_of_vacancy', '$other', '$vacated_by', '$original_appointment', '$last_promotion', '$casual_promotion','$supervisor','$abolish', NULL, NULL)";
		$mysqli->query($sql);
		echo $mysqli->error;
}


// deleteRow Start
elseif (isset($_POST["deleteData"])) {
	$id = $_POST["id"];
	$sql = "DELETE FROM `plantillas` WHERE `plantillas`.`id` = '$id'";
	$mysqli->query($sql);
}


elseif (isset($_POST["editPlantilla"])) {
	$id = $_POST["id"];
	$position = $_POST["position"];
	$incumbent = $_POST["incumbent"];
	$department = $_POST["department"];
	$office = $_POST["office"];
	$step = $_POST["step"];
	$schedule = $_POST["schedule"];
	$item_no = $_POST["item_no"];
	$page_no = $_POST["page_no"];
	$original_appointment = $_POST["original_appointment"];
	$casual_promotion = $_POST["casual_promotion"];
	$last_promotion = $_POST["last_promotion"];
	$vacated_by = $_POST["vacated_by"];
	$reason_of_vacancy = $_POST["reason_of_vacancy"];
	$other = $_POST["other"];
	$supervisor = $_POST["supervisor"];
	$abolish = $_POST["abolish"];

	$sql = "UPDATE `plantillas` SET `position_id` = '$position', 
										 `incumbent` = '$incumbent',
										 `department_id` = '$department', 
										 `office_id` = '$office' ,
										 `step` = '$step',
										 `schedule` = '$schedule', 
										 `item_no` = '$item_no',
										 `page_no` = '$page_no',
										 `original_appointment` = '$original_appointment', 
										 `casual_promotion` = '$casual_promotion',
										 `last_promotion` = '$last_promotion' ,
										 `vacated_by` = '$vacated_by',
										 `reason_of_vacancy` = '$reason_of_vacancy', 
										 `other` = '$other',
										 `supervisor` = '$supervisor',
										 `abolish` = '$abolish'
										
										 WHERE `id` = '$id' ";
	$mysqli->query($sql);
	echo $mysqli->error;
}



elseif (isset($_POST["vacatePos"])) {
	$id = $_POST["id"];
	$incumbent = $_POST["incumbent"];
	$vacated_by = $_POST["incumbent"];
	$reason_of_vacancy = $_POST["reason_of_vacancy"];
	$other = $_POST["other"];
	$sql = "UPDATE `plantillas` SET `vacated_by` = '$incumbent', 
										 `incumbent` = '',
										 `reason_of_vacancy` = '$reason_of_vacancy', 
										 `other` = '$other'


										 WHERE `id` = '$id'";
	$mysqli->query($sql);
	echo $mysqli->error;
}
?>
