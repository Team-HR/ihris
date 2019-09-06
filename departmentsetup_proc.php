<?php
require_once "_connect.db.php";
?>
<?php
// validation starts here
if (isset($_POST["addDepartment"])) {
	# code...
	$newDept = addslashes($_POST["newDept"]);
	if (!empty($newDept)) {
		# code...
		$sql = "SELECT `department` FROM `department` WHERE `department` = '$newDept'";
		$result = $mysqli->query($sql);
		if ($result->num_rows == 0) {
			# code...
			$sql = "INSERT INTO `department` (`department`) VALUES ('$newDept')";
			$mysqli->query($sql);
			echo "1";
		} else {
			echo "2";
		}
	}
}
// validation ends here
	// load starts here
elseif (isset($_POST["load"])){
?>
<table id="dept_table" class="ui blue selectable striped very compact small table">
  <thead>
    <tr>
      <th></th>	
      <th>Department</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
<?php 
$sql = "SELECT * FROM `department` ORDER BY `department` ASC";
$result = $mysqli->query($sql);
$counter = 0;
while ($row = $result->fetch_assoc()) {
	$counter++;
	$department_id = $row["department_id"];
	$department = $row["department"];
?>
	<tr>
		<td><?php  echo "( ".$counter." )"?></td>
		<td><?php echo $department;?></td>
		<td class="right aligned">
			<i class="edit outline icon" title="Edit" style="cursor: pointer;" onclick="editDept('<?php echo $department_id."','".addslashes($department);?>')"></i>
			<i class="trash alternate outline icon" title="Delete" style="cursor: pointer;" onclick="deleteRow('<?php echo $department_id; ?>')"></i>
		</td>
	</tr>
<?php
}
?>
  </tbody>
</table>
<?php
}
// load ends here
elseif (isset($_POST["editDepartment"])) {
	# code...
	$department = addslashes($_POST["department"]);
	$department_id = $_POST["department_id"];
	// UPDATE `department` SET `department` = 'City Administrator\'s Offices' WHERE `department`.`department_id` = 1;
	$sql = "UPDATE `department` SET `department` = '$department' WHERE `department`.`department_id` = '$department_id'";
	$mysqli->query($sql);
	echo "Success!";
}
elseif (isset($_POST["deleteDepartment"])) {
	# code...
	$department_id = $_POST["department_id"];
	$sql = "DELETE FROM `department` WHERE `department`.`department_id` = '$department_id'";
	$mysqli->query($sql);
}
?>