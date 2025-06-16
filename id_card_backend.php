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
            $date = $date->format('m/d/Y');
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
        $data["address_res_country"] = mb_convert_case($row["res_country"], MB_CASE_UPPER);
        $data["contact_number"] = $row["mobile"];
        $data["emergency_name"] = $row["emergency_name"];
        $data["emergency_address"] = mb_convert_case($row["emergency_address"], MB_CASE_UPPER);
        // $data["emergency_address"] = $data["emergency_address"] ? substr($data["emergency_address"], 0, 37) . '...' : '';
        $data["emergency_number"] = $row["emergency_number"];
        $data["all"] = $row;
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
        $data["date_expire"] = "2025-12-31";
    } else {
        $data["date_expire"] = "2028-06-30";
    }
    $data["department"] = "";
    $data["section"] = "";
    $data["date_expire_formatted"] = "";
    if ($row = $res->fetch_assoc()) {
        if (isset($row["position"])) {
            $data["position"] = $row["position"];
        }
        $data["department"] = $row["department"];
        $data["section"] = $row["section"];
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
} else if (isset($data->getIdCardsDataCaptured)) {
    $department_id = isset($data->selectedDepartment->value) ? $data->selectedDepartment->value : null;
    $departments = getEmployeesByDepartments($department_id, $mysqli);
    echo json_encode($departments);
} else if (isset($data->getDepartments)) {
    $data = [];
    $sql = "SELECT * FROM `department`";
    $res = $mysqli->query($sql);
    $excepts = [23, 27, 28, 33];
    while ($row = $res->fetch_assoc()) {
        if (!in_array($row["department_id"], $excepts)) {
            $data[] = [
                "label" => $row["department"] . " (" . $row["alias"] . ")",
                "value" => $row["department_id"],
            ];
        }
    }
    echo json_encode($data);
} elseif (isset($data->tagAsPrinted)) {
    $employees_id = $data->selected_employee_data->employees_id;
    $sql = "UPDATE  `employee_id_cards` SET `printed_at` = CURRENT_TIMESTAMP WHERE `ihris_employee_id` = '$employees_id'";
    $mysqli->query($sql);
    // echo json_encode(date_default_timezone_get() . " " . date('m/d/Y h:i:s a', time()));
} else if (isset($data->saveEmployeeData)) {
    $selected_employee_data = $data->selected_employee_data;

    $employees_id = $selected_employee_data->employees_id;

    // echo json_encode(getCardFileName($employees_id, $mysqli));
    // return null;

    $firstName = $selected_employee_data->firstName;
    $lastName = $selected_employee_data->lastName;
    $middleName = $selected_employee_data->middleName;
    $extName = $selected_employee_data->extName;
    $gender = $selected_employee_data->gender;
    $empno = $selected_employee_data->empno;
    $position = $selected_employee_data->position;
    $department = $selected_employee_data->department;
    $section = $selected_employee_data->section;
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

    $frontDataUrl = $data->selected_employee_image_data->frontDataUrl;
    $backDataUrl = $data->selected_employee_image_data->backDataUrl;

    // uploadIdCard($employees_id, $frontDataUrl, "front");
    $name = getCardFileName($employees_id, $mysqli);
    _uploadIdCard($name, $frontDataUrl, "a");
    _uploadIdCard($name, $backDataUrl, "b");
    // uploadIdCard($employees_id, $backDataUrl, "back");

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
        // UPDATE query with prepared statement
        $stmt = $mysqli->prepare("UPDATE `employee_id_cards` 
        SET `position` = ?, 
            `department` = ?, 
            `section` = ?, 
            `text_formatting` = ?, 
            `photo_formatting` = ?, 
            `date_issued` = ?, 
            `date_expire` = ? 
        WHERE `ihris_employee_id` = ?");

        $stmt->bind_param(
            "ssssssss",
            $position,
            $department,
            $section,
            $text_formatting,
            $photo_formatting,
            $date_issued,
            $date_expire,
            $employees_id
        );

        $stmt->execute();
        $stmt->close();

        echo json_encode($photo_formatting);
    } else {
        // INSERT query with prepared statement
        $stmt = $mysqli->prepare("INSERT INTO `employee_id_cards` (
        `ihris_employee_id`, 
        `position`, 
        `department`, 
        `section`, 
        `text_formatting`, 
        `photo_formatting`, 
        `date_issued`, 
        `date_expire`, 
        `created_at`, 
        `updated_at`
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, current_timestamp(), current_timestamp())");

        $stmt->bind_param(
            "ssssssss",
            $employees_id,
            $position,
            $department,
            $section,
            $text_formatting,
            $photo_formatting,
            $date_issued,
            $date_expire
        );

        $stmt->execute();
        $stmt->close();

        echo json_encode("inserted");
    }


    // echo json_encode($data->photoFormat);
} else if (isset($data->getOfficeNamesForAutocomplete)) {
    $data =  getOfficeNamesForAutocomplete($mysqli);
    echo json_encode($data);
    return json_encode($data);
} else if (isset($data->getAddressesForAutocomplete)) {
    $data =  getAddressesForAutocomplete($mysqli);
    echo json_encode($data);
    return json_encode($data);
}

