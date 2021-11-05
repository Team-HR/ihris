<?php
require_once "Controller.php";

class CascadePcrController extends Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function get_cascaded_pcr_report()
    {
        $data = [];

        $departments = $this->get_departments();

        foreach ($departments as $department) {
            $data[] = [
                "department_id" => $department["id"],
                "department" => $department["department"],
                "department_head" => 0,
                "supervisors" => []
            ];
        }

        return $data;


    }

    private function get_departments()
    {
        $departments = [];
        $sql = "SELECT * FROM `department`";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $departments[] = [
                "id" => $row["department_id"],
                "department" => $row["department"]
            ];
        }
        return $departments;
    }
}