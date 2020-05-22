
<?php
require_once '../_connect.db.php';

// $echo = getPlantillas($mysqli);
// print("<pre>".print_r($echo,true)."</pre>");

    $json['employee_id']='9';
    $json['first_name']='Jane';
    $json['last_name']='Doe';
    $json['middle_name']='Mcaskill';
    $json['ext_name']='';

    $json['plantilla_id']='6';
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

    print("<pre>".print_r(newEmployeeNewAppointment($json,$mysqli),true)."</pre>");
    // array_walk($json,function(&$value, $key){
    //     $value = (!$value?NULL:$value);
    // });

    // echo(newEmployeeNewAppointment($json,$mysqli));
    // echo json_encode($json);
if(isset($_POST['getEmployees'])){
    echo json_encode(getEmployees($mysqli));
}

elseif(isset($_POST['getPlantillas'])){
    echo json_encode(getPlantillas($mysqli));
}


function newEmployeeNewAppointment($json,$mysqli){
    // insert new empoyee to employees table
    $sql = <<<SQL
    INSERT INTO `employees`(`firstName`, `lastName`, `middleName`, `extName`)
    SELECT ?, ?, ?, ? 
    -- FROM DUAL
    WHERE NOT EXISTS (
    SELECT * FROM 
    `employees` WHERE 
    `firstName`= ? AND 
    `lastName` = ? AND 
    `middleName` = ? AND 
    `extName` = ?
    )

    SQL;
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ssss',$json['first_name'],$json['last_name'],$json['middle_name'],$json['ext_name']);
    $stmt->execute();
    // get insert_id
    $employee_id = $stmt->insert_id;
    // if($stmt->error) return $stmt->error;
    // $stmt->close();
    return $stmt->fetch ();
//     $sql = <<<SQL
//     INSERT INTO `appointments` (`id`, 
//     `plantilla_id`,
//     `employee_id`,
//     `status_of_appointment`,
//     `date_of_appointment`,
//     `date_ended`,
//     `nature_of_appointment`,
//     `legal_doc`,
//     `memo_for_legal`,
//     `head_of_agency`,
//     `date_of_signing`,
//     `csc_auth_official`,
//     `date_signed_by_csc`,
//     `csc_mc_no`,
//     `published_at`,
//     `date_of_publication`,
//     `hrmo`,
//     `screening_body`,
//     `date_of_screening`,
//     `committee_chair`,
//     `notation_1`,
//     `notation_2`,
//     `notation_3`,
//     `notation_4`,
//     `csc_release_date`, 
//     `timestamp_created`, 
//     `timestamp_updated`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, current_timestamp(), current_timestamp())
//     SQL;
//     $stmt = $mysqli->prepare($sql);
//     $stmt->bind_param('iisssssssssssssssssiiiis',
//     $json['plantilla_id'],
//     $employee_id,
//     $json['status_of_appointment'],
//     $json['date_of_appointment'],
//     $json['date_ended'],
//     $json['nature_of_appointment'],
//     $json['legal_doc'],
//     $json['memo_for_legal'],
//     $json['head_of_agency'],
//     $json['date_of_signing'],
//     $json['csc_auth_official'],
//     $json['date_signed_by_csc'],
//     $json['csc_mc_no'],
//     $json['published_at'],
//     $json['date_of_publication'],
//     $json['hrmo'],
//     $json['screening_body'],
//     $json['date_of_screening'],
//     $json['committee_chair'],
//     $json['notation_1'],
//     $json['notation_2'],
//     $json['notation_3'],
//     $json['notation_4'],
//     $json['csc_release_date']
// );
//     $stmt->execute();
//     if($stmt->error) return $stmt->error;
//     $stmt->close();
}
function existingEmployeeNewAppointment($json,$mysqli){

}

function existingEmployeeUpdateAppointment($json,$mysqli){

}


function getEmployees($mysqli){
    $data = [];
    $sql = <<<SQL
        SELECT 
            `employees_id`,
            `lastName`,
            `firstName`,
            `middleName`,
            `extName` 
        FROM 
            `employees` 
        ORDER BY 
            `employees`.`lastName` 
        ASC
    SQL;
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($employee = $result->fetch_assoc()) {

    }
    return $data;
}

function getPlantillas($mysqli){
    $data = [];
    $sql = <<<SQL
    SELECT 
        * 
    FROM 
        `plantillas` 
    ORDER BY 
        `plantillas`.`position_title`
    ASC
    SQL;
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($plantilla = $result->fetch_assoc()) {
        $data[$plantilla['id']] = $plantilla;
    }
    return $data;
}
