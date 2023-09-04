<?php
require "_connect.db.php";


if (isset($_POST["getEntries"])) {
    $data = [];
    $personneltrainings_id = $_POST['personneltrainings_id'];
    $sql = "SELECT * FROM `training_needs_analysis_entries` WHERE `personneltrainings_id` = '$personneltrainings_id' ORDER BY `id` DESC";
    $res = $mysqli->query($sql);
    while ($row = $res->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} elseif (isset($_POST["getPersonnelTraining"])) {
    $data = [];
    $personneltrainings_id = $_POST['personneltrainings_id'];
    $sql = "SELECT `personneltrainings`.*,`trainings`.* FROM `personneltrainings` LEFT JOIN `trainings` ON `personneltrainings`.`training_id` = `trainings`.`training_id` WHERE `personneltrainings`.`personneltrainings_id` = '$personneltrainings_id';";
    $res = $mysqli->query($sql);
    $data = $res->fetch_assoc();
    $data['startDate'] = formatDate($data['startDate']);
    $data['endDate'] = formatDate($data['endDate']);
    echo json_encode($data);
}

function formatDate($numeric_date)
{
    if (!$numeric_date) return NULL;
    $date = new DateTime($numeric_date);
    $strDate = $date->format('M d, Y');
    return $strDate;
}

    
