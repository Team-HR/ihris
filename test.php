<?php
require_once "_connect.db.php";
$date = "Feb20,2021";
echo strtotime($date);
echo "<br>";
$date = "Feb21,2021";
echo strtotime($date);
echo "<br>";

$sql = "SELECT * FROM `ldactivitieslist` WHERE `act_id` = '10'";
$result = $mysqli->query($sql);

$data = array();

while ($row = $result->fetch_assoc()) {
    $data[] = array(
        "date" => $row ["date"]
    );
}

// parse string date to sortable date start



$data = add_sortable_date($data);

usort($data, function ($item1, $item2) {
    return $item2['sortable_date'] <=> $item1['sortable_date'];
});

print("<pre>".print_r($data,true)."</pre>");


// 1613836800
// 9999999999



function add_sortable_date($data) {
    if (!$data) return [];
    $data = $data;
    foreach ($data as $key=>$value) {
        $date = $value["date"];
        // $data[$key]["date_arr"] = preg_split('/[\s\,\-]+/', $date);
         $data[$key]["sortable_date"] = create_time($date);
    }
    // parse string date to sortable date end
    return $data;
}

function create_time($date){
    $err = 9999999999;
    if (!$date) return $err;
    $arr = preg_split('/[\s\,\-]+/', $date);
    $month = $arr[0]?substr($arr[0],0,3):'01';
    $day = $arr[1]?substr($arr[1],0,2):'01';
    // get length of arr
    $length = count($arr);
    $year = $length>0?$arr[$length-1]:9999;
    $date_str = $month.$day.",".$year;
    return strtotime($date_str);
}


