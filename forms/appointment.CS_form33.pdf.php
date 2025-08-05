<?php
//============================================================+
// File name   : example_048.php
// Begin       : 2009-03-20
// Last Update : 2013-05-14
//
// Description : Example 048 for TCPDF class
//               HTML tables and table headers
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: HTML tables and table headers
 * @author Nicola Asuni
 * @since 2009-03-20
 */

// Include the main TCPDF library (search for installation path).
require_once('../TCPDF-master/tcpdf.php');
require_once('../_connect.db.php');
require_once("../libs/NumberToWords.php");
require_once("../libs/NameFormatter.php");
require_once("../libs/EmployeeInfo.php");

$numberToWords = new NumberToWords;


if (!isset($_GET["appointment_id"])) {
  echo "Invalid Appointment Id;";
  return;
}

$appointment_id = $_GET["appointment_id"];

$appointment = null;
$data = [];

// get appointment start
$sql = "SELECT * FROM `appointments` WHERE `appointment_id` = '$appointment_id'";
$res = $mysqli->query($sql);
if ($row = $res->fetch_assoc()) {
  $appointment = $row;
}
// get appointment end

if (!$appointment) {
  echo "No Appointment Record found";
  return;
}

$employee_id = $appointment["employee_id"];

// get employee info start
$employee = null;
$sql = "SELECT * FROM `employees` WHERE `employees_id` = '$employee_id'";
$res = $mysqli->query($sql);
if ($row = $res->fetch_assoc()) {
  $employee = $row;
}
if (!$employee) return;

// get employee info end

// get plantilla info start
$plantilla = null;
$plantilla_id = $appointment["plantilla_id"];
$sql = "SELECT * FROM `plantillas` WHERE `id` = '$plantilla_id'";

$res = $mysqli->query($sql);
if ($row = $res->fetch_assoc()) {
  $plantilla = $row;
}


if (!$plantilla) return;
// get plantilla info end

$department_id = $plantilla["department_id"];
$position_id = $plantilla["position_id"];

// get positiontitle start
$position = null;
$sql = "SELECT * FROM `positiontitles` WHERE `position_id` = '$position_id'";
$res = $mysqli->query($sql);
if ($row = $res->fetch_assoc()) {
  $position = $row;
}

if (!$position)  return;
// get positiontitle end

// get department start
$department = null;
$sql = "SELECT * FROM `department` WHERE `department_id` = '$department_id'";
$res = $mysqli->query($sql);
if ($row = $res->fetch_assoc()) {
  $department = $row;
}
if (!$department) return;
// get department end

// get salary schedule start
$setup_salary_adjustment = null;
$salary_schedule = $plantilla["schedule"];
// get parent_id
$sql = "SELECT * FROM `setup_salary_adjustments` WHERE `active` = '1' AND `schedule` = '$salary_schedule'";
$res = $mysqli->query($sql);
if ($row = $res->fetch_assoc()) {
  $setup_salary_adjustment = $row;
}

if (!$setup_salary_adjustment) return;
$setup_salary_adjustment_id = $setup_salary_adjustment["id"];

$monthly_salary = "";
$monthly_salary_str = "";

$sg = $position["salaryGrade"];
$step = $plantilla["step"];

$sql = "SELECT * FROM `setup_salary_adjustments_setup` WHERE `parent_id` = '$setup_salary_adjustment_id' AND `salary_grade` = '$sg' AND `step_no` = '$step'";
$res = $mysqli->query($sql);
if ($row = $res->fetch_assoc()) {
  $monthly_salary = $row["monthly_salary"];
  $monthly_salary_str = $numberToWords->convert_number_to_words($monthly_salary);
  $monthly_salary = number_format($monthly_salary, 2, ".", ",");
}
// get salary schedule end

// get vacated by start
$vacated_by = null;
$vacated_by_name = "";
$reason_of_vacancy = "";

