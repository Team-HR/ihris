<?php
require_once "_connect.db.php";
require_once "./libs/config_class.php";

// $employee_id = 21615;
// $period_id = 2;
// $department_id = 4;

// $employee_data = new Employee_data($mysqli);
// $employee_data->set_emp($employee_id);
// $employee_data->set_period($period_id);

// $data =  $employee_data->get_final_numerical_rating();

// $data = $employee_data->coreAr();
// echo "<pre>";
// print_r($data);
// echo "</pre>";
// $data = [];
// $sql = "SELECT * from spms_corefunctions where parent_id='' and mfo_periodId='$period_id' and `dep_id` = '$department_id' ORDER BY `spms_corefunctions`.`cf_count` ASC";
// $res = $mysqli->query($sql);
// while ($row = $res->fetch_assoc()) {
//     $data[] = $row;
// }
// echo "<pre>";
// print_r($data);
// echo "</pre> <br/>";

$date = format_date_ymd("11/13/22");

echo $date;

function format_date_ymd($date)
{
    if (!$date || $date == "0000-00-00") return "0000-00-00";
    $date = date_create($date);
    return date_format($date, "Y-m-d");
}
