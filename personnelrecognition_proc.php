<?php
require '_connect.db.php';
require 'libs/NameFormatter.php';
// $nameFormatter = new NameFormatter;

if (isset($_POST['get_data'])) {
    // $sql = "SELECT `employees`.`employees_id` AS `emp_id`,`firstName`,`lastName`,`middleName`,`extName`,`department`,`position`,`recognition` FROM `employees` LEFT JOIN `department` ON `employees`.`department_id` = `department`.`department_id` LEFT JOIN `positiontitles` ON `employees`.`position_id` = `positiontitles`.`position_id` LEFT JOIN `rnr_recognitions` ON `employees`.`employees_id` = `rnr_recognitions`.`employees_id` ORDER BY `lastName` ASC";
    $sql = "SELECT `employees`.`employees_id` AS `emp_id`,`firstName`,`lastName`,`middleName`,`extName`,`department`,`position`,`recognition` FROM `employees` LEFT JOIN `department` ON `employees`.`department_id` = `department`.`department_id` LEFT JOIN `positiontitles` ON `employees`.`position_id` = `positiontitles`.`position_id` LEFT JOIN `rnr_recognitions` ON `employees`.`employees_id` = `rnr_recognitions`.`employees_id` ORDER BY `lastName` ASC LIMIT 50";
    $result = $mysqli->query($sql);
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $employees_id = $row["emp_id"];
        $nameFormatter = new NameFormatter($row["firstName"], $row["lastName"], $row["middleName"], $row["extName"]);
        $row['fullName'] = mb_convert_case($nameFormatter->getFullname(), MB_CASE_UPPER, "UTF-8");
        // $row;

        $row["recs"] = get_awards($employees_id, $mysqli);

        $data[] = $row;
    }

    echo json_encode($data);
} elseif (isset($_POST["loadEntry"])) {
    $employees_id = $_POST["employees_id"];
    $sql = "SELECT * FROM `rnr_recognitions` WHERE `employees_id` = '$employees_id'";
    $result = $mysqli->query($sql);
    $num_rows = $result->num_rows;
    $data = array();
    if ($num_rows > 0) {
        $row = $result->fetch_assoc();
        $data = unserialize($row["recognition"]);
    } else {
        $recognition = serialize($data);
        if ($stmt = $mysqli->prepare("INSERT INTO `rnr_recognitions` (`recognition_id`, `employees_id`, `recognition`, `timestamp`) VALUES (NULL, ?, ?, CURRENT_TIMESTAMP)")) {
            $stmt->bind_param("is", $employees_id, $recognition);
            $stmt->execute();
            $stmt->close();
        }
    }
    echo json_encode($data);
} elseif (isset($_POST["updateEntry"])) {
    $employee_id = $_POST["employees_id"];
    $recs =  $_POST["recs"];
    if (count($recs) == 0) {
        $sql = "DELETE FROM `pds_non_academic_recognitions` WHERE `pds_non_academic_recognitions`.`employee_id` = $employee_id";
        $mysqli->query($sql);
        // $mysqli->close();
        return false;
    }
    
    // if ($stmt = $mysqli->prepare("UPDATE `rnr_recognitions` SET `recognition`=? WHERE `employees_id`=?")) {
    //     $stmt->bind_param("si", $recognition, $employees_id);
    //     $stmt->execute();
    //     $stmt->close();
    // }
    $employee_id = $mysqli->real_escape_string($employee_id);
    $sql = "DELETE FROM `pds_non_academic_recognitions` WHERE `pds_non_academic_recognitions`.`employee_id` = $employee_id";
    $mysqli->query($sql);
    // $mysqli->close();
    // echo json_encode($mysqli->error);

    foreach ($recs as $rec) {
        $rec = $mysqli->real_escape_string($rec);
        $sql = "INSERT INTO `pds_non_academic_recognitions` (`id`,`employee_id`, `nar_title`) VALUES (NULL,$employee_id, '$rec')";
        $mysqli->query($sql);
    }
    // $mysqli->close();
    
    // echo json_encode($mysqli->error);
}

function get_awards($employees_id, $mysqli)
{
    $data = [];
    if (!$employees_id) return $data;
    $employees_id = $mysqli->real_escape_string($employees_id);

    $sql = "SELECT * FROM `pds_non_academic_recognitions` WHERE `employee_id` = $employees_id";

    $result = $mysqli->query($sql);

    while ($row = $result->fetch_assoc()) {
        $datum = $row['nar_title'];
        $data[] = $datum;
    }

    return $data;
}
