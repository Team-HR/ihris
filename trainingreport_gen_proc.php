<?php
require_once '_connect.db.php';

if (isset($_POST["load"])) {
    $training_ids = array();
    $trainings = array();

    $sql = "SELECT DISTINCT `training_id` FROM `personneltrainings`";
    $res = $mysqli->query($sql);
    $rows = $res->num_rows;

    while($row = $res->fetch_assoc()){
        $training_id = $row['training_id'];
        $training_ids[] = $training_id;
    }

    foreach ($training_ids as $training_id) {
        $insert = array(
            'training_id' => 0,
            'title' => '',
            'total' => 0,
            'trainings' => array()
        );
        $insert['training_id'] = $training_id;

        $sql = "SELECT * FROM `trainings` WHERE `training_id` = '$training_id'";
        $res = $mysqli->query($sql);
        $row = $res->fetch_assoc();
        $title = $row['training'];
        $insert['title'] = $title;

        $sql = "SELECT * FROM `personneltrainings` WHERE `training_id` = '$training_id'";
        $res = $mysqli->query($sql);
        $num_rows = $res->num_rows;
        $insert['total'] = $num_rows;
        
        $insert_trainings = array();
        while ($row = $res->fetch_assoc()) {
            $insert_trainings['startDate'] = $row['startDate'];
            $insert_trainings['endDate'] = $row['endDate'];
            $insert_trainings['numHours'] = $row['numHours'];
            $insert_trainings['venue'] = $row['venue'];
            $insert_trainings['remarks'] = $row['remarks'];

            array_push($insert['trainings'],$insert_trainings);
        }

        $trainings[] = $insert;
    }

    echo json_encode($trainings);


}