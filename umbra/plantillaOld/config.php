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
        $sql = "INSERT INTO `appointments` (`appointment_id`, `employee_id`, `plantilla_id`) VALUES (NULL, '$saveIncumbent', '$Oldplantilla')";
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