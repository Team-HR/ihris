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
    ),
    array(
        "elig_title"=>"",
        "rating"=>"",
        "exam_date"=>"0000-00-00",
        "exam_place"=>"",
        "license_id"=>"",
        "release_date"=>"0000-00-00"
    )
);

array_walk($data, function(&$data1,$key){
    array_walk($data1, function(&$item1){
        if ($item1 == "0000-00-00") {
            $item1  = null;
        }
        $item1 = !empty($item1)?$item1:null;
    });
    
});


echo "<br>";
echo "<pre>".print_r($data,true)."</pre>";
// $test = null;
echo "<br>";
echo "<br>";
echo "<br>";
var_dump($data);
echo "<br>";
echo "<br>";
echo "<br> AFTER UNSET";