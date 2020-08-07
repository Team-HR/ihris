<?php
require_once "../../_connect.db.php";

if (isset($_POST['getEmployee'])) {
    $sql = "SELECT * FROM `employees`";
    $sql = $mysqli->query($sql);
    $dat = [];
    while ($row = $sql->fetch_assoc()) {
        $dat[] = $row;
    }
    echo json_encode($dat);
} elseif (isset($_POST['saveIncumbent'])) {
    $saveIncumbent = $_POST["saveIncumbent"];
    $Oldplantilla = $_POST["Oldplantilla"];
    $nature_of_appointment = $_POST["nature_of_appointment"];
    $date_appointment = $_POST["date_appointment"];
    $date_last_promotion = $_POST["date_last_promotion"];
    $casual_promotion = $_POST["casual_promotion"];
    $sql = "INSERT INTO `appointments` 
        (`appointment_id`, `employee_id`, `plantilla_id`,`nature_of_appointment`,`date_of_appointment`,`date_of_last_promotion`,`casual_promotion`) 
                VALUES (NULL, '$saveIncumbent', '$Oldplantilla','$nature_of_appointment','$date_appointment','$date_last_promotion','$casual_promotion')";
    $sql = $mysqli->query($sql);
    if (!$sql) {
        echo "Error: " . $mysqli->error;
    } else {
        $lastInput = $mysqli->insert_id;
        $sqlPl = "UPDATE `plantillas` SET `incumbent` = '$lastInput' WHERE `plantillas`.`id` = '$Oldplantilla'";
        $sqlPl = $mysqli->query($sqlPl);
        if (!$sqlPl) {
            echo "Error: " . $mysqli->error;
        }
        ############## Service Record Auto Start ######################
        else
        service_record_update($saveIncumbent,$Oldplantilla,$nature_of_appointment,$date_appointment,$date_last_promotion);
        ############## Service Record Auto End ########################
    }
}


############## Service Record Auto Start ######################
function service_record_update($saveIncumbent,$Oldplantilla,$nature_of_appointment,$date_appointment,$date_last_promotion)
{
    require_once $_SERVER["CONTEXT_DOCUMENT_ROOT"]."/libs/ServiceRecord.php";
    require_once $_SERVER["CONTEXT_DOCUMENT_ROOT"]."/libs/PlantillaPermanent.php";

    $old = array(
        "employee_id" => $saveIncumbent,
        "sr_branch" => "LOCAL",
        "sr_date_from" => $date_appointment,
        "sr_date_to" => $date_appointment, //"--INC--",
        "sr_designation" => (new PlantillaPermanent())->getData($Oldplantilla)["position"],
        "sr_is_per_session" => "0",
        "sr_place_of_assignment" => "LGU BAYAWAN",
        "sr_rate_on_schedule" => (new PlantillaPermanent())->getData($Oldplantilla)["monthly_salary"],
        "sr_remarks" => "Original",
        "sr_status" => "PERMANENT",
        "sr_type" => "APPOINTMENT",
    );


    $oldLastPromotion = array(
        "employee_id" => $saveIncumbent,
        "sr_branch" => "LOCAL",
        "sr_date_from" => $date_last_promotion,
        "sr_date_to" => $date_last_promotion, //"--INC--",
        "sr_designation" => "--INC--", //"--INC--",
        "sr_is_per_session" => "0",
        "sr_place_of_assignment" => "LGU BAYAWAN",
        "sr_rate_on_schedule" => "--INC--", //"--INC--",
        "sr_remarks" => "Promotion",
        "sr_status" => "PERMANENT",
        "sr_type" => "BUILD-UP",
    );
    // echo json_encode(count($old)." : ".count($oldLastPromotion));
    // return false;
    $service_rec = new ServiceRecord();
    $service_rec->sensePlantilla($old);
    $service_rec->sensePlantilla($oldLastPromotion);
    // echo json_encode($service_rec->sensePlantilla($old));
}
############## Service Record Auto End ########################