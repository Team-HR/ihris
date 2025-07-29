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
require "libs/models/Position.php";
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
$department = $data["department"] ? blanks() . "$data[department]" . blanks() : blanks(20);;
$date_of_appointment = $data["date_of_appointment"] ? blanks() . "$data[date_of_appointment]" . blanks() : blanks(20);
$address_of_assumption = $data["address_of_assumption"] ? blanks() . "$data[address_of_assumption]" . blanks() : blanks(20);



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

$hrmo = $data['hrmo'] ? $data['hrmo'] : blanks(15);
$hrmo_div_width = $data['hrmo'] ? intval(strlen($data['hrmo']) / 3) : 6;
$hrmo_position = $data['hrmo_position'] ? $data['hrmo_position'] : blanks(15);


$html = <<<HTML
   <!-- html starts here -->
   <i style="font-size: 12pt;">CS Form No.4</i><br>
   <i style="font-size: 9pt;">Series of 2017</i>
    <br>
    <br>
    <br>
   <div style="text-align: center;"><b style="font-size:17px"> REPUBLIC OF THE PHILIPPINES</b><br>
      <p style="font-size:15px"> Province of Negros Oriental</b><br>
      <b>City of Bayawan</b></p><br><br>
      <b style="font-size:20px">CERTIFICATION OF ASSUMPTION TO DUTY</b>
      <br><br>
    </div> 
                     <p style="line-height: 2em; font-size:16px; text-align: justify; text-indent:30px" class="small"> This is to certify that <u>{$name}</u> has assumed the duties and responsibilities as <u>{$position_title}</u> of <u>{$department}</u> effective <u>{$date_of_appointment}</u>
                    </p>

                    <p style="line-height: 2em; font-size:16px; text-align: justify; text-indent:30px" class="small"> This certification is issued in connection with the issuance of the appointment of <u>{$name}</u> as <u>{$position_title}</u>.
                    </p>

                    <p style="line-height: 2em; font-size:16px; text-align: justify; text-indent:30px" >Done this <u>{$sworn_day}</u> day of <u>{$sworn_month}, {$sworn_year}</u> in <u>{$address_of_assumption}</u></p>

                    <br>
                    <br> 
                <div style="width: {$appointing_authority_div_width}cm; float: right; text-align:center; font-size: 12pt;">
                  <center>
                    <u>{$appointing_authority}</u><br>
                    CITY MAYOR
                    <!-- Head of Office/Department/Unit -->
                  </center>
                </div>

                  <div style="clear:both "></div>
<br><br>
                  <p style="font-size:12pt; text-align: justify; text-indent:30px" class="small">Attested by:<u><b> {$date_of_appointment} </b></u></p>
                  <p style="font-size:12pt; text-align: justify; text-indent:30px" class="small">Attested by:</u></p>
<br><br>

                   <div style="width: {$hrmo_div_width}cm; float:left;text-align: center;font-size:12pt;text-indent:30px"><center><u>{$hrmo}</u><br>
                  {$hrmo_position}</center>
                  </div>

                  <div style="clear:both "></div>

  <br><br><br><br><br>
      
    <i style="font-size:11pt;">201 file<br>
  Admin<br>
  COA<br>
  CSC</i>
   <!-- html ends here -->
HTML;


// printf($html);
$mpdf->WriteHTML($html);
$mpdf->Output("CS Form No32.pdf - Oath of Office.pdf", 'I');


function get_data($mysqli, $appointment_id)
{

  $employee = new Employee();
  $plantilla_ = new Plantilla();
  $position = new Position();

  $data = [
    "name" => "",
    "address" => "",
    "position_title" => "",
    "department" => "",
    "date_of_appointment" => "",
    "address_of_assumption" => "",
    "gov_id_type" => "",
    "gov_id_num" => "",
    "gov_id_date_issued" => "",
    "sworn_day" => "",
    "sworn_month" => "",
    "sworn_year" => "",
    "sworn_in" => "",
    "appointing_authority" => "",
    "hrmo" => "",
    "hrmo_position" => "",
  ];

  $sql = "SELECT * FROM `appointments` WHERE `appointment_id` = '$appointment_id';";
  $res = $mysqli->query($sql);
  if ($row = $res->fetch_assoc()) {
    $data["name"] = $employee->get_full_name_upper_std($row["employee_id"]);
    $data["address"] = $row["address"];
    $plantilla = $plantilla_->get_plantilla_data($row["plantilla_id"]);
    $data["position_title"] = $plantilla["position"]["position"];
    $data["position_title"] .= $plantilla["position"]["functional"] ? " (" . $plantilla["position"]["functional"] . ") " : "";
    $data["department"] = $plantilla["department"]["department"];
    $date = DateTime::createFromFormat("Y-m-d", $row["date_of_appointment"]);
    $data["date_of_appointment"] = $date->format("F d, Y");
    $data["address_of_assumption"] = $row["address_of_assumption"];
    $data["gov_id_type"] = $row["govId_type"];
    $data["gov_id_num"] = $row["govId_no"];
    $data["gov_id_date_issued"] = $row["govId_issued_date"];

    // $date = DateTime::createFromFormat("Y-m-d", $row["date_of_appointment"]);

    $data["sworn_day"] = $date->format("jS");
    $data["sworn_month"] = $date->format("F");
    $data["sworn_year"] = $date->format("Y");
    $data["sworn_in"] = $row["sworn_in"];
    $data["appointing_authority"] = $row["appointing_authority"];
    $data["hrmo"] = $employee->get_full_name_upper_std($row["HRMO"]);
    $data["hrmo_position"] = $position->get_position_data($row["hrmo_position_id"]);

    $data["hrmo_position"] = $data["hrmo_position"] ? $data["hrmo_position"]["alias"] : "";
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
