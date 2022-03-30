<?php
    require_once "../../_connect.db.php";

    if(isset($_POST['salary_adjustment'])){
        $dataId = $mysqli->real_escape_string($_POST['dataId']);
        $effectivity_date = $mysqli->real_escape_string($_POST['effectivity_date']);
        $date_approved = $mysqli->real_escape_string($_POST['date_approved']);
        $schedule = $mysqli->real_escape_string($_POST['schedule']);
        $notation = $mysqli->real_escape_string($_POST['notation']);
        $active_status = $mysqli->real_escape_string($_POST['active_status']);
        if($dataId!=""||$dataId!=0){
            $sql = "UPDATE `setup_salary_adjustments` set `date_approved`='$date_approved', `effectivity_date` = '$effectivity_date' ,`schedule`='$schedule',`notation`='$notation',`active`='$active_status' where `setup_salary_adjustments`.`id`='$dataId'";
            $success_msg = "Data is Successfully update";
        }else{
            $sql = "INSERT into `setup_salary_adjustments` (`id`,`date_approved`,`effectivity_date`,`schedule`,`notation`,`active`) values ('','$date_approved','$effectivity_date','$schedule','$notation','$active_status')";
            $success_msg = "Salary Adjustment is added";
        }
        $sql = $mysqli->query($sql);
        if(!$sql){
           $msg = $mysqli->error;
           $status = 'error';
           $salary_adjustment = [];
        }else{
            $msg = $success_msg;
            $status = 'success';
            $salary_adjustment = get_salary_adjustment();                    
        }
            $ar = array('msg' => $msg ,'status' => $status ,'salary' => $salary_adjustment);
            echo json_encode($ar);
    }elseif (isset($_POST['get_salary_adjustment'])) {
        echo json_encode(get_salary_adjustment());
    }elseif ($_POST['removeData']) {
        $remove = $_POST['removeData'];
        $sql = "DELETE FROM `setup_salary_adjustments` WHERE `setup_salary_adjustments`.`id` = '$remove'";
        $sql = $mysqli->query($sql);
        if (!$sql) {
            $status = 'error';
            $msg = $mysqli->error;
            $salary_adjustment = [];
        }else{
            $status = "success";
            $msg = "Data has been removed";
            $salary_adjustment = get_salary_adjustment();                    
        }
        $ar = array('msg' => $msg ,'status' => $status ,'salary' => $salary_adjustment);
        echo json_encode($ar);
    }



    function get_salary_adjustment(){
        $mysqli = $GLOBALS['mysqli'];
        $sql = "SELECT * from setup_salary_adjustments";
        $sql = $mysqli->query($sql);
        $salary_adjustment = [];
        while ($a = $sql->fetch_assoc()) {
            $salary_adjustment[] = $a;
        }
        return $salary_adjustment;
    }




?>