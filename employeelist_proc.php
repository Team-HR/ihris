<?php
include "_connect.db.php";


if (isset($_POST["load"])) {

	$filters = $_POST["filters"];
	$sql = construct_sql($filters);
	$result = $mysqli->query($sql);
	$counter = 0;
	$num_rows = $result->num_rows;

	while ($row = $result->fetch_assoc()) {
		$counter++;
		$status = $row["status"];
		$employees_id = $row["employees_id"];

		$firstName	=	$row["firstName"];
		$lastName	=	$row["lastName"];
		if ($row["middleName"] == ".") {
			$middleName = "";
		} else {
			$middleName	= $row["middleName"];
			$middleName = $middleName[0].".";
		}

		$extName	=	strtoupper($row["extName"]);
		$exts = array('JR','SR');

		if (in_array(substr($extName,0,2), $exts)) {
			$extName = " ".mb_convert_case($extName,MB_CASE_TITLE, "UTF-8");

		} else {
			$extName = " ".$extName;
		}

		$fullname =  mb_convert_case("$firstName $middleName $lastName",MB_CASE_TITLE, "UTF-8").$extName;//$lastName.", ".$firstName." ".$middleName." ".$extName;


		$gender = $row["gender"];
		if (!$gender) {
			$gender = "<i style='color:grey'>N/A</i>";
		} else {
			$gender = $gender[0];
		}

		$department = $row["department"];
		if (!$department) {
			$department = "<i style='color:grey'>N/A</i>";
		}

		$position = $row["position"];
		if (!$position) {
			$position = "<i style='color:grey'>N/A</i>";
		}
		$employmentStatus = mb_convert_case($row["employmentStatus"], MB_CASE_TITLE);
		if (!$employmentStatus) {
			$employmentStatus = "<i style='color:grey'>N/A</i>";
		}
		$natureOfAssignment = mb_convert_case($row["natureOfAssignment"], MB_CASE_TITLE);
		if (!$natureOfAssignment) {
			$natureOfAssignment = "<i style='color:grey'>N/A</i>";
		}
		?>

		<tr>
			<?php
			if ($status == "ACTIVE") {
				?>
				<td style="color: green;"><i class="link large eye icon" title="Active" onclick="editStat(<?php echo $employees_id;?>)"></i></td>
				<?php
			} elseif ($status == "INACTIVE") {
				?>
				<td style="color: red;"><i class="link large eye slash icon" title="Inactive" style="cursor: pointer;" onclick="editStat(<?php echo $employees_id;?>)"></i></td>
				<?php
			} else {
				?>
				<td style="color: grey;"><i class="link large eye slash icon" title="Inactive" style="cursor: pointer;" onclick="editStat(<?php echo $employees_id;?>)"></i></td>
				<?php 
			}
			?>
			<td><a href="employeeinfo.php?employees_id=<?php echo $employees_id;?>" title="View Profile"><i class="blue large address book icon"></i></a></td>
			<td id="<?=$employees_id	?>"><?php echo str_pad($employees_id,5,0,STR_PAD_LEFT);?></td>
			<td><?=$fullname;?></td>
			<td><?php echo $gender;?></td>
			<td><?php echo $department;?></td>
			<td><?php echo $position;?></td>
			<td><?php echo $employmentStatus;?></td>
			<td><?php echo $natureOfAssignment;?></td>
		</tr>
		<?php
	}
}

elseif (isset($_POST["get_editStat"])) {
	$employees_id = $_POST["employees_id"];
	$sql = "SELECT `status`,`dateActivated`,`dateInactivated`,`dateIPCR` FROM `employees` WHERE `employees_id` = '$employees_id'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	$status = $row["status"];
	$dateIPCR = $row["dateIPCR"];

	if ($status === "ACTIVE") {
		$date = $row["dateActivated"];
	} elseif ($status === "INACTIVE"){
		$date = $row["dateInactivated"];
	}
		// echo json_encode($status);
	$json = array('status' => $status, 'date' => $date, 'dateIPCR' => $dateIPCR);
	echo json_encode($json);
}













elseif (isset($_POST["editStat"])) {
	$employees_id = $_POST["employees_id"];
	$status = $_POST["status"];
	$dateStat = $_POST["dateStat"];
	$dateStartIPCR = $_POST["dateStartIPCR"];

	if ($status === "INACTIVE") {
		$activation = ", `dateInactivated` = '$dateStat'";
	} elseif ($status === "ACTIVE") {
		$activation = ", `dateActivated` = '$dateStat'";
	} else {
		$activation = "";
	}

	$sql = "UPDATE `employees` SET `status` = '$status' $activation, `dateIPCR` = '$dateStartIPCR' WHERE `employees`.`employees_id` = '$employees_id'";
	$mysqli->query($sql);
}













