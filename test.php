<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once "_connect.db.php";

$request_body = file_get_contents('php://input');
$data = json_decode($request_body);

if (isset($data->getEmployeeList)) {
    // require_once
    // echo json_encode("test");
    $sql = "SELECT * FROM `employees` WHERE `status` = 'ACTIVE' ORDER BY `lastName` ASC";
    $res = $mysqli->query($sql);
    $data = [];

    while ($row = $res->fetch_assoc()) {

        $lastName = $row["lastName"];
        $firstName = $row["firstName"];
        $middleName = $row["middleName"] ? " " . $row["middleName"][0] . "." : "";
        $extName = $row["extName"] ? " " . $row["extName"] : "";

        $data[] = [
            "label" => $lastName . ", " . $firstName . $middleName . $extName,
            "value" => $row["employees_id"],
        ];
    }

    echo json_encode($data);
} elseif (isset($data->getEmployeeData)) {

    if (!$data->employeeId) return;

    $employee_id = $data->employeeId;
    $sql = "SELECT * FROM `pds_personal` WHERE `employee_id` = '$employee_id'";
    $res = $mysqli->query($sql);
    $data = [];

    if ($row = $res->fetch_assoc()) {
        $data = getEmployeeInformation($mysqli, $employee_id);

        $data["date_of_birth"] = "";

        if ($row["birthdate"]) {
            $date = new DateTimeImmutable($row["birthdate"]);
            $date = $date->format('F d, Y');
            $data["date_of_birth"] = mb_convert_case($date, MB_CASE_UPPER);
        }

        new DateTimeImmutable('2000-01-01');

        $data["blood_type"] = $row["blood_type"];

        $address = "";
        $address .= $row["res_house_no"] ? $row["res_house_no"] . ", " : "";
        $address .= $row["res_street"] ? $row["res_street"] . ", " : "";
        $address .= $row["res_subdivision"] ? $row["res_subdivision"] . ", " : "";
        $address .= $row["res_barangay"] ? $row["res_barangay"] . ", " : "";
        $address .= $row["res_city"] ? $row["res_city"] . ", " : "";
        $address .= $row["res_province"] ? $row["res_province"] . " " : "";
        $address .= $row["res_zip_code"] ? $row["res_zip_code"] : "";
        $data["address"] = $address ? substr($address, 0, 46) . '...' : '';
        $data["emergency_name"] = $row["emergency_name"];
        $data["emergency_address"] = $row["emergency_address"];
        $data["emergency_address"] = $data["emergency_address"] ? substr($data["emergency_address"], 0, 37) . '...' : '';
        $data["emergency_number"] = $row["emergency_number"];
    }

    echo json_encode($data);
}

function getEmployeeInformation($mysqli, $employee_id)
{
    if (!$employee_id) return;

    $sql = "SELECT * FROM `employees` WHERE `employees_id` = $employee_id";
    $res = $mysqli->query($sql);

    if ($row = $res->fetch_assoc()) {
        $row["idNumber"] = $row["employees_id"];
        $row["name"] = "";
        $name = "";
        $name .= $row["lastName"] . ", " . $row["firstName"];
        $name .= $row["middleName"] ? " " . $row["middleName"][0] . "." : "";
        $name .= $row["extName"] ? " " . $row["extName"] : "";
        $row["middleName"] = $row["middleName"] ? " " . $row["middleName"][0] . "." : "";
        $row["name"] = mb_convert_case($name, MB_CASE_UPPER);
        $row["position"] = getPositionInformation($mysqli, $row["position_id"])["position"];
        $row["position_function"] = getPositionInformation($mysqli, $row["position_id"])["function"];
        $row["date_issued"] = mb_convert_case(date("F d, Y"), MB_CASE_UPPER);
        $row["date_valid_until"] = "";
        $row["sex"] = $row["gender"];

        $row["sex"] = "";
        return $row;
    }

    return [];
}

function getPositionInformation($mysqli, $position_id)
{
    $data = [
        "position" => "",
        "function" => "",
    ];

    if (!$position_id) return $data;

    $sql = "SELECT * FROM `positiontitles` WHERE `position_id` = '$position_id'";
    $res = $mysqli->query($sql);

    if ($row = $res->fetch_assoc()) {
        $data["position"] = $row["position"];
        $data["function"] = $row["functional"];
    }

    return $data;
}