function getOfficeNamesForAutocomplete($mysqli)
{
    $data = [
        'departments' => [],
        'sections' => []
    ];

    // Use associative arrays as sets to prevent duplicates
    $departmentsSet = [];
    $sectionsSet = [];

    $sql = "SELECT `department`, `section` FROM `employee_id_cards`";
    $res = $mysqli->query($sql);

    while ($row = $res->fetch_assoc()) {
        if (!empty($row['department']) && !isset($departmentsSet[$row['department']])) {
            $departmentsSet[$row['department']] = true;
            $data['departments'][] = $row['department'];
        }
        if (!empty($row['section']) && !isset($sectionsSet[$row['section']])) {
            $sectionsSet[$row['section']] = true;
            $data['sections'][] = $row['section'];
        }
    }

    return $data;
}

function getAddressesForAutocomplete($mysqli)
{
    $data = [
        'res_barangays' => [],
        'res_citys' => [],
        'res_provinces' => [],
        'res_zip_codes' => []
    ];

    // Use associative arrays as sets to prevent duplicates
    $res_barangaySet = [];
    $res_citySet = [];
    $res_provinceSet = [];
    $res_zip_codeSet = [];

    $sql = "SELECT `res_barangay`,`res_city`,`res_province`, `res_zip_code` FROM `pds_personal`";
    $res = $mysqli->query($sql);

    while ($row = $res->fetch_assoc()) {
        $barangay = strtoupper($row['res_barangay']);
        $city = strtoupper($row['res_city']);
        $province = strtoupper($row['res_province']);
        $zip_code = strtoupper($row['res_zip_code']); // in case zip codes are alphanumeric

        if (!empty($barangay) && !isset($res_barangaySet[$barangay])) {
            $res_barangaySet[$barangay] = true;
            $data['res_barangays'][] = $barangay;
        }
        if (!empty($city) && !isset($res_citySet[$city])) {
            $res_citySet[$city] = true;
            $data['res_citys'][] = $city;
        }
        if (!empty($province) && !isset($res_provinceSet[$province])) {
            $res_provinceSet[$province] = true;
            $data['res_provinces'][] = $province;
        }
        if (!empty($zip_code) && !isset($res_zip_codeSet[$zip_code])) {
            $res_zip_codeSet[$zip_code] = true;
            $data['res_zip_codes'][] = $zip_code;
        }
    }

    return $data;
}



function checkIfCardExists($employees_id, $mysqli)
{
    $name = getCardFileName($employees_id, $mysqli);

    $imagePath1 = "id_cards/" . $name . "/a.jpg";
    $imagePath2 = "id_cards/" . $name . "/b.jpg";

    if (file_exists($imagePath1) && file_exists($imagePath2)) {
        return true;
    }
    return false;
}

function getEmployeesByDepartments($department_id, $mysqli)
{
    // $department_id = 32; // remove after testing
    $departments = [];
    if (!$department_id) {
        $sql = "SELECT * FROM `department` ORDER BY `department`.`department` ASC";
    } else {
        $sql = "SELECT * FROM `department` WHERE `department_id` = $department_id;";
    }

    $res = $mysqli->query($sql);
    while ($row = $res->fetch_assoc()) {
        $departmentData = getDepartmentData($row["department_id"], $mysqli);

        $row["totalAccomplishedInputs"] = $departmentData["totalAccomplishedInputs"];
        $row["totalRequiredInputs"] = $departmentData["totalRequiredInputs"];

        $row["employees"]  = $departmentData["employees"];
        $row["totalAccomplishedEmployee"] = $departmentData["totalAccomplishedEmployee"];
        $row["totalDepartmentEmployee"] = $departmentData["totalDepartmentEmployee"];
        $row["perentageCompletion"] = $departmentData["perentageCompletion"];
        $row["perentageCompletionInputs"] = $departmentData["perentageCompletionInputs"];
        $row["employeesCompleted"] = 0;
        $departments[] = $row;
    }

    $dashChartData = [];
    $labels = [];
    $values = [];
    foreach ($departments as $department) {
        $labels[] = isset($department["alias"]) ? $department["alias"] : $department["department"];
        $values[] = $department["perentageCompletionInputs"];
        $dashChartData = [
            "labels" => $labels,
            "values" => $values
        ];
    }

    return ["rows" => $departments, "dashChartData" => $dashChartData];
}

