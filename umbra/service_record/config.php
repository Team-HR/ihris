<?php
require_once "../../_connect.db.php";

if (isset($_POST['get_salaries'])) {
    $sql = "SELECT `monthly_salary` FROM `setup_salary_adjustments_setup` ORDER BY monthly_salary ASC";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $rslt = $stmt->get_result();
    $data = array();
    while ($row = $rslt->fetch_assoc()) {
        $data[] = number_format($row["monthly_salary"], 2, ".", ",");
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
        $data[] = $row;
    }
    echo json_encode($data);
} elseif (isset($_GET["get_positions"])) {
    $sql = "SELECT DISTINCT position FROM positiontitles ORDER BY position ASC";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row["position"];
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
    $data["sr_date_to"] = $data["sr_date_to"]?$data["sr_date_to"]:NULL;
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
        $stmt->bind_param("isssissssssss", $data["employee_id"], $data["sr_type"], $data["sr_designation"], $data["sr_salary_rate"], $data["sr_is_per_session"], $data["sr_rate_on_schedule"], $data["sr_date_from"], $data["sr_date_to"], $data["sr_place_of_assignment"], $data["sr_branch"], $data["sr_memo"], $data["sr_status"], $data["sr_remarks"]);
    } else {
        $sql = "UPDATE `service_records` SET `employee_id`= ?,`sr_type`= ?,`sr_designation`= ?,`sr_salary_rate`= ?,`sr_is_per_session`= ?,`sr_rate_on_schedule`= ?,`sr_date_from`= ?,`sr_date_to`= ?,`sr_place_of_assignment`= ?,`sr_branch`= ?,`sr_memo`= ?,`sr_status`= ?,`sr_remarks`= ? WHERE 
        `id`=?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("isssissssssssi", $data["employee_id"], $data["sr_type"], $data["sr_designation"], $data["sr_salary_rate"], $data["sr_is_per_session"], $data["sr_rate_on_schedule"], $data["sr_date_from"], $data["sr_date_to"], $data["sr_place_of_assignment"], $data["sr_branch"], $data["sr_memo"], $data["sr_status"], $data["sr_remarks"], $id_for_editing);
    }

    $stmt->execute();
    $stmt->close();

    echo json_encode("success");
}
