<?php
    require_once "../../_connect.db.php";

    if (isset($_POST['saveSalarySetup'])) {
        $dataId = $mysqli->real_escape_string($_POST['dataId']);
        $monthly_salary = $mysqli->real_escape_string($_POST['monthly_salary']);
        $step_no = $mysqli->real_escape_string($_POST['step_no']);
        $salary_grade = $mysqli->real_escape_string($_POST['salary_grade']);
        $dat = $mysqli->real_escape_string($_POST['dat']);
        if($dat !=""||$dat!=0){
            $sql = "UPDATE `setup_salary_adjustments_setup` set `salary_grade`='$salary_grade',`step_no`='$step_no',`monthly_salary`='$monthly_salary' where `id`='$dat'";
            $msg = "Updated Successfully";
        }else{
            $sql = "INSERT into `setup_salary_adjustments_setup` (`id`,`parent_id`,`salary_grade`,`step_no`,`monthly_salary`) 
                    values ('','$dataId','$salary_grade','$step_no','$monthly_salary')";
            $msg = "Data has been added";
        }
        $sql = $mysqli->query($sql);
        if(!$sql){
            $msg = $mysqli->error;
            $status = "error";
            $setup_dat = [];
        }else{
            $status = "success";
            $setup_dat = setup_data($dataId);
        }
        $results = array('msg' => $msg,'status' => $status,'setup_data'=>$setup_dat );
        echo json_encode($results);
    }elseif (isset($_POST['get_setup'])) {
        echo json_encode(setup_data($_POST['get_setup']));
    }elseif (isset($_POST['removeSetup'])) {
        $dataId = $_POST['removeSetup'];
        $sql = "DELETE FROM `setup_salary_adjustments_setup` WHERE `setup_salary_adjustments_setup`.`id` = '$dataId'";
        $sql = $mysqli->query($sql);
        if(!$sql){
            $msg = $mysqli->error;
            $status = "error";
        }else{
            $msg = "Data has been Deleted";
            $status = "warning";
        }
        $results = array('msg' => $msg,'status' => $status);
        echo json_encode($results);
    }
    function setup_data($dataId){
        $mysqli = $GLOBALS['mysqli'];
        $sql = "SELECT * from `setup_salary_adjustments_setup` 
                where `setup_salary_adjustments_setup`.`parent_id`='$dataId'";
        $sql = $mysqli->query($sql);
        $a = [];
        while($ar = $sql->fetch_assoc()){
            $a[] = $ar;
        }
        return $a;
    }
?>