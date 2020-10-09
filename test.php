<?php
require_once "_connect.db.php";
require './libs/PlantillaPermanent.php';
require "./libs/ItemNumbersSorter.php";

// http://localhost/ihris/plantilla_report_print.php?status=permanent&gender=all&date=2020-10-08&department_id=1

$sql = "SELECT plantillas.*,positiontitles.position,positiontitles.functional,positiontitles.salaryGrade,positiontitles.category,appointments.*,employees.firstName,employees.middleName,employees.lastName,employees.extName,pds_personal.gender,pds_personal.birthdate FROM `plantillas` LEFT JOIN `positiontitles` ON `plantillas`.`position_id`=`positiontitles`.`position_id` LEFT JOIN `appointments` ON `plantillas`.`incumbent`=`appointments`.`appointment_id` LEFT JOIN `employees` ON `appointments`.`employee_id`=`employees`.`employees_id` LEFT JOIN `pds_personal` ON `employees`.`employees_id`=`pds_personal`.`employee_id` WHERE `plantillas`.`department_id`=1 ORDER BY `item_no` ASC";
$stmt = $mysqli->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$plantilla = new PlantillaPermanent();

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$arr = [
    "ADM-1",
    "ADM-1.1",
    "ADM-2",
    "ADM-2.1",
    "ADM-7",
    "ADM-7.1",

];
$sorter = new ItemNumbersSorter($arr);
echo "<pre>" . print_r($sorter, true) . "</pre>";

// get item numbers


$item_nos = array_column($data, 'item_no');
$sorted_item_nos = new ItemNumbersSorter($item_nos);
echo "<pre>" . print_r($sorted_item_nos->arr, true) . "</pre>";


$sorted_data = array();
foreach ($sorted_item_nos->arr as $item_no) {
    echo $item_no . "<br/>";
    foreach ($data as $item) {
        if ($item_no === $item['item_no']) {
            $sorted_data[] = $item;
            break;
        }
    }
}
echo "<pre>" . print_r($sorted_data, true) . "</pre>";
