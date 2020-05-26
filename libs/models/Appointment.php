<?php
class Appointment
{
    private $db;
    function __construct()
    {
        // echo "HELLOW";
        require __DIR__."/../../_connect.db.php";
        $this->db = $mysqli;
    }
    
    public function addNewAppointment($json){

        array_walk($json,function(&$value){
            $value = empty($value)?NULL:$value;
        });

        $sql = <<<SQL
            INSERT INTO `appointments` (`plantilla_id`,`employee_id`,`status_of_appointment`,`date_of_appointment`,`date_ended`,`nature_of_appointment`,`legal_doc`,`memo_for_legal`,`head_of_agency`,`date_of_signing`,`csc_auth_official`,`date_signed_by_csc`,`csc_mc_no`,`published_at`,`date_of_publication`,`hrmo`,`screening_body`,`date_of_screening`,`committee_chair`,`notation_1`,`notation_2`,`notation_3`,`notation_4`,`csc_release_date`,`timestamp_created`,`timestamp_updated`)
            VALUES (?,?,?,?,NULL,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,CURRENT_TIMESTAMP (), CURRENT_TIMESTAMP ())
        SQL;
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('iissssssssssssssssiiiis',$json['plantilla_id'],$json['employee_id'],$json['status_of_appointment'],$json['date_of_appointment'],$json['nature_of_appointment'],$json['legal_doc'],$json['memo_for_legal'],$json['head_of_agency'],$json['date_of_signing'],$json['csc_auth_official'],$json['date_signed_by_csc'],$json['csc_mc_no'],$json['published_at'],$json['date_of_publication'],$json['hrmo'],$json['screening_body'],$json['date_of_screening'],$json['committee_chair'],$json['notation_1'],$json['notation_2'],$json['notation_3'],$json['notation_4'],$json['csc_release_date']);
        $stmt->execute();
        $error = $stmt->error;
        $stmt->close();
        return $error;
    }

    public function isAppointed($employee_id){
        $appointment_id = 0;
        $sql = <<<SQL
            SELECT `id` FROM `appointments` WHERE `employee_id` = ? 
            AND `date_ended` IS NULL
        SQL;
        $stmt = $this->db->prepare($sql);
        $stmt-> bind_param('i',$employee_id);
        $stmt->execute();
        $stmt->bind_result($appointment_id);
        $stmt->fetch();
        return $appointment_id != 0?true:false;
    }

}
