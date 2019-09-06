<?php
include_once '_connect.db.php';

$sql = "SELECT `applicant_id`,`num_years_in_gov` FROM `rsp_applicants`";

$stmt = $mysqli->prepare($sql);
$stmt->execute();

$stmt->store_result();
$stmt->bind_result($id,$yrs);
while ($stmt->fetch()) {
	// echo "$yrs<br>";
	echo $id."<br>";
	echo json_encode($s_yrs = unserialize($yrs));
	echo "<br>";
	if (!isset($s_yrs["Temporary"])) {
		$s_yrs = array("Temporary" => "") + $s_yrs;
		update($id,$s_yrs,$mysqli);
		var_dump($s_yrs);
		echo "<br>"; 
	} else {
		var_dump($s_yrs);
		echo "<br>"; 
	}
}
$stmt->close();


function update($id,$arr,$mysqli){
	$s_arr = serialize($arr);
	$sql = "UPDATE `rsp_applicants` SET `num_years_in_gov` = '$s_arr' WHERE `rsp_applicants`.`applicant_id` = '$id'";
	$mysqli->query($sql);

}
