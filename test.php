<?php

require "libs/models/Competency.php";
$comp = new Competency;
$array_data = $comp->generate_report_by_dept_id(7);

print("<pre>".print_r($array_data,true)."</pre>");


