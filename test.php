<?php
require "_connect.db.php";
$data = array(
    "year" => 2020,
    "period" => 1,
    "nature" => "Reemployment"
);
$sql = "SELECT * FROM `casual_plantillas` WHERE `year` = ? AND `period` = ? AND `nature` = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sss",$data["year"],$data["period"],$data["nature"]);
$stmt->execute();
$stmt->store_result();
echo $num_rows = $stmt->num_rows;
$stmt->close();
// echo "<pre>".print_r($data,true)."</pre>";