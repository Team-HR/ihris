<?php
require "_connect.db.php";

if (isset($_POST["getData"])) {
    $sql = "SELECT*FROM `casual_plantillas` ORDER BY `id` DESC";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $id = "pid_".$row["year"];
        $data[$id] = $row;
    }
    echo json_encode($data);
} elseif ($_POST["addData"]) {
    # code...
}
