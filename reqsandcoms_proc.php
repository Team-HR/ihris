<?php 
require_once "_connect.db.php";

if (isset($_POST["load"])) {
	$year = $_POST["year"];
	$department_ids = $_POST["department_ids"];

	if ($year !== "all") {
		$filterByYear = "WHERE year(`fromDate`) = '$year'";
		$filterByYear1 = "AND year(`fromDate`) = '$year'";
	} else {
		$filterByYear = "";
		$filterByYear1 = "";
	}


	if ($department_ids === "all") {
		$sql = "SELECT * FROM `requestandcoms` $filterByYear ORDER BY `dateReceived` DESC";
	} elseif ($department_ids !== "all") {
		$sql = "SELECT * FROM `requestandcoms` WHERE controlNumber IN (SELECT controlNumber FROM `requestandcomslist_dept` WHERE `department_id` IN ($department_ids)) $filterByYear1 ORDER BY `dateReceived` DESC";
	}

	$result = $mysqli->query($sql);
	if ($result->num_rows === 0) {
		?>
		<tr>
			<td colspan="11" style="color: grey; text-align: center; padding: 20px; font-size: 24px;"><i>No records found...</i></td>
		</tr>
		<?php
	}
	
	while ($row = $result->fetch_assoc()) {
		$controlNumber = $row["controlNumber"];
		$dateReceived = $row["dateReceived"];
		$source = $row["source"];
		if ($source == null) {
			$source = "<i style=\"color: lightgrey;\">N/A</i>";
		}

		$department_ids = getDeptInvolved($mysqli,$controlNumber);
		$dept_ids = "";

		if ($department_ids != null) {
			$counter = 1;
			$eol = ";<br>";
			foreach ($department_ids as $department_id) {
				$counter++;
				if (count($department_ids) == $counter) {
					$eol = ";<br>";
				}
				$dept_ids .= getDepartment($mysqli,$department_id).$eol;
			}
		} else {
			$dept_ids = "<i style=\"color: lightgrey;\">N/A</i>";
		}

		$subject = $row["subject"];
		$fromDate = $row["fromDate"];
		$toDate= $row["toDate"];
		$venue = $row["venue"];
		$remarks= $row["remarks"];
		$carriedBy = $row["carriedBy"];
		$date= $row["date"];
		$isMeeting= $row["isMeeting"];
		?>
		<tr style="vertical-align: top">
			<td style="white-space: nowrap;">
				<?php 
				echo "HRMO-".getYearOnly($dateReceived)."-".str_pad((string)$controlNumber, 5, "0", STR_PAD_LEFT);
				?>
			</td>
			<td style="white-space: nowrap;"><?php echo dateToStr($dateReceived);?></td>
			<td><?php echo $source;?></td>
			<td><?php echo $dept_ids;?></td>
			<td><?php echo $subject;?></td>
			<td style="white-space: nowrap;"><?php echo dateToStr($fromDate);?></td>
			<td style="white-space: nowrap;"><?php echo dateToStr($toDate);?></td>
			<td><?php echo $venue;?></td>
			<td style="white-space: nowrap;"><?php echo getEmployeeInvolved($mysqli,$controlNumber);?></td>
			<td>
				<?php
				if ($isMeeting === "no") {
					$isMeeting = "Training";
				} elseif ($isMeeting === "yes") {
					$isMeeting = "Meeting";
				} elseif ($isMeeting === "seminar") {
					$isMeeting = "Seminar";
				} elseif ($isMeeting === "orientation") {
					$isMeeting = "Orientation";
				} elseif ($isMeeting === "conference") {
					$isMeeting = "Conference";
				} elseif ($isMeeting === "workshop") {
					$isMeeting = "Workshop";
				} elseif ($isMeeting === "others") {
					$isMeeting = "Others";
				}
				
				else {
					$isMeeting = "<div title='Please identify the type of communication!' style='color: red;'><i class='icon circle info'></i><i>n/a</i></div";
				}
				echo $isMeeting;
				?>

			</td>
			<td>
				<div class="ui icon basic mini buttons">
					<button onclick="viewFunc('<?php echo $controlNumber;?>')" title="Open" class="ui button"><i class="folder open outline icon"></i></button>
					<button onclick="updateFunc('<?php echo $controlNumber;?>')" title="Quick Edit" class="ui button"><i class="edit outline icon"></i></button>
					<button onclick="deleteFunc('<?php echo $controlNumber;?>')" title="Delete" class="ui button"><i class="trash alternate outline icon"></i></button>
				</div>
			</td>
		</tr>
		<?php
	}
// header('Location: http://192.168.14.22/hris/reqsandcoms.php');
}

