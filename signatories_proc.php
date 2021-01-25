<?php
require "_connect.db.php";
require "libs/NameFormatter.php";

if (isset($_POST["add_new_role"])) {
    $role = $_POST["role"];
    $sql = "INSERT INTO `signatory_roles` (`role`) VALUES ('$role')";
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
        $sql = "SELECT `firstName`, `lastName`, `middleName`, `extName` FROM `employees` WHERE `employees_id` = '$employee_id'";
        $res = $mysqli->query($sql);
        if ($emp = $res->fetch_assoc()) {
            $name_formatter = new NameFormatter($emp["firstName"], $emp["lastName"], $emp["middleName"], $emp["extName"]);
            $name = $name_formatter->getFullNameStandardUpper();
        } else {
            $name = NULL;
        }
        $position = NULL;
    } elseif ($is_internal == 0) {
        $employee_id = NULL;
    }

    $id = $data["id"];
    $role = $data["role"];

    // $output = array();
    // $output["name"] = $name;
    // $output["position"] = $position;

    $sql = "INSERT INTO `signatory_saves` (`signatory_role_id`, `is_internal`, `employee_id`, `name`, `position`) VALUES ('$id', '$is_internal', '$employee_id', '$name', '$position')";
    $mysqli->query($sql);
    $signatory_save_id = $mysqli->insert_id;

    $sql = "UPDATE `signatory_roles` SET `signatory_save_id` = '$signatory_save_id' WHERE `id` = '$id'";
    $mysqli->query($sql);

    echo json_encode($signatory_save_id);
}

elseif (isset($_POST["get_roles"])) {
    $data = array();
    $sql = "SELECT signatory_roles.*,is_internal,employee_id,name,position,date_assigned,date_unassigned FROM signatory_roles LEFT JOIN signatory_saves ON signatory_roles.signatory_save_id = signatory_saves.id";
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

        if ($row["is_internal"]=== NULL) {
            $row["is_internal"] = 1;
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
        if ($employee = $return->fetch_assoc()) {
            $datum["position"] = $employee["position"];
        } else $datum["position"] = "";
        
        array_push($data, $datum);
    }
    echo json_encode($data);
}
