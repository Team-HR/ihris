<?php
// header('Content-Type: application/json');
require "_connect.db.php";

if (isset($_POST["generateReport"])) {
    $year = $_POST["year"];
    $employmentStatus = $_POST["employmentStatus"];
    $data = [];

    if ($employmentStatus == 'ALL') {
        $filter = "`employmentStatus` != 'ELECTIVE'";
    } else {
        $filter = "`employmentStatus` = '$employmentStatus'";
    }


    $sql = "SELECT * FROM `employees` WHERE `status` = 'ACTIVE' AND $filter ORDER BY `employees`.`lastName` ASC";

    $res = $mysqli->query($sql);
    while ($row = $res->fetch_assoc()) {
        $data[] = get_employee_dtr($mysqli, $row['employees_id'], $year);
    }

    echo json_encode($data, JSON_PRETTY_PRINT);
}

function get_employee_dtr($mysqli, $employee_id, $year)
{
    require_once "libs/models/Employee.php";

    $employee = new Employee;

    $sql = "SELECT * FROM `dtrsummary` WHERE `employee_id` = '$employee_id';";
    $res = $mysqli->query($sql);
    $dtrs = [];
    while ($row = $res->fetch_assoc()) {
        $header_month = explode("-", $row["month"]);
        $row['dtr_year'] = $header_month[0];
        $row['dtr_month'] = $header_month[1];
        $dtrs[] = $row;
    }


    $dtrs = filter_array('dtr_year', $year, $dtrs);
    $months = [];

    for ($i = 0; $i < 12; $i++) {
        $m = filter_array('dtr_month', $i + 1, $dtrs);
        $months[] =  $m ?  $m[0] : [
            // "dtrSummary_id" => null,
            // "employee_id" => null,
            // "month" => null,
            // "totalMinsTardy" => 0,
            // "totalTardy" => 0,
            // "totalMinsUndertime" => 0,
            // "letterOfNotice" => null,
            // "halfDaysTardy" => 0,
            // "halfDaysUndertime" => 0,
            // "remarks" => "",
            // "submitted" => null,
            // "color" => null,
            // "dtr_year" => null,
            // "dtr_month" => null
        ];
    }

    $employment_status = $employee->get_data($employee_id) ? $employee->get_data($employee_id)['employmentStatus'] : '';
    $employee = [
        "id" => $employee_id,
        "name" => $employee->get_full_name_upper($employee_id),
        "employment_status" => $employment_status,
        "months" => $months
    ];

    return $employee;
}

function filter_array($property, $value, $data)
{
    $resultArray = array_filter($data, function ($element) use ($property, $value) {
        return isset($element[$property]) && $element[$property] == $value;
    });

    return array_values($resultArray);
}
