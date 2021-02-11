<?php
require "vendor/autoload.php";
require "_connect.db.php";

$mpdf = new \Mpdf\Mpdf([
  'mode' => 'utf-8', 'format' => 'A4-L',
  'margin_top' => 5,
  'margin_left' => 3,
  'margin_right' => 3,
  'margin_bottom' => 5,
  'margin_footer' => 1,
  'default_font' => 'helvetica'
]);

$mpdf->Bookmark('Start of the document');

$html = <<<EOD
TESTING
EOD;

$mpdf->defaultheaderline = 0;
$mpdf->defaultfooterline = 0;
$mpdf->defaultfooterline = 0;

$mpdf->WriteHTML($html);
$department = $department?$department:"NODEPTSELECTED";
$status = $status=="permanent"?"PERMANENT":$status;
$gender = $gender=="all"||$gender==""?"M&F":$gender;
// $mpdf->Output("PLANTILLA $department-$status-$gender as of $date.pdf", 'I');
$mpdf->Output("plantilla_test.pdf", 'I');