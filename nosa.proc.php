<?php

require_once "_connect.db.php";
require_once "./libs/NameFormatter.php";

if (isset($_POST["getFolders"])) {
    $data = [];
    $sql = "SELECT * FROM `notice_of_salary_adjustments` ORDER BY created_at DESC";
    $res = $mysqli->query($sql);

    while ($row = $res->fetch_assoc()) {
        $row["dateString"] = dateToString($row["date"]);
        $row['default_new_salary'] = number_format($row['default_new_salary'], 2, '.', ',');
        $row['default_salary'] = number_format($row['default_salary'], 2, '.', ',');
        $row["date_effective"] = dateToString($row["date_effective"]);
        $data[] = $row;
    }

    echo json_encode($data);
} elseif (isset($_POST["getItems"])) {

    $notice_of_salary_adjustment_id = $_POST["id"];

    // get notice of salary adjustment information
    $sql = "SELECT * FROM notice_of_salary_adjustments WHERE id = '$notice_of_salary_adjustment_id'";
    $res = $mysqli->query($sql);
    $nosa = [];
    if ($row = $res->fetch_assoc()) {
        $nosa = $row;
    }

    $data = [];

    // $slq = "SELECT * FROM notice_of_salary_adjustment_records WHERE notice_of_salary_adjustment_id = '$id'";
    // $res = $mysqli->query($sql);


    // get casual employees_id in ihris

    $sql = "SELECT employees_id, lastName, firstName, middleName, extName, gender FROM `employees` WHERE employmentStatus = 'CASUAL' AND status = 'ACTIVE' ORDER BY lastName ASC;";

    // $sql = "SELECT employees_id, lastName, firstName, middleName, extName, gender FROM `employees` WHERE employmentStatus = 'CASUAL' AND status = 'ACTIVE' ORDER BY lastName ASC;";

    $res = $mysqli->query($sql);
    $ihris_employees = [];
    while ($row = $res->fetch_assoc()) {
        $nameFormatter = new NameFormatter($row["firstName"], $row["lastName"], $row["middleName"], $row["extName"]);
        $row["full_name"] = mb_convert_case($nameFormatter->getFullNameStandardTitle(),MB_CASE_UPPER);
        $ihris_employees[] = $row;
    }

    // get existing employee_ids from notice_of_salary_adjustment_records
    $sql = "SELECT * FROM notice_of_salary_adjustment_records WHERE notice_of_salary_adjustment_id = '$notice_of_salary_adjustment_id'";
    $res = $mysqli->query($sql);
    $nosa_employee_ids = [];
    while ($row = $res->fetch_assoc()) {
        $nosa_employee_ids[] = $row["employee_id"];
    }

    // check if casual employee already have entries if none create
    foreach ($ihris_employees as $emp) {
        if (!in_array($emp['employees_id'], $nosa_employee_ids)) {
            $honorific = "";
            if ($emp["gender"] == 'MALE') {
                $honorific =  'MR.';
            } else {
                $honorific = 'MS.';
            }

            $sql = "INSERT INTO `notice_of_salary_adjustment_records` (`notice_of_salary_adjustment_id`, `employee_id`, `honorific`,`lastName`, `firstName`, `middleName`, `extName`,`full_name`, `new_salary`, `old_salary`, `position_title`, `salary_grade`) VALUES ('$notice_of_salary_adjustment_id', '$emp[employees_id]','$honorific','$emp[lastName]','$emp[firstName]','$emp[middleName]','$emp[extName]','$emp[full_name]', '$nosa[default_new_salary]', '$nosa[default_salary]', '$nosa[default_position_title]', '$nosa[default_salary_grade]')";
            $mysqli->query($sql);
        }
    }


    // get all records from notice_of_salary_adjustment_records
    $sql = "SELECT * FROM notice_of_salary_adjustment_records WHERE notice_of_salary_adjustment_id = '$notice_of_salary_adjustment_id'";
    $res = $mysqli->query($sql);
    while ($row = $res->fetch_assoc()) {
        $nameFormatter = new NameFormatter($row["firstName"], $row["lastName"], $row["middleName"], $row["extName"]);
        $row['full_name_upper'] = mb_convert_case($row['honorific']." ".$nameFormatter->getFullName(), MB_CASE_UPPER);
        $row['new_salary'] = number_format($row['new_salary'], 2, '.', ',');
        $row['old_salary'] = number_format($row['old_salary'], 2, '.', ',');
        $row["is_checked"] = $row["is_checked"]==1?true:false;
        $data[] = $row;
    }

    echo json_encode($data);
    // echo json_encode($nosa_employee_ids);
} elseif (isset($_POST['changeCheck'])) {
    $id = $_POST["id"];
    $is_checked = $_POST["is_checked"];

    if ($is_checked=='true') {
        $is_checked = 1;
    } else {
        $is_checked = 0;
    }

    $sql = "UPDATE notice_of_salary_adjustment_records SET is_checked = '$is_checked' WHERE id = '$id';";
    // echo json_encode($is_checked);
    $mysqli->query($sql);

} elseif (isset($_POST['saveEdit'])) {
    $details = $_POST["details"];

    $sql = "UPDATE notice_of_salary_adjustment_records SET honorific = '$details[honorific]', full_name = '$details[full_name]', new_salary = '$details[new_salary]', old_salary = '$details[old_salary]' WHERE id = '$details[id]';";
    $res = $mysqli->query($sql);
    echo json_encode($res);
}




function dateToString($date)
{
    $date = new DateTime($date);
    $dateString = $date->format("F j, Y");
    return $dateString; // Example: 2025-09-10 12:34:56
}
