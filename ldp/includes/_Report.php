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
				<th>Training Subjects</th>
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

function get_num($mysqli,$id,$stat,$gen,$year,$bool){
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

		$sql = "SELECT * FROM `employees` WHERE $filterByDept employmentStatus = '$stat' AND gender = '$gen' AND employees_id $in (SELECT `employees_id` FROM `personneltrainingslist` WHERE `personneltrainings_id` IN (SELECT `personneltrainings_id` FROM `personneltrainings` WHERE year(startDate) = '$year'))";
		$result = $mysqli->query($sql);
		return $result->num_rows;
    }

// function dateToStr($numeric_date){
// 		if ($numeric_date) {
// 			$date = new DateTime($numeric_date);
// 			$strDate = $date->format('F d, Y');
// 		} else {
// 			$strDate = "<i style=\"color:grey\">N/A</i>";
// 		}
	  	
// 		return $strDate;
// }




// function getDepartment($mysqli,$department_id){
// 	$sql = "SELECT `department` FROM `department` WHERE `department_id` ='$department_id'";
// 	$result = $mysqli->query($sql);
// 	$row = $result->fetch_assoc();
// 	return $row["department"];
// }