$vacated_by_appointment_id = $plantilla["vacated_by"];
$sql = "SELECT * FROM `appointments` WHERE `appointment_id` = '$vacated_by_appointment_id'";
$res = $mysqli->query($sql);
if ($row = $res->fetch_assoc()) {
  $vacated_by = $row;


  $reason_of_vacancy = $vacated_by["reason_of_vacancy"];

  $reason = explode(":", $reason_of_vacancy);
  if (count($reason) > 1) {
    $reason = $reason[1];
    $reason = trim($reason);
    $reason = mb_convert_case($reason, MB_CASE_TITLE);
  }

  $reasons = [
    "Retirement" => "Retired",
    "Promotion" => "Promoted",
    "Transfer" => "Transferred",
    "Others" => $reason ? $reason : ""
  ];

  $reason_of_vacancy = trim($reason_of_vacancy); // remove leading/trailing spaces
  $matched = false;

  foreach ($reasons as $key => $value) {
    if (stripos($reason_of_vacancy, $key) !== false) {
      $reason_of_vacancy = $value;
      $matched = true;
      break;
    }
  }


  if ($reason_of_vacancy == "Death") {
    $reason_of_vacancy = "Deceased";
  }

  if (!$matched) {
    $reason_of_vacancy = "";
  }

  $vacated_by_employees_id = $vacated_by["employee_id"];


  $sql = "SELECT * FROM `employees` WHERE `employees_id` = '$vacated_by_employees_id'";
  $res = $mysqli->query($sql);
  if ($row  = $res->fetch_assoc()) {
    $nameFormatted = new NameFormatter($row["firstName"], $row["lastName"], $row["middleName"], $row["extName"]);
    $vacated_by_name = $nameFormatted->getFullNameStandardTitle();
  }
}

// get vacated by end

$honorific = "";

if ($employee["gender"] == "MALE") {
  $honorific = "Mr.";
} elseif ($employee["gender" == "female"]) {
  $honorific = "Ms.";
}

$firstName = $employee["firstName"];

$middleName = "";
if (isset($employee["middleName"])) {
  $middleName = $employee["middleName"];
  if (strlen($middleName) > 0 && $middleName != ".") {
    $middleName = " " . $middleName[0] . ".";
  } else {
    $middleName = "";
  }
}

$lastName = $employee["lastName"];
$extName = $employee["extName"] ? " " . $employee["extName"] : "";

$full_name = $firstName . $middleName . " " . $lastName . $extName;
$full_name = mb_convert_case($full_name, MB_CASE_TITLE);

$position_title = $position["position"];
$position_title = titleCaseWithRomanNumerals($position_title);

$employment_status = $employee["employmentStatus"];
$employment_status = mb_convert_case($employment_status, MB_CASE_TITLE);

$department_name = $department["department"];
$department_name = mb_convert_case($department_name, MB_CASE_TITLE);

$nature_of_appointment = $appointment["nature_of_appointment"];
$nature_of_appointment = mb_convert_case($nature_of_appointment, MB_CASE_TITLE);

$item_no = $plantilla["item_no"];

$city_mayor = new EmployeeInfo($appointment["city_mayor"], $mysqli);
$city_mayor = $city_mayor->getFullNameStandardUpper();

$date_of_signing = $appointment["date_of_signing"];
$date_of_signing =  mb_convert_case(convertDateToWords($date_of_signing), MB_CASE_UPPER);

$posted_date_from = $appointment["posted_date_from"];
$posted_date_from =  convertDateToWords($posted_date_from);

$posted_date_to = $appointment["posted_date_to"];
$posted_date_to =  convertDateToWords($posted_date_to);

$assessment_date_from = $appointment["assesment_date_from"];
$assessment_date_from =  convertDateToWords($assessment_date_from);

$assessment_date_to = $appointment["assesment_date_to"];
$assessment_date_to =  convertDateToWords($assessment_date_to);

