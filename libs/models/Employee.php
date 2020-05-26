<?php
class Employee {
    private $db;

    function __construct()
    {
        require __DIR__.'/../../_connect.db.php';
        $this->db = $mysqli;
    }   

    public function addNewEmployee($last_name,$first_name,$middle_name,$ext_name){
        $employees_id = 0;
        // check if employee exists
        $sql = <<<SQL
            SELECT `employees_id` FROM `employees` WHERE `firstName` = ? AND `lastName` = ? AND `middleName` = ? AND `extName` = ?
        SQL;
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('ssss',$first_name,$last_name,$middle_name,$ext_name);
        $stmt->execute();
        $stmt->bind_result($employees_id);
        $stmt->fetch();
        $stmt->close();
    
        // if not existing
        if($employees_id == 0) {
            $sql = <<<SQL
                INSERT INTO `employees` (`first_name`, `last_name`, `middle_name`, `ext_name`) VALUES (?,?,?,?)
            SQL;
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param('ssss',$first_name,$last_name,$middle_name,$ext_name);
            $stmt->execute();
            $employees_id = $stmt->insert_id;
            $stmt->close();
        }
        return $employees_id;
    }
    
    public function getEmployees(){
        $data = [];
        $sql = <<<SQL
            SELECT 
                `employees_id`,
                `lastName`,
                `firstName`,
                `middleName`,
                `extName` 
            FROM 
                `employees` 
            ORDER BY 
                `employees`.`lastName` 
            ASC
        SQL;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($employee = $result->fetch_assoc()) {
            $data[] = $employee;
        }
        $stmt->close();
        return $data;
    }

}