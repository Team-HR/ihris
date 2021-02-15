<?php
require "vendor/autoload.php";
require "_connect.db.php";

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8', 'format' => 'FOLIO-P',
    'margin_top' => 15,
    'margin_left' => 5,
    'margin_right' => 5,
    'margin_bottom' => 5,
    'margin_footer' => 1,
    'default_font' => 'helvetica'
]);
$department_id = 21;
$department = "";
$sql = "SELECT `department` from `department` WHERE `department_id` = '$department_id'";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$department = strtoupper($row["department"]);

$mpdf->Bookmark('Start of the document');


$full_name = "";
$id_no = "";
$birthdate = "";
$civil_status = "";
$birth_place = "";
$maiden_name = "";

$hrmo = "VERONICA GRACE P. MIRAFLOR";
$hrmo_position = "HRMO IV";
$mayor = "PRYDE HENRY A. TEVES";
$date_now = date("F d,Y");

$service_records = array();
$employee_id = $_GET["employee_id"];
$sql = "SELECT employees.firstName,employees.lastName,employees.middleName,employees.extName,pds_personal.employee_id,pds_personal.birthdate,pds_personal.birthplace,pds_personal.civil_status FROM employees LEFT JOIN pds_personal ON employees.employees_id=pds_personal.employee_id WHERE pds_personal.employee_id=?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $employee_id);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();
$full_name = $employee["firstName"] . ($employee["middleName"] != "." && !empty($employee["middleName"]) ? " " . $employee["middleName"] : "") . " " . $employee["lastName"] . ($employee["extName"] ? " " . $employee["extName"] : "");
$id_no = $employee_id;
$birthdate = strtoupper(date_format(date_create($employee["birthdate"]),"F d, Y"));
$civil_status = strtoupper($employee["civil_status"]);
$birth_place = strtoupper($employee["birthplace"]);
$maiden_name = "";
$stmt->close();

$sql = "SELECT * FROM `service_records` WHERE `employee_id` = ? ORDER BY `sr_date_from`,`sr_date_to` ASC";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $employee_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    // $row["sr_salary_rate"] = number_format($row["sr_salary_rate"], 2, ".", ",")."/day";
    
    $row["salary"] = "₱";

    if ($row["sr_status"] === 'CASUAL') {
        $row["salary"] .= $row["sr_salary_rate"] || $row["sr_rate_on_schedule"]?(number_format(($row["sr_salary_rate"]?$row["sr_salary_rate"]:$row["sr_rate_on_schedule"]), 2, ".", ",")."/DAY"):"N/I";   
    } else {
        $row["salary"] .= $row["sr_salary_rate"] || $row["sr_rate_on_schedule"]?(number_format(($row["sr_salary_rate"]?$row["sr_salary_rate"]:$row["sr_rate_on_schedule"]), 2, ".", ",")."/YEAR"):"N/I";    
    }
    
    // $salary = $row["sr_rate_on_schedule"];
    $row["sr_date_from"] = date_format(date_create($row["sr_date_from"]),"m/d/Y");
    $row["sr_date_to"] = $row["sr_date_to"]?date_format(date_create($row["sr_date_to"]),"m/d/Y"):"To Present";
    $service_records[] = $row;
}
$stmt->close();

$leave_wo_pays = array();
$absence_wo_official_leaves = array();

$html = <<< EOD
<style>
    .p-2 {
        padding: 3px;
    }
    .u {
        border-bottom: 1px solid black;
    }
    .nw {
        white-space:nowrap;
    }
    .w {
        width: 250;
    }
    th,td {
        font-size: 10px;
    }
    .tbl {
        width: 100%;
        border-collapse: collapse;
    }
    .tbl tr th {
        border: 1px inset grey;
    }
    .tbl tr td {
        border: 1px inset grey;
        padding: 3px;
    }
    .center {
        text-align: center;
    }
    .grey {
        background-color: lightgrey;
    }
</style>

<table class="tbl">
    <tr>
        <th>Month<br></th>
        <th>No. of times</th>
    </tr>
EOD;

foreach ($service_records as $record) {

    // $record["sr_is_per_session"] === 1 ? $record["sr_salary_rate"] = $record["sr_rate_on_schedule"] : "";

         

    $html .= <<< EOD
    <tr>
        <td>$record[sr_date_from]</td>
        <td>$record[sr_date_to]</td>
    </tr>
EOD;
}

$html .= <<< EOD
    <tr>
        <td colspan="8" class="center">************************************************* nothing follows *************************************************</td>
    </tr>
    <tr>
        <th colspan="8" class="grey center">Leave Without Pay</th>
    </tr>
    <tr>
        <td colspan="8">No Leave Without Pay</td>
    </tr>
    <tr>
        <th colspan="8" class="grey center">Absence Without Official Leave</th>
    </tr>
    <tr>
        <td colspan="8">No Absence Without Official Leave</td>
    </tr>
</table>
  

EOD;

$mpdf->defaultheaderline = 0;
$mpdf->defaultfooterline = 0;
$mpdf->defaultfooterline = 0;

$mpdf->WriteHTML($html);
$mpdf->Output();