$assessment_date = "";
if ($assessment_date_from != "" && $assessment_date_to != "") {
  $assessment_date_from = explode(" ", $assessment_date_from);

  $assessment_date_from[1] = str_replace(",", "", $assessment_date_from[1]);
  $assessment_date_to = explode(" ", $assessment_date_to);

  if ($assessment_date_from[0] == $assessment_date_to[0]) {
    $assessment_date = "{$assessment_date_from[0]} {$assessment_date_from[1]}-{$assessment_date_to[1]} {$assessment_date_to[2]}";
  } else {
    $assessment_date = "{$assessment_date_from[0]} {$assessment_date_from[1]} - {$assessment_date_to[0]} {$assessment_date_to[1]} {$assessment_date_to[2]}";
  }
}

$hrmo = new EmployeeInfo($appointment["HRMO"], $mysqli);
$hrmo = $hrmo->getFullNameStandardUpper();

$hrmo_position = $appointment["hrmo_position_id"];
if (!$hrmo) {
  $hrmo_position = "";
}

$sql = "SELECT * FROM `positiontitles` WHERE `position_id` = '$hrmo_position'";
$res = $mysqli->query($sql);
if ($row = $res->fetch_assoc()) {
  $hrmo_position = $row["alias"];
}

$deliberation_date_from = "";
if ($deliberation_date_from = $appointment["deliberation_date_from"]) {
  $deliberation_date_from = convertDateToWords($deliberation_date_from);
}

$committee_chair = "";
if ($committee_chair = $appointment["committee_chair"] && $appointment["committee_chair"] != 0) {
  $committee_chair = new EmployeeInfo($appointment["committee_chair"], $mysqli);
  $committee_chair = $committee_chair->getFullNameStandardUpper();
}

$full_name_upper = mb_convert_case($full_name, MB_CASE_UPPER);

$data = [
  "honorific" => $honorific,
  "full_name" => $full_name,
  "position_title" => $position_title,
  "sg" => $sg,
  "step" => $step,
  "employment_status" => $employment_status,
  "department_name" => $department_name,
  "monthly_salary_str" => $monthly_salary_str,
  "monthly_salary" => $monthly_salary,
  "nature_of_appointment" => $nature_of_appointment,
  "vacated_by_name" => $vacated_by_name,
  "reason_of_vacancy" => $reason_of_vacancy,
  "item_no" => $item_no,
  "city_mayor" => $city_mayor,
  "date_of_signing" => $date_of_signing,
  "posted_date_from" => $posted_date_from,
  "posted_date_to" => $posted_date_to,
  "assessment_date" => $assessment_date,
  "hrmo" => $hrmo,
  "hrmo_position" => $hrmo_position,
  "deliberation_date_from" => $deliberation_date_from,
  "committee_chair" => $committee_chair,
  "full_name_upper" => $full_name_upper
];

// echo '<pre>';
// print_r([
//   "appointment" => $appointment,
//   "employee" => $employee,
//   "plantilla" => $plantilla,
//   "position" => $position,
//   "department" => $department,
//   "setup_salary_adjustment" => $setup_salary_adjustment,
//   $data
// ]);
// echo '</pre>';

// return;

// create new PDF document
// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new TCPDF('P', 'mm', 'LEGAL', true, 'UTF-8', false);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
  require_once(dirname(__FILE__) . '/lang/eng.php');
  $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
$where = "";
$file_title = $lastName . " " . $firstName . ($extName ? " " . $extName : "") . " Appointment-CS_Form_No_33-B";

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('IHRIS');
$pdf->SetTitle($file_title);

// $pdf->SetSubject('TCPDF Tutorial');
// $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 048', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
// $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 5, PDF_MARGIN_RIGHT);
// $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

// $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
// $pdf->SetFooterMargin(1);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 1);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set font
$pdf->SetFont('times', '', 12);

// $pdf->SetFont('helvetica', '', 8);
$dateOfUse = date('F d, Y');

// Start First Page Group
// $pdf->startPageGroup();

