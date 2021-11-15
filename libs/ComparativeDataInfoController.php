<?php
require_once "Controller.php";

class ComparativeDataInfoController extends Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function get_vacant_position($rspvac_id)
    {
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
            "education" => $row['education'],
            "trainings" => $row['training'] ? unserialize($row['training']) : [],
            "experiences" => $row['experience'] ? unserialize($row['experience']) : [],
            "eligibilities" => $row['eligibility'] ? unserialize($row['eligibility']) : [],
            "awards" => $row['awards'] ? unserialize($row['awards']) : []
        );
        return $data;
    }

    public function get_list_of_applicants($rspvac_id)
    {
        $data = array();
        $mysqli = $this->mysqli;
        $sql = "SELECT `rspcomp_id`, `rsp_comparative`.`applicant_id`, `name`,`age`,`gender`,`num_years_in_gov`,`civil_status`,`education`,`training`,`experience`,`eligibility`,`awards`,`records_infractions` FROM `rsp_applicants` LEFT JOIN `rsp_comparative`ON `rsp_comparative`.`applicant_id` = `rsp_applicants`.`applicant_id` WHERE `rspvac_id` = '$rspvac_id'";
        $result = $mysqli->query($sql);
        while ($row = $result->fetch_assoc()) {
            $row['records_infractions'] = $row['records_infractions'] ? unserialize($row['records_infractions']) : [];
            $row['awards'] = $row['awards'] ? unserialize($row['awards']) : [];
            $row['eligibility'] = $row['eligibility'] ? unserialize($row['eligibility']) : [];
            $row['experience'] = $row['experience'] ? unserialize($row['experience']) : [];
            $row['training'] = $row['training'] ? unserialize($row['training']) : [];
            $row['num_years_in_gov'] = $row['num_years_in_gov'] ? unserialize($row['num_years_in_gov']) : [];

            $row['is_checklisted'] = $this->is_checklisted($row['rspcomp_id']);
            $data[] = $row;
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


    public function search_applicants_where_name_like($name)
    {
        $items = [];
        $sql = "SELECT * FROM `rsp_applicants` WHERE `name` LIKE '%$name%'";
        $result = $this->mysqli->query($sql);
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }

        return $items;
    }

    /**
     * 
     * Not Saving
     * 
     * 
     * */
    public function save_new_applicant_submit($arr)
    {
        if (!$arr) return false;

        $applicant_id = NULL; //$arr["applicant_id"];
        $name = $arr["name"];
        $age = $arr["age"];
        $gender = $arr["gender"];
        $civil_status = $arr["civil_status"];
        $mobile_no = $arr["mobile_no"];
        $address = $arr["address"];
        $education = $arr["education"];
        $school = $arr["school"];
        // $training = ""; //$arr["training"]; //##### deprecated
        // $num_years_in_gov = ""; //$arr["num_years_in_gov"]; //#### deprecated
        // $experience = ""; // $arr["experience"]; //##### deprecated
        // $eligibility = ""; //$arr["eligibility"]; //##### deprecated
        $remarks = $arr["remarks"];
        $awards = isset($arr["awards"])? serialize($arr["awards"]): "[]";
        $records_infractions = isset($arr["records_infractions"])? serialize($arr["records_infractions"]): "[]";
        $trainings = isset($arr["trainings"])? serialize($arr["trainings"]): "[]";
        $experiences = isset($arr["experiences"])? serialize($arr["experiences"]): "[]";
        $eligibilities = isset($arr["eligibilities"])? serialize($arr["eligibilities"]): "[]";

        $sql = "INSERT INTO `rsp_applicants` (`name`, `age`, `gender`, `civil_status`, `mobile_no`, `address`, `education`, `school`, `awards`, `records_infractions`, `remarks`, `trainings`, `experiences`, `eligibilities`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        
        $stmt = $this->mysqli->prepare($sql);
        
        $stmt->bind_param("sissssssssssss", $name,$age,$gender,$civil_status,$mobile_no,$address,$education,$school,$awards,$records_infractions,$remarks,$trainings,$experiences,$eligibilities);
        
        $stmt->execute();

        $insert_id = $stmt->insert_id;

        $stmt->close();

        return $insert_id;
    }

    public function add_applicant_to_vacant_post($applicant_id, $rspvac_id) 
    {
        $sql = "INSERT INTO `rsp_comparative` (`rspvac_id`, `applicant_id`) VALUES (?,?)";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("ii",$applicant_id, $rspvac_id);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }
}