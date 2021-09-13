<?php
require "libs/Competency.php";
require "libs/Department.php";

$comp = new Competency;
$dept = new Department;

if (isset($_GET["get_departments"])) {
    echo json_encode($dept->get_departments());
} elseif (isset($_GET["get_data"])) {
    $department_id = $_GET["department_id"];
    $data = [];
    $data = $comp->generate_report_by_dept_id($department_id);
    echo json_encode($data);
}