// add a page
$pdf->AddPage();
// -----------------------------------------------------------------------------
ob_start();
?>
<div>
  <table cellspacing="0" cellpadding="2">
    <tr>
      <td width="60%" colspan="2"></td>
      <td width="40%" border="1" align="center"><i><b>For Accredited/Deregulated Agencies</b></i></td>
    </tr>
  </table>
  <br><br>

  <div style="border:20px solid gray; position: relative;">
    <table cellspacing="0" cellpadding="10">
      <tr>
        <td width="60%"><b style="font-size:15px;font-family:Arial">CS Form No.33 - B</b> <br> <i style="font-family:Arial">Revised 2018</i></td>
        <td width="40%" align="center"><i>(Stamp of Date of Receipt)</i></td>
      </tr>
    </table>
    <p align="center" style="font-size:16px;"><b style="font-size:16px;"> REPUBLIC OF THE PHILIPPINES</b><br>
      Province of Negros Oriental<br>
      City of Bayawan
    </p><br><br>
    <table style="width: 100%;">
      <tr>
        <td>
          <p style="font-size:15px; text-align: justify; font-weight:bold;">
            <?= $honorific ?> <u><?= $full_name ?></u>
          </p>

          <p style="font-size:15px; text-align: justify; text-indent:30px; line-height:3; font-weight:bold;">
            You are hereby appointed as <u><?= $position_title ?></u> <u>(SG <?= $sg ?>, step <?= $step ?>)</u> under <u><?= $employment_status ?></u> status at the <u><?= $department_name ?>, LGU Bayawan City</u> with a comepensation rate of <u><?= $monthly_salary_str ?></u> <u>(P <?= $monthly_salary ?>)</u> pesos per month.
          </p>

          <p style="font-size:15px; text-align: justify; text-indent:30px; line-height:3; font-weight:bold;" class="small">
            The nature of this appointment is <u><?= $nature_of_appointment ?></u> vice <?= $vacated_by_name ? "<u>" . $vacated_by_name . "</u>" : "_____________________________" ?>, who <?= $reason_of_vacancy ? "<u>" . $reason_of_vacancy . "</u>" : "_____________" ?> with Plantilla Item No. <u><?= $item_no ?></u> Page ____.</p>

          <p style="font-size:14px; text-align: justify; text-indent:30px; font-weight:bold;" class="small">
            This appointmet shall take effect on the date of signing by the appointing officer/authority.
          </p>
        </td>
      </tr>
    </table>

    <table style="width: 100%;">
      <tr>
        <td style="width: 45%;"></td>
        <td style="font-size:16px; text-align: center;">
          <p></p>
          <b>
            Very truly yours,
          </b>
          <p></p>
          <p></p>
        </td>
      </tr>
    </table>

    <table style="width: 100%;">
      <tr>
        <td></td>
        <td style="width: 250px;"></td>
        <td style="width: 200px; text-align: center;">
          <b style="font-size:15px">
            <?= $city_mayor ?>
          </b>
        </td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td style="width: 250px;"></td>
        <td style="width: 200px; text-align: center; border-top: 1px solid black;">
          <b><cite>City Mayor</cite></b>
        </td>
        <td></td>
      </tr>
    </table>

    <br><br>
    <table style="width: 100%;">
      <tr>
        <td></td>
        <td style="width: 250px;"></td>
        <td style="width: 200px; text-align: center;">
          <b style="font-size:15px;">
            <?= $date_of_signing ?>
          </b>
        </td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td style="width: 250px;"></td>
        <td style="width: 200px; text-align: center; border-top: 1px solid black;">
          <b><cite>Date of Signing</cite></b>
          <p></p>
          <p></p>
        </td>
        <td></td>
      </tr>
    </table>
    <p></p>
    <table style="width: 100%;">
      <tr>
        <td>
          <b>Accredited/Deregulated Pursuant to <br>
            CSC Resolution NO.1201478<br>
            <u>September 26, 2012</u>
          </b>
        </td>
        <td></td>
      </tr>
      <tr>
        <td style="text-align: center; width: 250px;">
          <img src="../assets/images/forms/csc logo.jpg" style="width:150px;">
        </td>
        <td>
        </td>
      </tr>
    </table>
    <div style="width: 100%;; text-align: right; padding: none; margin:none;"><i>(Stamp of Date of Release)</i></div>
  </div>
