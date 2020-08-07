<?php
class Position
{
    private $db;
    private $dat = array();
    function __construct()
    {
        require $_SERVER["CONTEXT_DOCUMENT_ROOT"] . '/_connect.db.php';
        $this->db = $mysqli;
    }

    public function store($arr = array())
    {
        // incomplete
        if (empty($arr)) return false;
        $this->dat = $arr;
        return $this->dat;
    }

    public function getData($id){
        $sql = "SELECT * FROM `ihris_dev`.`positiontitles` WHERE `position_id` = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        // $salary_grade = $row["salaryGrade"];
        $stmt->close();
        return $data;
    }

    public function getSalaryGrade($id){
        if(!$id) return false;
        $sql = "SELECT `salaryGrade` FROM `ihris_dev`.`positiontitles` WHERE `position_id` = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $salary_grade = $row["salaryGrade"];
        $stmt->close();
        return $salary_grade?$salary_grade:"";
    }


}
