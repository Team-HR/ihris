<?php
require_once "_connect.db.php";

$sql = "SELECT * FROM `employees_card_number`";
$res = $mysqli->query($sql);
$data = [];
while ($row = $res->fetch_assoc()) {
    $data[] = $row;
}

$queries = [];
// "employees_id": "432369",
//         "empid": "3678",
//         "objid": "3678",
//         "dtrno": "438",
//         "empno": "32429"

foreach ($data as $emp) {
    $employees_id = $emp['employees_id'];
    $empid = $emp['empid'];
    $objid = $emp['objid'];
    $dtrno = $emp['dtrno'];
    $empno = $emp['empno'];

    $sql = "UPDATE `employees` SET `empid`='$empid', `objid` = '$objid', `dtrno` = '$dtrno', `empno` = '$empno' WHERE `employees_id` = '$employees_id';";
    $queries[] = $mysqli->query($sql);
}

$json = json_encode($queries, JSON_PRETTY_PRINT);

echo "<pre> $json </pre>";
