<?php
	require_once "_connect.db.php";

	if (isset($_POST["load"])) {

		$sql = "SELECT * FROM `employees` ORDER BY `lastName` ASC";
		$result = $mysqli->query($sql);
		$counter = 0;
		while ($row = $result->fetch_assoc()) {
			$counter++;

			$status = $row["status"];
			$employees_id = $row["employees_id"];
			// $s_number = str_pad( "3", 4, "0", STR_PAD_LEFT );

			$firstName	=	$row["firstName"];
			$lastName	=	$row["lastName"];
			if ($row["middleName"] = ".") {
				$middleName = "";
			} else {
				$middleName	=	$row["middleName"];
			}
			$extName	=	$row["extName"];

			$fullname = $lastName.", ".$firstName." ".$middleName." ".$extName;

			// get department name start
			$department_id	=	$row["department_id"];
			$sql2 = "SELECT * FROM `department` WHERE `department_id` = '$department_id'";
			$result2 = $mysqli->query($sql2);
			$row2 = $result2->fetch_assoc();
			$department = $row2["department"];
			// get department name end

			// get position name start
			$position_id	=	$row["position_id"];
			$sql3 = "SELECT * FROM `positiontitles` WHERE `position_id` = '$position_id'";
			$result3 = $mysqli->query($sql3);
			$row3 = $result3->fetch_assoc();
			$position = $row3["position"];
			// get position name start
?>

<tr>
<?php
	if ($status == "ACTIVE") {
?>
	<td style="color: green;"><i class="large eye icon" title="Active" style="cursor: pointer;" onclick="editStat(<?php echo $employees_id;?>)"></i></td>
<?php
	} elseif ($status == "INACTIVE") {
?>
	<td style="color: red;"><i class="large eye slash icon" title="Inactive" style="cursor: pointer;" onclick="editStat(<?php echo $employees_id;?>)"></i></td>
<?php
	}
?>
	<td><a href="employeeinfo.php?employees_id=<?php echo $employees_id;?>" title="View Profile"><i class="blue large address book icon"></i></a></td>
	<td><?php echo str_pad($employees_id,5,0,STR_PAD_LEFT);?></td>
	<td><?php echo mb_convert_case($fullname, MB_CASE_TITLE, "UTF-8");?></td>
	<td><?php echo $department;?></td>
	<td><?php echo $position;?></td>
</tr>
<?php
		}
	}

	elseif (isset($_POST["get_editStat"])) {
		$employees_id = $_POST["employees_id"];
		$sql = "SELECT `status` FROM `employees` WHERE `employees_id` = '$employees_id'";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		$status = $row["status"];
		echo json_encode($status);
	}

	elseif (isset($_POST["editStat"])) {
		$employees_id = $_POST["employees_id"];
		$status = $_POST["status"];
		$sql = "UPDATE `employees` SET `status` = '$status' WHERE `employees`.`employees_id` = '$employees_id'";
		$mysqli->query($sql);
	}

	elseif (isset($_POST["addPersonnel"])) {
		$firstName = addslashes($_POST["firstNameModal"]);
		$middleName = addslashes($_POST["middleNameModal"]);
		$lastName = addslashes($_POST["lastNameModal"]);
		$extName = addslashes($_POST["extNameModal"]);
		$gender = $_POST["genderModal"];
		$status = $_POST["statusModal"];
		$employmentStatus = $_POST["employmentStatusModal"];
		$natureOfAssignment = $_POST["natureOfAssignmentModal"];
		$department_id = $_POST["departmentModal"];
		$position_id = $_POST["positionModal"];

		$sql = "INSERT INTO `employees` (`firstName`, `lastName`, `middleName`, `extName`, `gender`, `status`, `employmentStatus`, `department_id`, `position_id`, `natureOfAssignment`) VALUES ('$firstName', '$lastName', '$middleName', '$extName', '$gender', '$status', '$employmentStatus', '$department_id', '$position_id', '$natureOfAssignment')";
		$mysqli->query($sql);
		// echo json_encode($sql);
	}
	elseif (isset($_POST["getNumOfStatus"])) {
		// get number of active/inactive start
		$sqlA = "SELECT * FROM `employees` WHERE `status` = 'ACTIVE'";
		$resultA = $mysqli->query($sqlA);
		$numOfActive = $resultA->num_rows." Active";

		$sqlI = "SELECT * FROM `employees` WHERE `status` = 'INACTIVE'";
		$resultI = $mysqli->query($sqlI);
		$numOfInactive = $resultI->num_rows." Inactive";
		// get number of active/inactive end

		$json = array('active'=>$numOfActive,'inactive'=>$numOfInactive);
		echo json_encode($json);
	}
	// var array = jQuery.parseJSON(data);
?>

