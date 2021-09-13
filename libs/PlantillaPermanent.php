<?php
require_once 'Controller.php';
class PlantillaPermanent extends Controller
{
    private $dat = array();
    public $monthly_salary;
    function __construct()
    {
        parent::__construct();
    }

    public function store($arr = array())
    {
        if (empty($arr)) return false;
        $this->dat = $arr;
        return $this->dat;
    }

    public function getDateOrigAppointment($employees_id)
    {
        $mysqli = $this->mysqli;
        $sql = "SELECT `date_of_appointment` FROM `appointments` WHERE `employee_id`=? 
        -- AND `nature_of_appointment`='original' 
        ORDER BY `date_of_appointment` ASC LIMIT 1";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $employees_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $date = $data["date_of_appointment"];
        
        return $date ? date("m/d/Y", strtotime($date)) : "";
    }

    public function getDateLastPromoted($employees_id)
    {
        // return "02/11/2021";
        $mysqli = $this->mysqli;
        $sql = "SELECT `date_of_last_promotion` FROM `appointments` WHERE `employee_id`=? AND `nature_of_appointment`='promotion' ORDER BY `date_of_last_promotion` DESC LIMIT 1";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $employees_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($data = $result->fetch_assoc()) {
            $date = $data["date_of_last_promotion"];
            return $date ? date("m/d/Y", strtotime($date)) : "";
        }
        return "";
        
    }

    public function getCurrentEmploymentStatus($employees_id)
    {
        $mysqli = $this->mysqli;
        $sql = "SELECT `status_of_appointment` FROM `appointments` WHERE `employee_id`=? ORDER BY `date_of_appointment` DESC LIMIT 1";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $employees_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $status = $data["status_of_appointment"];
        
        return $status ? strtoupper($status) : "";
    }

    public function getData($plantilla_id)
    {
        if (!$plantilla_id) return false;
        $mysqli = $this->mysqli;
        $sql = "SELECT * FROM `plantillas` WHERE `id` = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i', $plantilla_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $data["monthly_salary"] = $this->getMonthlySalary($data["position_id"], $data["step"], $data["schedule"]);
        
        $data = $data + $this->positionData($data["position_id"]);
        $data = $data + $this->departmentData($data["department_id"]);
        return $data;
    }

    public function departmentData($department_id)
    {
        $department = new Department();
        $data = $department->getData($department_id);
        return $data;
    }


    public function positionData($position_id)
    {
        $position = new Position();
        $data = $position->getData($position_id);
        return $data;
    }


    public function getMonthlySalary($position_id, $step, $schedule)
    {
        if (empty($position_id) || empty($step) || empty($schedule)) return false;
        $position = new Position();
        $sg = $position->getSalaryGrade($position_id);
        $monthly_salary = 0;
        if (empty($sg)) return false;
        $mysqli = $this->mysqli;
        $sql = "SELECT id FROM `setup_salary_adjustments` WHERE schedule = ? AND active = '1'";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i', $schedule);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $parent_id = 0;
        $parent_id = $row["id"];
        
        if (empty($parent_id)) return false;
        $sql = "SELECT monthly_salary FROM `setup_salary_adjustments_setup` WHERE parent_id = ? AND salary_grade = ? AND step_no = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('iii', $parent_id, $sg, $step);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $monthly_salary = $row["monthly_salary"];
        
        return $monthly_salary;
    }
}
