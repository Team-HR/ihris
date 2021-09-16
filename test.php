<?php
require_once "libs/Competency.php";
require_once "libs/Department.php";
require_once "libs/LeaveRecordsController.php";

$comp = new Competency;
$dept = new Department;
$leave = new LeaveRecordsController;
$leave->set_employee(9);

$array_data = [];
$array_data = $leave->get_summary();
// $array_data = $comp->generate_report_by_dept_id(7);
// $array_data = $dept->get_departments();
// $array_data = $comp->get_in_depth_data(14);
// var_dump($array_data);
print("<pre>".print_r($array_data,true)."</pre>");

