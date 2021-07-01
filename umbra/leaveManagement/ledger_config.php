<?php
require_once '../../_connect.db.php';

if (isset($_GET['getLedger'])) {
    $employee_id = $_GET['employee_id'];
    $sql =  "SELECT * from `lm_logs` left join `lm_earnings` on `lm_logs`.`employees_id`=`lm_earnings`.`emp_id` WHERE `lm_logs`.`employees_id`= $employee_id ORDER BY `date_filed` DESC";
        $sql = $mysqli->query($sql);
        $a = [];
        while($ar = $sql->fetch_assoc()){
            $a[]  = $ar;
        }
        echo json_encode($a);
}
