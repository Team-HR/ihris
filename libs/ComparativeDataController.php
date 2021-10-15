<?php
require_once "Controller.php";

class ComparativeDataController extends Controller
{

    function __construct()
    {
        parent::__construct();
    }
    
    public function get_vacant_position($rspvac_id){
        $mysqli = $this->mysqli;
        $sql = "SELECT * FROM `rsp_vacant_positions` WHERE `rspvac_id` = '$rspvac_id'";
        $result = $mysqli->query($sql);
        $row = $result->fetch_assoc();
        $department = new Department();
        $office = null;
        if ($row['office']) {
            $office = $department->getDepartment($row['office']);
        }
        $data = array(
            "rspvac_id" => $row['rspvac_id'],
            "positiontitle" => $row['positiontitle'],
            "itemNo" => $row['itemNo'],
            "sg" => $row['sg'],
            "office" => $office,
            "dateVacated" => $row['dateVacated'],
            "education" => $row['education']?unserialize($row['education']):null,
            "training" => $row['training']?unserialize($row['training']):null,
            "experience" => $row['experience']?unserialize($row['experience']):null,
            "eligibility" => $row['eligibility']?unserialize($row['eligibility']):null
        );
        return $data;
    }

    public function get_list_of_applicants($rspvac_id){
        $data = array();
        $mysqli = $this->mysqli;
        $sql = "SELECT `rspcomp_id`, `rsp_comparative`.`applicant_id`, `name`,`age`,`gender`,`num_years_in_gov`,`civil_status`,`education`,`training`,`experience`,`eligibility`,`awards`,`records_infractions` FROM `rsp_applicants` LEFT JOIN `rsp_comparative`ON `rsp_comparative`.`applicant_id` = `rsp_applicants`.`applicant_id` WHERE `rspvac_id` = '$rspvac_id'";
        $result = $mysqli->query($sql);
        while ($row = $result->fetch_assoc()) {
            $row['records_infractions'] = $row['records_infractions']?unserialize($row['records_infractions']):[];
            $row['awards'] = $row['awards']?unserialize($row['awards']):[];
            $row['eligibility'] = $row['eligibility']?unserialize($row['eligibility']):[];
            $row['experience'] = $row['experience']?unserialize($row['experience']):[];
            $row['training'] = $row['training']?unserialize($row['training']):[];
            $row['num_years_in_gov'] = $row['num_years_in_gov']?unserialize($row['num_years_in_gov']):[];

            $row['is_checklisted'] = $this->is_checklisted($row['rspcomp_id']);
            $data [] = $row;
        }
        return $data;
    }

    public function is_checklisted($rspcomp_id)
    {
        if (!$rspcomp_id) return false;
        $mysqli = $this->mysqli;
        // check if rspcomp_id has already a checklist
        $exist = false;
        $sql = "SELECT * FROM `rsp_comp_checklist` WHERE `rspcomp_id` = $rspcomp_id";
        $result = $mysqli->query($sql);
        $row = $result->fetch_assoc();
        if ($result->num_rows > 0) {
            $exist = true;
        }
    
        return $exist;
    }


}


