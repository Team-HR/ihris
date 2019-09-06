<!-- <?php
require "_connect.db.php";


if (isset($_POST["load"])) {
	// $sql = "SELECT * FROM `employees` WHERE `position_id` != '200' ORDER BY `lastName` ASC";
	$prr_id = $_POST["prr_id"];
	$type = $_POST["type"];

	$sql = "SELECT * FROM `employees` ORDER BY gender ASC , lastName ASC ";	

	// $sql = "SELECT * FROM `employees` WHERE `employees_id` IN (SELECT `employees_id` FROM `prrlist` WHERE `prr_id` = '$prr_id') ORDER BY `lastName` ASC";
	$result = $mysqli->query($sql);
	$counter = 1;
	$entry = 0; 
	$Average =0;
	while ($row = $result->fetch_assoc()) {
		$employees_id = $row["employees_id"];
		$lastName = $row["lastName"];
		$firstName = $row["firstName"];
		$middleName = mb_convert_case($row["middleName"],MB_CASE_TITLE, "UTF-8");
		$extName = $row["extName"];
		$gender = $row["gender"];

	$sql1 = "SELECT * from prrlist where prr_id='$prr_id' AND employees_id='$employees_id'";
	$result1 = $mysqli->query($sql1);
	$row1 = $result1->fetch_assoc();
	$i=0;
	if ($result1->num_rows==0) {
		$i = 0;
	}else{
		$i=$row1['prrlist_id'];
	}

	if($row1['stages']=='Y'){
		$color = 'YELLOW';
	}else if($row1['stages']=='W'){
		$color = "WHITE";
	}else{
		$color = "CYAN";
	}
?>

<tr style="background: <?=$color?>">
	<td>
		<a href="employeeinfo.php?employees_id=<?php echo $employees_id;?>&spms" title="Open"> <i class="icon folder"></i> </a>
	</td>
	<td>1712<?php echo $counter++;?></td>
	<td><?php echo mb_convert_case($lastName,MB_CASE_TITLE, "UTF-8");?></td>
	<td><?php echo mb_convert_case($firstName,MB_CASE_TITLE, "UTF-8");?></td>
	<td align="center"><?php echo mb_convert_case($middleName[0],MB_CASE_TITLE, "UTF-8");?></td>
	<td align="center"><?php echo $extName;?></td>
	<td align="center"><?php echo $gender[0];?></td>
	<td><?=$row1['date_submitted']?></td>
	<td><?=$row1['appraisal_type']?></td>
	<td><?=$row1['date_appraised']?></td>
	<td><?=$row1['numerical']?></td>
	<td><?=$row1['adjectival']?></td>
	<td><?=$row1['remarks']?></td>
	<td class="noprint">
		<button class="ui inverted green tiny icon button" onclick="ratingModal(<?=$i?>,<?=$employees_id?>,<?=$prr_id?>)">
			<i class="edit icon" data-content="Add users to your feed"></i>
		</button>
	</td>
	<td class="noprint">
		<button class="ui inverted blue tiny icon button" onclick="stateColor(<?=$i?>,<?=$employees_id?>,<?=$prr_id?>,'C')">
		</button>
	</td>	
	<td class="noprint">
		<button class="ui inverted yellow tiny icon button" onclick="stateColor(<?=$i?>,<?=$employees_id?>,<?=$prr_id?>,'Y')">
		</button>
	</td>	
	<td class="noprint">
		<button class="ui inverted black tiny icon button" onclick="stateColor(<?=$i?>,<?=$employees_id?>,<?=$prr_id?>,'W')">
		</button>
	</td>
</tr>

<?php
$entry++;
$Average += $row1['numerical']; 
	}

	$Average = $Average/$entry;
}
?>
<tr>
	<th colspan="5" style="text-align: right;">Overall Entries:</th>
	<th colspan="3"><?=$entry?></th>
	<th colspan="2" style="text-align: right;"> Total Average:</th>
	<th colspan="7" style="text-align: left;"><?=bcdiv($Average,1,2)?></th>
</tr>

 -->
