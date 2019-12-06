<?php 
include "_connect.db.php";
// include "ldp/includes/_Report.php";

if (isset($_POST["load"])) {
	$department_id = $_POST["department_id"];
	$year = $_POST["year"];
	createSummaryTable($mysqli,$department_id,$year);
	createTable($mysqli,"PERMANENT",$department_id,$year);
	createTable($mysqli,"CASUAL",$department_id,$year);
	createTable2($mysqli,$department_id,$year);
}

elseif (isset($_POST["load_graph"])) {
	$department_id = $_POST["department_id"];
	$year = $_POST["year"];

	$permanent = array(
		get_num($mysqli,$department_id,"PERMANENT","MALE",$year,true),
		get_num($mysqli,$department_id,"PERMANENT","FEMALE",$year,true),
		get_num($mysqli,$department_id,"PERMANENT","MALE",$year,false),
		get_num($mysqli,$department_id,"PERMANENT","FEMALE",$year,false)
	);

	$casual = array(
		get_num($mysqli,$department_id,"CASUAL","MALE",$year,true),
		get_num($mysqli,$department_id,"CASUAL","FEMALE",$year,true),
		get_num($mysqli,$department_id,"CASUAL","MALE",$year,false),
		get_num($mysqli,$department_id,"CASUAL","FEMALE",$year,false)
	);

	echo json_encode(array($permanent, $casual));

}

function createSummaryTable($mysqli,$department_id,$year){
	$permanent = array(
		get_num($mysqli,$department_id,"PERMANENT","MALE",$year,true),
		get_num($mysqli,$department_id,"PERMANENT","FEMALE",$year,true),
		get_num($mysqli,$department_id,"PERMANENT","MALE",$year,false),
		get_num($mysqli,$department_id,"PERMANENT","FEMALE",$year,false)
	);

	$casual = array(
		get_num($mysqli,$department_id,"CASUAL","MALE",$year,true),
		get_num($mysqli,$department_id,"CASUAL","FEMALE",$year,true),
		get_num($mysqli,$department_id,"CASUAL","MALE",$year,false),
		get_num($mysqli,$department_id,"CASUAL","FEMALE",$year,false)
	);
	
	?>
	<div class="ui grid" style="page-break-inside: avoid;">
		
		<div class="eight wide column">
			<div class="ui segment">
				<h4 class="ui blue header block">Permanent</h4>
				<div class="ui grid">
					<div class="eight wide column">
						<ol class="ui list">
							<li value=""><i class="check icon"></i> With Trainings:
								<ol>
									<li value="">Male: <?=$permanent[0]?></li>
									<li value="">Female: <?=$permanent[1]?></li>
									<li value="=">Total: <?=$sumPermW = $permanent[0]+$permanent[1]?></li>
								</ol>
							</li>
						</ol>
					</div>
					<div class="eight wide column">
						<ol class="ui list">
							<li value=""><i class="times icon"></i> Without Trainings:
								<ol>
									<li value="">Male: <?=$permanent[2]?></li>
									<li value="">Female: <?=$permanent[3]?></li>
									<li value="=">Total: <?=$sumPermWo = $permanent[2]+$permanent[3]?></li>
								</ol>
							</li>
						</ol>
					</div>
				</div>
				<div class="ui basic segment">
					<div class="ui grid">
						<div class="eight wide column">
					<p style="font-size: 16px;">
					<b>
					<?php 
						$percentPerW = getPercentage($sumPermW,$sumPermWo);
						echo $percentPerW[0];
					?>%</b> of permanent employees have our trainings.
					</p>
						</div>
						<div class="eight wide column">
					<p style="font-size: 16px;">
					<b>						
					<?php 
						echo $percentPerW[1];
					?>%</b> of permanent employees don't have our trainings.
					</p>
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="eight wide column">
			<div class="ui segment">
			<h4 class="ui blue header block">Casual</h4>
			<div class="ui grid">
				<div class="eight wide column">
					<ol class="ui list">
						<li value=""><i class="check icon"></i> With Trainings:
							<ol>
								<li value="">Male: <?=$casual[0]?></li>
								<li value="">Female: <?=$casual[1]?></li>
								<li value="=">Total: <?=$sumCasW=$casual[0]+$casual[1]?></li>
							</ol>
						</li>
					</ol>
				</div>
				<div class="eight wide column">
					<ol class="ui list">
						<li value=""><i class="times icon"></i> Without Trainings:
							<ol>
								<li value="">Male: <?=$casual[2]?></li>
								<li value="">Female: <?=$casual[3]?></li>
								<li value="=">Total: <?=$sumCasWo=$casual[2]+$casual[3]?></li>
							</ol>
						</li>
					</ol>	
				</div>
			</div>
				<div class="ui basic segment">
					<div class="ui grid">
						<div class="eight wide column">
					<p style="font-size: 16px;">
					<b>
					<?php 
						$percentCasW = getPercentage($sumCasW,$sumCasWo);
						echo $percentCasW[0];
					?>%</b> of casual employees have our trainings.
					</p>
						</div>
						<div class="eight wide column">
					<p style="font-size: 16px;">
					<b>						
					<?php 
						echo $percentCasW[1];
					?>%</b> of casual employees don't have our trainings.
					</p>
						</div>
					</div>
				</div>
		</div>
		</div>
	</div>

	<?php
}

