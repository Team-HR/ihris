<?php
require_once "_connect.db.php";
require_once "./libs/config_class.php";
$employee_data = new Employee_data($mysqli);
$employee_data->set_emp(21615);
$employee_data->set_period(2);

echo $employee_data->get_final_numerical_rating();

echo "<pre>";
// print_r($data);
echo "</pre> <br/>";
// echo $data = $pms->get_numerical_rating();
