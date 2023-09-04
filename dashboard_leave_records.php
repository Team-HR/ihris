<?php
require_once "libs/LeaveRecordsController.php";
$leave = new LeaveRecordsController;

if (isset($_GET["get_leave_records"])) {
    if (!$_GET["employees_id"]) return null;
    $employees_id = $_GET["employees_id"];
    
    $array_data = [];
    $leave->set_employee($employees_id);
    $array_data = $leave->get_summary();
    echo json_encode($array_data);

}
