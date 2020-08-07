<?php
    require_once "../../_connect.db.php";
    if(isset($_POST['getEmployee'])){
        $sql = "SELECT * FROM `employees`";
        $sql = $mysqli->query($sql);
        $dat = [];
        while ($row = $sql->fetch_assoc()) {
            $dat[] = $row;
        }
        echo json_encode($dat);
    }elseif(isset($_POST['saveIncumbent'])){
        $saveIncumbent = $_POST["saveIncumbent"];
        $Oldplantilla = $_POST["Oldplantilla"];
        $nature_of_appointment = $_POST["nature_of_appointment"];
        $date_appointment = $_POST["date_appointment"];
        $date_last_promotion = $_POST["date_last_promotion"];
        $casual_promotion = $_POST["casual_promotion"];
        $sql = "INSERT INTO `appointments` 
        (`appointment_id`, `employee_id`, `plantilla_id`,`nature_of_appointment`,`date_of_appointment`,`date_of_last_promotion`,`casual_promotion`) 
                VALUES (NULL, '$saveIncumbent', '$Oldplantilla','$nature_of_appointment','$date_appointment','$date_last_promotion','$casual_promotion')";
        $sql = $mysqli->query($sql);
        if(!$sql){
            echo "Error: ".$mysqli->error;
        }else{
            $lastInput = $mysqli->insert_id;
            $sqlPl = "UPDATE `plantillas` SET `incumbent` = '$lastInput' WHERE `plantillas`.`id` = '$Oldplantilla'";
            $sqlPl = $mysqli->query($sqlPl);
            if(!$sqlPl){
                echo "Error: ".$mysqli->error;
            }
        }
    }
?>