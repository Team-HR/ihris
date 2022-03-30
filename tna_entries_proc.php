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


} elseif (isset($_POST["addNewEntry"])) {
    // $data = [];
    $personneltrainings_id = $_POST['personneltrainings_id'];
    $formData = $_POST['formData'];

    $highlights = $mysqli->real_escape_string($formData['highlights']);
    $performance_issues = isset($formData['performance_issues']) ? $formData['performance_issues'] : [];
    $performance_issues = $mysqli->real_escape_string(json_encode($performance_issues));
    $performance_issues_others = $mysqli->real_escape_string($formData['others']);
    $areas_of_improvement = $mysqli->real_escape_string($formData['areas_of_improvement']);

    $sql = "INSERT INTO `training_needs_analysis_entries` (`id`, `personneltrainings_id`, `highlights`, `performance_issues`, `performance_issues_others`, `areas_of_improvement`, `created_at`) VALUES (NULL, '$personneltrainings_id', '$highlights', '$performance_issues', '$performance_issues_others', '$areas_of_improvement', current_timestamp())";

    $mysqli->query($sql);
    echo json_encode('success');


} elseif (isset($_POST["deleteEntry"])) {
    // $data = [];
    $id = $_POST['id'];

    $sql = "DELETE FROM `training_needs_analysis_entries` WHERE `training_needs_analysis_entries`.`id` = '$id'";
    $mysqli->query($sql);

    echo json_encode('success');
}

function formatDate($numeric_date)
{
    if (!$numeric_date) return NULL;
    $date = new DateTime($numeric_date);
    $strDate = $date->format('M d, Y');
    return $strDate;
}
