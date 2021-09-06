<?php

require "_connect.db.php";

$arrayName = array(
    "test1" => "989123asd's &intl'''s",
    "test2" => 100213,
    "test3" => 123816,
);


$arr[0] = $mysqli->real_escape_string(json_encode($arrayName));
$arr[1] = $mysqli->real_escape_string(serialize($arrayName));
echo $arr[0];
echo "<br>";
echo $arr[1];