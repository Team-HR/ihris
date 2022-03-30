<?php
	require_once "../_connect.db.php";

	if(isset($_POST['checkEmpty'])){
		$query = "SELECT * from `prrlist` where appraisal_type=''";
		$query = $mysqli->query($query);
		echo $query->num_rows;
	}elseif (isset($_POST['aditApp'])) {
		$query = "SELECT * from `prrlist` where appraisal_type=''";
		$query = $mysqli->query($query);
		while ($ar=$query->fetch_assoc()) {
			$sql = "UPDATE `prrlist` SET `appraisal_type` = 'Semestral' WHERE `prrlist`.`prrlist_id` = '$ar[prrlist_id]'";
			$sql = $mysqli->query($sql);
		}

	}



?>