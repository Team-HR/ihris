<?php
require_once "_connect.db.php";
require_once "./libs/Pms.php";

// $employee_id = 21136; //jkbriones
// $employee_id = 22012; //gctuale
$employee_id = 21615;

// $department_id = 21; //gso
// $department_id = 11; //cho
$department_id = 4;
$period_id = 2;

$pms = new Pms();
$pms->set_employee_id($employee_id);
$pms->set_period_id($period_id);
$pms->set_department_id($department_id);

// $data = $pms->get_core_function_rating();
echo $pms->get_final_numerical_rating();

$data = [
    $pms->get_strategic_function_rating(),
    $pms->get_core_function_rating(),
    $pms->get_support_function_rating()
];
// $data = $pms->get_support_function_rating();
// $mi_incharge = [];
// $sql = "SELECT * FROM `spms_corefunctions` LEFT JOIN `spms_matrixindicators` ON `spms_corefunctions`.`cf_ID` = `spms_matrixindicators`.`cf_ID` WHERE  `spms_corefunctions`.`mfo_periodId` = '$period_id' AND `spms_matrixindicators`.`mi_incharge` LIKE '%$employee_id%'";
// $res = $mysqli->query($sql);
// while ($row = $res->fetch_assoc()) {

//     $mi_incharge = [];
//     if (isset($row["mi_incharge"])) {
//         $mi_incharge = explode(",", $row["mi_incharge"]);
//     }
//     $row["mi_incharge"] = $mi_incharge;

//     if (in_array($employee_id, $mi_incharge)) {
//         $mi_incharge[] = $row["mi_id"];
//     }
// }

// $spms_corefucndata = [];
// $mi_incharge = implode(",", $mi_incharge);

// $sql = "SELECT * FROM `spms_corefucndata` WHERE `p_id` IN ($mi_incharge)";
// $res = $mysqli->query($sql);

// while ($row = $res->fetch_assoc()) {
//     $spms_corefucndata[] = $row;
// }


echo "<pre>";
print_r($data);
echo "</pre> <br/>";
// echo $data = $pms->get_numerical_rating();