</div>
<?php
$html = ob_get_clean();
$pdf->writeHTML($html, true, false, false, false, '');

$pdf->AddPage();
ob_start();
?>
<p></p>
<p></p>
<div style="border:20px solid gray;">
  <table cellspacing="0" cellpadding="10">
    <tr>
      <td width="100%" style="font-size:18px" align="center"><b>Certification</b></td>
    </tr>

    <tr>
      <td width="100%" style="font-size:15px; line-height:1.5" align="justify">
        This is to certify that all requirements ans supporting papers pursuant to CSC MC.No.<u><b>14</b></u>, series of <u><b>2018</b></u>
        have been complied with, reviewed and found to be in order.
        <br> <br>
        The position was published at <u><b>CSC Job Portal</b></u> on <b><?= $posted_date_from ? "<u>" . $posted_date_from . "</u>" : "__________________" ?></b> to <b><?= $posted_date_to ? "<u>" . $posted_date_to . "</u>" : "__________________" ?></b> and posted
        in <u><b>BVP and 3 conspicuous places</b></u> from <b><?= $posted_date_from ? "<u>" . $posted_date_from . "</u>" : "__________________"  ?></b> to <b><?= $posted_date_to ? "<u>" . $posted_date_to . "</u>" : "__________________"  ?></b> in consonance with <u><b>RA No. 7041</b></u>. The assessment by the <b>Human Resource Merit Promotion and Selection Board(HRMPSB) started on </b><b><?= $assessment_date ? "<u>" . $assessment_date . "</u>" : "__________________" ?></b>
      </td>
    </tr>
  </table>
  <p></p>
  <table style="width: 100%;">
    <tr>
      <td></td>
      <td style="width: 150px;"></td>
      <td style="width: 300px; text-align: center;">
        <b style="font-size:15px">
          <?= $hrmo ?>
        </b>
      </td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td style="width: 150px;"></td>
      <td style="width: 300px; text-align: center; border-top: 1px solid black;">
        <b><cite><?= $hrmo_position ?></cite></b>
      </td>
      <td></td>
    </tr>
  </table>
</div>
<div style="border:20px solid gray;">
  <table cellspacing="0" cellpadding="10">
    <tr>
      <td width="100%" style="font-size:18px" align="center"><b>Certification</b></td>
    </tr>
    <tr>
      <td width="100%" style="font-size:15px; line-height:1.5" align="justify">
        This is to certify that the appointee has been screened and found qualified by the majority of the <b>Human Resource Merit Promotion and Selection Board(HRMPSB) started on</b> during the deliberation held on <b><?= $deliberation_date_from ? "<u>" . $deliberation_date_from . "</u>" : "_________________________" ?></b>.
      </td>
    </tr>
  </table>
  <p></p>
  <table style="width: 100%;">
    <tr>
      <td></td>
      <td style="width: 200px;"></td>
      <td style="width: 200px; text-align: center;">
        <b style="font-size:15px">
          <?= $committee_chair ?>
        </b>
      </td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td style="width: 200px;"></td>
      <td style="width: 200px; text-align: center; border-top: 1px solid black;">
        <b><cite>Chairperson, HRMPSB</cite></b>
      </td>
      <td></td>
    </tr>
  </table>
</div>
<br>
<br>
<table cellspacing="0">
  <tr>
    <td width="100%" style="font-size:15px" align="center"><b>CSC/HRMO Notation</b></td>
  </tr>
