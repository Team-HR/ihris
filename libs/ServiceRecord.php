<?php
require_once "Controller.php";

class ServiceRecord extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function sensePlantilla($arr = array())
    {
        $mysqli = $this->mysqli;
        if (empty($arr)) return false;
        $data = $arr;
        if (
            empty($data["sr_date_from"])
        ) return false;

        array_walk($data, function (&$item1) {
            if (!$item1) return '';
            $item1 = strtoupper($item1);
        });

        if ($this->hasRecs($data["employee_id"])) {
            $this->toDateClosure($data["employee_id"], $data["sr_date_from"]);
        }

        $sql = "INSERT INTO `service_records` (`employee_id`,`sr_branch`,`sr_date_from`,`sr_date_to`,`sr_designation`,`sr_is_per_session`,`sr_place_of_assignment`,`sr_rate_on_schedule`,`sr_remarks`,`sr_status`,`sr_type`) VALUES (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("issssssssss", $data["employee_id"], $data["sr_branch"], $data["sr_date_from"], $data["sr_date_to"], $data["sr_designation"], $data["sr_is_per_session"], $data["sr_place_of_assignment"], $data["sr_rate_on_schedule"], $data["sr_remarks"], $data["sr_status"], $data["sr_type"]);
        $stmt->execute();
        $affected_rows = $stmt->affected_rows;
        $stmt->close();
        return $affected_rows;
    }

    private function hasRecs($employee_id)
    {
        $mysqli = $this->mysqli;
        $sql = "SELECT `id` FROM `service_records` WHERE `employee_id` = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $num_rows = $result->num_rows;
        $stmt->close();
        return $num_rows > 0 ? true : false;
    }

    private function toDateClosure($employee_id, $date_of_appointment)
    {
        $mysqli = $this->mysqli;
        $sql = "UPDATE `service_records` SET `sr_date_to` = ? WHERE `sr_date_to` IN (NULL,'') AND `employee_id` = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("si", $date_of_appointment, $employee_id);
        $stmt->execute();
        $stmt->close();
    }

    // public function getDailyRate($sg, $step, $schedule)
    // {
    //     require './Position.php';
    //     $position = new Position();
    //     $salary_grade = $position->getSalaryGrade($position_id);

    //     $monthly_salary = 0;
    //     if (empty($sg) || empty($step) || empty($schedule)) return false;
    //     $mysqli = $this->mysqli;
    //     $sql = "SELECT id FROM `setup_salary_adjustments` WHERE schedule = ? AND active = '1'";
    //     $stmt = $mysqli->prepare($sql);
    //     $stmt->bind_param('i', $schedule);
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    //     $row = $result->fetch_assoc();
    //     $parent_id = 0;
    //     $parent_id = $row["id"];
    //     $stmt->close();
    //     if (empty($parent_id)) return false;
    //     $sql = "SELECT monthly_salary FROM `setup_salary_adjustments_setup` WHERE parent_id = ? AND salary_grade = ? AND step_no = ?";
    //     $stmt = $mysqli->prepare($sql);
    //     $stmt->bind_param('iii', $parent_id, $sg, $step);
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    //     $row = $result->fetch_assoc();
    //     $monthly_salary = $row["monthly_salary"];
    //     $stmt->close();
    //     // return $monthly_salary?number_format(($monthly_salary*12),2,'.',','):"---";
    //     return $monthly_salary ? ($monthly_salary / 30) : "---";
    // }
}
