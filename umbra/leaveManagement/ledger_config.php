<?php
require_once '../../_connect.db.php';

if (isset($_GET['getLedger'])) {
    $employee_id = $_GET['employee_id'];
    // $sql =  "SELECT * from `lm_logs` left join `lm_deductions` on `lm_logs`.`employees_id`=`lm_deductions`.`employee_id` WHERE `lm_logs`.`employees_id`= $employee_id ORDER BY `date_filed` DESC";
    $sql =  "SELECT * from `employees`       left join `lm_logs` on `employees`.`employees_id`=`lm_logs`.`employees_id`
                                             left join `lm_deductions` on `lm_logs`.`log_id`=`lm_deductions`.`log_id`
                                             left join `lm_earnings` on `employees`.`employees_id`=`lm_earnings`.`emp_id` WHERE `employees`.`employees_id`= $employee_id";
        $sql = $mysqli->query($sql);
        $a = [];
        while($ar = $sql->fetch_assoc()){
            $a[]  = $ar;
        }
        echo json_encode($a);
}
