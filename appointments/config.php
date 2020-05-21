
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


function createAppointment($json,$mysqli){
    // check if employee is existing or not
    // if existing update appointment
    // if not create new employee get id and insert to appointments
}

function getEmployees($mysqli){
    $data = [];
    $sql = "SELECT `employees_id`,`lastName`,`firstName`,`middleName`,`extName` FROM `employees` ORDER BY `employees`.`lastName` ASC";
	$result = $mysqli->query($sql);
    while ($employee = $result->fetch_assoc()) {
		$data[$employee['employees_id']] = $employee;
    }
    return $data;
}

function getPlantillas($mysqli){
    $sql = "SELECT * FROM `plantillas` ORDER BY `plantillas`.`position_title` ASC
    ";
    $result = $mysqli->query($sql);
    $data = [];
    while ($plantilla = $result->fetch_assoc()) {
        $data[$plantilla['id']] = $plantilla;
    }
    return $data;
}