<?php
//============================================================+
// File name   : form_CS_form32_revision_2017.php
// Begin       : 2023-11-07
// Last Update : 
//
// Description : Oath of Office Certification
//               
//
// Author: Franz Joshua A. Valencia
//
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: HTML tables and table headers
 * @author Nicola Asuni
 * @since 2009-03-20
 */

// Include the main TCPDF library (search for installation path).
require_once('TCPDF-master/tcpdf.php');
require "vendor/autoload.php";
require_once('_connect.db.php');
require "libs/models/Employee.php";
require "libs/models/Plantilla.php";
// require "libs/NumberToWords.php";

$appointment_id = $_GET["appointment_id"];

$mpdf = new \Mpdf\Mpdf([
  'mode' => 'utf-8',
  'format' => 'A4',
  'margin_top' => 10.27,
  'margin_left' => 20.54,
  'margin_right' => 20.54,
  'margin_bottom' => 0.95,
  'margin_footer' => 1,
  'default_font' => 'Arial'
]);

$data = get_data($mysqli, $appointment_id);

$name = $data["name"] ? blanks() . "$data[name]" . blanks() : blanks(20);
$address = $data["address"] ? blanks() . "$data[address]" . blanks() : blanks(20);
$position_title = $data["position_title"] ? blanks() . "$data[position_title]" . blanks() : blanks(20);
$printed_name =  $data["name"] ? blanks() . "$data[name]" . blanks() : blanks(20);
// to dynamically change width of the signatory field
$printed_name_div_width = intval(strlen($data['name']) / 4);
$printed_name_div_width = $printed_name_div_width > 7 ? $printed_name_div_width : 7;

$gov_id_type = $data["gov_id_type"] ? $data["gov_id_type"] : blanks(10);
$gov_id_num = $data["gov_id_num"] ? $data["gov_id_num"] : blanks(10);
$gov_id_date_issued = $data["gov_id_date_issued"] ? $data["gov_id_date_issued"] : blanks(10);

$sworn_day = $data["sworn_day"] ? $data["sworn_day"] : blanks(4);
$sworn_month = $data["sworn_month"] ? $data["sworn_month"] : blanks(10);
$sworn_year = $data["sworn_year"] ? $data["sworn_year"] : blanks(2); //only the last 2 digits of the year
$sworn_in = $data["sworn_in"] ?  $data["sworn_in"] : blanks(40);

$appointing_authority = $data['appointing_authority'] ? $data['appointing_authority'] : blanks(15);
$appointing_authority_div_width = $data['appointing_authority'] ? intval(strlen($data['appointing_authority']) / 3) : 6;


$html = <<<HTML
    <i style="font-size:12pt;">CS Form No.32</i><br>
    <i style="font-size:9pt;">Revised 2017</i>
    <br><br><br>
   <div style="text-align:center;">
    <div style="font-size:14pt"><b>REPUBLIC OF THE PHILIPPINES</b></div>
    <div style="font-size:13pt"> Province of Negros Oriental</div>
    <div>City of Bayawan</div>
    <br><br>
    <div style="font-size:16pt"><b>OATH OF OFFICE</b></div>
    <br><br>
    <br><br>
  </div>
                     <p style="text-align: justify; text-indent:30px; line-height: 2em;"> I, <u>{$name}</u> of <u>{$address}</u>  having been appointed to the position of <u>{$position_title}</u> hereby solemnly swear, that I will faithfully discharge to the best of my ability, the duties of my present position and of all others that I may hereafter hold under the Republic of the Philippines; that I will bear true faith and allegiance to the same; that I will obey the laws, legal orders, and decrees promulgated by the duly constituted authorities of the Republic of the Philippines; and that I impose this obligation upon myself voluntarily, without mental reservation or purpose of evasion.
                    </p>
                    <p style="text-align: justify; text-indent:30px" >SO HELP ME GOD.</p>
                    <br>
                    <br> 

                    <div style="width: {$printed_name_div_width}cm; float: right; text-align:center; ">
                      <u>{$printed_name}</u>
                      <br>
                      (Signature over Printed Name of the Appointee)
                  </div>

                  <div style="clear:both "></div>

                  <br>
                  <br>
<table style="font-size:12px;">
  <tr>
    <td>Government ID:</td>
    <td><u>{$gov_id_type}</u></td>
  </tr>
  <tr>
    <td>ID NUmber:</td>
    <td><u>{$gov_id_num}</u></td>  
  </tr>
  <tr>
    <td>Date Issued:</td>
    <td><u>{$gov_id_date_issued}</u></td>
  </tr>
</table>
<br>
<div style="border: 1px solid black; border-style: solid double; height: 4px;"></div>
<br>
    <p style="text-align: justify; text-indent:30px; line-height: 2em;"> Subscribed and sworn to before me this <u>{$sworn_day}</u> day of <u>{$sworn_month}</u>, 20<u>{$sworn_year}</u> in <u>{$sworn_in}</u>.</p>
<br>
<br>
<br>
<br>

  
<div style="width: {$appointing_authority_div_width}cm; float: right; text-align:center; font-size: 12pt;">
  <u>{$appointing_authority}</u>
  <br>
  CITY MAYOR
</div>

<div style="clear:both "></div>

HTML;


// printf($html);
$mpdf->WriteHTML($html);
$mpdf->Output("CS Form No32.pdf - Oath of Office.pdf", 'I');


function get_data($mysqli, $appointment_id)
{

  $employee = new Employee;
  $plantilla = new Plantilla;

  $data = [
    "name" => "",
    "address" => "",
    "position_title" => "",
    "gov_id_type" => "",
    "gov_id_num" => "",
    "gov_id_date_issued" => "",
    "sworn_day" => "",
    "sworn_month" => "",
    "sworn_year" => "",
    "sworn_in" => "",
    "appointing_authority" => "",
  ];

  $sql = "SELECT * FROM `appointments` WHERE `appointment_id` = '$appointment_id';";
  $res = $mysqli->query($sql);
  if ($row = $res->fetch_assoc()) {
    $data["name"] = $employee->get_full_name_upper_std($row["employee_id"]);
    $data["address"] = $row["address"];
    $plantilla = $plantilla->get_plantilla_data($row["plantilla_id"]);
    $data["position_title"] = $plantilla["position"]["position"];
    $data["position_title"] .= $plantilla["position"]["functional"] ? " (" . $plantilla["position"]["functional"] . ") " : "";
    $data["gov_id_type"] = $row["govId_type"];
    $data["gov_id_num"] = $row["govId_no"];
    $data["gov_id_date_issued"] = $row["govId_issued_date"];

    $date = DateTime::createFromFormat("Y-m-d", $row["sworn_date"]);

    $data["sworn_day"] = $date->format("jS");
    $data["sworn_month"] = $date->format("F");
    $data["sworn_year"] = $date->format("y");
    $data["sworn_in"] = $row["sworn_in"];
    $data["appointing_authority"] = $row["appointing_authority"];
  }

  return $data;
}


function blanks($x = 1)
{
  $blanks = "";

  $i = 0;
  while ($i < $x) {
    $blanks .= "&nbsp;&nbsp;&nbsp;";
    $i++;
  }
  return $blanks;
}
