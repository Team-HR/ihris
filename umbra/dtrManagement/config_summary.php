<?php
require_once "../../_connect.db.php";

if(isset($_POST['getDepartment'])){
    $sql = "SELECT * from `department`";
    $sql = $mysqli->query($sql);
    echo $mysqli->error;
    $a = [];
    while ($row = $sql->fetch_assoc()){
        $a[] = $row;
    }
    echo json_encode($a);
}elseif(isset($_POST['dateNeeded'])){
    $period = $_POST['period'];
    $type = $_POST['type'];
    // if(strtoupper($type)=="TARDY"){
        $sql ="SELECT * from `dtrSummary` 
                left join `employees` on `dtrSummary`.`employee_id`=`employees`.`employees_id`
                left join `department` on `employees`.`department_id`=`department`.`department_id`
                left join `positiontitles` on `employees`.`position_id`=`positiontitles`.`position_id`
                WHERE `dtrSummary`.`month`='$period'";        
    // }elseif(false){
    // }
    $a = [];
    $sql = $mysqli->query($sql);
    echo $mysqli->error;
    while ($row = $sql->fetch_assoc()) {
        $a[]=$row;
    }
    echo json_encode($a);
}elseif(isset($_POST['tardyHistory'])){
    $period = $_POST['period'];
    $emp = $_POST['emp'];
    $sql = "SELECT * FROM `dtrSummary` where `employee_id`='$emp' AND `totalTardy`>=10 AND NOT `month`='$period' LIMIT 5";
    $sql = $mysqli->query($sql);
    echo $mysqli->error;
    $a = [];
    while ($row = $sql->fetch_assoc()) {
        $a[] = $row;
    }
    echo json_encode($a);
}
?>