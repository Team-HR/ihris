<?php
class Plantilla
{
    private $db;

    function __construct()
    {
        require __DIR__ . '/../../_connect.db.php';
        require "Position.php";
        $this->db = $mysqli;
    }

    public function getPlantillas()
    {
        $data = [];
        $sql = "SELECT * FROM `plantillas` ORDER BY `plantillas`.`position_title` ASC";
        $stmt = $this->db->prepare($sql);
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
        $position = new Position;
        $data = null;
        $sql = "SELECT * FROM `plantillas` WHERE `id` = '$id'";
        $res = $this->db->query($sql);
        if ($row = $res->fetch_assoc()) {
            $position = $position->get_position_data($row["position_id"]);
            $row["position"] = "";
            if ($position) {
                $row["position"] = $position;
            }
            $data = $row;
        }
        return $data;
    }

}
