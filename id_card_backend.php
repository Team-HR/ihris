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
        $middleName = $row["middleName"] ? " " . $row["middleName"] : "";
        $extName = $row["extName"] ? " " . $row["extName"] : "";

        $data[] = [
            "label" => $lastName . ", " . $firstName . $middleName . $extName,
            "value" => $row["employees_id"],
        ];
    }

    echo json_encode($data);
} elseif (isset($data->uploadPhoto)) {
    # code...
    $employees_id = $data->employees_id;
    $formData = $data->formData;
    echo json_encode($formData);
} elseif (isset($data->getPhoto)) {
    $employees_id = $data->employees_id;
    $imagePath = "id_photos/" . $employees_id . ".jpg";

    if (file_exists($imagePath)) {
        $imageData = file_get_contents($imagePath);
        $base64 = base64_encode($imageData);
        $imageBase64 = 'data:image/jpeg;base64,' . $base64;
        echo json_encode($imageBase64);
    }
} elseif (isset($data->saveImageCaptured)) {
    $img = $data->dataUrl;
    $employees_id = $data->employees_id;
    $img = str_replace('data:image/jpeg;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $fileData = base64_decode($img);
    //saving
    $fileName = "id_photos/" . $employees_id . '.jpg';
    file_put_contents($fileName, $fileData);

    echo json_encode($employees_id);
} elseif (isset($data->savePendata)) {
    $m_penData = $data->m_penData;

    $m_penData = json_encode($m_penData);

    $employees_id = $data->employees_id;

    $sql = "SELECT * FROM `employee_id_cards` WHERE `ihris_employee_id` = '$employees_id';";
    $res = $mysqli->query($sql);

    if ($row = $res->fetch_assoc()) {
        $sql = "UPDATE `employee_id_cards` SET `sig_src`='$m_penData' WHERE `ihris_employee_id` = '$employees_id'";
    } else {
        $sql = "INSERT INTO `employee_id_cards` (`ihris_employee_id`, `sig_src`, `created_at`, `updated_at`) VALUES ( '$employees_id', '$m_penData', current_timestamp(), current_timestamp())";
    }
    $mysqli->query($sql);

    echo json_encode($m_penData);
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
        $data["birthdate"] = $row["birthdate"];
        $address = "";
        $address .= $row["res_house_no"] ? $row["res_house_no"] . ", " : "";
        $address .= $row["res_street"] ? $row["res_street"] . ", " : "";
        $address .= $row["res_subdivision"] ? $row["res_subdivision"] . ", " : "";
        $address .= $row["res_barangay"] ? $row["res_barangay"] . ", " : "";
        $address .= $row["res_city"] ? $row["res_city"] . ", " : "";
        $address .= $row["res_province"] ? $row["res_province"] . " " : "";
        $address .= $row["res_zip_code"] ? $row["res_zip_code"] : "";
        // $data["address"] = $address ? substr($address, 0, 46) . '...' : '';
        $data["address"] = mb_convert_case($address, MB_CASE_UPPER);
        $data["address_res_house_no"] = mb_convert_case($row["res_house_no"], MB_CASE_UPPER);
        $data["address_res_street"] = mb_convert_case($row["res_street"], MB_CASE_UPPER);
        $data["address_res_subdivision"] = mb_convert_case($row["res_subdivision"], MB_CASE_UPPER);
        $data["address_res_barangay"] = mb_convert_case($row["res_barangay"], MB_CASE_UPPER);
        $data["address_res_city"] = mb_convert_case($row["res_city"], MB_CASE_UPPER);
        $data["address_res_province"] = mb_convert_case($row["res_province"], MB_CASE_UPPER);
        $data["address_res_zip_code"] = mb_convert_case($row["res_zip_code"], MB_CASE_UPPER);
        $data["contact_number"] = $row["mobile"];
        $data["emergency_name"] = $row["emergency_name"];
        $data["emergency_address"] = mb_convert_case($row["emergency_address"], MB_CASE_UPPER);
        // $data["emergency_address"] = $data["emergency_address"] ? substr($data["emergency_address"], 0, 37) . '...' : '';
        $data["emergency_number"] = $row["emergency_number"];
    }


    // get id text formatting values
    $sql = "SELECT * FROM `employee_id_cards` WHERE `ihris_employee_id` = '$employee_id'";
    $res = $mysqli->query($sql);

    $data["text_formatting"] = null;
    $data["photo_formatting"] = null;
    $data["sig_src"] = null;
    $data["date_issued"] = date("Y-m-d");
    $data["date_expire"] = "";
    if ($data["employmentStatus"] == "CASUAL") {
        $data["date_expire"] = "2024-06-30";
    } else {
        $data["date_expire"] = "2025-06-30";
    }

    $data["date_expire_formatted"] = "";
    if ($row = $res->fetch_assoc()) {

        if (isset($row["position"]) || $row["position"]) {
            $data["position"] = $row["position"];
        }

        $data["text_formatting"] = json_decode($row["text_formatting"]);
        $data["sig_src"] = json_decode($row["sig_src"]);
        $data["photo_formatting"] = json_decode($row["photo_formatting"]);
        $data["date_issued"] = $row["date_issued"] ? $row["date_issued"] : $data["date_issued"];
        $data["date_expire"] = $row["date_expire"] ? $row["date_expire"] : $data["date_expire"];
    }

    $data["date_issued_formatted"] = mb_convert_case(dateFormat($data["date_issued"]), MB_CASE_UPPER);
    $data["date_expire_formatted"] = mb_convert_case(dateFormat($data["date_expire"]), MB_CASE_UPPER);

    // $date_issued = mb_convert_case(date("F d, Y"), MB_CASE_UPPER);
    // $row["date_issued"] = $date_issued;
    // $date_expire = "";

    // $t = strtotime($date_issued);
    // $validity = "+6 years";
    // $date_expire = strtotime($validity, $t);


    // $row["date_expire"] = mb_convert_case(date("F d, Y", $date_expire), MB_CASE_UPPER);

    // if ($row["employmentStatus"] == 'CASUAL') {
    //     $row["date_expire"]  = "";
    // }


    echo json_encode($data);
} else if (isset($data->saveEmployeeData)) {
    $selected_employee_data = $data->selected_employee_data;

    $employees_id = $selected_employee_data->employees_id;
    $firstName = $selected_employee_data->firstName;
    $lastName = $selected_employee_data->lastName;
    $middleName = $selected_employee_data->middleName;
    $extName = $selected_employee_data->extName;
    $gender = $selected_employee_data->gender;
    $empno = $selected_employee_data->empno;
    $position = $selected_employee_data->position;

    $birthdate = $selected_employee_data->birthdate;
    $blood_type = $selected_employee_data->blood_type;
    $address_res_barangay = $selected_employee_data->address_res_barangay;
    $address_res_city = $selected_employee_data->address_res_city;
    $address_res_zip_code = $selected_employee_data->address_res_zip_code;
    $address_res_province = $selected_employee_data->address_res_province;
    $contact_number = $selected_employee_data->contact_number;
    $emergency_name = $selected_employee_data->emergency_name;
    $emergency_number = $selected_employee_data->emergency_number;
    $emergency_address = $selected_employee_data->emergency_address;
    $date_issued = $selected_employee_data->date_issued;
    $date_expire = $selected_employee_data->date_expire;


    // update employees table
    $sql = "UPDATE `employees` SET `firstName`='$firstName',`lastName`='$lastName',`middleName`='$middleName',`extName`='$extName',`gender`='$gender',`empno`='$empno' WHERE `employees_id` = '$employees_id'";
    $mysqli->query($sql); // uncomment to execute query

    // update/insert pds_personal

    $sql = "SELECT * FROM `pds_personal` WHERE `employee_id` = '$employees_id'";
    $res = $mysqli->query($sql);
    if ($row = $res->fetch_assoc()) {
        $query = "UPDATE `pds_personal` SET `birthdate` = '$birthdate', `blood_type` = '$blood_type', `res_barangay` = '$address_res_barangay', `res_city` = '$address_res_city', `res_zip_code` = '$address_res_zip_code', `res_province` = '$address_res_province', `mobile` = '$contact_number', `emergency_name` = '$emergency_name', `emergency_number` = '$emergency_number', `emergency_address` = '$emergency_address' WHERE `employee_id` = '$employees_id'";
    } else {
        $query = "INSERT INTO `pds_personal` (`employee_id`, `birthdate`, `blood_type`, `res_barangay`, `res_city`, `res_zip_code`, `res_province`, `mobile`, `emergency_name`,  `emergency_number`, `emergency_address`) VALUES ('$employees_id', '$birthdate', '$blood_type','$address_res_barangay', '$address_res_city', '$address_res_zip_code',  '$address_res_province', '$contact_number', '$emergency_name', '$emergency_number', '$emergency_address')";
    }

    $mysqli->query($query); // uncomment to execute query

    $sql = "SELECT * FROM `employee_id_cards` WHERE `ihris_employee_id` = '$employees_id';";
    $res = $mysqli->query($sql);

    $text_formatting = json_encode($data->textFormat);
    $photo_formatting = json_encode($data->photoFormat);

    if ($row = $res->fetch_assoc()) {
        $sql = "UPDATE `employee_id_cards` SET `position` ='$position' , `text_formatting`='$text_formatting', `photo_formatting`='$photo_formatting', `date_issued` = '$date_issued', `date_expire` = '$date_expire' WHERE `ihris_employee_id` = '$employees_id'";
        $mysqli->query($sql);
    } else {
        $sql = "INSERT INTO `employee_id_cards` (`ihris_employee_id`, `position`, `text_formatting`, `photo_formatting`, `date_issued`,
        `date_expire`, `created_at`, `updated_at`) VALUES ( '$employees_id', '$position', '$text_formatting', '$photo_formatting', '$date_issued', '$date_expire', current_timestamp(), current_timestamp())";
        $mysqli->query($sql);
    }

    echo json_encode($data->textFormat);
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
        $row["middleName"] = $row["middleName"] ? $row["middleName"] : "";
        $row["name"] = mb_convert_case($name, MB_CASE_UPPER);
        $row["position"] = getPositionInformation($mysqli, $row["position_id"])["position"];
        $row["position_function"] = getPositionInformation($mysqli, $row["position_id"])["function"];
        $row["position"] = $row["position"] . " " . $row["position_function"];
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


function dateFormat($dateInput)
{
    if (!$dateInput) return null;
    $dateFormatted = new DateTimeImmutable($dateInput);
    return $dateFormatted->format('F d, Y');
}
