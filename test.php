<?php
require "_connect.db.php";
$employee_id = 124  ;
$data = [];
$sql = "SELECT `id` FROM `pds` WHERE `pds`.`employee_id` = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i',$employee_id);
$stmt->execute();
$stmt->store_result();
$num_rows = $stmt->num_rows;
$stmt->close();

if( $num_rows == 0){
    $sql = "INSERT INTO `pds` (`employee_id`) VALUES (?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i',$employee_id);
    $stmt->execute();
    $stmt->close();
}

$sql = "SELECT `employees`.`lastName`,`employees`.`firstName`,`employees`.`middlename`,`employees`.`extName`,`pds`.* FROM `employees` LEFT JOIN `pds` ON `employees`.`employees_id` = `pds`.`employee_id` WHERE `employees`.`employees_id` = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i',$employee_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();


echo "<pre>".print_r($data,true)."</pre>";

