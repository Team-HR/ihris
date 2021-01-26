<?php
require '_connect.db.php';
require 'libs/NameFormatter.php';
// $nameFormatter = new NameFormatter;

if (isset($_POST['loadlist'])){
	$sql = "SELECT `employees`.`employees_id` AS `emp_id`,`firstName`,`lastName`,`middleName`,`extName`,`department`,`position`,`recognition` FROM `employees` LEFT JOIN `department` ON `employees`.`department_id` = `department`.`department_id` LEFT JOIN `positiontitles` ON `employees`.`position_id` = `positiontitles`.`position_id` LEFT JOIN `rnr_recognitions` ON `employees`.`employees_id` = `rnr_recognitions`.`employees_id` ORDER BY `lastName` ASC";
	$result = $mysqli->query($sql);
	while ($row = $result->fetch_assoc()) {	
		$employees_id = $row["emp_id"];
		$nameFormatter = new NameFormatter($row["firstName"],$row["lastName"],$row["middleName"],$row["extName"]);
		$fullName = $nameFormatter->getFullname();
		// // sql insertion starts here
		// 	$sql1 = "INSERT INTO `rnr_recognitions` (`recognition_id`, `employees_id`, `recognition`, `timestamp`) VALUES (NULL, '$employees_id', NULL, CURRENT_TIMESTAMP)";
		// 	$mysqli->query($sql1);
		// // sql insertion ends here
		
?>
<tr style="">
	<!-- <td><?=var_dump($row)?></td> -->
	<td class=" center aligned"><?=str_pad($employees_id,5,0,STR_PAD_LEFT);?></td>
	<td style="width: 85px;">	
		
				<div class="ui icon green mini buttons">
					<!-- <button onclick="viewFunc('<?php echo $controlNumber;?>')" title="Open" class="ui button"><i class="folder open outline icon"></i></button> -->
					<button onclick="updateFunc('<?=$employees_id?>','<?=$fullName?>')" title="Quick Edit" class="ui button"><i class="edit outline icon"></i> Update</button>
					<!-- <button onclick="deleteFunc('<?php echo $controlNumber;?>')" title="Delete" class="ui button"><i class="trash alternate outline icon"></i></button> -->
				</div>

	</td>
	<td><?=$fullName?></td>

	<td style="min-width: 500px;">
		<!-- Recognitions here -->
		<?php
		$recognition = $row["recognition"];	
		// $recognition = "<span style='white-space: pre;'>".$row["recognition"]."</span>";	
		if (!$recognition) {
			// $recognition = "<span style='color:grey'>N/A</span>";
			$recognition = "<i style='color:grey'>N/A</i>";
		} else {
			// $recognition = "<span style='white-space: pre;'>".$recognition."<span>";
			$recogs_arr = unserialize($recognition);
			$recognition="";
			foreach ($recogs_arr as $key => $value) {
				$recognition .= ($key+1).". ".$value."<br>";
			}
		}
		echo $recognition;
		?>
	</td>

	<td><?php
	$position = $row["position"];
		if (!$position) {
			$position = "<i style='color:grey'>N/A</i>";
		}
		echo $position;
	?></td>

	<td><?php
	$department = $row["department"];
		if (!$department) {
			$department = "<i style='color:grey'>N/A</i>";
		}
		echo $department;
	?></td>




</tr>

<?php
	}
}

elseif (isset($_POST["loadEntry"])) {
	$employees_id = $_POST["employees_id"];
	$sql = "SELECT * FROM `rnr_recognitions` WHERE `employees_id` = '$employees_id'";
	$result = $mysqli->query($sql);
	$num_rows = $result->num_rows;
	$data = array();
	if ($num_rows > 0) {
		$row = $result->fetch_assoc();
		$data = unserialize($row["recognition"]);
	} else {
		$recognition = serialize($data);
		if ($stmt = $mysqli->prepare("INSERT INTO `rnr_recognitions` (`recognition_id`, `employees_id`, `recognition`, `timestamp`) VALUES (NULL, ?, ?, CURRENT_TIMESTAMP)")) {
			$stmt->bind_param("is",$employees_id,$recognition);
			$stmt->execute();
			$stmt->close();
		}
	}
	echo json_encode($data);
}

elseif (isset($_POST["updateEntry"])) {
	$employees_id = $_POST["employees_id"];
	$recognition =  serialize($_POST["recognition"]);
	if ($stmt = $mysqli->prepare("UPDATE `rnr_recognitions` SET `recognition`=? WHERE `employees_id`=?")) {
		$stmt->bind_param("si",$recognition,$employees_id);
		$stmt->execute();
		$stmt->close();
	}

}

?>