function getDepartmentData($department_id, $mysqli)
{
    $totalAccomplishedInputs = 0;
    $employees = [];
    $sql = "SELECT * FROM `employees` LEFT JOIN `employee_id_cards` ON `employees`.`employees_id` = `employee_id_cards`.`ihris_employee_id` LEFT JOIN `employees_card_number` ON `employees`.`employees_id` = `employees_card_number`.`employees_id` WHERE `employees`.`department_id` = '$department_id' AND `employees`.`status` = 'ACTIVE';";

    $res = $mysqli->query($sql);

    $totalAccomplishedEmployee = 0;
    $totalDepartmentEmployee = 0;

    while ($row = $res->fetch_assoc()) {
        $totalDepartmentEmployee++;
        $row["full_name"] = formatName($row);
        $getPercentageCompletion = getPercentageCompletion($row["employees_id"], $mysqli);
        $totalAccomplishedInputs += isset($getPercentageCompletion["filledOut"]) ? $getPercentageCompletion["filledOut"] : 0;
        $percentCompleted = isset($getPercentageCompletion["percent"]) ? $getPercentageCompletion["percent"] : '';
        if ($percentCompleted == 100) {
            $totalAccomplishedEmployee++;
        }
        $employees[] = [
            // $row["employees_id"],
            "id" => $row["id"],
            "employees_id" => $row["employees_id"],
            "full_name" => formatName($row),
            "hasIdCard" => checkIfCardExists($row["employees_id"], $mysqli),
            "completionRating" => isset($getPercentageCompletion["percent"]) ? $getPercentageCompletion["percent"] : '',
            "percentageCompletion" => isset($getPercentageCompletion["desc"]) ? $getPercentageCompletion["desc"] : '',
            "empno" => $row["empno"],
            "created_at" => $row["created_at"],
            "updated_at" => $row["updated_at"],
            "printed_at" => $row["printed_at"]
        ];
    }

    $perentageCompletion = 0;

    if ($totalAccomplishedEmployee != 0 && $totalDepartmentEmployee != 0) {
        $perentageCompletion = round(($totalAccomplishedEmployee / $totalDepartmentEmployee) * 100, 0);
    }

    $totalRequiredInputs = $totalDepartmentEmployee * 12;

    $perentageCompletionInputs = $totalRequiredInputs ? number_format($totalAccomplishedInputs / $totalRequiredInputs * 100, 0) : 0;

    return [
        "employees" => $employees,
        "totalAccomplishedEmployee" => $totalAccomplishedEmployee,
        "totalDepartmentEmployee" => $totalDepartmentEmployee,
        "totalAccomplishedInputs" => $totalAccomplishedInputs,
        "totalRequiredInputs" => $totalRequiredInputs,
        "perentageCompletionInputs" => $perentageCompletionInputs,
        "perentageCompletion" => $perentageCompletion
    ];
}