elseif (isset($_POST["loadListToAdd"])) {
	$sql = "SELECT * FROM `employees` WHERE `status` = 'ACTIVE' ORDER BY `lastName` ASC";
	$result = $mysqli->query($sql);
	while ($row = $result->fetch_assoc()) {
		$employees_id = $row["employees_id"];
		$lastName = $row["lastName"];
		$firstName = $row["firstName"];
		$middleName = $row["middleName"];
		$extName = $row["extName"];
		$fullName = $lastName.", ".$firstName." ".$middleName." ".$extName."<br>";
		?>
		<div id="<?php echo $employees_id;?>" class="item">
			<div class="right floated content">
				<button onclick="addToList('<?php echo $employees_id;?>')" class="ui icon mini basic button">Add
				</button>
			</div>
			<div class="content"><?php echo $fullName; ?></div>
		</div>
		<?php
	}
}

elseif (isset($_POST["addOther"])) {
	if ($name = $_POST["name"]) {
		$nameUp = mb_convert_case($name, MB_CASE_UPPER, "UTF-8")

		?>
		<div id="<?php echo $name;?>" class="item">
			<div class="right floated content">
				<button onclick="removeOther('<?php echo $name;?>')" class="ui icon basic mini button"><i class="icon times"></i></button>
			</div>
			<div class="content"><?php echo $nameUp; ?></div>
		</div>

		<?php

	}
}

elseif (isset($_POST["add"])) {
	$source = addslashes($_POST["source"]);
	$subject = addslashes($_POST["subject"]);
	$department_ids = $_POST["department_ids"];
	$fromDate = $_POST["fromDate"];
	$toDate = $_POST["toDate"];
	$venue = addslashes($_POST["venue"]);
	$type = $_POST["type"];
	$employeesArray = $_POST["employeesArray"];
	$othersArray = $_POST["othersArray"];
	$dateReceived = date('Y-m-d H:i:s');
	$sql = "INSERT INTO `requestandcoms` (`dateReceived`, `source`, `subject`, `fromDate`, `toDate`, `venue`, `remarks`, `carriedBy`, `date`, `isMeeting`) VALUES ( '$dateReceived', '$source', '$subject', '$fromDate', '$toDate', '$venue', NULL, NULL, NULL, '$type')";
	$mysqli->query($sql);
	$controlNumber = $mysqli->insert_id;


	if ($department_ids != null) {
		$department_ids_arr = explode(",", $department_ids);
		foreach ($department_ids_arr as $department_id) {
			$sql = "INSERT INTO `requestandcomslist_dept` (`requestandcomslist_dept_id`, `controlNumber`, `department_id`) VALUES (NULL, '$controlNumber', '$department_id')";
			$mysqli->query($sql);
		}
	}

	if ($employeesArray != null) {
		foreach ($employeesArray as $employees_id) {
			if ($employees_id != null) {
				$sql = "INSERT INTO `requestandcomslist` (`controlNumber`, `employees_id`) VALUES ('$controlNumber', '$employees_id')";
				$mysqli->query($sql);
			}
		}
	}

	if ($othersArray != null) {
		foreach ($othersArray as $others) {
			if ($others != null) {
				$sql = "INSERT INTO `requestandcomslist` (`controlNumber`, `others`) VALUES ('$controlNumber', '$others')";
				$mysqli->query($sql);
			}
		} 
	}

}

