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

    $salary = $row["sr_salary_rate"] || $row["sr_rate_on_schedule"]?(number_format(($row["sr_salary_rate"]?$row["sr_salary_rate"]:$row["sr_rate_on_schedule"])/22, 2, ".", ",")."/day"):"N/I";
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

<htmlpagefooter name="myFooter2">
    <table width="100%" style="border: none; font-size: 9px; font-weight: bold; font-style: italic;">
        <tr><td colspan="3" class="u"></td></tr>
        <tr>
            <td width="33%">Printed on {DATE F d, Y}</td>
            <td width="33%"></td>
            <td width="33%" style="text-align:right;">Page {PAGENO} of {nbpg}</td>
        </tr>
    </table>
</htmlpagefooter>
<sethtmlpagefooter name="myFooter2" value="on" />

<div style="position: fixed; left: 200px; top: 1px;">
    <img src="bayawanLogo.png" width="60">
</div>
<div style="text-align:center; width: 100%;">
    <p>Republic of the Philippines <br>
    Province of Negros Oriental <br>
    City of Bayawan</p>
</div>
<h4 style="text-align: center; padding: 0px; margin: 0px;">SERVICE RECORD</h4>
<table style="font-size: 12px; padding-top: 10px;">
    <tr>
        <td class="p-2 nw">NAME</td>
        <td class="p-2 nw">:</td>
        <td class="p-2 nw u w"><strong>$full_name</strong></td>
        <td class="p-2 nw">I.D. No</td>
        <td class="p-2 nw">:</td>
        <td class="p-2 nw u w"><strong>$id_no</strong></td>
    </tr>
    <tr>
        <td class="p-2 nw">BIRTHDAY</td>
        <td class="p-2 nw">:</td>
        <td class="p-2 nw u w"><strong>$birthdate</strong></td>
        <td class="p-2 nw">CIVIL STATUS</td>
        <td class="p-2 nw">:</td>
        <td class="p-2 nw u w"><strong>$civil_status</strong></td>
    </tr>
    <tr>
        <td class="p-2 nw">BIRTH PLACE</td>
        <td class="p-2 nw">:</td>
        <td class="p-2 nw u w"><strong>$birth_place</strong></td>
        <td class="p-2 nw">MAIDEN NAME</td>
        <td class="p-2 nw">:</td>
        <td class="p-2 nw u w"><strong>$maiden_name</strong></td>
    </tr>
</table>

<p style="text-indent: 5%; font-size: 12px;">This is to certify that the employee herein shows actually rendered service in this office as shown by the service record below, each line of which
is supported by appointment and other papers actually issued by this Office and approved by authorities concerned.</p>

<table class="tbl">
    <tr class="grey">
        <th colspan="2">SERVICE<br>(inclusive dates)</th>
        <th colspan="3">RECORD OF APPOINTMENT</th>
        <th colspan="2">OFFICE / ENTITY / DIVISION</th>
        <th rowspan="2" width="25%">SEPARATION L/V ABS W/O PAY</th>
    </tr>
    <tr class="grey">
        <th>From</th>
        <th>To</th>
        <th>Designation</th>
        <th>Status</th>
        <th>Salary</th>
        <th>Station / Place of Assignment</th>
        <th>Branch</th>
    </tr>
EOD;

foreach ($service_records as $record) {

    // $record["sr_is_per_session"] === 1 ? $record["sr_salary_rate"] = $record["sr_rate_on_schedule"] : "";

    

    $html .= <<< EOD
    <tr>
        <td>$record[sr_date_from]</td>
        <td>$record[sr_date_to]</td>
        <td>$record[sr_designation]</td>
        <td>$record[sr_status]</td>
        <td>$salary</td>
        <td>$record[sr_place_of_assignment]</td>
        <td>$record[sr_branch]</td>
        <td>$record[sr_remarks]</td>
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
        <td colspan="8" class="grey center">Absence Without Official Leave</td>
    </tr>
    <tr>
        <td colspan="8">No Absence Without Official Leave</td>
    </tr>
</table>


<table width="100%" style="padding-top: 20px;">
<tr><td colspan="2" class="center">Prepared by:</td></tr>
<tr>
    <td></td>
    <td class="center nw" width="50%"><strong>$hrmo</strong></td>
</tr>
<tr>
    <td></td>
    <td class="center nw" width="50%">$hrmo_position</td>
</tr>
<tr><td colspan="2" class="center">Issued in compliance with Executive Order No. 54, dated August 10, 1954 and in accordance with Circular No. 58, dated August 10, 1954 of the System.
</td></tr>
</table>


<table width="100%" style="padding-top: 20px;">
<tr><td colspan="2" class="center">Certified Correct:</td></tr>
<tr>
    <td></td>
    <td class="center nw" width="50%"><strong>$mayor</strong></td>
</tr>
<tr>
    <td></td>
    <td class="center nw" width="50%">CITY MAYOR</td>
</tr>
<tr><td colspan="2">
Date: $date_now
</td></tr>

</table>

EOD;

$mpdf->defaultheaderline = 0;
$mpdf->defaultfooterline = 0;
$mpdf->defaultfooterline = 0;

$mpdf->WriteHTML($html);
$mpdf->Output();