<?php
require_once '../_connect.db.php';

if (isset($_GET['getPdsPersonal'])) { 
    $employee_id = $_GET['employee_id'];
    $data = [];
    $sql = "SELECT `id` FROM `pds_personal` WHERE `pds_personal`.`employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i',$employee_id);
    $stmt->execute();
    $stmt->store_result();
    $num_rows = $stmt->num_rows;
    $stmt->close();
    
    if( $num_rows == 0){
        $sql = "INSERT INTO `pds_personal` (`employee_id`) VALUES (?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i',$employee_id);
        $stmt->execute();
        $stmt->close();
    }
    
    $sql = "SELECT `employees`.`lastName`,`employees`.`firstName`,`employees`.`middleName`,`employees`.`extName`,`pds_personal`.* FROM `employees` LEFT JOIN `pds_personal` ON `employees`.`employees_id` = `pds_personal`.`employee_id` WHERE `employees`.`employees_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i',$employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    echo json_encode($data);
}
elseif (isset($_GET['getPdsFamily'])) {
    $employee_id = $_GET['employee_id'];
    $data = [];
    $sql = "SELECT `id` FROM `pds_families` WHERE `pds_families`.`employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i',$employee_id);
    $stmt->execute();
    $stmt->store_result();
    $num_rows = $stmt->num_rows;
    $stmt->close();

    if($num_rows == 0){
        $sql = "INSERT INTO `pds_families` (`employee_id`) VALUES (?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i',$employee_id);
        $stmt->execute();
        $stmt->close();
    }

     $sql = "SELECT `pds_families`.* FROM `pds_families` WHERE `pds_families`.`employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i',$employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    echo json_encode($data);
}

elseif (isset($_POST['savePdsFamily'])) {
    $employee = $_POST['employee'];
    $affected_rows = 0;

    $sql = "UPDATE `pds_families` SET `father_ext_name` = ?,`father_first_name` = ?,`father_last_name` = ?,`father_middle_name` = ?,`mother_first_name` = ?,`mother_last_name` = ?,`mother_middle_name` = ?,`spouse_business_address` = ?,`spouse_employeer` = ?,`spouse_ext_name` = ?,`spouse_first_name` = ?,`spouse_last_name` = ?,`spouse_middle_name` = ?,`spouse_mobile` = ?,`spouse_occupation` = ? WHERE `employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssssssssssssssi",$employee['father_ext_name'],$employee['father_first_name'],$employee['father_last_name'],$employee['father_middle_name'],$employee['mother_first_name'],$employee['mother_last_name'],$employee['mother_middle_name'],$employee['spouse_business_address'],$employee['spouse_employeer'],$employee['spouse_ext_name'],$employee['spouse_first_name'],$employee['spouse_last_name'],$employee['spouse_middle_name'],$employee['spouse_mobile'],$employee['spouse_occupation'],$employee['employee_id']);
    $stmt->execute();
    $affected_rows += $stmt->affected_rows;
    $stmt->close();
    echo json_encode($affected_rows);
}

elseif (isset($_POST['savePdsPersonal'])) {
    $employee = $_POST['employee'];
    $affected_rows = 0;
    
    $sql = "UPDATE `employees` SET `lastName` = ?, `firstName` = ?, `middleName` = ?, `extName` = ? WHERE `employees_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssssi",$employee["lastName"],$employee["firstName"],$employee["middleName"],$employee["extName"],$employee["employee_id"]);
    $stmt->execute();
    $affected_rows += $stmt->affected_rows;
    $stmt->close();

    $sql = "UPDATE `pds_personal` SET `birthdate` = ?,`birthplace` = ?,`citizenship` = ?,`gender` = ?,`civil_status` = ?,`height` = ?,`weight` = ?,`blood_type` = ?,`gsis_id` = ?,`pag_ibig_id` = ?,`philhealth_id` = ?,`sss_id` = ?,`tin_id` = ?,`res_house_no` = ?,`res_street` = ?,`res_subdivision` = ?,`res_barangay` = ?,`res_city` = ?,`res_province` = ?,`res_zip_code` = ?,`res_tel` = ?,`perm_house_no` = ?,`perm_street` = ?,`perm_subdivision` = ?,`perm_barangay` = ?,`perm_city` = ?,`perm_province` = ?,`perm_zip_code` = ?,`perm_tel` = ?,`mobile` = ?,`email` = ? WHERE `employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssssssssssssssssssssssssssssssi",$employee['birthdate'],$employee['birthplace'],$employee['citizenship'],$employee['gender'],$employee['civil_status'],$employee['height'],$employee['weight'],$employee['blood_type'],$employee['gsis_id'],$employee['pag_ibig_id'],$employee['philhealth_id'],$employee['sss_id'],$employee['tin_id'],$employee['res_house_no'],$employee['res_street'],$employee['res_subdivision'],$employee['res_barangay'],$employee['res_city'],$employee['res_province'],$employee['res_zip_code'],$employee['res_tel'],$employee['perm_house_no'],$employee['perm_street'],$employee['perm_subdivision'],$employee['perm_barangay'],$employee['perm_city'],$employee['perm_province'],$employee['perm_zip_code'],$employee['perm_tel'],$employee['mobile'],$employee['email'],$employee['employee_id']);
    $stmt->execute();
    $affected_rows += $stmt->affected_rows;
    $stmt->close();
    echo json_encode($affected_rows);
}