function getPercentage($sumW,$sumWo){
	$out = array();
	$divisor = $sumW + $sumWo;

	if ($divisor !== 0) {
		$out[0] = number_format(($sumW/$divisor)*100,2);
		$out[1] = number_format(($sumWo/$divisor)*100,2);
	} else {
		$out[0] = number_format(0,2);
		$out[1] = number_format(0,2);
	}

	// } elseif ($sumW !== 0 && $sumWo === 0) {
	// 	$out = 100; 
	// }
	return $out;
}

function createTable2($mysqli,$department_id,$year){
	$permanent = array(
		get_num($mysqli,$department_id,"PERMANENT","MALE",$year,true),
		get_num($mysqli,$department_id,"PERMANENT","FEMALE",$year,true),
		get_num($mysqli,$department_id,"PERMANENT","MALE",$year,false),
		get_num($mysqli,$department_id,"PERMANENT","FEMALE",$year,false)
	);

	$casual = array(
		get_num($mysqli,$department_id,"CASUAL","MALE",$year,true),
		get_num($mysqli,$department_id,"CASUAL","FEMALE",$year,true),
		get_num($mysqli,$department_id,"CASUAL","MALE",$year,false),
		get_num($mysqli,$department_id,"CASUAL","FEMALE",$year,false)
	);
	
	?>
	<div class="ui grid" style="page-break-inside: avoid;">
		
		<div class="eight wide column">
			<div class="ui segment">
				<h4 class="ui blue header block">Permanent</h4>
				<div class="ui grid">
					<div class="eight wide column">
						<ol class="ui list">
							<li value=""><i class="check icon"></i> With Trainings:
								<ol>
									<li value="">Male: <?=$permanent[0]?></li>
									<li value="">Female: <?=$permanent[1]?></li>
									<li value="=">Total: <?=$permanent[0]+$permanent[1]?></li>
								</ol>
							</li>
						</ol>
					</div>
					<div class="eight wide column">
						<ol class="ui list">
							<li value=""><i class="times icon"></i> Without Trainings:
								<ol>
									<li value="">Male: <?=$permanent[2]?></li>
									<li value="">Female: <?=$permanent[3]?></li>
									<li value="=">Total: <?=$permanent[2]+$permanent[3]?></li>
								</ol>
							</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
		<div class="eight wide column">
			<div class="ui segment">
			<h4 class="ui blue header block">Casual</h4>
			<div class="ui grid">
				<div class="eight wide column">
					<ol class="ui list">
						<li value=""><i class="check icon"></i> With Trainings:
							<ol>
								<li value="">Male: <?=$casual[0]?></li>
								<li value="">Female: <?=$casual[1]?></li>
								<li value="=">Total: <?=$casual[0]+$casual[1]?></li>
							</ol>
						</li>
					</ol>
				</div>
				<div class="eight wide column">
					<ol class="ui list">
						<li value=""><i class="times icon"></i> Without Trainings:
							<ol>
								<li value="">Male: <?=$casual[2]?></li>
								<li value="">Female: <?=$casual[3]?></li>
								<li value="=">Total: <?=$casual[2]+$casual[3]?></li>
							</ol>
						</li>
					</ol>	
				</div>
			</div>
		</div>
		</div>
	</div>

	<?php
}

