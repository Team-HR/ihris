<?php
require "_connect.db.php";
require "libs/NameFormatter.php";

if (isset($_POST["add_new_role"])) {
    $role = $_POST["role"];
    $sql = "INSERT INTO `signatories` (`id`, `role`, `employee_id`, `name`, `position`, `date_assigned`, `date_unassigned`) VALUES (NULL, '$role', NULL, NULL, NULL, current_timestamp(), NULL)";
    $mysqli->query($sql);
    echo json_encode("success");
} 

elseif (isset($_POST["update_assignment"])) {
    $data = $_POST["data"];

    $is_internal = $data["is_internal"];

    $employee_id = $data["employee_id"];
    $name = $data["name"];
    $position = $data["position"];
    
    if($is_internal == 1){
        $name = NULL;    
        $position = NULL;
    } elseif ($is_internal == 0) {
        $employee_id = NULL;
    }

    $id = $data["id"];

    $sql = "UPDATE `signatories` SET `is_internal`= '$is_internal',`employee_id`='$employee_id',`name`='$name',`position`='$position' WHERE `id` = '$id'";

    $mysqli->query($sql);


    echo json_encode($sql);
}

elseif (isset($_POST["get_roles"])) {
    $data = array();
    $sql = "SELECT * FROM signatories";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
        if ($row["employee_id"]) {
            // get name
            $return = $mysqli->query("SELECT * FROM `employees` WHERE `employees_id`='$row[employee_id]'");
            $employee = $return->fetch_assoc();
            $name_formatter = new NameFormatter($employee["firstName"], $employee["lastName"], $employee["middleName"], $employee["extName"]);
            $row["name"] = $name_formatter->getFullNameStandardUpper();
            // get position
            $return = $mysqli->query("SELECT * FROM `positiontitles` WHERE `position_id`='$employee[position_id]'");
            $employee = $return->fetch_assoc();
            $row["position"] = $employee["position"];
        }
        array_push($data, $row);
    }
    echo json_encode($data);
} elseif (isset($_POST["get_employee_list"])) {
    $data = array();
    $sql = "SELECT * FROM `employees` ORDER BY `firstName` ASC";
    $result = $mysqli->query($sql);
    while ($employee = $result->fetch_assoc()) {
        $datum = array();
        // get id
        $datum["id"] = $employee["employees_id"];
        // get name
        $name_formatter = new NameFormatter($employee["firstName"], $employee["lastName"], $employee["middleName"], $employee["extName"]);
        $datum["name"] = $name_formatter->getFullNameStandardUpper();
        // get position
        $return = $mysqli->query("SELECT * FROM `positiontitles` WHERE `position_id`='$employee[position_id]'");
        $employee = $return->fetch_assoc();
        $datum["position"] = $employee["position"];
        array_push($data, $datum);
    }
    echo json_encode($data);
}
