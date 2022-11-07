<?php
require_once "_connect.db.php";
require_once "./libs/Pms.php";


$pms = new Pms;

$pms->set_period_id(2);
$pms->set_employee_id(22012);
$pms->set_department_id(21);

$data = $pms->get_numerical_rating();

echo $data;
// echo "<pre>";
// echo print_r($data);
// echo "</pre>";
