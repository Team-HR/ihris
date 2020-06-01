<?php
    require_once "../../_connect.db.php";
    if(isset($_POST['savefeedback'])){
        $yr = $_POST['yr'];
        $emp = $_POST['emp'];
        $feedback = $_POST['feedback'];
        $sucess = true;
        $mess = "";
        $check = "SELECT * from `spms_feedbacking` where `feedbacking_year`='$yr' and `feedbacking_emp`='$emp'";
        $check = $mysqli->query($check);
        echo $mysqli->error;

        if($check->num_rows){
            $mess = "Data has been modified";    
            $check = $check->fetch_assoc();
            $sql = "UPDATE `spms_feedbacking` SET `feedbacking_feedback` = '$feedback' WHERE `spms_feedbacking`.`feedbacking_id` = '$check[feedbacking_id]'";
            $sql = $mysqli->query($sql);
            if(!$sql){
                $mess = $mysqli->error;
                $sucess = false;
            }
        }else{
            $mess = "Data is saved";    
            $sql = "INSERT into `spms_feedbacking` 
                    (`feedbacking_id`,`feedbacking_year`,`feedbacking_emp`,`feedbacking_feedback`)
                    values ('','$yr','$emp','$feedback')";
            $sql = $mysqli->query($sql);
            if(!$sql){
                $mess = $mysqli->error;
                $sucess = false;
            }
        }
        $ar = array(
            "success" => $sucess,
            "message" => $mess,
        );
        echo json_encode($ar);
    }elseif (isset($_POST['editIfExist'])) {
        $emp = $_POST['emp'];
        $period = $_POST['period'];
        $yr = $_POST['yr'];
        $sql = "SELECT * from `spms_feedbacking` where 
        `feedbacking_period`='$period' and `feedbacking_emp`='$emp' and `feedbacking_year`='$yr'";
        $sql = $mysqli->query($sql);
        if($sql->num_rows>0){
            $ar = $sql->fetch_assoc();
            echo $ar['feedbacking_feedback'];
        }
    }
?>