elseif (isset($_POST["delete"])) {
	$controlNumber = $_POST["controlNumber"];
	$sql0 ="DELETE FROM `requestandcoms` WHERE `requestandcoms`.`controlNumber` = '$controlNumber'";
	$sql1 ="DELETE FROM `requestandcomslist` WHERE `requestandcomslist`.`controlNumber` = '$controlNumber'";
	$sql2 ="DELETE FROM `requestandcomslist_dept` WHERE `requestandcomslist_dept`.`controlNumber` = '$controlNumber'";
	$mysqli->query($sql0);
	$mysqli->query($sql1);
	$mysqli->query($sql2);
}

elseif (isset($_POST["getRowData"])) {

	$controlNumber = $_POST["controlNumber"];
	$sql = "SELECT * FROM `requestandcoms` WHERE `controlNumber` = '$controlNumber'" ;
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();

	$dateReceived = $row["dateReceived"];
	$source = $row["source"];

	$sql_department_ids = "SELECT * FROM requestandcomslist_dept WHERE controlNumber = '$controlNumber'";
	$result_department_ids = $mysqli->query($sql_department_ids);
	$num_rows_department_ids = $result_department_ids->num_rows;
	$counter = 0;
	$department_ids = "";
	while ($row_department_ids = $result_department_ids->fetch_assoc()) {
		$department_id = $row_department_ids["department_id"];
		$counter++;
		$department_ids .= $department_id;
		if ($counter !== $num_rows_department_ids) {
			$department_ids .= ",";
		}
	}

	$subject = $row["subject"];
	$fromDate = $row["fromDate"];
	$toDate = $row["toDate"];
	$venue = $row["venue"];
	$isMeeting = $row["isMeeting"];



	$sql = "SELECT * FROM `requestandcomslist` WHERE `controlNumber` = '$controlNumber'";
	$result = $mysqli->query($sql);
	$employees_ids = array();
	$others_array = array();
	while ($row = $result->fetch_assoc()) {
		$employees_id = $row["employees_id"];
		$others = $row["others"];
		if ($employees_id != null) {
			array_push($employees_ids, $employees_id);
		} elseif ($others != null) {
			array_push($others_array, $others);
		}
	}

	$controlNumber = str_pad((string)$controlNumber, 5, "0", STR_PAD_LEFT);

	if ($isMeeting === "yes") {
		$isMeeting = "Meeting";
	} elseif ($isMeeting === "no") {
		$isMeeting = "Training";
	} elseif ($isMeeting === "seminar") {
		$isMeeting = "Seminar";
	} elseif ($isMeeting === "orientation") {
		$isMeeting = "Orientation";
	} elseif ($isMeeting === "conference") {
		$isMeeting = "Conference";
	}
	else {
		$isMeeting = "";
	}
// <i style=\"color: lightgrey\">n/a</i>
	$json = array(
		'controlNumber' => $controlNumber,
		'controlNumberFormatted' => "HRMO-".getYearOnly($dateReceived)."-".$controlNumber,
		'dateReceived' => dateToStrComplete($dateReceived),
		'source'=> $source,
		'department_ids'=> $department_ids,
		'subject'=> $subject,
		'fromDate'=> $fromDate,
		'toDate'=> $toDate,
		'fromDateFormatted'=>dateToStrComplete( $fromDate),
		'toDateFormatted'=> dateToStrComplete($toDate),
		'venue'=> $venue,
		'type'=> $isMeeting,
		'employees_ids'=> $employees_ids,
		'others_array'=> $others_array
	);
	echo json_encode($json);

}
elseif (isset($_POST["loadListToAddEdit"])) {
	$controlNumber = $_POST["controlNumber"];
	$sql = "SELECT * FROM `employees` WHERE `employees_id` NOT IN (SELECT `employees_id` FROM `requestandcomslist` WHERE `controlNumber` = '$controlNumber' AND `employees_id` IS NOT NULL) AND `status` = 'ACTIVE' ORDER BY `lastName` ASC";
	$result = $mysqli->query($sql);
	while ($row = $result->fetch_assoc()) {
		$employees_id = $row["employees_id"];
		$lastName = $row["lastName"];
		$firstName = $row["firstName"];
		$middleName = $row["middleName"];
		$extName = $row["extName"];
		$fullName = $lastName.", ".$firstName." ".$middleName." ".$extName."<br>";
		?>
		<div id="<?php echo $employees_id;?>" class="item">
			<div class="right floated content">
				<button onclick="addToListEdit('<?php echo $employees_id;?>')" class="ui icon basic mini button">
					Add
				</button>
			</div>
			<div class="content"><?php echo $fullName; ?></div>
		</div>
		<?php
	}
}
elseif (isset($_POST["addOtherEdit"])) {
	if ($name = $_POST["name"]) {
		$nameUp = mb_convert_case($name, MB_CASE_UPPER, "UTF-8");
		$element_id = str_replace(' ', '', $name);

		?>
		<div id="<?php echo $element_id;?>" class="item">
			<div class="right floated content">
				<button onclick="removeOtherEdit('<?php echo $element_id;?>','<?php echo $name;?>')" class="ui icon basic mini button"><i class="icon times"></i></button>
			</div>
			<div class="content"><?php echo $nameUp; ?></div>
		</div>

		<?php

	}
}
elseif (isset($_POST["popListEmployees_id"])) {
	$employees_id = $_POST["employees_id"];
	$sql = "SELECT * FROM `employees` WHERE `employees_id` = '$employees_id'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	$lastName = $row["lastName"];
	$firstName = $row["firstName"];
	$middleName = $row["middleName"];
	$extName = $row["extName"];
	$fullName = $lastName.", ".$firstName." ".$middleName." ".$extName."<br>";

	?>
	<div id="<?php echo $employees_id;?>" class="item">
		<div class="right floated content">
			<button onclick="removeFromListEdit('<?php echo $employees_id;?>')" class="ui icon basic mini button">Del</button>
		</div>
		<div class="content"><?php echo $fullName; ?></div>
	</div>
	<?php
}

