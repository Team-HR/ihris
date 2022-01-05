<?php
require "_connect.db.php";
if (isset($_POST["load"])) {
	$sql = "SELECT * FROM `prr` ORDER BY `prr_id` DESC";
	$result = $mysqli->query($sql);
	while ($row = $result->fetch_assoc()) {
		$prr_id = $row["prr_id"];
		$period = $row["period"];
		$year = $row["year"];
		$type = $row["type"];
		$agency = $row["agency"];
		$address = $row["address"];
		?>
		<tr>
		  <td>
		  	<div class="ui basic mini icon buttons">
				  <a href="performanceratingreportinfo.php?prr_id=<?php echo $prr_id;?>&type=<?=$type?>" title="Open" class="ui button"><i class="folder open outline icon"></i></a>
			</div>
		  </td>
			<td><?php echo $period;?></td>
			<td><?php echo $year;?></td>
			<td><?php echo $type;?></td>
			<td>
				<i class="bordered red trash icon" data-id='<?=$row["prr_id"]?>' onclick="deleteBtn()"></i>
 			</td>
		</tr>
<?php
	}
}
elseif (isset($_POST["addNew"])) {
	$dropdown_period_add = $_POST["dropdown_period_add"];
	$input_year_add = $_POST["input_year_add"];
	$dropdown_type_add = $_POST["dropdown_type_add"];
	$input_agency_add = addslashes($_POST["input_agency_add"]);
	$input_address_add = addslashes($_POST["input_address_add"]);
	$sqlCheck = "SELECT * from prr where period='$dropdown_period_add' AND year='$input_year_add' AND type = '$dropdown_type_add'";
	$check = $mysqli->query($sqlCheck);
	 if($check->num_rows>0){
	 	echo "Folder Already Exist";
	 }else{
			$sql1 = "INSERT INTO `prr`(`period`, `year`, `type`, `agency`, `address`) VALUES ('$dropdown_period_add','$input_year_add','$dropdown_type_add','$input_agency_add','$input_address_add')";
			$mysqli->query($sql1);
			$i = $mysqli->insert_id;
			if($sql1){
				if(strtoupper($dropdown_type_add)=="PERMANENT"){
					$empStatus = "AND `employmentStatus`='PERMANENT' or `employmentStatus`='COTERMINUS'";
				}else{	
					$empStatus = "AND `employmentStatus`='$dropdown_type_add'";
				}
				// $getEmp = "SELECT * FROM `employees` where $empStatus AND status='ACTIVE' ORDER BY gender ASC , lastName ASC ";
				$getEmp = "SELECT * FROM `employees` WHERE `status`='ACTIVE' $empStatus ORDER BY `employees`.`lastName` ASC;";
				// $getEmp = "SELECT * FROM `employees` where employmentStatus='$dropdown_type_add' AND status='ACTIVE' ORDER BY gender ASC , lastName ASC ";
				$getEmp = $mysqli->query($getEmp);
				while ($addEmp = $getEmp->fetch_assoc()) {
					$insertEmp = "INSERT INTO `prrlist` (`prrlist_id`, `prr_id`, `employees_id`, `date_submitted`, `appraisal_type`, `date_appraised`, `numerical`, `adjectival`, `remarks`, `comments`,`stages`) VALUES (NULL, '$i', '$addEmp[employees_id]', '', '', '', '', '', '', '','C')";
					$insertEmp = $mysqli->query($insertEmp);
					if(!$insertEmp){
						echo $mysqli->error;
						die();
					}
				}
				echo '1';
			}else{
				echo $mysqli->error;
			}
	  }
}else if(isset($_POST['removePrrData'])){
	$dataId = $_POST['removePrrData'];
	$sql = "SELECT * FROM `prrlist` where `prr_id`='$dataId'";
	$sql = $mysqli->query($sql);
	if(!$sql){
		echo $mysqli->error;
	}else{
		while ($dataRet = $sql->fetch_assoc()) {
			$d = "DELETE FROM `prrlist` WHERE `prrlist`.`prrlist_id` ='$dataRet[prrlist_id]'";
			$mysqli->query($d);
		}
		$sql = "DELETE FROM `prr` WHERE `prr`.`prr_id` = $dataId";
		$sql = $mysqli->query($sql);
		if(!$sql){
			echo $mysqli->error;
		}else{
			echo 1;
		}
	}
}else if(isset($_POST['countPrrData'])){
	$dataId = $_POST['countPrrData'];
	$sql = "SELECT * FROM `prrlist` where `prr_id`='$dataId'";
	$sql = $mysqli->query($sql);
	echo $sql->num_rows;
}else if(isset($_POST['savingCount'])){
	$sql0 = "SELECT * from `prr`";
	$sql0 =	$mysqli->query($sql0);
		while($row = $sql0->fetch_assoc()){
			$dataId = $row['prr_id'];
			$sql = "SELECT * from prrlist where prr_id='$dataId'";
			$sql = $mysqli->query($sql);
	}
	echo $sql->num_rows;
}
?>
