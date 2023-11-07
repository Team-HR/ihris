<?php
class Position
{
    private $db;

    function __construct()
    {
        require __DIR__ . '/../../_connect.db.php';
        $this->db = $mysqli;
    }

    public function get_position_data($id)
    {
        $data = null;
        $sql = "SELECT * FROM `positiontitles` WHERE `position_id` = '$id'";
        $res = $this->db->query($sql);
        if ($row = $res->fetch_assoc()) {
            $data = $row;
        }
        return $data;
    }
}
