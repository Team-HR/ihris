<?php
 require '_connect.db.php';
 $employee_id = 2158;

$data = array(
    array(
        "elig_title"=>"testing",
        "rating"=>"12",
        "exam_date"=>"2020-06-18",
        "exam_place"=>"DGTE",
        "license_id"=>"1",
        "release_date"=>"2020-06-26"
    ),
    array(
        "elig_title"=>"asdasd",
        "rating"=>"13",
        "exam_date"=>"0000-00-00",
        "exam_place"=>"CBU",
        "license_id"=>"",
        "release_date"=>"0000-00-00"
    )
);

array_walk($data, function(&$data1){
    array_walk($data1, function(&$item1){
        $item1 = $item1?$item1:null;
    });
});

echo "<pre>".print_r($data,true)."</pre>";
// $test = null;

var_dump($data);

