
<?php
require_once '../_connect.db.php';

// $echo = getPlantillas($mysqli);
// print("<pre>".print_r($echo,true)."</pre>");

if(isset($_POST['getEmployees'])){
    echo json_encode(getEmployees($mysqli));
}
elseif(isset($_POST['getPlantillas'])){
    echo json_encode(getPlantillas($mysqli));
}


function newEmployeeNewAppointment($json,$mysqli){
    // insert new empoyee to employees table
    // $sql = "INSERT INTO `employees` (`employees_id`, `firstName`, `lastName`, `middleName`, `extName`) VALUES (NULL, ?, ?, ?, ?)";
    // $stmt = $mysqli->prepare($sql);
    // $stmt->bind_param('ssss',$json['first_name'],$json['last_name'],$json['middle_name'],$json['ext_name']);
    // $stmt->execute();
    // $stmt->();
    // // get insert_id
    // $sql = "INSERT INTO `appointments` (`id`, `plantilla_id`, `employee_id`, `status_of_appointment`, `date_of_appointment`, `date_ended`, `nature_of_appointment`, `legal_doc`, `memo_for_legal`, `head_of_agency`, `date_of_signing`, `csc_auth_official`, `date_signed_by_csc`, `csc_mc_no`, `published_at`, `date_of_publication`, `hrmo`, `screening_body`, `date_of_screening`, `committee_chair`, `notation_1`, `notation_2`, `notation_3`, `notation_4`, `csc_release_date`, `timestamp_created`, `timestamp_updated`) VALUES (NULL, ?, ?, ?, ?, NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, current_timestamp(), current_timestamp())";

}
function existingEmployeeNewAppointment($json,$mysqli){

}
function existingEmployeeUpdateAppointment($json,$mysqli){

}
function existingEmployeeUpdateAppointment($json,$mysqli){

}



function getEmployees($mysqli){
    $data = [];
    $sql = "SELECT `employees_id`,`lastName`,`firstName`,`middleName`,`extName` FROM `employees` ORDER BY `employees`.`lastName` ASC";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($employee = $result->fetch_assoc()) {
        $data[$employee['employees_id']] = $employee;
    }
    return $data;
}

function getPlantillas($mysqli){
    $data = [];
    $sql = "SELECT * FROM `plantillas` ORDER BY `plantillas`.`position_title` ASC
    ";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($plantilla = $result->fetch_assoc()) {
        $data[$plantilla['id']] = $plantilla;
    }
    return $data;
}
