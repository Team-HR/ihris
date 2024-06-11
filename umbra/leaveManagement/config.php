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
        $date_logged = date('Y-m-d H:i:s');
        $date_received = $_POST["date_received"];
        $date_filed = $_POST["date_filed"];
        $leaveType = $_POST["leaveType"];
        $sp_type = $_POST["sp_type"];
        if ($sp_type  == '') {
                $sp_type =  $_POST["mone_type"];
        }
        if ($leaveType  == 'Others') {
            $leaveType =  $_POST["others"];
        }
        $remarks = $_POST["remarks"];
        $selectedDate = $_POST["selectedDate"];
        // $totalDays = $_POST["mone_days"];
        $totalDays = $_POST["totalDays"];
        // if ($sp_type  == '') {
        //     $sp_type =  $_POST["mone_type"];
        //  }
        if ($totalDays == 0) {
            $totalDays = $_POST["mone_days"];
         }
        $log_editId = $_POST["log_editId"];
       
        $sql = "INSERT INTO `lm_logs` (`log_id`, `date_logged`, `employees_id`, `dateReceived`,  `date_filed`,`dateApplied`, `totalDays`, `leaveType` , `sp_type`, `status`, `remarks`)
             VALUES (NULL, '$date_logged', '$emp_id', '$date_received','$date_filed', '$selectedDate', '$totalDays', '$leaveType', '$sp_type', '', '$remarks')";
    
        if($log_editId){
            $sql = "UPDATE `lm_logs` SET   
                         `employees_id` = '$emp_id', 
                         `dateReceived` = '$date_received', 
                         `date_filed` = '$date_filed',
                         `dateApplied` = '$selectedDate', 
                         `totalDays` = '$totalDays', 
                         `leaveType` = '$leaveType', 
                         `sp_type` = '$sp_type', 
                         `remarks` = '$remarks' 
                    WHERE `lm_logs`.`log_id` = $log_editId";
        }
            
            $sql = $mysqli->query($sql);
        
        $controlNumber = $mysqli->insert_id;

       
    }elseif (isset($_POST['getLog'])) {
        $sql = "SELECT * from `lm_logs` left join `employees` on `lm_logs`.`employees_id`=`employees`.`employees_id`";
        $counter = 0;
        $sql = $mysqli->query($sql);
        $a = [];
        while($ar = $sql->fetch_assoc()){
            $a[] = $ar;
        }   
        echo json_encode($a);
    }
    elseif (isset($_POST['getLeaveBalance'])) {
        $emp_id = $_POST['emp_id']; 
        $year_filed = $_POST['year_filed'];

        // sql query for lm_earning & lm_logs
        $lm_earning_sql = "SELECT * FROM `lm_earning` WHERE `emp_id` = '$emp_id' ORDER BY `month_earned` LIMIT 1";
        $lm_logs_sql = "SELECT SUM(`totalDays`) AS totalDaysSum  FROM `lm_logs` WHERE `employees_id` = '$emp_id' AND `leaveType` = 'SP' AND YEAR(`date_filed`) = '$year_filed'";

        // Execute Queries 
        $lm_earning_query = $mysqli->query($lm_earning_sql);
        $lm_logs_query = $mysqli->query($lm_logs_sql);

        // Fetch Results
        $lm_earning_result = $lm_earning_query->fetch_assoc();
        $lm_logs_result = $lm_logs_query->fetch_assoc();

        $combined_result = array( "lm_earning_result" => $lm_earning_result, "lm_logs_result" => $lm_logs_result);

        // Encode combined result as JSON and return it
        echo json_encode($combined_result);
    }elseif (isset($_POST['updateLeaveBalances'])){
        $emp_id = $_POST['emp_id']; 
        $vl_bal = $_POST['vl_bal'];
        $sl_bal = $_POST['sl_bal'];

        // sql
        $sql = "UPDATE `lm_earning` SET `vl_bal`='$vl_bal',`sl_bal`='$sl_bal' WHERE `emp_id` = '$emp_id'";
        // execute query
        $query = $mysqli->query($sql);

        echo json_encode($query);
    }
?> 