elseif (isset($_POST["popListOthers"])) {
	if ($name = $_POST["name"]) {
		$nameUp = mb_convert_case($name, MB_CASE_UPPER, "UTF-8");
		$element_id = str_replace(' ', '', $name);

		?>
		<div id="<?php echo $element_id;?>" class="item">
			<div class="right floated content">
				<button onclick="removeOtherEdit('<?php echo $element_id;?>','<?php echo $name;?>')" class="ui icon basic mini button"><i class="icon times"></i></button>
			</div>
			<div class="content"><?php echo $nameUp; ?></div>
		</div>

		<?php

	}
}

elseif (isset($_POST["edit"])) {
	$controlNumber = $_POST["controlNumber"];
	$source = addslashes($_POST["source"]);
	$subject = addslashes($_POST["subject"]);
	$department_ids = $_POST["department_ids"];
	$fromDate = $_POST["fromDate"];
	$toDate = $_POST["toDate"];
	$venue = addslashes($_POST["venue"]);
	$type = $_POST["type"];
	$employeesArray = $_POST["employeesArray"];
	$othersArray = $_POST["othersArray"];

	$sql = "UPDATE `requestandcoms` SET `source`='$source',`subject`='$subject',`fromDate`='$fromDate',`toDate`='$toDate',`venue`='$venue',`isMeeting`='$type' WHERE `controlNumber` = '$controlNumber'";
	$mysqli->query($sql);

	if ($department_ids != null) {
		$department_ids_arr = explode(",", $department_ids);

		$sql = "DELETE FROM `requestandcomslist_dept` WHERE controlNumber = '$controlNumber'";
		$mysqli->query($sql);

		foreach ($department_ids_arr as $department_id) {
			$sql = "INSERT INTO `requestandcomslist_dept` (`requestandcomslist_dept_id`, `controlNumber`, `department_id`) VALUES (NULL, '$controlNumber', '$department_id')";
			$mysqli->query($sql);
		}
	}

	$sql = "DELETE FROM `requestandcomslist` WHERE `requestandcomslist`.`controlNumber` = '$controlNumber'";
	$mysqli->query($sql);

	if ($employeesArray != null) {
		foreach ($employeesArray as $employees_id) {
			if ($employees_id != null) {
				$sql = "INSERT INTO `requestandcomslist` (`controlNumber`, `employees_id`) VALUES ('$controlNumber', '$employees_id')";
				$mysqli->query($sql);
			}
		}
	}

	if ($othersArray != null) {
		foreach ($othersArray as $others) {
			if ($others != null) {
				$sql = "INSERT INTO `requestandcomslist` (`controlNumber`, `others`) VALUES ('$controlNumber', '$others')";
				$mysqli->query($sql);
			}
		}
	}
}