elseif (isset($_POST["addPersonnel"])) {
	$firstName = addslashes($_POST["firstNameModal"]);
	$middleName = addslashes($_POST["middleNameModal"]);
	$lastName = addslashes($_POST["lastNameModal"]);
	$extName = addslashes($_POST["extNameModal"]);
	$gender = $_POST["genderModal"];
	$status = $_POST["statusModal"];
	$statusDate = $_POST["statusDate"];
	$dateIPCR = $_POST["dateIPCR"];

	if ($status === 'ACTIVE') {
		$sql_statusDate0 = ", `dateActivated`";
		$sql_statusDate1 = ", '$statusDate'";
	} elseif ($status === 'INACTIVE') {
		$sql_statusDate0 = ", `dateInactivated`";
		$sql_statusDate1 = ", '$statusDate'";
	} else {
		$sql_statusDate0 = "";
		$sql_statusDate1 = "";
	}
		// $sql_statusDate

	$employmentStatus = $_POST["employmentStatusModal"];
	$natureOfAssignment = $_POST["natureOfAssignmentModal"];
	$department_id = $_POST["departmentModal"];
	$position_id = $_POST["positionModal"];

	$sql = "INSERT INTO `employees` (`firstName`, `lastName`, `middleName`, `extName`, `gender`, `status`, `employmentStatus`, `department_id`, `position_id`, `natureOfAssignment`,`dateIPCR` $sql_statusDate0) VALUES ('$firstName', '$lastName', '$middleName', '$extName', '$gender', '$status', '$employmentStatus', '$department_id', '$position_id', '$natureOfAssignment', '$dateIPCR' $sql_statusDate1)";
	$mysqli->query($sql);
		// echo json_encode($sql);
}

elseif (isset($_POST["getNumOfStatus"])) {
		// get number of active/inactive start
	$filters = $_POST["filters"];
	$sql = construct_sql($filters);
	$result = $mysqli->query($sql);
	$total = $result->num_rows;

	$json = array('total'=>$total);
	echo json_encode($json);
}
	// var array = jQuery.parseJSON(data);

function filter_val($arr){
	if (count($arr)>0) {
		$str = "";
		$i=0;
		foreach ($arr as $value) {
			$str .= "'$value'";
			$i++;
			if (count($arr)!== $i) {
				$str .= ",";
			}
		}
		return $str;
	} else {
		return "";
	}
}


function construct_sql ($filters){

	$status_arr = array();
	$gender_arr = array();
	$type_arr = array();
	$nature_arr = array();
	$dept_arr = array();

	$filters_sql = '';

	if ($filters) {
		foreach ($filters as $value) {
			$value_arr = explode("=", $value);
			$index = $value_arr[0];
			$el = $value_arr[1];
			if ($index === "status") {
				array_push($status_arr, $el);
			} elseif ($index === "gender") {
				array_push($gender_arr, $el);
			} elseif ($index === "type") {
				array_push($type_arr, $el);
			} elseif ($index === "nature") {
				array_push($nature_arr, $el);
			} elseif ($index === "dept_id") {
				array_push($dept_arr, $el);
			}
		}	

		$sql_arr = array();
		if ($status_arr) {
			array_push($sql_arr, "employees.status IN(".filter_val($status_arr).")");
		} 
		if ($gender_arr) {
			array_push($sql_arr, "employees.gender IN(".filter_val($gender_arr).")");
		} 
		if ($type_arr) {
			array_push($sql_arr, "employees.employmentStatus IN(".filter_val($type_arr).")");
		} 
		if ($nature_arr) {
			array_push($sql_arr, "employees.natureOfAssignment IN(".filter_val($nature_arr).")");
		} 
		if ($dept_arr) {
			array_push($sql_arr, "employees.department_id IN(".filter_val($dept_arr).")");
		}

		$i = 0;
		$filters_sql = " WHERE ";
		foreach ($sql_arr as $value) {
			$i++;
			$filters_sql .= $value;
			if (count($sql_arr)!== $i) {
				$filters_sql .= " AND ";
			}
		}
	}

	$sql = "SELECT * FROM `employees` LEFT JOIN `department` ON employees.department_id = department.department_id LEFT JOIN `positiontitles` ON employees.position_id = positiontitles.position_id 
	$filters_sql
	ORDER BY `lastName` ASC";


	return $sql;
}

?>

