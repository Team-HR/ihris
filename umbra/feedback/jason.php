<?php
    require_once "../../_connect.db.php";
    if(isset($_POST['getFeedback'])){
        $sql = "SELECT * from `spms_feedbacking` where `feedbacking_year`='$_POST[year]'";
        echo a($sql);        
    }else{
        $sql = "SELECT * from `employees` ORDER BY `employees`.`employmentStatus` ASC , lastName ASC";
        echo a($sql);
    }
    function a($sql){
        $sql = $GLOBALS['mysqli']->query($sql);
        $a = [];
        while($ar = $sql->fetch_assoc()){
            $a[] = $ar;
        }
        return json_encode($a);
    }
?>