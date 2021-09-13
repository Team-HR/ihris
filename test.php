<?php
require_once "libs/Competency.php";
require_once "libs/Department.php";

$comp = new Competency;
$dept = new Department;


// $array_data = $comp->generate_report_by_dept_id(7);
// $array_data = $dept->get_departments();
$array_data = $comp->generate_report_by_dept_id(7);
// var_dump($array_data);

print("<pre>".print_r($array_data,true)."</pre>");