elseif (isset($_POST["getListsForView"])) {
	$controlNumber = $_POST["controlNumber"];
	$sql = "SELECT `department_id` FROM `requestandcomslist_dept` WHERE `controlNumber` = '$controlNumber'";
	$result = $mysqli->query($sql);
	$department_ids = array();
	while ($row = $result->fetch_assoc()) {
		array_push($department_ids, $row["department_id"]);
	}
  // $department_ids = $row["department_ids"];
	if ($department_ids != null) {
    // $department_ids = unserialize($department_ids);
		?>
		<div class="field" id="deptsField">
			<h5 class="ui header">Departments Concerned:</h5>
			<div class="ui small list">
				<?php
				foreach ($department_ids as $department_id) {
					$sql = "SELECT `department` FROM `department` WHERE `department_id` = '$department_id'";
					$result = $mysqli->query($sql);
					$row = $result->fetch_assoc();
					$department = $row["department"];
					?>
					<div class="item">
						<?php echo $department;?>
					</div>
					<?php
				}
				?>
			</div>
		</div>
		<?php
	}

	$sql = "SELECT * FROM `requestandcomslist` WHERE `controlNumber` = '$controlNumber'";
	$result = $mysqli->query($sql);
	$employees_ids = array();
	$otherss = array();
	if ($result->num_rows != 0) {
		?>
		<div class="field" id="employeesInvolvedField">
			<?php
			while ($row = $result->fetch_assoc()) {
				$employees_id = $row["employees_id"];
				$others = $row["others"];
				if ($employees_id != null) {  
					array_push($employees_ids, $employees_id);
				}
				if ($others != null) {
					array_push($otherss, $others);
				}
			}

			if (count($employees_ids) != 0) {
				?>
				<h5 class="ui header">Personnels Involved:</h5>
				<div class="ui small list">
					<?php
					foreach ($employees_ids as $employees_id) {
						$sql = "SELECT * FROM `employees` WHERE `employees_id` = '$employees_id'";
						$result = $mysqli->query($sql);
						$row = $result->fetch_assoc();
						$employees_id = $row["employees_id"];
						$firstName = $row["firstName"];
						$middleName = $row["middleName"];
						$lastName = $row["lastName"];
						$extName = $row["extName"];
						$fullName = "$lastName, $firstName $middleName $extName";
						?>
						<div class="item">
							<?php echo mb_convert_case($fullName, MB_CASE_TITLE, "UTF-8");?>
						</div>
						<?php
					}
					?>
				</div>
				<?php
			}
			if (count($otherss) != 0) {
				?>
				<h5 class="ui header">Other/s Involved:</h5>
				<div class="ui small list">
					<?php
					foreach ($otherss as $others) {
						?>
						<div class="item">
							<?php echo mb_convert_case($others, MB_CASE_TITLE, "UTF-8");?>
						</div>
						<?php
					}
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	}
} elseif (isset($_POST["loadViewRemarks"])) {
	$controlNumber = $_POST["controlNumber"];
	$sql = "SELECT * FROM `requestandcoms` WHERE `controlNumber` = '$controlNumber'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	$remarks = $row["remarks"];

	if (empty($remarks)) {
		$remarks = "";
	}


	$carriedBy = $row["carriedBy"];
	if (empty($carriedBy)) {
		$carriedBy = "";
	}

	$date = $row["date"];
	if ($date != null) {
		$dateFormatted = dateToStrComplete($date);
	} else {
		$dateFormatted = "";
	}


	$json = array('remarks'=>$remarks, 'carriedBy'=>$carriedBy,'date'=>$date, 'dateFormatted'=>$dateFormatted);
	echo json_encode($json);

} elseif (isset($_POST["saveRemarks"])) {
	$controlNumber = $_POST["controlNumber"];
	$remarks = addslashes($_POST["remarks"]);
	$carriedBy = addslashes($_POST["carriedBy"]);
	$date = $_POST["date"];

  // if ($date == null) {
  //  $date = date('Y-m-d');
  // }

	$sql = "UPDATE `requestandcoms` SET `remarks`='$remarks',`carriedBy`='$carriedBy', `date` = '$date' WHERE `controlNumber` = '$controlNumber'";
	$mysqli->query($sql);
}

function getYearOnly($numeric_date){
	$date = new DateTime($numeric_date);
	$year = $date->format('Y');
	return $year;
}

function dateToStr($numeric_date){
	$date = new DateTime($numeric_date);
	$strDate = $date->format('M d Y');
	return $strDate;
}

function dateToStrComplete($numeric_date){
	$date = new DateTime($numeric_date);
	$strDate = $date->format('F d, Y');
	return $strDate;
}


function getDepartment($mysqli,$department_id){
  // require "_connect.db.php";
	$sql = "SELECT `department` FROM `department` WHERE `department_id` = '$department_id'"; 
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	return $department = $row["department"];
}

function getDeptInvolved($mysqli,$controlNumber){
	$sql = "SELECT `department_id` FROM `requestandcomslist_dept` WHERE `controlNumber` = '$controlNumber'"; 
	$result = $mysqli->query($sql);

	$department_ids = array();
	while ($row = $result->fetch_assoc()) {
		array_push($department_ids, $row["department_id"]);
	}
	return $department_ids;
}

function getEmployeeInvolved($mysqli,$controlNumber){
	$sql = "SELECT `controlNumber`,`requestandcomslist`.`employees_id`,`others`,`firstName`,`middleName`,`lastName`,`extName` FROM `requestandcomslist` 
	LEFT JOIN `employees` 
	ON `requestandcomslist`.`employees_id` = `employees`.`employees_id`
	WHERE `controlNumber` = '$controlNumber'"; 
	$result = $mysqli->query($sql);
  // $employee = array();
	$employees = "";
	while ($row = $result->fetch_assoc()) {
		$employees_id = $row["employees_id"];
		$lastName = mb_convert_case($row["lastName"], MB_CASE_TITLE, "UTF-8");
		$firstName = mb_convert_case($row["firstName"], MB_CASE_TITLE, "UTF-8");
		$middleName = mb_convert_case($row["middleName"], MB_CASE_TITLE, "UTF-8");
		$extName = $row["extName"];
		$fullName = "$lastName, $firstName $middleName $extName";
		$others = $row["others"];

		if ($employees_id) {
			$employees .= $fullName."<br>";
		} elseif (!$employees_id) {
			$employees .= mb_convert_case($others, MB_CASE_TITLE, "UTF-8")."<br>";
		}
    // array_push($employee, $row["department_id"]);
	}

	return $employees;
}

?>