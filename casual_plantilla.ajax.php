<?php
require "_connect.db.php";

if (isset($_POST["getData"])) {
    $sql = "SELECT*FROM `casual_plantillas` ORDER BY `id` DESC";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = array();
    while ($row = $result->fetch_assoc()) {
        // $id = "pid_".$row["year"];
        $data[] = $row;
    }
    echo json_encode($data);
} elseif (isset($_POST["addData"])) {
    $data = $_POST["data"];

    $sql = "SELECT * FROM `casual_plantillas` WHERE `year` = ? AND `period` = ? AND `nature` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sss",$data["year"],$data["period"],$data["nature"]);
    $stmt->execute();
    $stmt->store_result();
    $num_rows = $stmt->num_rows;
    $stmt->close();

    if ($num_rows > 0) return false;

    $sql = "INSERT INTO `casual_plantillas` (`year`, `period`, `nature`) VALUES (?,?,?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('sss', $data["year"], $data["period"], $data["nature"]);
    $stmt->execute();
    echo json_encode($stmt->error);
}
// casual_plantilla_lists

elseif (isset($_POST["getPlantillaInfo"])) {
    $plantilla_id = $_POST["plantilla_id"];
    $data = array();
    $sql = "SELECT * FROM `casual_plantillas` WHERE `id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $plantilla_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($data["period"] == 1) {
        $data["period"] = array($data["year"] . "-01-01", date('Y') . "-06-30");
    } else {
        $data["period"] = array($data["year"] . "-07-01", date('Y') . "-12-30");
    }

    echo json_encode($data);
} elseif (isset($_POST["getEmployees"])) {
    $plantilla_id = $_POST["plantilla_id"];
    $sql = "SELECT*FROM casual_plantillas_lists LEFT JOIN employees ON casual_plantillas_lists.employee_id=employees.employees_id LEFT JOIN positiontitles ON employees.position_id=positiontitles.position_id WHERE `plantilla_id` = ? ORDER BY lastName, firstName ASC";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $plantilla_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $row["daily_wage"] = number_format($row["daily_wage"], 2, ".", ",");
        $row["employee_name"] = $row["lastName"] . ", " . $row["firstName"] . " " . ($row["middleName"] && $row["middleName"] != "." ? " " . $row["middleName"][0] . "." : "") . ($row["extName"] ? " " . $row["extName"] : "");
        $data[] = $row;
    }
    echo json_encode($data);
} elseif (isset($_POST["getCasualEmployeesNotInlist"])) {
    $plantilla_id = $_POST["plantilla_id"];
    $sql = "SELECT employees_id,  lastName, firstName, middleName, extName FROM `employees` WHERE employmentStatus = 'CASUAL' AND employees_id NOT IN (SELECT employee_id AS employees_id FROM casual_plantillas_lists WHERE plantilla_id = ?) ORDER BY lastName ASC";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $plantilla_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $id = $row["employees_id"];
        $dat = array(
            "employee_id" => $id,
            "employee_name" => $row["lastName"] . ", " . $row["firstName"] . " " . ($row["middleName"] && $row["middleName"] != "." ? " " . $row["middleName"][0] . "." : "") . ($row["extName"] ? " " . $row["extName"] : "")
        );
        // $data["id_" . $id] = $dat;
        $data[] = $dat;
    }
    echo json_encode($data);
} elseif (isset($_POST["add_employee"])) {

    $plantilla_id = $_POST["plantilla_id"];
    $data = $_POST["data"];

    // var_dump($plantilla_id);
    if (empty($data["employee_id"]) || empty($plantilla_id) || empty($data["pay_grade"]) || empty($data["daily_wage"])) return false;

    $sql = "SELECT id  FROM casual_plantillas_lists WHERE plantilla_id = ? AND employee_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ii', $plantilla_id, $data["employee_id"]);
    $stmt->execute();
    $stmt->store_result();
    $existing = $stmt->num_rows;
    $stmt->close();
    if ($existing == 0) {
        $sql = "INSERT INTO `casual_plantillas_lists` (`plantilla_id`, `employee_id`,`pay_grade`,`daily_wage`,`from_date`,`to_date`,`nature`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('iisdsss', $plantilla_id, $data["employee_id"], $data["pay_grade"], $data["daily_wage"], $data["from_date"], $data["to_date"], $data["nature"]);
        $stmt->execute();
        echo json_encode($stmt->affected_rows);
    } else {
        echo json_encode("existing!");
    }
} elseif (isset($_POST["edit_data"])) {
    $data = $_POST["data"];
    
    if (empty($data["pay_grade"]) ||empty($data["daily_wage"]) ||empty($data["from_date"]) ||empty($data["to_date"]) ||empty($data["nature"]) ||empty($data["id"])) return false;

    $sql = "UPDATE `casual_plantillas_lists` SET `pay_grade`=?,`daily_wage`=?,`from_date`=?,`to_date`=?,`nature`=? WHERE `id`=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sdsssi",$data["pay_grade"],$data["daily_wage"],$data["from_date"],$data["to_date"],$data["nature"],$data["id"]);
    $stmt->execute();
    $affected_rows = $stmt->affected_rows;
    $stmt->close();

    $try = $mysqli->prepare($sql);
    $try->bind_param;
    echo json_encode($affected_rows);
}
 elseif (isset($_POST["delete_data"])) {
     $id = $_POST["id"];
     $sql = "DELETE FROM `casual_plantillas_lists` WHERE `id` = ?";
     $stmt = $mysqli->prepare($sql);
     $stmt->bind_param('i',$id);
     $stmt->execute();
     $affected_rows = $stmt->affected_rows;
     $stmt->close();
     echo json_encode($affected_rows);
 }