function createTable($mysqli,$employmentStatus,$department_id,$year){
	$PERMANENT = array(
		get_num($mysqli,$department_id,"PERMANENT","MALE",$year,true),
		get_num($mysqli,$department_id,"PERMANENT","FEMALE",$year,true),
		get_num($mysqli,$department_id,"PERMANENT","MALE",$year,false),
		get_num($mysqli,$department_id,"PERMANENT","FEMALE",$year,false)
	);
	
	$CASUAL = array(
		get_num($mysqli,$department_id,"CASUAL","MALE",$year,true),
		get_num($mysqli,$department_id,"CASUAL","FEMALE",$year,true),
		get_num($mysqli,$department_id,"CASUAL","MALE",$year,false),
		get_num($mysqli,$department_id,"CASUAL","FEMALE",$year,false)
	);
	?>
	<div class="ui basic segment">
		<div class="ui blue segment center aligned top attached">
			<h3 class="ui blue header"><?=$employmentStatus?></h3>
		</div>
		<table class="ui table very compact bottom attached" style="font-size: 11px;">
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
					<!-- <th>Remarks</th> -->
				</tr>
			</thead>
			<tbody>
				<div style="page-break-inside: avoid;">
					<tr style="background-color: #e9edf1; color: #4075a9;">
						<th colspan="10" style="font-size: 18px; padding: 5px; text-align: left;">


							<div class="ui form">
								<div class="fields" style="margin: 0px;">
									<div class="two wide field">
										<i class="icon venus"></i>FEMALE: <?=${$employmentStatus}[1]+${$employmentStatus}[3];?>
									</div>
									<div class="two wide field" style="font-style: italic;font-size: 12px;">
										<i class="icon black circle outline"></i> With Trainings: <?=${$employmentStatus}[1];?>
									</div>
									<div class="two wide field" style="font-style: italic;font-size: 12px;">
										<i class="icon circle outline" style="color: #ff2900;"></i> Without Trainings: <?=${$employmentStatus}[3];?>
									</div>
								</div>
							</div>

						</th>
					</tr>
					<?=listEmployees($mysqli, "FEMALE", $employmentStatus, $department_id,$year)?>
				</div>
				<div style="page-break-inside: avoid;">
					<tr style="background-color: #e9edf1; color: #4075a9;">
						<th colspan="10" style="font-size: 18px; padding: 5px; text-align: left;">
							<div class="ui form">
								<div class="fields" style="margin: 0px;">
									<div class="two wide field">
										<i class="icon mars"></i>MALE: <?=${$employmentStatus}[0]+${$employmentStatus}[2];?>
									</div>
									<div class="two wide field" style="font-style: italic;font-size: 12px;">
										<i class="icon black circle outline"></i> With Trainings: <?=${$employmentStatus}[0];?>
									</div>
									<div class="two wide field" style="font-style: italic;font-size: 12px;">
										<i class="icon circle outline" style="color: #ff2900;"></i> Without Trainings: <?=${$employmentStatus}[2];?>
									</div>
								</div>
							</div>
						</th>
					</tr>
					<?=listEmployees($mysqli, "MALE", $employmentStatus, $department_id,$year)?>
				</div>
			</tbody>
		</table>
	</div>

	<?php
}

