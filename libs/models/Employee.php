<?php
class Employee
{
    private $db;
    public $inserted_id;
    private $exts = array('JR', 'SR');

    function __construct()
    {
        require __DIR__ . '/../../_connect.db.php';
        $this->db = $mysqli;
    }

    public function addNewEmployee($last_name, $first_name, $middle_name, $ext_name)
    {
        $employees_id = 0;
        // check if employee exists
        $sql = <<<SQL
            SELECT `employees_id` FROM `employees` WHERE `firstName` = ? AND `lastName` = ? AND `middleName` = ? AND `extName` = ?
        SQL;
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('ssss', $first_name, $last_name, $middle_name, $ext_name);
        $stmt->execute();
        $stmt->bind_result($employees_id);
        $stmt->fetch();
        $stmt->close();

        // if not existing
        if ($employees_id == 0) {
            $sql = <<<SQL
                INSERT INTO `employees` (`first_name`, `last_name`, `middle_name`, `ext_name`) VALUES (?,?,?,?)
            SQL;
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param('ssss', $first_name, $last_name, $middle_name, $ext_name);
            $stmt->execute();
            $employees_id = $stmt->insert_id;
            $stmt->close();
        }
        $this->inserted_id = $employees_id;
    }

    public function getEmployees()
    {
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

    public function get_data($id)
    {
        $data = [];
        $sql = <<<SQL
            SELECT 
                *
            FROM 
                `employees` 
            WHERE 
                `employees_id` = ?
        SQL;
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        // while ($employee = $result->fetch_assoc()) {
        //     $data[] = $employee;
        // }
        $stmt->close();
        return $data;
    }

    public function get_full_name_upper($id)
    {
        if (!$id) return "";
        $employee = $this->get_data($id);

        $firstName = $employee['firstName'];
        $lastName = $employee['lastName'];
        $middleName = $employee['middleName'];
        $extName = $employee['extName'];
        if ($middleName == ".") {
            $middleName = "";
        } else {
            $middleName    = $middleName;
            // $middleName = $this->middleName[0].".";
            if (strlen($middleName) > 0) {
                $middleName = " " . $middleName[0] . ".";
            } else $middleName = " " . $middleName . ".";
        }

        $extName    =    $extName ? strtoupper($extName) : "";
        $exts = $this->exts;

        if (in_array(substr($extName, 0, 2), $exts)) {
            $extName = " " . mb_convert_case($extName, MB_CASE_TITLE, "UTF-8");
        } else {
            $extName = $extName ? " " . $extName : "";
        }

        $full_name =  mb_convert_case("$lastName, $firstName $middleName", MB_CASE_UPPER, "UTF-8") . $extName;

        return $full_name;
    }

    public function get_full_name_upper_std($id)
    {
        if (!$id) return "";
        $employee = $this->get_data($id);

        $firstName = $employee['firstName'];
        $lastName = $employee['lastName'];
        $middleName = $employee['middleName'];
        $extName = $employee['extName'];

        if ($middleName == ".") {
            $middleName = "";
        } else {
            if ($middleName) {
                $middleName = " " . $middleName[0] . ". ";
            }
        }

        $extName    =    strtoupper($extName);
        $exts = $this->exts;

        if (in_array(substr($extName, 0, 2), $exts)) {
            $extName = " ," . mb_convert_case($extName, MB_CASE_TITLE, "UTF-8");
        } else {
            $extName = "" . $extName;
        }

        $full_name =  mb_convert_case("$firstName $middleName $lastName", MB_CASE_UPPER, "UTF-8") . $extName;

        return $full_name;
    }
}
