<?php
require "_connect.db.php";
require "libs/Competency.php";
$comp = new Competency;
$dept = new Department;

if (isset($_POST["get_data"])) {
    $department_id = $_POST["department_id"];
    $data = [];
    $data = $comp->generate_report_by_dept_id($department_id);
    echo json_encode($data);
} else if (isset($_GET["get_departments"])) {
    echo json_encode($dept->get_departments());
}
