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
} elseif (isset($_GET["get_competency_dictionary"])) {
    $data = $comp->competencies;
    echo json_encode($data);
} elseif (isset($_GET["get_in_depth_data"])) {
    $superior_id = $_GET["superior_id"];
    $data = [];
    // get superiors_records with superior_id
    $data = $comp->get_in_depth_data($superior_id);
    echo json_encode($data);
}