function listEmployees($mysqli, $gender, $employmentStatus, $department_id,$year){

	$filterByGender = " AND employees.gender = '$gender'";

	if ($employmentStatus) {
		$filterByEmploymentStat = " AND employees.employmentStatus = '$employmentStatus'";
	} else {
		$filterByEmploymentStat = "";
	}

	if ($department_id !== "all") {
		$filterByDept = " AND employees.department_id = '$department_id'";
	} else {
		$filterByDept = "";
	}

	$sql = "SELECT * FROM employees 
	LEFT JOIN positiontitles
	ON `employees`.`position_id` = `positiontitles`.`position_id`
	WHERE `employees`.`status` = 'ACTIVE'
	$filterByGender $filterByEmploymentStat	$filterByDept
	ORDER BY `employees`.`lastName` ASC";

	$result = $mysqli->query($sql);
	$num_rows = $result->num_rows;

	if ($num_rows === 0) {
		echo "<tr style='color: grey; text-align: center;'><td colspan='10'><i>N/A</i></td></tr>";
	} else {
		while ($row = $result->fetch_assoc()) {
			$employees_id = $row["employees_id"];
			$lastName = mb_convert_case($row["lastName"], MB_CASE_TITLE, "UTF-8");
			$firstName = mb_convert_case($row["firstName"], MB_CASE_TITLE, "UTF-8");
			$middleName = mb_convert_case($row["middleName"], MB_CASE_TITLE, "UTF-8");
			$extName = $row["extName"];
			$fullName = "$lastName, $firstName $middleName $extName";

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
			$training = "";
			$startDate = "";
			$endDate = "";;
			$numHours = "";
			$remarks = "";

			$masterArr = createTrainings($mysqli,$employees_id,$year);

			if ($masterArr) {
				foreach ($masterArr as $key => $value) {

					if ($key === 0) {
						?>
						<tr style="background-color: /*#cce2f7*/;">
							<td style="white-space: nowrap;"><?=$fullName?></td>
							<td><?=$gender[0]?></td>
							<td><?=$employmentStatus?></td>
							<td><?=$department?></td>
							<td><?=$position?></td>
							<td><?=$value["training"]?></td>
							<td><?=dateToStr($value["startDate"])?></td>
							<td><?=dateToStr($value["endDate"])?></td>
							<td><?=$value["numHours"]?></td>
							<!-- <td><?=$value["remarks"]?></td> -->
						</tr>
						<?php
					} else {
						?>
						<tr>
							<td colspan="5"></td>
							<td><?=$value["training"]?></td>
							<td><?=dateToStr($value["startDate"])?></td>
							<td><?=dateToStr($value["endDate"])?></td>
							<td><?=$value["numHours"]?></td>
							<!-- <td><?=$value["remarks"]?></td> -->
						</tr>
						<?php
					}
				}
			} elseif (!$masterArr) {
				if ($year !== "all") {
					$yearStmnt = " on year $year.";
				} else {
					$yearStmnt = ".";
				}
				?>
				<tr style="background-color: #f5e0dc;">
					<td style="white-space: nowrap;"><?=$fullName?></td>
					<td><?=$gender[0]?></td>
					<td><?=$employmentStatus?></td>
					<td><?=$department?></td>
					<td><?=$position?></td>
					<td colspan="4" ><i style="color: grey;">No trainings attended<?=$yearStmnt?></i></td>
				</tr>
				<?php
			}

// end of while
		}
	}
// ender
}

function totalNum($mysqli,$employees_id){
	$total = 0;
	
	$sql1 = "SELECT * FROM `personneltrainingslist` WHERE `employees_id` = '$employees_id'";
	$result1 = $mysqli->query($sql1);
	$t1 = $result1->num_rows;

	$sql2 = "SELECT * FROM `requestandcoms`
	LEFT JOIN `requestandcomslist`
	ON `requestandcoms`.`controlNumber` = `requestandcomslist`.`controlNumber`
	WHERE `requestandcomslist`.`employees_id` = '$employees_id' AND `requestandcoms`.`isMeeting` != 'yes'";
	$result2 = $mysqli->query($sql2);
	$t2 = $result2->num_rows;

	return $t1+$t2;
}


