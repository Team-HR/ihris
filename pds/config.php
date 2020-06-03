<?php
require_once '../_connect.db.php';

if (isset($_GET['getEmployeeData'])) { 
    $employee_id = $_GET['employee_id'];
    $data = [];
    $sql = "SELECT `id` FROM `pds` WHERE `pds`.`employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i',$employee_id);
    $stmt->execute();
    $stmt->store_result();
    $num_rows = $stmt->num_rows;
    $stmt->close();
    
    if( $num_rows == 0){
        $sql = "INSERT INTO `pds` (`employee_id`) VALUES (?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i',$employee_id);
        $stmt->execute();
        $stmt->close();
    }
    
    $sql = "SELECT `employees`.`lastName`,`employees`.`firstName`,`employees`.`middlename`,`employees`.`extName`,`pds`.* FROM `employees` LEFT JOIN `pds` ON `employees`.`employees_id` = `pds`.`employee_id` WHERE `employees`.`employees_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i',$employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    echo json_encode($data);
}


elseif (isset($_POST['savePdsPersonalss'])) {
    $employee = $_POST['employee'];
    $sql = "INSERT INTO pds (`employee_id`,`birthdate`) VALUES (?,?) ON DUPLICATE KEY UPDATE `birthdate`=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("iss", $employee['employee_id'],$employee['birthdate'],$employee['birthdate']);
    $stmt->execute();
    $stmt->fetch();
    echo json_encode($employee);
}


elseif (isset($_POST['savePdsPersonal'])) {
    $employee = $_POST['employee'];
    $sql = "UPDATE `pds` SET (`employee_id`,`birthdate`,`birthplace`,`citizenship`,`gender`,`civil_status`,`height`,`weight`,`blood_type`,`gsis_id`,`pag_ibig_id`,`philhealth_id`,`sss_id`,`tin_id`,`res_house_no`,`res_street`,`res_subdivision`,`res_barangay`,`res_city`,`res_province`,`res_zip_code`,`res_tel`,`perm_house_no`,`perm_street`,`perm_subdivision`,`perm_barangay`,`perm_city`,`perm_province`,`perm_zip_code`,`perm_tel`,`mobile`,`email`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE `birthdate`=?,`birthplace`=?,`citizenship`=?,`gender`=?,`civil_status`=?,`height`=?,`weight`=?,`blood_type`=?,`gsis_id`=?,`pag_ibig_id`=?,`philhealth_id`=?,`sss_id`=?,`tin_id`=?,`res_house_no`=?,`res_street`=?,`res_subdivision`=?,`res_barangay`=?,`res_city`=?,`res_province`=?,`res_zip_code`=?,`res_tel`=?,`perm_house_no`=?,`perm_street`=?,`perm_subdivision`=?,`perm_barangay`=?,`perm_city`=?,`perm_province`=?,`perm_zip_code`=?,`perm_tel`=?,`mobile`=?,`email`=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("issssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss", $employee['employee_id'],$employee['birthdate'],$employee['birthplace'],$employee['citizenship'],$employee['gender'],$employee['civil_status'],$employee['height'],$employee['weight'],$employee['blood_type'],$employee['gsis_id'],$employee['pag_ibig_id'],$employee['philhealth_id'],$employee['sss_id'],$employee['tin_id'],$employee['res_house_no'],$employee['res_street'],$employee['res_subdivision'],$employee['res_barangay'],$employee['res_city'],$employee['res_province'],$employee['res_zip_code'],$employee['res_tel'],$employee['perm_house_no'],$employee['perm_street'],$employee['perm_subdivision'],$employee['perm_barangay'],$employee['perm_city'],$employee['perm_province'],$employee['perm_zip_code'],$employee['perm_tel'],$employee['mobile'],$employee['email'],$employee['birthdate'],$employee['birthplace'],$employee['citizenship'],$employee['gender'],$employee['civil_status'],$employee['height'],$employee['weight'],$employee['blood_type'],$employee['gsis_id'],$employee['pag_ibig_id'],$employee['philhealth_id'],$employee['sss_id'],$employee['tin_id'],$employee['res_house_no'],$employee['res_street'],$employee['res_subdivision'],$employee['res_barangay'],$employee['res_city'],$employee['res_province'],$employee['res_zip_code'],$employee['res_tel'],$employee['perm_house_no'],$employee['perm_street'],$employee['perm_subdivision'],$employee['perm_barangay'],$employee['perm_city'],$employee['perm_province'],$employee['perm_zip_code'],$employee['perm_tel'],$employee['mobile'],$employee['email']);
    $stmt->execute();
    $stmt->fetch();
    echo json_encode($stmt->num_rows);
}