<?php
require_once "Controller.php";

class CascadePcrController extends Controller
{

    private $period_id = 0;
    private $pcr_numerical_rating;
    private $employee;


    function __construct()
    {
        parent::__construct();
        $this->pcr_final = new PcrFinalNumericalRatingController();
        $this->employee = new EmployeeController();
    }

    public function set_period_id($period_id)
    {
        $this->period_id = $period_id;
    }

    public function get_cascaded_pcr_report($department_id = NULL)
    {
        $data = [];

        $departments = $this->get_department_by_id($department_id);

        foreach ($departments as $department) {
            $department_id = $department["id"];

            $data[] = [
                "department_id" => $department_id,
                "department" => $department["department"],
                "department_head" => $this->get_department_head_by_department_id($department_id),
                "supervisors" => $this->get_supervisors_by_department_id($department_id)
            ];
        }

        return $data;
    }

    private function get_supervisors_by_department_id($department_id)
    {
        $data = [];

        $sql = "SELECT DISTINCT `ImmediateSup` FROM `spms_performancereviewstatus` WHERE `department_id` = ? AND `ImmediateSup` != '' AND `department_id` != 'NULL' AND `period_id` = ?;";

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("ii", $department_id, $this->period_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {

            $employee_id = $row["ImmediateSup"];
            $name = $this->employee->get_full_name_upper($employee_id);

            $supervisor = [
                "employee_id" => $employee_id,
                "name" => $name,
                "pcr_final_numerical_rating" => 0,
                "subordinates" => []
            ];

            $data[] = $supervisor;
        }


        foreach ($data as $i => $supervisor) {
            $data[$i]["pcr_final_numerical_rating"] = $this->pcr_final->get_final_numerical_rating($supervisor["employee_id"], $this->period_id);
            $data[$i]["subordinates"] = $this->get_subordinates_by_supervisor_employee_id($supervisor["employee_id"]);
        }

        usort($data, function($a, $b) {
            return $a['name'] > $b['name'];
        });

        return $data;
    }

    private function get_subordinates_by_supervisor_employee_id($employee_id){
        $data = [];
        $sql = "SELECT * FROM `spms_performancereviewstatus` WHERE `ImmediateSup` = ? AND `period_id` = ?;";

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("ii", $employee_id, $this->period_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $employee_id = $row["employees_id"];

            $subordinate = [
                "employee_id" => $employee_id,
                "name" => "",
                "pcr_final_numerical_rating" => 0
            ];

            $data [] = $subordinate;
        }

        foreach ($data as $i => $subordinate) {
            $data[$i]["name"] = $this->employee->get_full_name_upper($subordinate["employee_id"]);
            $data[$i]["pcr_final_numerical_rating"] = $this->pcr_final->get_final_numerical_rating($subordinate["employee_id"], $this->period_id);
        }

        usort($data, function($a, $b) {
            return $a['name'] > $b['name'];
        });

        return $data;
    }

    private function get_department_head_by_department_id($department_id)
    {
        $data = [
            "employee_id" => 0,
            "name" => ""
        ];

        if (!$department_id) return [];

        $sql = "SELECT `DepartmentHead` AS `employee_id` FROM `spms_performancereviewstatus` WHERE `department_id` = ? AND `period_id` = ? AND `DepartmentHead` != '' LIMIT 1;";

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("ii", $department_id, $this->period_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {

            $data = $row;
        }

        $data["name"] = $this->employee->get_full_name_upper($data["employee_id"]);

        return $data;
    }

    private function get_department_by_id($department_id = NULL)
    {
        $departments = [];

        if ($department_id) {
            $sql = "SELECT * FROM `department` WHERE `department_id` = ?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("i", $department_id);
            $stmt->execute();
        } else {
            $sql = "SELECT * FROM `department`";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->execute();
        }

        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $departments[] = [
                "id" => $row["department_id"],
                "department" => $row["department"]
            ];
        }

        usort($departments, function($a, $b) {
            return $a['department'] > $b['department'];
        });

        return $departments;
    }
}
