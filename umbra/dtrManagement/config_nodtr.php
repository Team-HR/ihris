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
        $sql = "SELECT * from `employees` where `status`='ACTIVE'"; 
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
                    $a[] = $row;
                }else{
                    continue;
                }
            }else{
                $a[]=$row;
            }
        }
        echo json_encode($a);
    }




 

?>