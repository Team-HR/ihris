
<?php
require_once '../../_connect.db.php';

// $echo = getPlantillas($mysqli);
// print("<pre>".print_r($echo,true)."</pre>");

if (isset($_POST['Employees'])) {
    $sql = "SELECT
                employees.employees_id, 
                employees.firstName, 
                employees.lastName, 
                employees.middleName, 
                employees.extName
            FROM
                employees";
    $sql = $mysqli->query($sql);
    $dat = [];
    $throwDat = [];
    $allEmp = [];
    while ($row = $sql->fetch_assoc()) {
        $allEmp[] = $row;
        $s = "SELECT * from `plantillas` left join `appointments` on `plantillas`.`incumbent`=`appointments`.`appointment_id` where `appointments`.`employee_id`='$row[employees_id]'";
        $s = $mysqli->query($s);
        echo $mysqli->error;
        if (!$s->num_rows) {
            $dat[] = $row;
        }
    }
    $throwDat['Employees'] = $dat;
    $throwDat['All_Employees'] = $allEmp;
    echo json_encode($throwDat);
} elseif (isset($_POST['Plantilla'])) {
    $dataId = $_POST['Plantilla'];
    $sendDat = array('status' => '', 'dat' => '');
    $sql = "SELECT
                plantillas.id as plantilla_id, 
                plantillas.item_no, 
                plantillas.step, 
                plantillas.schedule, 
                plantillas.incumbent,
                positiontitles.position, 
                positiontitles.functional, 
                positiontitles.salaryGrade, 
                department.department, 
                employees.firstName AS vac_firstName, 
                employees.lastName AS vac_lastName, 
                employees.middleName AS vac_middleName, 
                employees.extName AS vac_extName, 
                appointments.reason_of_vacancy
            FROM
                plantillas
                LEFT JOIN
                positiontitles
                ON 
                    plantillas.position_id = positiontitles.position_id
                LEFT JOIN
                department
                ON 
                    plantillas.department_id = department.department_id
                LEFT JOIN
                appointments
                ON 
                    plantillas.vacated_by = appointments.appointment_id
                LEFT JOIN
                employees
                ON 
                    appointments.employee_id = employees.employees_id
            WHERE
                plantillas.id = '$dataId'";
    $sql = $mysqli->query($sql);
    $plan = $sql->fetch_assoc();
    if ($sql->num_rows == 0 || $plan['incumbent'] != "0") {
        $sendDat['status'] = false;
    } else {
        $dat = [];
        foreach ($plan as $key => $a) {
            $dat[$key] =  $a;
        }
        $salary_sql = "SELECT
                        setup_salary_adjustments_setup.monthly_salary
                    FROM
                        setup_salary_adjustments_setup
                        LEFT JOIN
                        setup_salary_adjustments
                        ON 
                            setup_salary_adjustments_setup.parent_id = setup_salary_adjustments.id
                    WHERE
                        setup_salary_adjustments.`schedule` = $plan[schedule] AND
                        setup_salary_adjustments_setup.step_no = $plan[step] AND
                        setup_salary_adjustments_setup.salary_grade = $plan[salaryGrade] AND
                        setup_salary_adjustments.active = 1";
        $salary_sql = $mysqli->query($salary_sql);

        if ($dat['vac_firstName'] == "") {
            $dat['vac_firstName'] = " ";
        }
        if ($dat['vac_middleName'] == "") {
            $dat['vac_middleName'] = " ";
        }
        if ($dat['vac_lastName'] == "") {
            $dat['vac_lastName'] = " ";
        }
        if ($dat['vac_extName'] == "") {
            $dat['vac_extName'] = " ";
        }
        if ($dat['reason_of_vacancy'] == "") {
            $dat['reason_of_vacancy'] = " ";
        }
        echo $mysqli->error;
        $salary_sql = $salary_sql->fetch_assoc();
        $dat['monthly_salary'] = $salary_sql['monthly_salary'];
        $sendDat['status'] = true;
        $sendDat['dat'] = $dat;
    }
    echo json_encode($sendDat);
} elseif (isset($_POST['saveAppointment'])) {
    $employees_id = $_POST['employees_id'];
    $plantilla_id = $_POST['plantilla_id'];
    $reason_of_vacancy = $_POST['reason_of_vacancy'];
    $status_of_appointment = $_POST['status_of_appointment'];
    $csc_authorized_official = $_POST['csc_authorized_official'];
    $date_signed_by_csc = $_POST['date_signed_by_csc'];
    $committee_chair = $_POST['committee_chair'];
    $date_of_appointment = $_POST['date_of_appointment'];
    $date_of_assumption = $_POST['date_of_assumption'];
    $csc_mc_no = $_POST['csc_mc_no'];
    $series_no = $_POST['series_no'];
    $HRMO = $_POST['HRMO'];
    $office_assignment = $_POST['office_assignment'];
    $nature_of_appointment = $_POST['nature_of_appointment'];
    $date_of_signing = $_POST['date_of_signing'];
    $deliberation_date_from = $_POST['deliberation_date_from'];
    $deliberation_date_to = $_POST['deliberation_date_to'];
    $published_at = $_POST['published_at'];
    $posted_in = $_POST['posted_in'];
    $govId_type = $_POST['govId_type'];
    $govId_no = $_POST['govId_no'];
    $govId_issued_date = $_POST['govId_issued_date'];
    $posted_date_from = $_POST['posted_date_from'];
    $posted_date_to = $_POST['posted_date_to'];
    $csc_release_date = $_POST['csc_release_date'];
    $sworn_date = $_POST['sworn_date'];
    $cert_issued_date = $_POST['cert_issued_date'];
    $casual_promotion = $_POST['casual_promotion'];
    $probationary_period = $_POST['probationary_period'];
    $date_of_last_promotion = $_POST['date_of_last_promotion'];
    ############## mysqli_real_escape fix start ######################
    $status_of_appointment = $mysqli->real_escape_string($status_of_appointment);
    $csc_authorized_official = $mysqli->real_escape_string($csc_authorized_official);
    $date_signed_by_csc = $mysqli->real_escape_string($date_signed_by_csc);
    $committee_chair = $mysqli->real_escape_string($committee_chair);
    $date_of_appointment = $mysqli->real_escape_string($date_of_appointment);
    $date_of_assumption = $mysqli->real_escape_string($date_of_assumption);
    $csc_mc_no = $mysqli->real_escape_string($csc_mc_no);
    $series_no = $mysqli->real_escape_string($series_no);
    $HRMO = $mysqli->real_escape_string($HRMO);
    $office_assignment = $mysqli->real_escape_string($office_assignment);
    $nature_of_appointment = $mysqli->real_escape_string($nature_of_appointment);
    $date_of_signing = $mysqli->real_escape_string($date_of_signing);
    $deliberation_date_from = $mysqli->real_escape_string($deliberation_date_from);
    $deliberation_date_to = $mysqli->real_escape_string($deliberation_date_to);
    $published_at = $mysqli->real_escape_string($published_at);
    $posted_in = $mysqli->real_escape_string($posted_in);
    $govId_type = $mysqli->real_escape_string($govId_type);
    $govId_no = $mysqli->real_escape_string($govId_no);
    $govId_issued_date = $mysqli->real_escape_string($govId_issued_date);
    $posted_date_from = $mysqli->real_escape_string($posted_date_from);
    $posted_date_to = $mysqli->real_escape_string($posted_date_to);
    $csc_release_date = $mysqli->real_escape_string($csc_release_date);
    $sworn_date = $mysqli->real_escape_string($sworn_date);
    $cert_issued_date = $mysqli->real_escape_string($cert_issued_date);
    $casual_promotion = $mysqli->real_escape_string($casual_promotion);
    $probationary_period = $mysqli->real_escape_string($probationary_period);
    $date_of_last_promotion = $mysqli->real_escape_string($date_of_last_promotion);
    ############## mysqli_real_escape fix end ######################
    $sql = "INSERT INTO `appointments` (
                            `appointment_id`,
                            `employee_id`,
                            `plantilla_id`,
                            `reason_of_vacancy`,
                            `status_of_appointment`,
                            `csc_authorized_official`,
                            `date_signed_by_csc`,
                            `committee_chair`,
                            `date_of_appointment`,
                            `date_of_assumption`,
                            `csc_mc_no`,
                            `series_no`,
                            `HRMO`,
                            `office_assignment`,
                            `nature_of_appointment`,
                            `date_of_signing`,
                            `deliberation_date_from`,
                            `deliberation_date_to`,
                            `published_at`,
                            `posted_in`,
                            `govId_type`,
                            `govId_no`,
                            `govId_issued_date`,
                            `posted_date_from`,
                            `posted_date_to`,
                            `csc_release_date`,
                            `sworn_date`,
                            `cert_issued_date`,
                            `casual_promotion`,
                            `probationary_period`,
                            `date_of_last_promotion`
                        ) VALUES (
                            NULL,
                            '$employees_id',
                            '$plantilla_id',
                            '$reason_of_vacancy',
                            '$status_of_appointment',
                            '$csc_authorized_official',
                            '$date_signed_by_csc',
                            '$committee_chair',
                            '$date_of_appointment',
                            '$date_of_assumption',
                            '$csc_mc_no',
                            '$series_no',
                            '$HRMO',
                            '$office_assignment',
                            '$nature_of_appointment',
                            '$date_of_signing',
                            '$deliberation_date_from',
                            '$deliberation_date_to',
                            '$published_at',
                            '$posted_in',
                            '$govId_type',
                            '$govId_no',
                            '$govId_issued_date',
                            '$posted_date_from',
                            '$posted_date_to',
                            '$csc_release_date',
                            '$sworn_date',
                            '$cert_issued_date',
                            '$casual_promotion',
                            '$probationary_period',
                            '$date_of_last_promotion'
                        )";
    $sql = $mysqli->query($sql);
    echo $mysqli->error;
    $lastInsertId = $mysqli->insert_id;
    $sqlPlantilla = "UPDATE `plantillas` SET `incumbent`='$lastInsertId' where `id`='$plantilla_id'";
    $sql1 = $mysqli->query($sqlPlantilla);
    $d = [];
    if (!$sql || !$sql1) {
        $d['status'] = false;
        $d['color'] = 'error';
        $d['msg'] = "An Error Occur";
    } else {
        $d['status'] = true;
        $d['color'] = 'success';
        $d['msg'] = "Successfull!!<br>Redirecting";
        ############## Service Record Auto Start ######################
        service_record_update($employees_id, $plantilla_id, $status_of_appointment, $date_of_appointment, $nature_of_appointment);
        ############## Service Record Auto End ########################
    }
    echo json_encode($d);
}

