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
    $sql = "INSERT INTO `casual_plantillas` (`year`, `period`, `nature`) VALUES (?,?,?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('sss', $data["year"], $data["period"], $data["nature"]);
    $stmt->execute();
    echo json_encode($stmt->error);
}
// casual_plantilla_lists
elseif (isset($_POST["getEmployees"])) {
    $plantilla_id = $_POST["plantilla_id"];
    $sql = "SELECT*FROM casual_plantillas_lists LEFT JOIN employees ON casual_plantillas_lists.employee_id=employees.employees_id LEFT JOIN positiontitles ON employees.position_id=positiontitles.position_id WHERE `plantilla_id` = ? ORDER BY lastName, firstName ASC";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $plantilla_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = array();
    while ($row = $result->fetch_assoc()) {
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
        $data["id_" . $id] = $dat;
    }
    echo json_encode($data);
} elseif (isset($_POST["addEmployee"])) {
    $employee_id = $_POST["employee_id"];
    $plantilla_id = $_POST["plantilla_id"];

    // var_dump($plantilla_id);
    if(empty($employee_id) || empty($plantilla_id)) return false;
    
    $sql = "SELECT id  FROM casual_plantillas_lists WHERE plantilla_id = ? AND employee_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ii', $plantilla_id, $employee_id);
    $stmt->execute();
    $stmt->store_result();
    $existing = $stmt->num_rows;
    $stmt->close();
    if ($existing == 0) {
        $sql = "INSERT INTO `casual_plantillas_lists` (`plantilla_id`, `employee_id`) VALUES (?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('ii', $plantilla_id, $employee_id,);
        $stmt->execute();
        echo json_encode($stmt->affected_rows);
    } else {
        echo json_encode("existing!");
    }
}
