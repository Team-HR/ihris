<?php
require_once "_connect.db.php";
?>

<?php
// addpos starts here
if (isset($_POST["addPosition"])) {

	$position = addslashes($_POST["position"]);
	$functional = addslashes($_POST["functional"]);
	if (isset($_POST["level"])) {
		$level = $_POST["level"];
		$category = $_POST["category"];

	} else {
		$level = "";
		$category = "";
	}
	$salaryGrade = $_POST["salaryGrade"];
	
	//check first if the post is already in the database
	$sql = "SELECT * FROM `positiontitles` WHERE `position` = '$position' AND `functional` = '$functional'";
	$result = $mysqli->query($sql);
	if ($result->num_rows == 0) {
	//If None existing Add to DB
		if (!empty($position)) {
			$sql="INSERT INTO `positiontitles` (`position_id`, `position`,`functional`,`level`,`category`,`salaryGrade`) VALUES (NULL, '$position','$functional','$level','$category','$salaryGrade')";
			$mysqli->query($sql);
			echo "1";
		}
	} else {
	// echo "Position Title Already Existed!";
		echo "2";
	}


}
// addpos ends here
	// load starts here
elseif (isset($_POST["load"])){
$sql = "SELECT * FROM `positiontitles` ORDER BY `position` ASC";
$result = $mysqli->query($sql);
$counter = 0;
while ($row = $result->fetch_assoc()) {
	$counter++;
	$position_id = $row["position_id"];
	$position = addslashes($row["position"]);
	$functional = addslashes($row["functional"]);
	$level = $row["level"];
	$category = $row["category"];
	$salaryGrade = $row["salaryGrade"];
?>
	<tr id="<?php echo $position_id."row";?>">
		<td><?php  echo "(".$counter.")"?></td>
		<td><?php echo $position;?></td>
		<td><?php echo $functional;?></td>
		<td><?php echo $level;?></td>
		<td><?php echo $category;?></td>
		<td><?php echo $salaryGrade;?></td>
		<td class="right aligned">
			<i class="edit outline icon" title="Edit" style="cursor: pointer;" onclick="editPos(<?php echo "'".$position_id."','".addslashes($position)."','".addslashes($functional)."','".$level."','".$category."','".$salaryGrade."'";?>)"></i>
			<i class="trash alternate outline icon" title="Delete" style="cursor: pointer;" onclick="deleteRow('<?php echo $position_id; ?>')"></i>
		</td>
	</tr>
<?php
	}
}
// load ends here

//editPost start
elseif (isset($_POST["editPosition"])) {
	$position_id = $_POST["position_id"];
	$position = addslashes($_POST["position"]);
	$functional = addslashes($_POST["functional"]);
	$level = $_POST["level"];
	$category = $_POST["category"];
	$salaryGrade = $_POST["salaryGrade"];
	$sql = "UPDATE `positiontitles` SET `position` = '$position',`functional` = '$functional', `level` = '$level', `category` = '$category', `salaryGrade` = '$salaryGrade' WHERE `position_id` = '$position_id'";
	$mysqli->query($sql);
	echo "#".$position_id."row";
}
//editPost end

// deleteRow Start
elseif (isset($_POST["deletePosition"])) {
	$position_id = $_POST["position_id"];
	$sql = "DELETE FROM `positiontitles` WHERE `positiontitles`.`position_id` = '$position_id'";
	$mysqli->query($sql);
}
// deleteRow End
?>