</table>
<div style="border:20px solid gray;">
  <br>
  <table cellspacing="0" cellpadding="10" background="gray" border="1" style="font-size:13px">
    <tr>
      <td width="80%" align="center"> ACTION ON APPOINTMENTS
      </td>
      <td width="19%" align="center"> Recorded by
      </td>
    </tr>
    <tr>
      <td width="80%">Validate per RAI for the month of _________________________________
      </td>
      <td width="19%" align="center">
      </td>
    </tr>
    <tr>
      <td width="80%">Invalidate per CSCRO/FO letter dated_________________________________
      </td>
      <td width="19%" align="center">
      </td>
    </tr>
    <tr>
      <td width="30%">Appeal
      </td>
      <td width="30%" align="center">DATE FILED
      </td>
      <td width="20%" align="center">STATUS
      </td>
      <td width="19%">
      </td>
    </tr>
    <tr>
      <td width="30%">CSCRO/CSC-Commission
      </td>
      <td width="30%" align="center">
      </td>
      <td width="20%" align="center">
      </td>
      <td width="19%">
      </td>
    </tr>
    <tr>
      <td width="30%">Petition for Review
      </td>
      <td width="30%" align="center">
      </td>
      <td width="20%" align="center">
      </td>
      <td width="19%">
      </td>
    </tr>
    <tr>
      <td width="30%">CSC-Commission
      </td>
      <td width="30%" align="center">
      </td>
      <td width="20%" align="center">
      </td>
      <td width="19%">
      </td>
    </tr>
    <tr>
      <td width="30%">Court of Appeals
      </td>
      <td width="30%" align="center">
      </td>
      <td width="20%" align="center">
      </td>
      <td width="19%">
      </td>
    </tr>
    <tr>
      <td width="30%">Supreme Court
      </td>
      <td width="30%" align="center">
      </td>
      <td width="20%" align="center">
      </td>
      <td width="19%">
      </td>
    </tr>

  </table>
</div>

<p></p>

<div style="border:20px solid gray;">
  <br>
  <table>
    <tr>
      <td></td>
    </tr>
  </table>
  <table cellspacing="0" background="gray" border="1" style="font-size:13px">
    <tr>
      <td width="40%" style="font-size: 10px">
        Origin Copy - for the Appointee<br>
        Origin Copy - for the Civil Service Commission<br>
        Origin Copy - for the Agency<br>
      </td>
      <td width="59%" align="center" style="font-size: 12px">
        <b>Acknowledgement</b><br>
        <brs>
          <i> Received original photocopy of appointment on ___________</i><br>
          <br>
          <b><u><?= $full_name_upper ?></u></b><br>
          Appointee
      </td>
    </tr>
  </table>
</div>
</div>
<?php
$html2 = ob_get_clean();
$pdf->writeHTML($html2, true, false, false, false, '');

// $pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output($file_title . '.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
function lister($arr)
{
  $item = "";
  if (isset($arr)) {
    foreach ($arr as $key => $value) {
      $item .= " *" . $value;
    }
  } else {
    $item = "*None Required";
  }
  return $item;
}

function convertDateToWords($date)
{
  $date_converted = "";
  if ($date != "" && $date != "0000-00-00") {
    $date_converted = (new DateTime($date))->format('F d, Y');
  } else {
    $date_converted = "";
  }
  return $date_converted;
}


function titleCaseWithRomanNumerals($string)
{
  if (!$string) return "";
  // Define valid Roman numerals up to 3999
  $romanNumerals = [
    'I',
    'II',
    'III',
    'IV',
    'V',
    'VI',
    'VII',
    'VIII',
    'IX',
    'X',
    'XI',
    'XII',
    'XIII',
    'XIV',
    'XV',
    'XVI',
    'XVII',
    'XVIII',
    'XIX',
    'XX',
    'XXI',
    'XXII',
    'XXIII',
    'XXIV',
    'XXV',
    'XXVI',
    'XXVII',
    'XXVIII',
    'XXIX',
    'XXX',
    'XL',
    'L',
    'LX',
    'LXX',
    'LXXX',
    'XC',
    'C',
    'D',
    'M'
  ];

  // Convert to title case using ucwords (handles basic spacing)
  $words = explode(' ', strtolower($string));
  $result = array_map(function ($word) use ($romanNumerals) {
    $cleaned_word = preg_replace('/\s+/', '', $word);
    $upper = strtoupper($cleaned_word);
    return in_array($upper, $romanNumerals) ? $upper : ucfirst($cleaned_word);
  }, $words);

  return implode(' ', $result);
}
