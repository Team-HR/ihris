<?php
    require_once "../../_connect.db.php";
    if(isset($_POST['getFeedback'])){
        $sql = "SELECT * from `spms_feedbacking` where `feedbacking_year`='$_POST[year]'";
        echo a($sql,'feedbacking_emp');        
    }else{
        $sql = "SELECT * from `employees` ORDER BY `employees`.`employmentStatus` ASC , lastName ASC";
        echo a($sql,'employees_id');
    }
    function a($sql,$index){
        $sql = $GLOBALS['mysqli']->query($sql);
        $a = [];
        while($ar = $sql->fetch_assoc()){
            $a[$ar[$index]] = $ar;
        }
        return json_encode($a);
    }
?>