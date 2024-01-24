<?php
// header('Content-Type: application/json');
require "_connect.db.php";

if (isset($_POST["generateReport"])) {
    $year = $_POST["year"];
    $employmentStatus = $_POST["employmentStatus"];
    $with_tardy_and_undertime = json_decode($_POST["with_tardy_and_undertime"]);
    $data = [];
    // echo json_encode($employmentStatus, JSON_PRETTY_PRINT);
    // return null;

    if ($employmentStatus == 'ALL') {
        $filter = "AND `employmentStatus` != 'ELECTIVE'";
    } else {
        $filter = "AND `employmentStatus` = '$employmentStatus'";
    }


    $sql = "SELECT * FROM `employees` WHERE `status` = 'ACTIVE' $filter ORDER BY `employees`.`lastName` ASC";

    $res = $mysqli->query($sql);
    while ($row = $res->fetch_assoc()) {
        $data[] = get_employee_dtr($mysqli, $row['employees_id'], $year);
    }

    if ($with_tardy_and_undertime !== null) {
        $data = filter_array("with_tardy_and_undertime", $with_tardy_and_undertime, $data);
    }

    echo json_encode($data, JSON_PRETTY_PRINT);
} elseif (isset($_POST["submitRemarks"])) {
    $payload = $_POST["payload"];
    $identifier = $payload["identifier"];
    // check first if identifier is already existing
    $sql = "SELECT * FROM `dtrsummary_remarks` WHERE `identifier` = '$identifier'";
    $res = $mysqli->query($sql);
    if ($row = $res->fetch_assoc()) {
        // update
        $column_name = $payload['column_name'];
        $remarks = $mysqli->real_escape_string($payload['remarks']);
        $sql = "UPDATE `dtrsummary_remarks` SET `$column_name` = '$remarks' WHERE `identifier` = '$identifier'";
        $mysqli->query($sql);
    } else {
        // create new entry
        $column_name = $payload['column_name'];
        $remarks = $mysqli->real_escape_string($payload['remarks']);
        $sql = "INSERT INTO `dtrsummary_remarks` (`identifier`,`$column_name`, `created_at`, `updated_at`) VALUES ('$identifier', '$remarks', current_timestamp(), current_timestamp())";
        $mysqli->query($sql);
    }

    echo json_encode(1);
} elseif (isset($_POST["updateSelections"])) {
    $year = $_POST["year"];
    $employee_id = $_POST["employee_id"];
    $is_selected = json_decode($_POST["is_selected"]);
    $employmentStatus = $_POST["employmentStatus"];
    $with_tardy_and_undertime = json_decode($_POST["with_tardy_and_undertime"]);

    if (!$is_selected) {
        $sql = "DELETE FROM `dtrsummary_selections` WHERE `employee_id` = '$employee_id' AND `year` = '$year';";
        $mysqli->query($sql);
    } else {
        $sql = "INSERT INTO `dtrsummary_selections` (`id`, `employee_id`, `year`, `employmentStatus`, `with_tardy_and_undertime`,`created_at`, `updated_at`) VALUES (NULL, '$employee_id', '$year', '$employmentStatus', '$with_tardy_and_undertime', current_timestamp(), current_timestamp())";
        $mysqli->query($sql);
    }

    echo json_encode([
        $year,
        $employee_id,
        $is_selected
    ]);


    // $selected_employees = $_POST["selected_employees"];
    // $employmentStatus = $_POST["employmentStatus"];
    // if ($employmentStatus == "ALL") {
    //     $sql = "DELETE FROM `dtrsummary_selections` WHERE `year` = '$year'";
    // } else {
    //     $sql = "DELETE FROM `dtrsummary_selections` WHERE `year` = '$year' AND `employmentStatus` = '$employmentStatus'";
    // }

    // $mysqli->query($sql);

    // foreach ($selected_employees as $employee) {
    //     if (isset($employee['employment_status']) && $employee['employment_status']) {
    //         $sql = "INSERT INTO `dtrsummary_selections` (`id`, `employee_id`, `year`, `employmentStatus`, `created_at`, `updated_at`) VALUES (NULL, '$employee[employee_id]', '$year', '$employee[employment_status]', current_timestamp(), current_timestamp())";
    //         $mysqli->query($sql);
    //     }
    // }

    // echo json_encode($selected_employees);
} elseif (isset($_POST["getSelections"])) {
    $year = $_POST["year"];
    $employmentStatus = $_POST["employmentStatus"];
    $with_tardy_and_undertime = json_decode($_POST["with_tardy_and_undertime"]);

    $filter = "";
    if ($employmentStatus != "ALL") {
        $filter .= " AND `employmentStatus` = '$employmentStatus'";
    }

    if ($with_tardy_and_undertime !== null) {
        $with_tardy_and_undertime = $with_tardy_and_undertime ? 1 : 0;
        $filter .= " AND `with_tardy_and_undertime` = '$with_tardy_and_undertime'";
    }

    $sql = "SELECT * FROM `dtrsummary_selections` WHERE `year` = '$year' $filter";
    $res = $mysqli->query($sql);
    $selections = [];
    while ($row = $res->fetch_assoc()) {
        $selections[] = $row["employee_id"];
    }

    echo json_encode($selections);
    // echo json_encode([
    //     $year,
    //     $employmentStatus,
    //     $with_tardy_and_undertime
    // ]);
}