function getPercentageCompletion($employee_id, $mysqli)
{

    if (!$employee_id) return;

    $sql = "SELECT * FROM `pds_personal` WHERE `employee_id` = '$employee_id'";
    $res = $mysqli->query($sql);
    $data = [];

    if ($row = $res->fetch_assoc()) {
        $data = getEmployeeInformation($mysqli, $employee_id);

        $data["date_of_birth"] = "";

        if ($row["birthdate"]) {
            $date = new DateTimeImmutable($row["birthdate"]);
            $date = $date->format('m/d/Y');
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

    // if ($data["employmentStatus"] == "CASUAL") {
    //     $data["date_expire"] = "2024-06-30";
    // } else {
    //     $data["date_expire"] = "2025-06-30";
    // }

    $data["date_expire_formatted"] = "";
    if ($row = $res->fetch_assoc()) {
        if (isset($row["position"])) {
            $data["position"] = $row["position"];
        }
        // $data["text_formatting"] = json_decode($row["text_formatting"]);
        $data["sig_src"] = isset($row["sig_src"]) ? true : null;
        // $data["photo_formatting"] = json_decode($row["photo_formatting"]);
        $data["date_issued"] = $row["date_issued"] ? $row["date_issued"] : $data["date_issued"];
        $data["date_expire"] = $row["date_expire"] ? $row["date_expire"] : $data["date_expire"];
    }

    $data["date_issued_formatted"] = mb_convert_case(dateFormat($data["date_issued"]), MB_CASE_UPPER);
    $data["date_expire_formatted"] = mb_convert_case(dateFormat($data["date_expire"]), MB_CASE_UPPER);

    // return $data;

    $details =  [];

    $fields = [
        "firstName",
        "lastName",
        "gender",
        "position",
        // "position_function",
        "date_of_birth",
        "blood_type",
        "birthdate",
        "address",
        "contact_number",
        "emergency_name",
        "emergency_number",
        // "emergency_address"
        "sig_src",
    ];


    foreach ($fields as $field) {
        if (isset($data[$field]) && $data[$field] != null) {
            $details[] = $data[$field];
        }
    }

    // return json_encode($details);    

    $totalRequiredDetails = count($fields);
    $nonEmptyDetails = 0;
    foreach ($details as $detail) {
        if ($detail) {
            $nonEmptyDetails++;
        }
    }

    // return $nonEmptyDetails . "/" . $totalRequiredDetails;

    $perentageCompletion = round(($nonEmptyDetails / $totalRequiredDetails) * 100, 0);

    return [
        "filledOut" => $nonEmptyDetails,
        "totalFields" => $totalRequiredDetails,
        "percent" => $perentageCompletion,
        "desc" => $perentageCompletion . "% Completed (" . $nonEmptyDetails . "/" . $totalRequiredDetails . ")"
    ];
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
        if ($row["employmentStatus"] != 'CASUAL') {
            $row["position"] = $row["position"] . " " . $row["position_function"];
        }
        return $row;
    }

    return [];
}

function formatName($assoc)
{
    $name = "";
    $name .= $assoc["lastName"] . ", " . $assoc["firstName"];
    $name .= $assoc["middleName"] ? " " . $assoc["middleName"][0] . "." : "";
    $name .= $assoc["extName"] ? " " . $assoc["extName"] : "";
    $assoc["middleName"] = $assoc["middleName"] ? $assoc["middleName"] : "";
    return mb_convert_case($name, MB_CASE_UPPER);
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

// function _uploadIdCard($name, $dataUrl, $face="")
// {
//     if (!$dataUrl) return;
//     $img = $dataUrl;
//     $img = str_replace('data:image/jpeg;base64,', '', $img);
//     $img = str_replace(' ', '+', $img);
//     $fileData = base64_decode($img);
//     $fileName = "id_cards/" . $name . "/" .$face. ".jpg";
//     file_put_contents($fileName, $fileData);
// }
function _uploadIdCard($name, $dataUrl, $face = "")
{
    if (!$dataUrl) return;

    // Decode base64 image
    $img = str_replace('data:image/jpeg;base64,', '', $dataUrl);
    $img = str_replace(' ', '+', $img);
    $fileData = base64_decode($img);

    // Define directory and file path
    $dir = "id_cards/" . $name;
    $fileName = $dir . "/" . $face . ".jpg";

    // Create directory if it doesn't exist
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true); // true for recursive, 0755 permissions
    }

    // Save the file
    file_put_contents($fileName, $fileData);
}

function uploadIdCard($employees_id, $dataUrl, $prefix = "")
{
    if (!$dataUrl) return;
    $img = $dataUrl;
    $img = str_replace('data:image/jpeg;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $fileData = base64_decode($img);
    $fileName = "id_cards/" . $employees_id . "_" . $prefix . ".jpg";
    file_put_contents($fileName, $fileData);
}

function getCardFileName_($employee_id, $mysqli)
{
    $data = [];
    $sql = "SELECT * FROM `employees`";
    $res = $mysqli->query($sql);


    while ($employee = $res->fetch_assoc()) {
        $firstName = $employee["firstName"];
        $lastName = $employee["lastName"];
        $middleName = $employee["middleName"];
        $extName = $employee["extName"];


        $nameParts = [$lastName, $firstName];

        if ($middleName) {
            $nameParts[] = $middleName;
        }

        if ($extName) {
            $nameParts[] = $extName;
        }

        $nameParts = array_map(function ($part) {
            return str_replace(' ', '_', $part);
        }, array_filter([$lastName, $firstName, $middleName, $extName]));

        $name = implode('_', $nameParts);
        $name = cleanNamePart($name);
        $data[] = $name;
    }


    return $data;
}


function getCardFileName($employee_id, $mysqli)
{
    $name = "";
    $sql = "SELECT * FROM `employees` WHERE `employees_id` = '$employee_id'";
    $res = $mysqli->query($sql);
    if ($employee = $res->fetch_assoc()) {
        $firstName = $employee["firstName"];
        $lastName = $employee["lastName"];
        $middleName = $employee["middleName"];
        $extName = $employee["extName"];

        $nameParts = [$lastName, $firstName];

        if ($middleName) {
            $nameParts[] = $middleName;
        }

        if ($extName) {
            $nameParts[] = $extName;
        }

        $nameParts = array_map(function ($part) {
            return str_replace(' ', '_', $part);
        }, array_filter([$lastName, $firstName, $middleName, $extName]));

        $name = implode('_', $nameParts);
        $name = cleanNamePart($name);
    }
    return $name;
}

function cleanNamePart($str)
{
    $str = str_replace(' ', '_', $str);   // Replace spaces with underscores
    $str = str_replace('.', '', $str);    // Remove periods
    return $str;
}
