
<?php
require '../libs/models/Employee.php';
require '../libs/models/Plantilla.php';
require '../libs/models/Appointment.php';
#============================================================================
#TEST START
#============================================================================
    $json['plantilla_id']='12'; //
    $json['employee_id']='33465'; //33465
    $json['first_name']='Jane';
    $json['last_name']='Doe';
    $json['middle_name']='Mcaskill';
    $json['ext_name']='';
    $json['status_of_appointment']='permanent';
    $json['date_of_appointment']='2020-01-01';
    $json['date_ended']='';
    $json['nature_of_appointment']='original';
    $json['legal_doc']='';
    $json['memo_for_legal']='';
    $json['head_of_agency']='Mayor Pryde Henrey Teves';
    $json['date_of_signing']='2020-01-02';
    $json['csc_auth_official']='Juaquin Phoenix';
    $json['date_signed_by_csc']='2020-01-02';
    $json['csc_mc_no']='123456';
    $json['published_at']='Legislative Bldg, Cabcabon, Banga, Bayawan, Negros Orietal';
    $json['date_of_publication']='2020-01-09';
    $json['hrmo']='Veronica Grace P. Miraflor';
    $json['screening_body']='PSB';
    $json['date_of_screening']='2020-01-03';
    $json['committee_chair']='Jeremias Gallo';
    $json['notation_1']='0';
    $json['notation_2']='0';
    $json['notation_3']='0';
    $json['notation_4']='0';
    $json['csc_release_date']='2020-01-10';
    print("<pre>".print_r($json,true)."</pre>");

#============================================================================
#TEST END
#============================================================================
$emp = new Employee;
$plantilla = new Plantilla;
$apt = new Appointment;
    
if(isset($_POST['getEmployees'])){
    echo json_encode($emp->getEmployees());
}

elseif(isset($_POST['getPlantillas'])){
    echo json_encode($plantilla->getPlantillas());
}

elseif (isset($_POST['addNewAppointment'])) {
    $json = json_decode($_POST['json']);
    // $json = $json;
    $status = array(
        'success' => false,
        'error' => false
    );

    // check if plantilla is null
    if(!$json['plantilla_id']) $status['error']['nullPlantilla'] = 'The plantilla id cannot be null!';
    // check if plantilla is occupied
    if($plantilla->isOccupied($json['plantilla_id'])) $status['error']['isOccupied'] = 'The plantilla is not vacant!';
    // check if employee id is null
    if (!$json['employee_id']) $status['error']['nullEmployee'] = 'The employee id cannot be null!';

    if(!$status['error']) {
        $apt->addNewAppointment($json);
        $status['success'] = true;
    }

    echo json_encode($status);   
}
