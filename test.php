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
        $row["position"] = getPositionInformation($mysqli, $row["position_id"])["position"];
        $row["position_function"] = getPositionInformation($mysqli, $row["position_id"])["function"];
        $row["date_of_birth"] = "";
        $row["sex"] = "";
        $row["blood_type"] = "";
        $row["address"] = "";
        $row["emergency_contact_name"] = "";
        $row["emergency_contact_address"] = "";
        $row["emergency_contact_mobile"] = "";
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
