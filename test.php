<?php
 require '_connect.db.php';
 $employee_id = 2158;


    $schools = array(
        "elementary"=>"",
        "secondary"=>"",
        "vocational"=>"",
        "college"=>"",
        "graduate_studies"=>""
    );
echo count($schools);

echo "<pre>".print_r($schools,true)."</pre>";