<?php
require '_connect.db.php';


if (isset($_POST["loadRequests"])){
	$sql = "SELECT id,name,username,created_at,employees_id,type,datetime_confirmed FROM `users` WHERE `type` IS NULL";
	$stmt = $mysqli->prepare($sql);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($id,$name,$username,$created_at,$employees_id,$type,$datetime_confirmed);
	$counter = 1;
	if ($stmt->num_rows === 0) {
		echo "0";
?>

<tr style="">
	<td colspan="5" style="text-align: center; color: lightgrey;"><i>There are no requests.</i></td>
</tr>

<?php
		
	} else {
	while ($result = $stmt->fetch()) {
?>

<tr style="background-color: #dfffdf;">
	<td><?=$counter++.".)"?></td>
	<td><?=$name?></td>
	<td><?=$username?></td>
	<td><?=formatDate($created_at)?></td>
	<!-- <td><?=$type?></td> -->
	<!-- <td><?=$datetime_confirmed?></td> -->
	<td>		
		<button class="ui mini blue basic button" onclick="sign('admin','<?=$id;?>')" style="margin: 0px;">As Admin</button>
	</td>
	<td>		
		<button class="ui mini blue basic button" onclick="sign('user','<?=$id;?>')" style="margin: 0px;">As User</button>
	</td>
	<td>		
		<button class="ui mini red basic button" onclick="sign('denied','<?=$id;?>')" style="margin: 0px;"><i class="icon ban"></i> Deny</button>
	</td>
</tr>

<?php

		}
	}
	$stmt->close();
}


elseif (isset($_POST["register"])) {
    $usrdata = $_POST["usrdata"];
    $name = $usrdata[0]." ".$usrdata[1]." ".$usrdata[2]." ".$usrdata[3];
    $username = $usrdata[4];
    $password = $usrdata[5];
    $type = $usrdata[6];
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, username, password, type) VALUES (?,?,?,?)";

    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("ssss", $name, $username, $password_hashed, $type);
        if ($stmt->execute()) {
            echo "0";
        } else {
            echo "1";
        }
    }

    $stmt->close();
    $mysqli->close();
}


elseif (isset($_POST["loadConfirmed"])) {
	$sql = "SELECT id,name,username,created_at,employees_id,type,datetime_confirmed FROM `users` WHERE 	`type` != ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("s",$type);
	$type = "denied";
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($id,$name,$username,$created_at,$employees_id,$type,$datetime_confirmed);
	$counter = 1;
	while ($result = $stmt->fetch()) {
?>

<tr>
	<td><?=$counter++.".)"?></td>
	<td><?=$name?></td>
	<td><?=$username?></td>
	<td><?=formatDate($created_at)?></td>
	<td><?=$type?></td>
	<td><?=formatDate($datetime_confirmed)?></td>
	<td>
		<button class="ui basic mini button" onclick="confOption('<?= $id;?>');" style="margin: 0px;">Options</button>
	</td>
</tr>

<?php
	}
		if ($stmt->num_rows === 0) {
		echo "0";
?>

<tr style="">
	<td colspan="6" style="text-align: center; color: lightgrey;"><i>There are no confirmed accounts.</i></td>
</tr>

<?php
		
	}
	$stmt->close();
} 


elseif (isset($_POST["loadDenied"])) {

	$sql = "SELECT id,name,username,created_at,employees_id,type,datetime_confirmed FROM `users` WHERE `type` = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("s",$type);
	$type = "denied";
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($id,$name,$username,$created_at,$employees_id,$type,$datetime_confirmed);
	$counter = 1;
	while ($result = $stmt->fetch()) {
?>

<tr>
	<td><?=$counter++.".)"?></td>
	<td><?=$name?></td>
	<td><?=$username?></td>
	<td><?=formatDate($created_at)?></td>
	<td><?=$type?></td>
	<td><?=formatDate($datetime_confirmed)?></td>
	<td>
		<button class="ui basic mini blue button" onclick="sign('admin','<?=$id;?>')" style="margin: 0px;">Reactivate as Admin</button>
	</td>
	<td>
		<button class="ui basic mini blue button" onclick="sign('user','<?=$id;?>')" style="margin: 0px;">Reactivate as User</button>
	</td>
</tr>

<?php
	}

	if ($stmt->num_rows === 0) {
		echo "0";
?>

<tr style="">
	<td colspan="6" style="text-align: center; color: lightgrey;"><i>There are no denied requests.</i></td>
</tr>

<?php
		
	}

	$stmt->close();

}

elseif (isset($_POST["sign"])) {
	$data = $_POST["data"];
	$type = $data[0];
	$id = $data[1];

	$datetime_confirmed = date("Y-m-d H:i:s");
	$sql = "UPDATE `users` SET `type` = ?, `datetime_confirmed` = ? WHERE `users`.`id` = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("ssi", $type, $datetime_confirmed, $id);
	$stmt->execute();
	$stmt->close();
}



function formatDate($numeric_date){
	  $date = new DateTime($numeric_date);
		$strDate = $date->format('F d, Y h:i:s a');
		return $strDate;
}

?>