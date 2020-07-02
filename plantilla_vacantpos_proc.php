<?php
require_once "_connect.db.php";
?>




<?php
if(isset($_POST["load"])){
$sql = "SELECT * FROM `plantillas_test` LEFT JOIN `department` ON `plantillas_test`.`department_id` = `department`.`department_id`  
									LEFT JOIN `positiontitles` ON `plantillas_test`.`position_title` = `positiontitles`.`position_id` 
									LEFT JOIN `employees` ON `plantillas_test`.`incumbent` = `employees`.`employees_id` WHERE `incumbent` = ''

									
			ORDER BY `item_no` DESC";	

$result = $mysqli->query($sql);
echo $mysqli->error;
$counter = 0;
while ($row = $result->fetch_assoc()) {

	$id = $row["id"];
	$item_no = $row["item_no"];
	$page_no = $row["page_no"];
	$position= addslashes($row["position"]);
	$functional_title = addslashes($row["functional"]);
		if (!$functional_title) {
			$functional_title = "<i style='color:grey'>N/A</i>";
		}
	$department = $row["department"];
	$vacated_by = addslashes($row["vacated_by"]);
?>
	<tr id="<?php echo $id."row";?>" style="text-align:center">
		<td><?php echo $item_no;?></td>
		<td><?php echo $position;?>( <?php echo $functional_title;?>)</td>
		<td><?php  echo $department?></td>
		<td><?php  echo $vacated_by?></td>
		<td class=" align">
			 <button class="ui icon mini green button" id="publishBtn" onclick="publish()">Publish<i onclick="()" style="margin-right: 5px; text-align: center" title="Publish"></i></button>
			 <button class="ui icon mini red button" id="restoreBtn" onclick="restore()">Restore<i onclick="()" style="margin-right: 5px; text-align: center" title="Publish"></i></button>
		
	</tr>
<?php
	}
}

?>