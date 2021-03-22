<?php
    require_once "../../_connect.db.php";

    if (isset($_POST['getEmp'])){
        $a = [];
        $sql = "SELECT * FROM employees";
        $sql = $mysqli->query($sql);
        while ($row = $sql->fetch_assoc()) {
            $a[] = $row;
        }
        echo json_encode($a);
    }elseif(isset($_POST['dtrDate'])){
        $dtrDate = $_POST["dtrDate"];
        $period = $_POST["period"];
        $emp_id = $_POST["emp_id"]; 
        $count = 1;
        $ar = [];
        for($count;$count<=$dtrDate;$count++){
            $d = $period.'-'.$count;
            $sql = "SELECT * from dtrManagement where `emp_id`='$emp_id' and `dtr_date`='$d'";
            $sql = $mysqli->query($sql);
            $result = $sql->fetch_assoc();
            if($result){
                $a = [
                    "id"=>$result['dtr_id'],
                    "date"=>$result['dtr_date'],
                    "amTardy"=>$result['amTardy'],
                    "amUnderTime"=>$result['amUnder'],
                    "pmTardy"=>$result['pmTardy'],
                    "pmUnderTime"=>$result['pmUnder'], 
                    "other"=>$result['other']
                ];
            }else{
                $a = [
                    "id"=>"",
                    "date"=>$d,
                    "amTardy"=>"",
                    "amUnderTime"=>"",
                    "pmTardy"=>"",
                    "pmUnderTime"=>"", 
                    "other"=>""
                    ];
            }            
            $ar[] = $a;
        }
        echo json_encode($ar);
    }elseif(isset($_POST['addDTR'])){
        $dtr_date = strtotime($_POST['dtr_date']);
        $dtr_date =  date('Y-m-d', $dtr_date);;  
        $emp_id = $_POST["emp_id"];
        $others = $_POST["others"];
        $amTardy = $_POST["amTardy"];
        $amUnder = $_POST["amUnder"];
        $pmTardy = $_POST["pmTardy"];
        $pmUnder = $_POST["pmUnder"];
        $editId = $_POST["editId"];
        // if($others){
        //     $amTardy = "";
        //     $amUnder = "";
        //     $pmTardy = "";
        //     $pmUnder = "";
        // }
        $other = $_POST["other"];
        if($editId!=""){
            $sql = "UPDATE `dtrManagement` SET 
                    `dtr_date` = '$dtr_date', `amTardy` = '$amTardy', `amUnder` = '$amUnder', `emp_id` = '$emp_id', `pmTardy` = '$pmTardy', `pmUnder` = '$pmUnder', `other` = '$others' WHERE 
                    `dtrManagement`.`dtr_id` = $editId";
        }else{  
            $sql="INSERT INTO `dtrManagement` (`dtr_id`, `dtr_date`, `amTardy`, `amUnder`, `emp_id`, `pmTardy`, `pmUnder`, `other`) 
                  VALUES (NULL, '$dtr_date', '$amTardy', '$amUnder', '$emp_id', '$pmTardy', '$pmUnder', '$others')";            
        }
        $sql = $mysqli->query($sql);
        echo $mysqli->error;
    }elseif (isset($_POST['submitReport'])) {
        $totalMinsTardy= $_POST['totalMinsTardy'];
        $totalTimesTardy= $_POST['totalTimesTardy'];
        $totalMinUnderTime= $_POST['totalMinUnderTime'];
        $period= $_POST['period'];
        $emp_id= $_POST['emp_id'];
        $halfDaysTardy = $_POST['halfDaysTardy'];
        $halfDaysUndertime = $_POST['halfDaysUndertime'];
        $remarksDtr = $_POST['remarksDtr'];
        $check = "SELECT * FROM `dtrSummary` where `month`='$period' AND `employee_id`='$emp_id'";
        $check = $mysqli->query($check);
        $count = $check->num_rows;
        $datID = $check->fetch_assoc();
        if($count){
            $sql = "UPDATE `dtrSummary` SET 
                            `totalMinsTardy` = '$totalMinsTardy', 
                            `totalTardy` = '$totalTimesTardy', 
                            `totalMinsUndertime` = '$totalMinUnderTime',
                            `halfDaysTardy` = '$halfDaysTardy',
                            `halfDaysUndertime` = '$halfDaysUndertime',
                            `remarks` = '$remarksDtr'
                    WHERE `dtrSummary`.`dtrSummary_id` ='$datID[dtrSummary_id]'";
        }else{
            $sql = "INSERT INTO `dtrSummary` (`dtrSummary_id`, `employee_id`, `month`, `totalMinsTardy`, `totalTardy`, `totalMinsUndertime`, `letterOfNotice`,`halfDaysTardy`,`halfDaysUndertime`,`remarks`,`submitted`) 
                                VALUES (NULL, '$emp_id', '$period', '$totalMinsTardy', '$totalTimesTardy', '$totalMinUnderTime', '0','$halfDaysTardy','$halfDaysUndertime','$remarksDtr','1')";
        }
        $sql = $mysqli->query($sql);
        echo $mysqli->error;
        $getDat = "SELECT * from `dtrSummary` WHERE `employee_id`='$emp_id' AND `month`='$period'";
        $getDat = $mysqli->query($getDat);
        $getDat = $getDat->fetch_assoc();
        echo json_encode($getDat);
    }elseif(isset($_POST['getSum'])){
        $emp_id = $_POST['emp_id'];
        $period = $_POST['period'];
        $getDat = "SELECT * from `dtrSummary` WHERE `employee_id`='$emp_id' AND `month`='$period'";
        $getDat = $mysqli->query($getDat);
        $getDat = $getDat->fetch_assoc();
        echo json_encode($getDat);  
    }elseif (isset($_POST['nodtr'])){
        $nodtr = $_POST['nodtr'];
        $period = $_POST['period'];
        $employee_id = $_POST['employee_id']; 
        $sql = "SELECT * from `dtrNoSubmission` where 
                              `employee_id`='$employee_id' and
                              `period` = '$period'";
        $sql = $mysqli->query($sql);
        $a = []; 
        while ($row = $sql->fetch_assoc()) {
            $a[] = $row;
        }
        echo json_encode($a);
    }elseif (isset($_POST['hasSumitted'])){
        $period = $_POST['period'];
        $emp_id = $_POST['emp_id'];
        $check = "SELECT * from dtrSummary where `month`='$period' and `employee_id`='$emp_id'";
        $check = $mysqli->query($check);
        $check = $check->fetch_assoc();
        if($check){
            $sql = "UPDATE `dtrSummary` SET `submitted` = 1 WHERE `dtrSummary_id` = '$check[dtrSummary_id]'";
        }else{
            $sql= "INSERT INTO `dtrSummary` (`dtrSummary_id`, `employee_id`, `month`, `submitted`) VALUES (NULL, '$emp_id', '$period','1')";
        }
        $sql = $mysqli->query($sql);
        echo $mysqli->error;
    }elseif (isset($_POST['cancelMove'])) {
            $period = $_POST['period'];
            $emp_id = $_POST['emp_id'];
            $check = "SELECT * from dtrSummary where `month`='$period' and `employee_id`='$emp_id'";
            $check = $mysqli->query($check);
            $check = $check->fetch_assoc();
            if($check){
                $sql = "UPDATE `dtrSummary` SET `submitted` = '' WHERE `dtrSummary_id` = '$check[dtrSummary_id]'";
            }else{
                $sql= "INSERT INTO `dtrSummary` (`dtrSummary_id`, `employee_id`, `month`, `submitted`) VALUES (NULL, '$emp_id', '$period','')";
            }
            $sql = $mysqli->query($sql);
            echo $mysqli->error;            
    }elseif(isset($_POST['passSlipFormSave'])){
        $passSlipFormSave = $_POST['passSlipFormSave'];
        $emp_id = $_POST['emp_id'];
        $period = $_POST['period'];
        $sqlCheck = "SELECT * from `dtrSummary` where `employee_id`='$emp_id' and `month`='$period'";
        $sqlCheck = $mysqli->query($sqlCheck);
        if($sqlCheck->num_rows>0){
            $sqlCheck = $sqlCheck->fetch_assoc();
            $sql = "UPDATE `dtrSummary` SET `passSlip`='$passSlipFormSave' WHERE `dtrSummary_id`='$sqlCheck[dtrSummary_id]'";
        }else{
            $sql = "INSERT INTO `dtrSummary` (`dtrSummary_id`,`month`,`employee_id`,`passSlip`) values (NULL,'$period','$employee_id','$passSlipFormSave')";
        }
        $mysqli->query($sql);
        echo $mysqli->error;
    }
?>