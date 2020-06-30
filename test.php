<?php
require "vendor/autoload.php";
require "_connect.db.php";

$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L',
    'margin_top' => 3,
	'margin_left' => 3,
    'margin_right' => 3,
    'margin_bottom' => 4,
    'margin_footer' => 1
]);

$mpdf->Bookmark('Start of the document');
$html = <<<EOD
<style>
    table, th, td {
        border: 1px inset grey;
        border-collapse: collapse;
        padding-left: 5px;
    }
    .rotate {
        -moz-transform: rotate(-90.0deg);
        -o-transform: rotate(-90.0deg);
        -webkit-transform: rotate(-90.0deg);
        filter: progid: DXImageTransform.Microsoft.BasicImage(rotation=0.083);
        -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)";
        transform: rotate(-90.0deg);
      }
</style>

<div style="position: fixed; left: 370px; top: 2px;">
    <img src="bayawanLogo.png" width="60">
</div>
<div style="text-align:center; width: 100%;">
    <p>Republic of the Philippines <br>
    Province of Negros Oriental <br>
    City of Bayawan</p>
</div>
<table>
    
    <tr>
        <th rowspan="2" style="white-space:nowrap">ITEM NO.</th>
        <th rowspan="2" style="white-space:nowrap">POSITION TITLE</th>
        <th rowspan="2" style="white-space:nowrap">FUNCTIONAL TITLE</th>
        <th rowspan="2">SG</th>
        <th colspan="2">ANNUAL SALARY</th>
        <th rowspan="2" text-rotate="90">STEP</th>
        <th colspan="2">AREA</th>
        <th rowspan="2" text-rotate="90">LEVEL</th>
        <th colspan="4" colspan="4">NAME OF INCUMBENT</th>
        <th rowspan="2" text-rotate="90">GENDER</th>
        <th rowspan="2">DATE OF BIRTH</th>
        <th rowspan="2">DATE OF ORIG. APPOINTMENT</th>
        <th rowspan="2">DATE OF LAST PROMOTION</th>
        <th rowspan="2">EMPLOYMENT STATUS</th>
        <th rowspan="2">ELIGIBILITY</th>
    </tr>
    <tr>
        <th>AUTHORIZED</th>
        <th >ACTUAL</th>
        <th text-rotate="90">CODE</th>
        <th text-rotate="90">TYPE</th>
        <th style="white-space:nowrap">LASTNAME</th>
        <th style="white-space:nowrap">FIRST NAME</th>
        <th style="white-space:nowrap">MIDDLE NAME</th>
        <th style="white-space:nowrap">EXT.</th>
    </tr>
    
    <tbody>
EOD;

$sql = "SELECT * FROM `ihris_dev`.`plantillas` WHERE `department_id` = '21' ORDER BY `item_no` ASC";
$result = $mysqli->query($sql);
while ($row = $result->fetch_assoc()) {

    $html .= <<<EOD
    <tr>
         <td>$row[item_no]</td>
         <td style="white-space:nowrap">$row[position_title]</td>
         <td style="white-space:nowrap">$row[functional_title]</td>
         <td>$row[sg]</td>
         <td>$row[authorized_salary]</td>
         <td>$row[actual_salary]</td>
         <td>$row[step]</td>
         <td>$row[area_code]</td>
         <td>$row[area_type]</td>
         <td>$row[level]</td>
         <td style="white-space:nowrap">$row[last_name]</td>
         <td style="white-space:nowrap">$row[first_name]</td>
         <td style="white-space:nowrap">$row[middle_name]</td>
         <td style="white-space:nowrap">$row[ext_name]</td>
         <td>$row[gender]</td>
         <td>$row[date_of_birth]</td>
         <td>$row[date_of_orig_appointment]</td>
         <td>$row[date_of_last_promotion]</td>
         <td>$row[status]</td>
         <td style="white-space:nowrap">$row[eligibility]</td>
     </tr>
    EOD;
    
}


$html .= <<<EOD
    </tbody>
</table>
<div style="page-break-inside: avoid;">
<div style="font-size: 10px; margin-top: 5px;">
    <strong>Total Number of Position Items: <span style="display: inline; width: 100px; border-bottom: 1px solid black;">79</span></strong>
    <p width="500" style="margin-top: 5px;">I certify to the correctness of the entries and that above Position Items are duly approved and authorized by
    the agency and in compliance to existing rules and regulations. I further certify that employees whose names
    appears above are the incumbents of the position.</p>
</div>
<table style="width:100%; font-size: 10px; border: none;">
<tr>
    <td colspan="2" style="border:none;"></td>
    <td colspan="2" style="border:none;">APPROVED BY:</td>
</tr>
<tr>
    <td style="text-align:center;border: none; font-weight: bold;">VERONICA GRACE P. MIRAFLOR</td>
    <td style="text-align:center;border: none;">JUNE 30, 2020</td>
    <td style="text-align:center;border: none; font-weight: bold;">PRYDE HENRY A. TEVES</td>
    <td style="text-align:center;border: none;">JUNE 30, 2020</td>
</tr>
<tr>
    <td style="text-align:center; border: none;">HRMO IV</td>
    <td style="text-align:center; border: none;">Date</td>
    <td style="text-align:center; border: none;">CITY MAYOR</td>
    <td style="text-align:center; border: none;">Date</td>
</tr>
</table>
</div>
EOD;
  $mpdf->defaultheaderline = 0;
  $mpdf->defaultfooterline = 0;
  $mpdf->defaultfooterline = 0;
  $mpdf->setFooter('Page {PAGENO} of {nb}');
$mpdf->WriteHTML($html);
$mpdf->Output();