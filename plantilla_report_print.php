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
$status = $_GET["status"];
$gender = $_GET["gender"];

$date = formatDate($_GET["date"]);
$department_id = $_GET["department_id"];

$department = "";
$sql = "SELECT `department` from `department` WHERE `department_id` = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $department_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$department = strtoupper($row["department"]);


$mpdf->Bookmark('Start of the document');
$html = <<<EOD
<style>
    table, th, td {
        border: 1px inset grey;
        border-collapse: collapse;
        padding-left: 5px;
    }
</style>

<htmlpagefooter name="myFooter2">
    <table width="100%" style="border: none; font-size: 9px;">
        <tr>
            <td style="border:none;" width="33%"></td>
            <td style="border:none;" width="33%" align="center">Page {PAGENO} of {nbpg}</td>
            <td width="33%" style="text-align: right; border:none;">Printed on {DATE F d, Y}</td>
        </tr>
    </table>
</htmlpagefooter>
<sethtmlpagefooter name="myFooter2" value="on" />

<div style="position: fixed; left: 370px; top: 2px;">
    <img src="bayawanLogo.png" width="60">
</div>
<div style="text-align:center; width: 100%;">
    <span>Republic of the Philippines <br>
    Province of Negros Oriental <br>
    City of Bayawan</span>
    <br>
    <span style="font-size: 10px;">As of $date</span>
</div>
<table style="margin-top: 20px;">
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
    <tr>
        <th colspan="20" style="text-align:left;">
            $department
        </th>
    </tr>
    <tbody>
EOD;
if ($gender === "all") {
  $sql = "SELECT plantillas.*,positiontitles.position,positiontitles.functional,positiontitles.salaryGrade,positiontitles.category,appointments.*,employees.firstName,employees.middleName,employees.lastName,employees.extName,pds_personal.gender,pds_personal.birthdate FROM `plantillas` LEFT JOIN `positiontitles` ON `plantillas`.`position_id`=`positiontitles`.`position_id` LEFT JOIN `appointments` ON `plantillas`.`incumbent`=`appointments`.`appointment_id` LEFT JOIN `employees` ON `appointments`.`employee_id`=`employees`.`employees_id` LEFT JOIN `pds_personal` ON `employees`.`employees_id`=`pds_personal`.`employee_id` WHERE `plantillas`.`department_id`=? ORDER BY `item_no` ASC";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param('i', $department_id);
} else {
  $gender = $gender[0];
  $sql = "SELECT plantillas.*,positiontitles.position,positiontitles.functional,positiontitles.salaryGrade,positiontitles.category,appointments.*,employees.firstName,employees.middleName,employees.lastName,employees.extName,pds_personal.gender,pds_personal.birthdate FROM `plantillas` LEFT JOIN `positiontitles` ON `plantillas`.`position_id`=`positiontitles`.`position_id` LEFT JOIN `appointments` ON `plantillas`.`incumbent`=`appointments`.`appointment_id` LEFT JOIN `employees` ON `appointments`.`employee_id`=`employees`.`employees_id` LEFT JOIN `pds_personal` ON `employees`.`employees_id`=`pds_personal`.`employee_id` WHERE `plantillas`.`department_id`=? AND `pds_personal`.`gender` = ? ORDER BY `item_no` ASC";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param('is', $department_id, $gender);
}
$stmt->execute();
$result = $stmt->get_result();
require_once 'libs/PlantillaPermanent.php';
$plantilla = new PlantillaPermanent();

$data = array();
while ($row = $result->fetch_assoc()) {
  $data[] = $row;
}

// 
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
// 


