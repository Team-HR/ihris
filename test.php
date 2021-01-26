<?php
require_once "_connect.db.php";
$sql = "SELECT * from dtrManagement where `emp_id`='4' and `dtr_date`='2021-08'";
$sql = $mysqli->query($sql);
$result = $sql->fetch_assoc();
echo count(NULL);
// echo count($result);