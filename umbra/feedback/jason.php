<?php
    require_once "../../_connect.db.php";
    if(isset($_POST['getEmpList'])){
        $period = $_POST['per'];
        $year = $_POST['yr'];
        // $sql = 
    }
    elseif(isset($_POST['empSearch'])){
        $search = $_POST['empSearch'];
        $sql = "SELECT * FROM `employees` where `firstName` like '$search%' or `lastName` like '$search%'";
        $sql = $mysqli->query($sql);
        $ar = [];
        while($row = $sql->fetch_assoc()){
            $ar[] = $row;
        }
        echo json_encode($ar);
    }
?>