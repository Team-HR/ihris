<?php
    require_once "../../_connect.db.php";
    
    if(isset($_POST['getEmployee'])){
        $sql = "SELECT * FROM `employees`";
        $sql = $mysqli->query($sql);
        $a = [];
        while($ar = $sql->fetch_assoc()){
            $a[]  = $ar;
        }
        echo json_encode($a);
    }elseif (isset($_POST['saveLeave'])) {
        $emp_id = $_POST["emp_id"];
        $date_received = $_POST["date_received"];
        $leaveType = $_POST["leaveType"];
        $sp_type = $_POST["sp_type"];
        $remarks = $_POST["remarks"];
        $selectedDate = $_POST["selectedDate"];
        $totalDays = $_POST["totalDays"];
        $controlNumber = $mysqli->insert_id;

        $sql = "INSERT INTO `lm_logs` (`log_id`, `controlNumber`, `employees_id`, `dateReceived`, `dateApplied`, `totalDays`, `leaveType` , `sp_type`, `status`, `remarks`)
             VALUES ('', '', '$emp_id', '$date_received', '$selectedDate', '$totalDays', '$leaveType', '$sp_type', '', '$remarks')";
            $sql = $mysqli->query($sql);
    }elseif (isset($_POST['getLog'])) {
        $sql = "SELECT * from `lm_logs` left join `employees` on `lm_logs`.`employees_id`=`employees`.`employees_id`";
        $sql = $mysqli->query($sql);
        $a = [];
        while($ar = $sql->fetch_assoc()){
            $a[] = $ar;
        }   
        echo json_encode($a);
    }
?> 


