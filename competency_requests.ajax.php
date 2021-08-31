<?php
    require "_connect.db.php";

if (isset($_GET["get_records"])) {
    $data = [];
    $sql = "SELECT * FROM `competency_ondemand_self_assessed_records`";
    $request = $mysqli->query($sql);
    
    while ($row = $request->fetch_assoc()) {
        $data [] = $row;
    }
    echo json_encode($data);
} elseif (isset($_GET["get_self_assessed_record"])) {
    $id = $_GET["get_self_assessed_record"];
    if (!$id) echo json_encode(""); 
    
    $data = [];
    $id = $mysqli->real_escape_string($id);
    $sql = "SELECT * FROM `competency_ondemand_self_assessed_records` WHERE `id` = '$id'";
    $request = $mysqli->query($sql);
    
    // while ($row = ) {
    $data = $request->fetch_assoc();
    // }
    echo json_encode($data);
}