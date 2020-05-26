<?php
class Plantilla {
    private $db;

    function __construct(){
        require __DIR__.'/../../_connect.db.php';
        $this->db = $mysqli;
    }
    
    public function getPlantillas(){
        $data = [];
        $sql = <<<SQL
        SELECT 
            * 
        FROM 
            `plantillas` 
        ORDER BY 
            `plantillas`.`position_title`
        ASC
        SQL;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($plantilla = $result->fetch_assoc()) {
            $data[$plantilla['id']] = $plantilla;
        }
        $stmt->close();
        return $data;
    }

    public function isOccupied($plantilla_id){
        $appointment_id = 0;
        $sql = <<<SQL
            SELECT `id` FROM `appointments` WHERE `plantilla_id` = ? 
            AND `date_ended` IS NULL
        SQL;
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i',$plantilla_id);
        $stmt->execute();
        $stmt->bind_result($appointment_id);
        $stmt->fetch();
        return $appointment_id != 0?true:false;
    }
}