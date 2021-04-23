<?php
    require_once "_connect.db.php";

    $sql = "SELECT * FROM  `tna`";
    $result = $mysqli->query($sql);
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $training_ids = unserialize($row["all_trs"]);
        $department_id = $row["department_id"];
        $datum = array(
            "department_id" => $department_id,
            "training_ids" => $training_ids
        );
        array_push($data,$datum);
    }

    // var_dump($data);
    print("<pre>".print_r($data,true)."</pre>");

