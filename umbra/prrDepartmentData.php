<?php
require_once '../_connect.db.php';
if (isset($_POST['dep'])) {
	$dep = $_POST['dep'];
	$prrId = $_POST['prrc_id'];
	$sql = "SELECT * FROM `employees` where employees.department_id='$dep' ORDER BY  employmentStatus DESC ,lastName ASC ";
	$result = $mysqli->query($sql);
	$Folder = "SELECT * FROM prr where prr_id='$prrId'";
	$Folder = $mysqli->query($Folder);
	$Folder = $Folder->fetch_assoc();
	$count = 0;
	$file = $Folder['year'];
	$cache = "";
	$count =0;
	$NO =1;
	$casual = "";
	$permanent = "";
	$av = 0;
	while ( $row = $result->fetch_assoc()) {
		$sql2 = "SELECT * FROM prr where prr_id='$prrId'";
		$result2 = $mysqli->query($sql2);
		$row2 = $result2->fetch_assoc();
		$empdata = empdata($mysqli,$row2,$row['employmentStatus'],$row['employees_id']);
		$dateEmpPRC = date('Y',strtotime($row['dateIPCR']));
		$dateEmpInac = date('Y',strtotime($row['dateInactivated']));
		if($file>=$dateEmpPRC) {
			if ($row['employmentStatus']=="PERMANENT") {
				$permanent .="
				<tr>
				<td>$NO</td>
				<td>$row[lastName]</td>
				<td>$row[firstName]</td>
				<td>$row[middleName]</td>
				<td>$row[extName]</td>
				<td width='50px'>$empdata[numerical]</td>
				<td width='50px'>$empdata[adjectival]</td>
				<td width='45%'>$empdata[comments]</td>
				</tr>
				";
			}else{
				$casual .= "
				<tr>
				<td>$NO</td>
				<td>$row[lastName]</td>
				<td>$row[firstName]</td>
				<td>$row[middleName]</td>
				<td>$row[extName]</td>
				<td width='50px'>$empdata[numerical]</td>
				<td width='50px'>$empdata[adjectival]</td>
				<td width='45%'>$empdata[comments]</td>
				</tr>
				";
			}
		}
		?>
		<?php
		$av +=$empdata['numerical'];
		$count++;
		$NO++;
	}
	$av = $av/$count;
}
?>


<table id="_table" class="customTable customTable2">
	<thead style="background-color: lightgrey;">
		<tr>
			<th rowspan="2">NO.</th>
			<th colspan="4">Name</th>
			<th rowspan="2">Numerical Rating</th>
			<th rowspan="2">Adjectival Rating</th>
			<th rowspan="2">Comments</th>
		</tr>
		<tr>
			<th>Last Name</th>
			<th>Given Name</th>
			<th>MI</th>
			<th style="font-size:10px;width: 30px">Name Ext.</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th colspan="8">Permanent</th>
		</tr>
		<?=$permanent?>
		<tr>
			<th colspan="8">Casual</th>
		</tr>
		<?=$casual?>
		<tr>
			<th colspan="5">Average</th>
			<td><?=bcdiv($av,1,2)?></td>
			<td><?=adjective($av)?></td>
			<td></td>
		</tr>
	</tbody>
</table>


<?php
function adjective($av){
	if ($av<=1) {
		return "Poor";
	}else if($av<=2&&$av>=0){
		return "Unsatisfactory";
	}else if($av<=3 && $av>=2){
		return "Satisfactory";
	}else if($av<=4 && $av>=3){
		return "Very Satisfactory";
	}else if($av<=5 && $av>=4){
		return "Outstanding";
	}else{
		return "Undefined value";
	}
}
function empdata($mysqli,$a,$type,$id){
	$sql = "SELECT * from prr where year='$a[year]' AND period ='$a[period]' AND type ='$type'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	$sql = "SELECT * from prrlist where prr_id='$row[prr_id]' AND employees_id='$id'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	return $row;
}
?>
