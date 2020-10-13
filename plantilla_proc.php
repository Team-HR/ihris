<?php
require_once "_connect.db.php";
?>

<?php
if (isset($_POST["load"])) {
	/*$sql = "SELECT *,`plantillas`.`position_id` AS `post_id` ,`plantillas`.`department_id` AS `dept_id` ,`plantillas`.`schedule` AS `sched`

										 FROM `plantillas` LEFT JOIN `department` ON `plantillas`.`department_id` = `department`.`department_id`  
										 LEFT JOIN `positiontitles` ON `plantillas`.`position_id` = `positiontitles`.`position_id` 
										 LEFT JOIN `employees` ON `plantillas`.`incumbent`= `employees`.`employees_id`
										 LEFT JOIN appointments ON `plantillas`.`id` = `appointments`.`plantilla_id`
			ORDER BY incumbent ASC ";	*/


	$sql = "SELECT *,`plantillas`.`position_id` AS `post_id` ,`plantillas`.`department_id` AS `dept_id` ,`plantillas`.`schedule` AS `sched`,
		
		department.department, 
		appointments.appointment_id, 
		positiontitles.position, 
		positiontitles.functional, 
		positiontitles.`level`, 
		positiontitles.category, 
		positiontitles.salaryGrade, 
		appointments.employee_id, 
		plantillas.step, 
		plantillas.`schedule`, 
		employees.employees_id, 
		employees.lastName, 
		employees.firstName, 
		employees.middleName, 
		employees.extName, 
		plantillas.incumbent
	FROM
		plantillas
		LEFT JOIN
		appointments
		ON 
			plantillas.incumbent = appointments.appointment_id
		LEFT JOIN
		department
		ON 
			plantillas.department_id = department.department_id
		LEFT JOIN
		positiontitles
		ON 
			plantillas.position_id = positiontitles.position_id
		LEFT JOIN
		employees
		ON 
			appointments.employee_id = employees.employees_id
	";

	$result = $mysqli->query($sql);
	echo $mysqli->error;
	$counter = 0;
	while ($row = $result->fetch_assoc()) {

		$sql2 = "SELECT * FROM  `setup_salary_adjustments` WHERE `schedule` = '$row[schedule]' and active = '1'";
		$sql2 = $mysqli->query($sql2);
		$sql2 = $sql2->fetch_assoc();

		$sql3 = "SELECT * FROM  `setup_salary_adjustments_setup` WHERE `parent_id` = '$sql2[id]' AND `salary_grade`='$row[salaryGrade]' AND `step_no`='$row[step]' ";
		$sql3 = $mysqli->query($sql3);
		$sql3 = $sql3->fetch_assoc();


		$sql4 = "SELECT appointments.appointment_id, 
		employees.employees_id, 
		employees.firstName, 
		employees.lastName, 
		employees.middleName, 
		employees.extName, 
		appointments.reason_of_vacancy,
		appointments.employee_id
	FROM plantillas LEFT JOIN appointments ON plantillas.vacated_by = appointments.appointment_id LEFT JOIN employees ON appointments.employee_id = employees.employees_id
	WHERE
		plantillas.id = '$row[id]'";
		$sql4 = $mysqli->query($sql4);
		$sql4 = $sql4->fetch_assoc();

		$sql5 = "SELECT
		appointments.appointment_id, 
		employees.employees_id, 
		employees.firstName, 
		employees.lastName, 
		employees.middleName, 
		employees.extName, 
		appointments.employee_id
	FROM
		plantillas LEFT JOIN appointments ON plantillas.incumbent = appointments.appointment_id	LEFT JOIN employees ON appointments.employee_id = employees.employees_id
	WHERE
		plantillas.id = '$row[id]'";
		$sql5 = $mysqli->query($sql5);
		$sql5 = $sql5->fetch_assoc();

		$counter++;
		$id = $row["id"];
		$employee_id = $sql5['employee_id'];
		$plantilla_id = $row["id"];
		$schedule = $row["schedule"];
		$item_no = $row["item_no"];
		$position = addslashes($row["position"]);

		$reason_of_vacancy = addslashes($sql4["reason_of_vacancy"]);
		if ($reason_of_vacancy == '') {
			$reason_of_vacancy = "<i style='color:grey'>N/A</i>";
		}
		$functional_title = addslashes($row["functional"]);
		if (!$functional_title) {
			$functional_title = "<i style='color:grey'>N/A</i>";
		}

		$incumbent = $sql5['firstName'] . " " . $sql5['middleName'] . " " . $sql5['lastName'] . " " . $sql5['extName'];
		if (!$row['incumbent']) {
			$incumbent = "
						<div class='ui buttons'>
							<a onclick='oldIncumbent.showModalOldIncumbent(\"$id\")' class='ui mini primary button' title='Appoint Employee'>Old</a>
							<a href='appointments.php?id=$id' class='ui mini positive button' title='Appoint Employee'>New</a>
						</div>
						";
		}
		$level = $row["level"];
		$category = $row["category"];
		$sg = $row["salaryGrade"];
		$department = $row["department"];

		$vacated_by = $sql4['firstName'] . " " . $sql4['middleName'] . " " . $sql4['lastName'] . " " . $sql4['extName'];
		if (!$row['vacated_by']) {
			$vacated_by = "<i style='color:grey'>N/A</i>";
		}


?>
		<tr id="<?php echo $id . "row"; ?>" style="text-align:center">
			<td><a href="plantilla_detail.php?id=<?php echo $id; ?>" title="View Plantilla Details"><i class=" open folder book icon"></a></i>
				<!-- <i class="blue edit outline icon" title="Edit" style="cursor: pointer;" onclick="editRow('<?= $id ?>',
																							'<?= $row["post_id"] ?>',
																							'<?= $row["incumbent"] ?>',
																							'<?= $row["dept_id"] ?>',
																							'<?= $row["step"] ?>',
																							'<?= $row["sched"] ?>',
																							'<?= $row["item_no"] ?>',
																							'<?= $row["abolish"] ?>') "></i> -->
				<i class="blue trash alternate outline icon" style="cursor: pointer;" onclick="deleteRow('<?php echo $id; ?>')" style="margin-right: 5px;" title="Delete"></i>

			</td>
			<td><?= $item_no; ?></td>
			<td><?= $counter; ?></td>
			<td><?= $position; ?></td>
			<td><?= $functional_title; ?></td>
			<td><?= $category ?></td>
			<td><?= $level; ?></td>
			<td><?= $sg; ?></td>
			<td>P<?= $sql3['monthly_salary']; ?>.00</td>
			<td><?= $department ?></td>
			<td><?= $incumbent ?></td>
			<td><?= $reason_of_vacancy ?></td>
			<td><?= $vacated_by ?></td>
			<td class=" align">

				<button class="ui mini negative button" id="bt_vacate" title="Vacate Position" onclick="vacateRow('<?= $plantilla_id ?>','<?= $row["incumbent"] ?>','<?= $row["position"] ?>')"></i>Vacate</button>
			</td>
		</tr><?php
			}
		} elseif (isset($_POST["addPlantilla"])) {
			$position = $_POST["position"];
			$department = $_POST["department"];
			$step = $_POST["step"];
			$schedule = $_POST["schedule"];
			$item_no = $_POST["item_no"];
			$abolish = $_POST["abolish"];
			$sql = "INSERT INTO `plantillas` (`id`, `item_no`,  `department_id`,  `position_id`, `step`, `schedule`, `incumbent`,  `vacated_by`,  `abolish`)

					VALUES (NULL, '$item_no', '$department', '$position', '$step', '$schedule', 0,NULL, '$abolish')";
			$mysqli->query($sql);
		}


		// deleteRow Start
		elseif (isset($_POST["deleteData"])) {
			$id = $_POST["id"];
			$sql = "DELETE FROM `plantillas` WHERE `plantillas`.`id` = '$id'";
			$sql2 = "DELETE `reason_of_vacancy` FROM `appointments` WHERE `appointments`.`plantilla_id` = '$id'";
			$mysqli->query($sql);
			$mysqli->query($sql2);
		} elseif (isset($_POST["editPlantilla"])) {
			$id = $_POST["id"];
			$position = $_POST["position"];
			$incumbent = $_POST["incumbent"];
			$department = $_POST["department"];
			$step = $_POST["step"];
			$schedule = $_POST["schedule"];
			$item_no = $_POST["item_no"];
			$abolish = $_POST["abolish"];
			$incumbent = $_POST['incumbent'];
			$last_day_of_service = $_POST['last_day_of_service'];
			$originalAppointmentDate = $_POST['originalAppointmentDate'];
			$casualPromotion = $_POST['casualPromotion'];
			$sql = "UPDATE `plantillas` SET `position_id` = '$position', 
											 `department_id` = '$department', 		
											 `step` = '$step',
											 `schedule` = '$schedule', 
											 `item_no` = '$item_no',	
											 `abolish` = '$abolish'
											 WHERE `id` = '$id' ";
			$mysqli->query($sql);
			if($mysqli->error){
				die($mysqli->error);
			}

			$sql2 = "UPDATE `appointments` SET `date_of_appointment` = '$originalAppointmentDate',
												`casual_promotion` = '$casualPromotion',
												`date_of_last_promotion` = '$last_day_of_service'
												where `appointment_id`='$incumbent'";
			$mysqli->query($sql2);
			if($mysqli->error){
				die($mysqli->error);
			}
		} elseif (isset($_POST["vacatePos"])) {
			$plantilla_id = $_POST['plantilla_id'];
			$incumbent = $_POST["incumbent"];
			$vacated_by = $_POST["incumbent"];
			$reason_of_vacancy = $_POST["reason_of_vacancy"];
			$other = $_POST["other"];

			############## mysqli_real_escape fix start ######################
			$other = $mysqli->real_escape_string($other);
			############## mysqli_real_escape fix end ######################


			$endService = $_POST["endService"];

			$sql1 = "UPDATE `plantillas` SET `vacated_by` = '$incumbent', 
									`incumbent` = 0 
									WHERE `id` = '$plantilla_id'";



			$sql2 = "UPDATE `appointments`	SET `last_day_of_service` ='$endService',
											`reason_of_vacancy` = '$reason_of_vacancy $other',
											`predecessor` = '$incumbent'

										WHERE `appointment_id` = '$incumbent'
										";

			$mysqli->query($sql1);
			$mysqli->query($sql2);
		}
				?>