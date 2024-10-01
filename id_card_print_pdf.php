<?php
require "vendor/autoload.php";
require 'libs/PlantillaPermanent.php';
require "_connect.db.php";

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8', 'format' => 'A4',
    'margin_top' => 5,
    'margin_left' => 3,
    'margin_right' => 3,
    'margin_bottom' => 5,
    'margin_footer' => 1,
    'default_font' => 'helvetica'
]);

$employee_id = $_GET["employee_id"];
$sql = "SELECT * FROM `employees` WHERE `employees_id` = '$employee_id'";
$res = $mysqli->query($sql);

$full_name = "";
if ($emp = $res->fetch_assoc()) {
    $full_name = $emp["lastName"] . ", " . $emp["firstName"] . "_" . $employee_id;
}

$mpdf->Bookmark('Start of the document');

$front_id = $employee_id . "_front.jpeg";
$back_id = $employee_id . "_back.jpeg";

$html = <<<EOD
    <img height="3.375in" width="2.125in" src="id_cards/$front_id" style="padding-right: 5px; border-right: 1px solid #e2e2e2; border-right-style: dashed;"/>
    <img height="3.375in" width="2.125in" src="id_cards/$back_id" style="padding-left: 3px;"/>
EOD;

$mpdf->defaultheaderline = 0;
$mpdf->defaultfooterline = 0;
$mpdf->defaultfooterline = 0;

$mpdf->WriteHTML($html);

$mpdf->Output("$full_name.pdf", 'I');
