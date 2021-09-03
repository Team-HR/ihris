<?php

require "_connect.db.php";

$sql = "SELECT * FROM `rsp_applicants` WHERE `applicant_id` = '334'";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();

// $exp = unserialize($row["experience"]);

print("<pre>".print_r($row,true)."</pre>");


$exp = unserialize($row["experience"]);

print("<pre>".print_r($exp,true)."</pre>");