foreach ($sorted_data as $row) {
  $employee_id = $row["employee_id"];
  $sg = $row["salaryGrade"];
  $step = $row["step"];
  $sg = $row["salaryGrade"];
  $schedule = $row["schedule"];
  $authorized_salary = getMonthlySalary($mysqli, $sg, $step, $schedule);
  $actual_salary = $authorized_salary;
  $area_code = "7";
  $area_type = "C";
  $level = $row["category"] ? $row["category"][0] : "";
  $lastName = $row["lastName"];
  $firstName = $row["firstName"];
  $middleName = $row["middleName"] == "." ? "" : $row["middleName"];
  $extName = $row["extName"];
  $gender = $row["gender"] ? $row["gender"][0] : "";
  $position = $row["position"];
  $functional = $row["functional"];
  $html .= <<<EOD
    <tr>
         <td>$row[item_no]</td>
         <td style="white-space:nowrap">$position</td>
         <td style="white-space:nowrap">$functional</td>
         <td style="text-align:center">$sg</td>
         <td style="text-align:center">$authorized_salary</td>
         <td style="text-align:center">$actual_salary</td>
         <td style="text-align:center">$step</td>
         <td style="text-align:center">$area_code</td>
         <td style="text-align:center">$area_type</td>
         <td style="text-align:center">$level</td>
    EOD;

  if ($row["abolish"] == "1") {
    $html .= <<<EOD
        <td colspan="10" style="white-space:nowrap; text-align:center;"><i>(TO BE ABOLISHED)</i></td>
    EOD;
  } elseif (empty($row["incumbent"])) {
    $html .= <<<EOD
        <td colspan="10" style="white-space:nowrap; text-align:center;"><i>(VACANT)</i></td>
    EOD;
  } else {

    $date_of_birth = formatDateSlashes($row["birthdate"]);
    $date_of_orig_appointment = $plantilla->getDateOrigAppointment($employee_id); // formatDate($row["date_of_orig_appointment"]);
    $date_of_last_promotion = $plantilla->getDateLastPromoted($employee_id); // formatDate($row["date_of_last_promotion"]);
    // $status = $row["status_of_appointment"] ? strtoupper($row["status_of_appointment"]) : "";
    $status = strtoupper($status);
    $eligibility = get_eligiblity($mysqli, $row["employee_id"]);
    $html .= <<<EOD
        <td style="white-space:nowrap">$lastName</td>
        <td style="white-space:nowrap">$firstName</td>
        <td style="white-space:nowrap">$middleName</td>
        <td style="white-space:nowrap">$extName</td>
        <td style="text-align:center;">$gender</td>
        <td style="text-align:center;">$date_of_birth</td>
        <td style="text-align:center;">$date_of_orig_appointment</td>
        <td style="text-align:center;">$date_of_last_promotion</td>
        <td style="text-align:center;">$status</td>
        <td style="white-space:nowrap;">$eligibility</td>
    EOD;
  }


  $html .= <<<EOD
     </tr>
    EOD;
}

$num_items = $result->num_rows;

if ($num_items === 0) {
  $html .= <<<EOD
  <tr>
    <td colspan="20" align="center">******************* EMPTY *******************</td>
  </tr>
  EOD;
  $num_items = "O";
}


$stmt->close();

$html .= <<<EOD
    </tbody>
</table>
<div style="page-break-inside: avoid;">
<div style="font-size: 10px; margin-top: 5px;">
    <strong>Total Number of Position Items: <span style="display: inline; width: 100px; border-bottom: 1px solid black;">$num_items</span></strong>
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
    <td style="text-align:center;border: none;">$date</td>
    <td style="text-align:center;border: none; font-weight: bold;">PRYDE HENRY A. TEVES</td>
    <td style="text-align:center;border: none;">$date</td>
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

$mpdf->WriteHTML($html);
$mpdf->Output();

function formatDateSlashes($date_in)
{
  if (!$date_in) return "";
  // if (!$date_in) return date("m/d/Y");
  $date = date_create($date_in);
  return date_format($date, "m/d/Y");
}

function formatDate($date_in)
{
  if (!$date_in) return date('F d, Y');
  $date = date_create($date_in);
  return date_format($date, "F d, Y");
}


function getMonthlySalary($mysqli, $sg, $step, $schedule)
{
  $monthly_salary = 0;
  if (empty($sg) || empty($step) || empty($schedule)) return false;
  $sql = "SELECT id FROM `setup_salary_adjustments` WHERE schedule = ? AND active = '1'";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param('i', $schedule);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $parent_id = 0;
  $parent_id = $row["id"];
  $stmt->close();
  if (empty($parent_id)) return false;
  $sql = "SELECT monthly_salary FROM `setup_salary_adjustments_setup` WHERE parent_id = ? AND salary_grade = ? AND step_no = ?";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param('iii', $parent_id, $sg, $step);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $monthly_salary = $row["monthly_salary"];
  // return $monthly_salary?number_format(($monthly_salary*12),2,'.',','):"---";
  return $monthly_salary ? ($monthly_salary * 12) : "---";
}
function get_eligiblity($mysqli, $employee_id)
{
  $sql = "SELECT `pds_eligibilities`.`elig_title` AS `eligibility` FROM `pds_eligibilities` WHERE `employee_id` = ? LIMIT 1";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param('i', $employee_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $eligibility = $row["eligibility"];
  $stmt->close();
  return $eligibility ? $eligibility : "";
}
