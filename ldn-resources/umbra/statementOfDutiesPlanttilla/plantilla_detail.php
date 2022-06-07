<?php

require_once "../../_connect.db.php";

if(isset($_POST['getDuties'])){
    $posId = $_POST['getDuties'];
    $sql = "SELECT * FROM `statement_of_duties` 
            where `position_id`='$posId'
            ORDER BY `no` ASC"; 
    $sql = $mysqli->query($sql);
    $ar = [];
    while ($row = $sql->fetch_assoc()) {
        $ar[] = $row;
    }
    if(!$sql){
        echo $mysqli->error;
    }else{
        echo json_encode($ar);
    }
}



?>