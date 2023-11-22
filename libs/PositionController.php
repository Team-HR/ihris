<?php
require_once "Controller.php";

class PositionController extends Controller
{
    private $dat = array();
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

    public function getData($id)
    {
        $mysqli = $this->mysqli;
        $sql = "SELECT * FROM `positiontitles` WHERE `position_id` = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        // $salary_grade = $row["salaryGrade"];
        $stmt->close();
        return $data;
    }

    public function getSalaryGrade($id)
    {
        if (!$id) return false;
        $mysqli = $this->mysqli;
        $sql = "SELECT `salaryGrade` FROM `positiontitles` WHERE `position_id` = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $salary_grade = $row["salaryGrade"];
        $stmt->close();
        return $salary_grade ? $salary_grade : "";
    }
}
