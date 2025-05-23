<?php
require "vendor/autoload.php";
require 'libs/PlantillaPermanent.php';
require "_connect.db.php";

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'margin_top' => 5,
    'margin_left' => 3,
    'margin_right' => 3,
    'margin_bottom' => 5,
    'margin_footer' => 1,
    'default_font' => 'helvetica'
]);


$employeeIds = $_GET["employeeIds"];
$departmentId = $_GET["departmentId"];

$sql = "SELECT * FROM `department` WHERE `department_id` = '$departmentId'";
$res = $mysqli->query($sql);
$row = $res->fetch_assoc();
$department = isset($row["alias"]) ? $row["alias"] : '';


$employeeIds = explode(",", $employeeIds);

$mpdf->Bookmark('Start of the document');

$html = "";
foreach ($employeeIds as $key => $employee_id) {
    $front_id = $employee_id . "_front.jpg";
    $back_id = $employee_id . "_back.jpg";
    $html .= <<<EOD
    <div style="display: block">
        <img height="3.375in" width="2.125in" src="id_cards/$front_id" style="padding-right: 5px; border-right: 1px solid #e2e2e2; border-right-style: dashed;"/>
        <img height="3.375in" width="2.125in" src="id_cards/$back_id" style="padding-left: 3px;"/>
    </div>
EOD;
}


$mpdf->defaultheaderline = 0;
$mpdf->defaultfooterline = 0;
$mpdf->defaultfooterline = 0;

$mpdf->WriteHTML($html);

$timestamp = time();

$mpdf->Output($department . "_" . $timestamp . ".pdf", 'I');
