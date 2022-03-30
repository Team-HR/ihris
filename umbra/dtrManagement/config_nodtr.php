<?php
    require_once "../../_connect.db.php";

    if (isset($_POST['getDepartment'])){
        $sql = "SELECT * from `department`";
        $sql = $mysqli->query($sql);
        echo $mysqli->error;
        $a = [];
        while ($row = $sql->fetch_assoc()) {
            $a[] = $row;
        }
        echo json_encode($a);
    }elseif (isset($_POST['getNoDtr'])) {
        $period = $_POST['getNoDtr'];        
        $sql = "SELECT * from `employees` where `status`='ACTIVE' ORDER BY `employees`.`lastName` ASC"; 
        $sql = $mysqli->query($sql);
        echo $mysqli->error;
        $a = [];
        while ($row = $sql->fetch_assoc()) {
            $emp = $row['employees_id']; 
            $summary = "SELECT * from `dtrSummary` where `month`='$period' AND `employee_id`='$emp'";
            $summary = $mysqli->query($summary);
            $summary = $summary->fetch_assoc();
            if($row['employmentStatus']=="ELECTIVE"){
            continue;
            }
            elseif($summary){
                if($summary['submitted']=="0"){
                    $row['dtrSummary_id'] = $summary['dtrSummary_id']; 
                    $row['letterOfNotice'] = $summary['letterOfNotice'];
                    $a[] = $row;
                }else{
                    continue;
                }
            }else{
                $row['dtrSummary_id'] = ""; 
                $row['letterOfNotice'] ="";
                $a[]=$row;
            }
        }
        echo json_encode($a);
    }
    elseif(isset($_POST['dtrSubmitted'])){
        $dtrSubmitted = $_POST['dtrSubmitted'];
        $employee_id = $_POST['employee_id'];
        $period = $_POST['period'];
        if($dtrSubmitted){
            $sql = "UPDATE `dtrSummary` SET `submitted` = '1' WHERE `dtrSummary`.`dtrSummary_id` ='$dtrSubmitted'";
        }else{
            $sql = "INSERT INTO `dtrSummary` 
                    (`dtrSummary_id`, `employee_id`, `month`,`submitted`) 
                    VALUES (NULL, '$employee_id', '$period','1')";
        }
            $sql = $mysqli->query($sql);
            echo $mysqli->error;
    }elseif(isset($_POST['letterSent'])){
        $letterSent = $_POST['letterSent'];
        $employee_id = $_POST['employee_id'];
        $period = $_POST['period'];
        if ($letterSent) {
            $sql = "UPDATE `dtrSummary` SET `letterOfNotice` = '1' WHERE `dtrSummary`.`dtrSummary_id` ='$dtrSubmitted'";
        }else{
            $sql = "INSERT INTO `dtrSummary` 
                    (`dtrSummary_id`, `employee_id`, `month`,`letterOfNotice`) 
                    VALUES (NULL, '$employee_id', '$period','1')";
        }
            $sql = $mysqli->query($sql);
            echo $mysqli->error;
    }




 

?>