
<?php 
require_once "../../_connect.db.php";
$cdp_gender = $_POST['cdp_gender'];
$cdp_empStatus = $_POST['cdp_empStatus'];
$cdp_category = $_POST['cdp_category'];
$cdp_period = $_POST['cdp_period'];
$cdp_year = $_POST['cdp_year'];
$cdp_department = $_POST['cdp_department'];
 	
$empQuery = "";
if($cdp_empStatus){
	$empQuery .= "and `employees`.`employmentStatus`='$cdp_empStatus'";
}
if($cdp_department){
  $empQuery .= "and `employees`.`department_id`='$cdp_department'";
}
if($cdp_gender){
  $empQuery .= "and `employees`.`gender`='$cdp_gender'";
}
$sql = "SELECT * from `employees` left join `positiontitles` on `employees`.`position_id`=`positiontitles`.`position_id` left join `prrlist` on `employees`.`employees_id`=`prrlist`.`employees_id` left join `prr` on `prrlist`.`prr_id`=`prr`.`prr_id` left join `department` on `employees`.`department_id`=`department`.`department_id` where  `employees`.`status` = 'ACTIVE' $empQuery  and `positiontitles`.`category`='$cdp_category'  and `prr`.`period` = '$cdp_period' and `prr`.`year` = '$cdp_year'";
$sql = $mysqli->query($sql);
$rowView = "";
while ($row = $sql->fetch_assoc()) {
	$rowView .="
				<tr>
					<td style='width:20%'>$row[lastName] $row[firstName] $row[middleName]</td>
					<td>$row[department]</td>
          <td>$row[gender]</td>
					<td>$row[employmentStatus]</td>
					<td>$row[category]</td>
					<td> $cdp_period $cdp_year </td>
					<td style='width:40%'>$row[comments]</td>
				</tr>
	";
}
if($rowView==""){
	$rowView = "<tr><td colspan='5' style='text-align:center;font-size:20px;color:#00000082'>No Record Found</td></tr>";
}
 ?>
<table class="ui striped table" id="cdpResultTable">
  <thead>
    <tr>
      <th>Name</th>
      <th>Department</th>
      <th>Gender</th>
      <th>Employment Status</th>
      <th>Category</th>
      <th>Semester</th>
      <th>Comments</th>
    </tr>
  </thead>
  <tbody>
    <?=$rowView?>
  </tbody>
</table>