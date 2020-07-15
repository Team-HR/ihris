<?php
require_once "_connect.db.php";
?>

<?php
if(isset($_POST["load"])){
$sql = "SELECT *,`plantillas`.`position_id` AS `post_id` ,`plantillas`.`department_id` AS `dept_id` ,`plantillas`.`schedule` AS `sched` 

										 FROM `plantillas` LEFT JOIN `department` ON `plantillas`.`department_id` = `department`.`department_id`  
										 LEFT JOIN `positiontitles` ON `plantillas`.`position_id` = `positiontitles`.`position_id` 
										 LEFT JOIN `employees` ON `plantillas`.`incumbent`= `employees`.`employees_id`
										 LEFT JOIN appointments ON `plantillas`.`id` = `appointments`.`plantilla_id`
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
	$position= addslashes($row["position"]);

	$reason_of_vacancy = addslashes($row["reason_of_vacancy"]);
		if (!$reason_of_vacancy) {
			$reason_of_vacancy = "<i style='color:grey'>N/A</i>";
		}
	$functional_title = addslashes($row["functional"]);
		if (!$functional_title) {
			$functional_title = "<i style='color:grey'>N/A</i>";
		}

	$incumbent =($row["incumbent"]);
		if ($incumbent ==  '' || $incumbent == 0) {
			$incumbent = "<a href='appointments.php?id=$id' class='ui mini positive button' title='Appoint Employee'>Appoint</a>";
		}

	$firstName=$row["firstName"];
	$level = $row["level"];
	$category = $row["category"];
	$sg = $row["salaryGrade"];
	$department = $row["department"];
	
	$vacated_by = addslashes($row["vacated_by"]);
		if ($vacated_by == '' || $vacated_by == 0) {
			$vacated_by = "<i style='color:grey'>N/A</i>";
		}
?>
	<tr id="<?php echo $id."row";?>" style="text-align:center">
		<td><a href="plantilla_detail.php?id=<?php echo $id;?>" title="View Plantilla Details"><i class=" open folder book icon"></a></i>
			<i class="blue edit outline icon" title="Edit" style="cursor: pointer;" onclick="editRow('<?=$id?>',
																							'<?=$row["post_id"]?>',
																							'<?=$row["incumbent"]?>',
																							'<?=$row["dept_id"]?>',
																							'<?=$row["step"]?>',
																							'<?=$row["sched"]?>',
																							'<?=$row["item_no"]?>',
																							'<?=$row["abolish"]?>') "></i>	
			<i class="blue trash alternate outline icon" style="cursor: pointer;"  onclick="deleteRow('<?php echo $id; ?>')" style="margin-right: 5px;" title="Delete"></i>
			
		</td>
		<td><?=$item_no;?></td>
		<td><?=$counter;?></td>
		<td><?=$position;?></td>
		<td><?=$functional_title;?></td>
		<td><?=$category?></td>
		<td><?=$level;?></td>
		<td><?=$sg;?></td>
		<td>P<?=$sql3['monthly_salary'];?>.00</td>
		<td><?=$department?></td>
		<td><?=$incumbent?></td>
		<td><?=$reason_of_vacancy?></td>
		<td><?=$sql4['firstName']?> <?=$sql4['middleName']?> <?=$sql4['lastName']?> <?=$sql4['extName']?></td>
		<td class=" align">

		<button class="ui mini negative button" title="Vacate"  onclick="vacateRow('<?=$id?>','<?=$row["incumbent"]?>','<?=$row["position"]?>') "></i>Vacate</button>	
		</td>
	</tr>
<?php
	}
}
// load ends here
elseif (isset($_POST["addPlantilla"])) {
	$position = $_POST["position"];
	$department = $_POST["department"];
	$step = $_POST["step"];
	$schedule = $_POST["schedule"];
	$item_no = $_POST["item_no"];
	$abolish = $_POST["abolish"];

		$sql = "INSERT INTO `plantillas` (`id`, `item_no`,  `department_id`,  `position_id`, `step`, `schedule`, `incumbent`,  `vacated_by`,  `abolish`, `endService`)

				VALUES (NULL, '$item_no', '$department', '$position', '$step', '$schedule', NUll,NULL, '$abolish', NULL)";
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
	$step = $_POST["step"];
	$schedule = $_POST["schedule"];
	$item_no = $_POST["item_no"];
	$abolish = $_POST["abolish"];

	$sql = "UPDATE `plantillas` SET `position_id` = '$position', 
										 `incumbent` = '$incumbent',
										 `department_id` = '$department', 		
										 `step` = '$step',
										 `schedule` = '$schedule', 
										 `item_no` = '$item_no',	
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
	$endService = $_POST["endService"];

	$sql = "UPDATE `appointments`	SET `last_day_of_service` ='$endService',
										`reason_of_vacancy` = '$reason_of_vacancy',
										`reason_of_vacancy` = '$other'
								WHERE `plantilla_id` = '$id'
				";

	$sql2 = "UPDATE `plantillas` SET   `vacated_by` = '$incumbent', 
										`incumbent` = ''									 
								WHERE `id` = '$id'
		";

	$mysqli->query($sql);
	$mysqli->query($sql2);
	echo $mysqli->error;

}
?>