############## Service Record Auto Start ######################
function service_record_update($employees_id, $plantilla_id, $status_of_appointment, $date_of_appointment, $nature_of_appointment)
{
    require "../../libs/ServiceRecord.php";
    require "../../libs/PlantillaPermanent.php";

    $data = array(
        "employee_id" => $employees_id,
        "sr_branch" => "LOCAL",
        "sr_date_from" => $date_of_appointment,
        "sr_date_to" => NULL, // INC LACKS AUTO sr_date_to closure once buildup triggers
        "sr_designation" => (new PlantillaPermanent())->getData($plantilla_id)["position"],
        "sr_is_per_session" => "0",
        "sr_place_of_assignment" => "LGU BAYAWAN",
        "sr_rate_on_schedule" => (new PlantillaPermanent())->getData($plantilla_id)["monthly_salary"],
        "sr_remarks" => ucfirst($nature_of_appointment), // INC LACKS CHECKER IF ORGINAL OR PROMOTION OR etc
        "sr_status" => strtoupper($status_of_appointment),
        "sr_type" => "BUILD-UP",
    );

    // echo json_encode($data);
    // return false;
    $service_rec = new ServiceRecord();
    $service_rec->sensePlantilla($data);
    // echo json_encode($service_rec->sensePlantilla($old));
}
############## Service Record Auto End ########################