function check_if_selected($mysqli, $employee_id, $year)
{
    $sql = "SELECT * FROM `dtrsummary_selections` WHERE `employee_id` = '$employee_id' AND `year` = '$year';";
    $res = $mysqli->query($sql);
    return ($res->fetch_assoc())  ? true : false;
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

    // get employee remarks for the year start

    $identifier = $year . "_" . $employee_id;
    $sql = "SELECT * FROM `dtrsummary_remarks` WHERE `identifier` = '$identifier'";
    $res = $mysqli->query($sql);

    $dtrsummary_remarks = null;
    $general_remarks = null;

    if ($row = $res->fetch_assoc()) {
        $dtrsummary_remarks = $row;
        $general_remarks = [
            'identifier' => $identifier,
            'column_name' => 'general_remarks',
            'remarks' => $row['general_remarks']
        ];
    } else {
        $general_remarks = [
            'identifier' => $identifier,
            'column_name' => 'general_remarks',
            'remarks' => null
        ];
    }

    // get employee remarks for the year end

    // $no_tardy_and_undertime = bool
    $with_tardy_and_undertime = false;
    for ($i = 0; $i < 12; $i++) {
        $m = filter_array('dtr_month', $i + 1, $dtrs);

        $remarks = isset($dtrsummary_remarks['m' . ($i + 1)]) ? $dtrsummary_remarks['m' . ($i + 1)] : null;

        if ($m) {
            $m = $m[0];
            $m['dtrsummary_remarks'] = [
                'identifier' => $identifier,
                'column_name' => 'm' . ($i + 1),
                'remarks' => $remarks
            ];

            if ($with_tardy_and_undertime !== true) {
                if ($m['totalTardy'] > 0 || $m['totalMinsUndertime'] > 0) {
                    $with_tardy_and_undertime = true;
                }
            }

            $months[] = $m;
        } else {

            $months[] = [
                "dtrSummary_id" => null,
                "employee_id" => null,
                "month" => null,
                "totalMinsTardy" => 0,
                "totalTardy" => 0,
                "totalMinsUndertime" => 0,
                "letterOfNotice" => null,
                "halfDaysTardy" => 0,
                "halfDaysUndertime" => 0,
                "remarks" => "",
                "submitted" => null,
                "color" => null,
                "dtr_year" => null,
                "dtr_month" => null,
                "dtrsummary_remarks" => [
                    'identifier' => $identifier,
                    'column_name' => 'm' . ($i + 1),
                    'remarks' => $remarks
                ],
            ];
        }

        // $months[] =  $m ?  $m[0] : [
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
        // ];
    }

    $employment_status = $employee->get_data($employee_id) ? $employee->get_data($employee_id)['employmentStatus'] : '';
    $employee = [
        "id" => $employee_id,
        "name" => $employee->get_full_name_upper($employee_id),
        "employment_status" => $employment_status,
        "months" => $months,
        "general_remarks" => $general_remarks,
        "with_tardy_and_undertime" => $with_tardy_and_undertime,
        "is_selected" => check_if_selected($mysqli, $employee_id, $year)
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
