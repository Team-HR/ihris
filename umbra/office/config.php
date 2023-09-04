<?php
    require_once "../../_connect.db.php";

    if(isset($_POST['getEmployee'])){
        $sql = "SELECT * From `employees`";
        $sql = $mysqli->query($sql);
        $dat = [];
        while ($row = $sql->fetch_assoc()) {
            $dat[] = $row;
        }
        echo json_encode($dat);
    }elseif(isset($_POST['office_setup'])) {
        $office_setup = $_POST['office_setup'];
        $emp = $_POST['emp'];
        $edit = $_POST['edit'];
        $department_id = $_POST['department_id'];
        if($edit){
            $sql = "UPDATE `office_setup` SET 
                        `department_id` = '$department_id',
                        `office_name` = '$office_setup',
                        `section_head` = '$emp'    
                    WHERE `office_setup`.`id` ='$edit'";
        }else{
            $sql = "INSERT INTO `office_setup` 
                (`id`, `office_name`, `section_head`,`department_id`) 
                VALUES ('', '$office_setup', '$emp','$department_id')";
        }
        $sql = $mysqli->query($sql);
        $msg = "Successfully Saved";
        $status = "success";
        $bol = 1;
        $dat = [];
        if($mysqli->error){
            $msg = "ERROR:".$mysqli->error;
            $status = "error";
            $bol = 0;
        }
        $dat['status'] = $status;
        $dat['msg'] = $msg;
        $dat['bol'] = $bol;
        echo json_encode($dat);
    }elseif(isset($_POST['getOffice'])) {
        $sql = "SELECT 
                `office_setup`.*,
                employees.firstName,
                employees.lastName,
                employees.middleName,
                employees.extName
                From `office_setup` left join `employees` on `office_setup`.`section_head`=`employees`.`employees_id` where `office_setup`.`department_id`='$_POST[getOffice]'";
        $sql = $mysqli->query($sql);
        // echo $mysqli->error;
        $dat = [];
        while ($row = $sql->fetch_assoc()){
            $dat[] = $row;
        }
        echo json_encode($dat);
    }elseif ($_POST['removeOffice']) {
        $sql = "DELETE FROM `office_setup` WHERE `id`='$_POST[removeOffice]'";
        $sql = $mysqli->query($sql);
        $dat = [];
        $dat['status'] = "warning";
        $dat['msg'] = "Deleted Successfully";
        if(!$sql){
            $dat['status'] = "error";
            $dat['msg'] = $mysqli->error;    
        }
        echo json_encode($dat);
    }
?>