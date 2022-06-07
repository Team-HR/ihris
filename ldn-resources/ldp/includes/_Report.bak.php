<?php
include "_connect.db.php";
class Report {

	public $_department_id = "";
	public $_employmentStatus = "";
	public $_gender = "";
	public $_permanent = array();
	public $_casual = array();

public function setParams ($_department_id,$_employmentStatus,$_gender){
	$this->_department_id = $_department_id;
	$this->_employmentStatus = $_employmentStatus;
	$this->_gender = $_gender;
}

public function getReports (){
	$_department_id = $this->_department_id;
	$_employmentStatus = $this->_employmentStatus;
	$_gender = $this->_gender;

	include "_connect.db.php";

	$filterByGender = "WHERE employees.gender = '$_gender'";

	if ($_employmentStatus) {
		$filterByEmploymentStat = "AND employees.employmentStatus = '$_employmentStatus'";
	} else {
		$filterByEmploymentStat = "";
	}
	

	if ($_department_id !== "all") {
		$filterByDept = "AND employees.department_id = '$_department_id'";
	} else {
		$filterByDept = "";
	}

 	$sql = "SELECT * FROM employees 
 		LEFT JOIN positiontitles
			ON employees.position_id = positiontitles.position_id
		LEFT JOIN personneltrainingslist
			ON employees.employees_id =  personneltrainingslist.employees_id
		LEFT JOIN personneltrainings
			ON personneltrainingslist.personneltrainings_id = personneltrainings.personneltrainings_id
		LEFT JOIN trainings
			ON personneltrainings.training_id = trainings.training_id
			$filterByGender $filterByEmploymentStat	$filterByDept
		ORDER BY `employees`.`lastName` ASC";

	$result = $mysqli->query($sql);
	$preName = "";
?>
	<h4 class="ui header center aligned"><?php echo $this->_employmentStatus;?></h4>

	<table class="ui table small very compact striped" style="font-size: 11px;">
		<thead>
			<tr>
				<th>Name</th>
				<th>Gender</th>
				<th>Status</th>
				<th>Department</th>
				<th>Position</th>
				<th>Trainings Seminar</th>
				<th>Start</th>
				<th>End</th>
				<th>Hrs</th>
				<th>Remarks</th>
			</tr>
		</thead>
		<tbody>
<?php



	if ($_gender === "MALE") {
	?>
		<tr style="background-color: grey; color: white;">
			<th colspan="10" style="padding: 5px; text-align: center;"><i class="icon mars"></i> MALE</th>
		</tr>
	<?php		
	} else {
	?>
		<tr style="background-color: grey; color: white;">
			<th colspan="10" style="padding: 5px; text-align: center;"><i class="icon venus"></i> FEMALE</th>
		</tr>
	<?php
	} 

	if ($result->num_rows === 0) {
	?>
		<tr style="color: grey; text-align: center;">
			<td colspan="10	">N/A</td>
		</tr>
	<?php
	}

	while ($row = $result->fetch_assoc()) {
			
			$lastName = mb_convert_case($row["lastName"], MB_CASE_TITLE, "UTF-8");
			$firstName = mb_convert_case($row["firstName"], MB_CASE_TITLE, "UTF-8");
			$middleName = mb_convert_case($row["middleName"], MB_CASE_TITLE, "UTF-8");
			$extName = $row["extName"];

			$gender = $row["gender"];
			if (!$gender) {
				$gender = "<i style=\"color: grey\">N/A</i>";
			}

			$employmentStatus = $row["employmentStatus"];
			if (!$employmentStatus) {
				$employmentStatus = "<i style=\"color: grey\">N/A</i>";
			}


			$department = $row["department_id"];
			if (!$department) {
				$department = "<i style=\"color: grey\">N/A</i>";
			} else {
				$department = getDepartment($mysqli,$department);
			}

			$position = $row["position"];
			if (!$position) {
				$position = "<i style=\"color: grey\">N/A</i>";
			}
			$training = $row["training"];
			if (!$training) {
				$training = "<i style=\"color: grey\">N/A</i>";
			}
			$numHours = $row["numHours"];
			if (!$numHours) {
				$numHours = "<i style=\"color: grey\">N/A</i>";
			}
			$remarks = $row["remarks"];
			if (!$remarks) {
				$remarks = "<i style=\"color: grey\">N/A</i>";
			}
			$fullName = "$lastName, $firstName $middleName $extName";

			if ($fullName !== $preName) {

		?>
<tr>
	<td><?= $fullName?></td>
	<td><?= $gender[0]?></td>
	<td><?= $employmentStatus?></td>
	<td><?= $department?></td>
	<td><?=$position?></td>
	<td><?=$training?></td>
	<td><?=dateToStr($row["startDate"])?></td>
	<td><?=dateToStr($row["endDate"])?></td>
	<td><?=$numHours?></td>
	<td><?=$remarks?></td>
</tr>

		<?php
} else {
?>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td><?=$training?></td>
	<td><?=dateToStr($row["startDate"])?></td>
	<td><?=dateToStr($row["endDate"])?></td>
	<td><?=$numHours?></td>
	<td><?=$remarks?></td>
</tr>
<?php
}
	$preName = $fullName;
	}

	
?>
		</tbody>
	</table>

<?php
}

public function exec_getNum(){
	$department_id = $this->_department_id;

	$males_in = get_num($department_id,"PERMANENT", "MALE", TRUE);
	$females_in = get_num($department_id,"PERMANENT", "FEMALE", TRUE);
	$total_in = $males_in + $females_in;
	$males_out = get_num($department_id,"PERMANENT", "MALE", FALSE);
	$females_out = get_num($department_id,"PERMANENT", "FEMALE", FALSE);
	$total_out = $males_out + $females_out;

	array_push($this->_permanent, $males_in);
	array_push($this->_permanent, $females_in);
	array_push($this->_permanent, $total_in);
	array_push($this->_permanent, $males_out);
	array_push($this->_permanent, $females_out);
	array_push($this->_permanent, $total_out);

	$males_in2 = get_num($department_id,"CASUAL", "MALE", TRUE);
	$females_in2 = get_num($department_id,"CASUAL", "FEMALE", TRUE);
	$total_in2 = $males_in2 + $females_in2;
	$males_out2 = get_num($department_id,"CASUAL", "MALE", FALSE);
	$females_out2 = get_num($department_id,"CASUAL", "FEMALE", FALSE);
	$total_out2 = $males_out2 + $females_out2;

	array_push($this->_casual, $males_in2);
	array_push($this->_casual, $females_in2);
	array_push($this->_casual, $total_in2);
	array_push($this->_casual, $males_out2);
	array_push($this->_casual, $females_out2);
	array_push($this->_casual, $total_out2);


    }


}

function get_num($id,$stat,$gen,$bool){
    	require "_connect.db.php";
    	if ($id !== "all") {
    		$filterByDept = "department_id = '$id' AND";
    	} else {
    		$filterByDept = "";
    	}
    	if ($bool === true) {
    		$in = "IN";
    	} else {
    		$in = "NOT IN";
    	}

		$sql = "SELECT * FROM `employees` WHERE $filterByDept employmentStatus = '$stat' AND gender = '$gen' AND employees_id $in (SELECT `employees_id` FROM `personneltrainingslist`)";
		$result = $mysqli->query($sql);
		return $result->num_rows;
    }

function dateToStr($numeric_date){
		if ($numeric_date) {
			$date = new DateTime($numeric_date);
			$strDate = $date->format('F d, Y');
		} else {
			$strDate = "<i style=\"color:grey\">N/A</i>";
		}
	  	
		return $strDate;
}


function getDepartment($mysqli,$department_id){
	$sql = "SELECT `department` FROM `department` WHERE `department_id` ='$department_id'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	return $row["department"];
}