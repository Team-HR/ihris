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
}