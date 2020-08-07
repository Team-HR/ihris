<?php
class ServiceRecord
{
    private $db;
    function __construct()
    {
        require $_SERVER["CONTEXT_DOCUMENT_ROOT"] . '/_connect.db.php';
        $this->db = $mysqli;
    }

    public function sensePlantilla($arr = array())
    {
        $mysqli = $this->db;
        if (empty($arr)) return false;
        $data = $arr;
        if (
            empty($data["sr_date_from"]) ||
            empty($data["sr_date_to"])
        ) return false;

        array_walk($data, function (&$item1) {
            $item1 = strtoupper($item1);
        });

        $sql = "INSERT INTO `service_records` (`employee_id`,`sr_branch`,`sr_date_from`,`sr_date_to`,`sr_designation`,`sr_is_per_session`,`sr_place_of_assignment`,`sr_rate_on_schedule`,`sr_remarks`,`sr_status`,`sr_type`) VALUES (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("issssssssss",$data["employee_id"],$data["sr_branch"],$data["sr_date_from"],$data["sr_date_to"],$data["sr_designation"],$data["sr_is_per_session"],$data["sr_place_of_assignment"],$data["sr_rate_on_schedule"],$data["sr_remarks"],$data["sr_status"],$data["sr_type"]);
        $stmt->execute();
        $affected_rows = $stmt->affected_rows;
        $stmt->close();
        return $affected_rows;
    }


    public function getDailyRate($sg, $step, $schedule)
    {
        require './Position.php';
        $position = new Position();
        $salary_grade = $position->getSalaryGrade($position_id);

        $monthly_salary = 0;
        if (empty($sg) || empty($step) || empty($schedule)) return false;
        $sql = "SELECT id FROM `ihris_dev`.`setup_salary_adjustments` WHERE schedule = ? AND active = '1'";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $schedule);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $parent_id = 0;
        $parent_id = $row["id"];
        $stmt->close();
        if (empty($parent_id)) return false;
        $sql = "SELECT monthly_salary FROM `ihris_dev`.`setup_salary_adjustments_setup` WHERE parent_id = ? AND salary_grade = ? AND step_no = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('iii', $parent_id, $sg, $step);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $monthly_salary = $row["monthly_salary"];
        $stmt->close();
        // return $monthly_salary?number_format(($monthly_salary*12),2,'.',','):"---";
        return $monthly_salary ? ($monthly_salary / 30) : "---";
    }
}
