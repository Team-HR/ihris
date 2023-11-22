<?php
require __DIR__ . '/../Controller.php';

class Plantilla extends Controller
{
    private $db;

    function __construct()
    {
        parent::__construct();
        // require __DIR__ . '/../../_connect.db.php';
        // require "Position.php";
        // require __DIR__ . '/../Department.php';
    }

    public function getPlantillas()
    {
        $data = [];
        $sql = "SELECT * FROM `plantillas` ORDER BY `plantillas`.`position_title` ASC";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($plantilla = $result->fetch_assoc()) {
            $data[$plantilla['id']] = $plantilla;
        }
        $stmt->close();
        return $data;
    }

    public function get_plantilla_data($id)
    {
        $position = new PositionController;
        $department = new Department;
        $data = null;
        $sql = "SELECT * FROM `plantillas` WHERE `id` = '$id'";
        $res = $this->mysqli->query($sql);
        if ($row = $res->fetch_assoc()) {
            $position = $position->getData($row["position_id"]);
            $row["position"] = "";
            if ($position) {
                $row["position"] = $position;
                $row["department"] = $department->getDepartmentData($row["department_id"]);
            }
            $data = $row;
        }
        return $data;
    }
}
