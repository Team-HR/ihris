<?php
require_once "_connect.db.php";

$sql = "SELECT * FROM `rsp_comp_checklist`";
$res = $mysqli->query($sql);

// $data = [];

while ($row = $res->fetch_assoc()) {
    $id = $row['id'];
    $serial = $row['data'];
    $unserialized = unserialize($serial);
    $data_new = [];
    foreach ($unserialized as $key => $value) {
        if ($key == 7) {
            $data_new[] = array(
                "polarity" => 0,
                "remarks" => ""
            );
        }
        $data_new[] = $value;
    }
    $serialized = $mysqli->real_escape_string(serialize($data_new));

    $sql = "UPDATE `rsp_comp_checklist` SET `data_new`='$serialized' WHERE `id` = '$id'";
    $mysqli->query($sql);
}