function createTrainings($mysqli,$employees_id,$year){

	if ($year !== "all") {
		$filterByYear  = "AND year(personneltrainings.startDate) = '$year'";
		$filterByYear2  = "AND year(`requestandcoms`.`fromDate`) = '$year'";
	} else {
		$filterByYear = "";
		$filterByYear2 = "";
	}


	$arrMaster = array();
	$sql1 = "SELECT * FROM `personneltrainingslist`
	LEFT JOIN personneltrainings
	ON personneltrainingslist.personneltrainings_id = personneltrainings.personneltrainings_id
	LEFT JOIN trainings
	ON personneltrainings.training_id = trainings.training_id
	WHERE `personneltrainingslist`.`employees_id` = '$employees_id' $filterByYear";

	$result1 = $mysqli->query($sql1);
	while ($row1 = $result1->fetch_assoc()) {
		$training = $row1["training"];
		$startDate = $row1["startDate"];
		$endDate = $row1["endDate"];
		$numHours = $row1["numHours"];
		$remarks = $row1["remarks"];

		$insertArr = array(
			'training' => $training,
			'startDate' => $startDate,
			'endDate' => $endDate,
			'numHours' => $numHours,
			'remarks' => $remarks
		);

		array_push($arrMaster, $insertArr);
	}


	$sql2 = "SELECT * FROM `requestandcoms`
	LEFT JOIN `requestandcomslist`
	ON `requestandcoms`.`controlNumber` = `requestandcomslist`.`controlNumber`
	WHERE `requestandcomslist`.`employees_id` = '$employees_id' AND `requestandcoms`.`isMeeting` != 'yes' $filterByYear2";
	$result2 = $mysqli->query($sql2);
	while ($row2 = $result2->fetch_assoc()) {
		$training = $row2["subject"];
		$startDate = $row2["fromDate"];
		$endDate = $row2["toDate"];
        // $numHours = $row2["numHours"];
        // $numHours = "0";
		$numHours = getNumHours($startDate,$endDate);

		$remarks = $row2["remarks"];
		$insertArr = array(
			'training' => $training,
			'startDate' => $startDate,
			'endDate' => $endDate,
			'numHours' => $numHours,
			'remarks' => $remarks
		);

		array_push($arrMaster, $insertArr);
	} 
	usort($arrMaster, function($a, $b) {
		return $b['startDate'] <=> $a['startDate'];
	});

	return $arrMaster;
}

function getDepartment($mysqli,$department_id){
	$sql = "SELECT `department` FROM `department` WHERE `department_id` ='$department_id'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	return $row["department"];
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

function getNumHours($date_early,$date_late){
	$date1 = strtotime($date_early);
	$date2 = strtotime($date_late);
	$dateDiff = $date2 - $date1;
	$numHrs = (($dateDiff/ (60 * 60 * 24))*8)+8;
	return $numHrs;
}

function get_num($mysqli,$id,$stat,$gen,$year,$bool){
	if ($id !== "all") {
		$filterByDept = "department_id = '$id' AND";
	} else {
		$filterByDept = "";
	}
	if ($year !== "all") {
		$filterByYear = "WHERE year(startDate) = '$year'";
		$filterByYear2 = "AND year(fromDate) = '$year'";
	} else {
		$filterByYear = "";
		$filterByYear2 = "";

	}
	if ($bool == true) {
		$in = "IN";
	} else {
		$in = "NOT IN";
	}

	$sql = "SELECT * FROM `employees` WHERE $filterByDept employmentStatus = '$stat' AND gender = '$gen' AND `status` = 'ACTIVE' AND employees_id $in (SELECT `employees_id` FROM `personneltrainingslist` WHERE `personneltrainings_id` IN (SELECT `personneltrainings_id` FROM `personneltrainings` $filterByYear))
	UNION
	SELECT * FROM `employees` WHERE $filterByDept employmentStatus = '$stat' AND gender = '$gen' AND `status` = 'ACTIVE' AND employees_id $in (SELECT `employees_id` FROM `requestandcomslist` WHERE `controlNumber` IN (SELECT `controlNumber` FROM `requestandcoms` WHERE `isMeeting` != 'yes' $filterByYear2))
	";

	$result = $mysqli->query($sql);
	$num_rows = $result->num_rows;

	if (!$num_rows) {
		$num_rows = 0;
	}

	return $num_rows;

}

?>



