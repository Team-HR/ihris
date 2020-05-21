<?php
require_once '../_connect.db.php';

if (isset($_GET['getEmployeeData'])) { 
    $employee_id = $_GET['employee_id'];
    $data = [];
    $sql = "SELECT * FROM `employees` LEFT JOIN `pds` ON `employees`.`employees_id` = `pds`.`employee_id` WHERE `employees`.`employees_id` = '$employee_id'";
    $result = $mysqli->query($sql);
    $data = $result->fetch_assoc();
    echo json_encode($data);
}
