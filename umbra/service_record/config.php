<?php
require_once "../../_connect.db.php";
if (isset($_POST['getSalary'])) {
    $sql = "SELECT * from `setup_salary_adjustments_setup`";
    $sql = $mysqli->query($sql);
    echo json_encode(converted_arr($sql));
} elseif (isset($_POST['save_form'])) {
    $dataID = $_POST['save_form'];
    $sr_form = $_POST['sr_form'];
    $designation_form = $_POST['designation_form'];
    $status_form = $_POST['status_form'];
    $salary_form = $_POST['salary_form'];
    $session_form = $_POST['session_form'];
    $from_form = $_POST['from_form'];
    $to_form = $_POST['to_form'];
    $assign_form = $_POST['assign_form'];
    $branch_form = $_POST['branch_form'];
    $remark_form = $_POST['remark_form'];
    $memo_form = $_POST['memo_form'];
    $edit = $_POST['editData'];

    if (
        empty($dataID) ||
        empty($sr_form) ||
        empty($designation_form) ||
        empty($status_form) ||
        empty($salary_form) ||
        // empty($session_form) ||
        empty($from_form) ||
        empty($to_form) ||
        empty($assign_form) ||
        empty($branch_form) ||
        empty($remark_form) ||
        empty($memo_form)
    ) echo json_encode(array('msg' => 'data have empty field/s', 'status' => 'failed', 'dat' => array()));

    // echo json_encode($data);

    // employee_id: "21019"
    // id: "31"
    // is_per_session: "0"
    // remarks: ""
    // session: null
    // sr_branch: ""
    // sr_designation: ""
    // sr_from: ""
    // sr_memo: ""
    // sr_place_of_assignment: ""
    // sr_rate_on_schedule: ""
    // sr_salary_rate: ""
    // sr_to: ""
    // sr_type: "Build-Up"
    // status: ""




    if ($edit == "") {
        $sql = "INSERT INTO `service_records` 
                    (`id`, `employee_id`, `sr_type`, `sr_designation`, `sr_salary_rate`, `is_per_session`, `sr_rate_on_schedule`, `sr_from`, `sr_to`, `sr_place_of_assignment`, `sr_branch`, `sr_memo`, `status`,`remarks`) 
                    VALUES 
                    (NULL, '$dataID', '$sr_form', '$designation_form', '$salary_form', '$session_form', '', '$from_form', '$to_form', '$assign_form', '$branch_form', '$memo_form', '$status_form','$remark_form')";
    } else {
        $sql = "UPDATE `service_records` SET 
                        `sr_type`='$sr_form',
                        `sr_designation`='$designation_form',
                        `sr_salary_rate`='$salary_form', 
                        `is_per_session`='$session_form', 
                        `sr_from`='$from_form', 
                        `sr_to`= '$to_form', 
                        `sr_place_of_assignment`='$assign_form', 
                        `sr_branch`='$branch_form', 
                        `sr_memo`='$memo_form', 
                        `status`='$status_form',
                        `remarks`='$remark_form'
                    WHERE `service_records`.`id` = $edit        
            ";
    }

    $sql = $mysqli->query($sql);
    $sql = "SELECT * FROM `service_records` where `employee_id`='$dataID'";
    $sql = $mysqli->query($sql);
    $ar = array('msg' => 'data is saved', 'status' => 'success', 'dat' => converted_arr($sql));
    echo json_encode($ar);

} elseif (isset($_GET['init_load'])) {
    $employee_id = $_GET['employee_id'];
    $sql = "SELECT * FROM `service_records` WHERE `employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
}
// elseif (isset($_POST['remove'])) {
//     $sql = "DELETE from `service_records` where `id`='$_POST[remove]'";
//     $mysqli->query($sql);
// } 
elseif (isset($_GET["get_positions"])) {
    $sql = "SELECT DISTINCT position FROM positiontitles ORDER BY position ASC";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row["position"];//.($row["functional"]?" - ".$row["functional"]:"");
    }
    echo json_encode($data);
}
