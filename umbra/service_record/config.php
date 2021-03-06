<?php
require_once "../../_connect.db.php";

if (isset($_POST['get_salaries'])) {
    $sql = "SELECT `monthly_salary` FROM `setup_salary_adjustments_setup` ORDER BY monthly_salary ASC";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $rslt = $stmt->get_result();
    $data = array();
    while ($row = $rslt->fetch_assoc()) {
        $yearly_salary = $row["monthly_salary"] * 12;
        $data[] = array(
            "text" => number_format($yearly_salary, 2, ".", ","),
            "value" => $yearly_salary,
        );
    }
    echo json_encode($data);
} elseif (isset($_GET['get_place_of_assignments'])) {
    $sql = "SELECT DISTINCT `sr_place_of_assignment` FROM `service_records` WHERE `sr_place_of_assignment` !='' AND `sr_place_of_assignment` IS NOT NULL ORDER BY `sr_place_of_assignment` ASC";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $rslt = $stmt->get_result();
    $data = array();
    while ($row = $rslt->fetch_assoc()) {
        $data[] = $row["sr_place_of_assignment"];
    }
    echo json_encode($data);
} elseif (isset($_GET['init_load'])) {
    $employee_id = $_GET['employee_id'];
    $sql = "SELECT * FROM `service_records` WHERE `employee_id` = ? ORDER BY `sr_date_from`,`sr_date_to` ASC";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = array();
    while ($row = $result->fetch_assoc()) {
        // $id = "sr_".$row["id"];
        // $data[$id] = $row;
        // $row["sr_salary_rate"] = number_format($row["sr_salary_rate"], 2, ".", ",");
        // $annual_salary = 

        $sr_salary_rate = $row["sr_salary_rate"];
        $sr_rate_on_schedule = $row["sr_rate_on_schedule"];


        // if casual
        if ($row["sr_status"] === 'CASUAL') {
            $row["annual_salary"] = "";
            if ($row["sr_salary_rate"]) {
                $row["annual_salary"] = format_salary($row["sr_salary_rate"]) . " /DAY";
            } elseif ($row["sr_rate_on_schedule"]) {
                $row["annual_salary"] = format_salary($row["sr_rate_on_schedule"]) . " /DAY";
            } else {
                $row["annual_salary"] = "N/I";
            }
        } else {
            // if permanent
            $row["annual_salary"] = "";
            if ($row["sr_salary_rate"]) {
                $row["annual_salary"] = format_salary($row["sr_salary_rate"]) . " /ANNUAL";
            } elseif ($row["sr_rate_on_schedule"]) {
                $row["annual_salary"] = format_salary($row["sr_rate_on_schedule"]) . " /ANNUAL";
            } else {
                $row["annual_salary"] = "N/I";
            }
        }

        // $row["annual_salary"] = $row["sr_salary_rate"] || $row["sr_rate_on_schedule"] ? (number_format(($row["sr_salary_rate"] ? ($row["sr_status"] === 'CASUAL' ? ($row["sr_salary_rate"] / 22) . "/day" : $row["sr_salary_rate"] . "/month") : $row["sr_rate_on_schedule"]), 2, ".", ",") . "/month") : "N/I";
        // $r
        $data[] = $row;
    }
    echo json_encode($data);
} elseif (isset($_GET["get_positions"])) {
    $sql = "SELECT position, functional FROM positiontitles ORDER BY position ASC";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $position = $row["position"];
        $function = $row["functional"];
        $data[] = $position . ($function ? " " . $function : "");
    }
    echo json_encode($data);
} elseif (isset($_POST['init_delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM `service_records` WHERE `id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $affected_rows = $stmt->affected_rows;
    $stmt->close();
    echo json_encode($affected_rows);
} elseif (isset($_POST['submit_form'])) {
    $data = $_POST["data"];
    $id_for_editing = $_POST["id_for_editing"];
    $data["sr_date_to"] = $data["sr_date_to"] ? $data["sr_date_to"] : NULL;
    if (
        empty($data["sr_type"]) ||
        empty($data["sr_designation"]) ||
        empty($data["sr_status"]) ||
        // sr_salary_rate
        // sr_rate_on_schedule
        // sr_is_per_session
        empty($data["sr_date_from"]) ||
        // empty($data["sr_date_to"]) ||
        empty($data["sr_place_of_assignment"]) ||
        empty($data["sr_branch"])
        // sr_remarks
        // sr_memo
    ) return false;

    array_walk($data, function (&$item1) {
        $item1 = strtoupper($item1);
    });

    if (empty($id_for_editing)) {
        $sql = "INSERT INTO `service_records` (`employee_id`, `sr_type`, `sr_designation`, `sr_salary_rate`, `sr_is_per_session`, `sr_rate_on_schedule`, `sr_date_from`, `sr_date_to`, `sr_place_of_assignment`, `sr_branch`, `sr_memo`, `sr_status`, `sr_remarks`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("issdidsssssss", $data["employee_id"], $data["sr_type"], $data["sr_designation"], $data["sr_salary_rate"], $data["sr_is_per_session"], $data["sr_rate_on_schedule"], $data["sr_date_from"], $data["sr_date_to"], $data["sr_place_of_assignment"], $data["sr_branch"], $data["sr_memo"], $data["sr_status"], $data["sr_remarks"]);
    } else {
        $sql = "UPDATE `service_records` SET `employee_id`= ?,`sr_type`= ?,`sr_designation`= ?,`sr_salary_rate`= ?,`sr_is_per_session`= ?,`sr_rate_on_schedule`= ?,`sr_date_from`= ?,`sr_date_to`= ?,`sr_place_of_assignment`= ?,`sr_branch`= ?,`sr_memo`= ?,`sr_status`= ?,`sr_remarks`= ? WHERE 
        `id`=?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("issdidsssssssi", $data["employee_id"], $data["sr_type"], $data["sr_designation"], $data["sr_salary_rate"], $data["sr_is_per_session"], $data["sr_rate_on_schedule"], $data["sr_date_from"], $data["sr_date_to"], $data["sr_place_of_assignment"], $data["sr_branch"], $data["sr_memo"], $data["sr_status"], $data["sr_remarks"], $id_for_editing);
    }

    $stmt->execute();
    $stmt->close();

    echo json_encode("success");
} elseif (isset($_POST['get_remarks'])) {
    // for remarks autocompletetion
    $data = array();
    $sql = "SELECT DISTINCT `sr_remarks` FROM `service_records`  
    ORDER BY `service_records`.`sr_remarks` ASC";
    $res = $mysqli->query($sql);
    while ($row = $res->fetch_assoc()) {
        $datum = array(
            "label"=> $row["sr_remarks"],
            "value"=> $row["sr_remarks"],
        );
        $data[] = $datum;
    }
    echo json_encode($data);
}

function format_salary($yearly_salary){
    if (!$yearly_salary) return "";
    return number_format($yearly_salary, 2, ".", ",");
}