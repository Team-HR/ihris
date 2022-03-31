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

// Fetch data
elseif (isset($_GET["pull_data"])) {

    if (!isset($_GET['training_needs_analysis_entries_id'])) {
        return null;
    }

    $id = $_GET['training_needs_analysis_entries_id'];
    $sql = "SELECT * FROM `training_needs_analysis_entries` WHERE `id` = '$id' "; 
    $res = $mysqli->query($sql);
    $row = $res->fetch_assoc();
    $row['performance_issues'] = ($row['performance_issues']?json_decode($row['performance_issues']):[]) ;
    echo json_encode($row);

    
}

elseif (isset($_POST["update_data"])) {
    // $data = [];
    $training_needs_analysis_entries_id = $_POST['training_needs_analysis_entries_id'];

    $formData = $_POST['formData'];
    $highlights = $formData["highlights"];
    $performance_issues = ($formData['performance_issues']?json_encode($formData["performance_issues"]):NULL);
    $performance_issues_others =$formData["performance_issues_others"];
    $areas_of_improvement = $formData["areas_of_improvement"];

    $sql = "UPDATE `training_needs_analysis_entries` SET `highlights`='$highlights',`performance_issues`='$performance_issues',`performance_issues_others`='$performance_issues_others',`areas_of_improvement`='$areas_of_improvement' WHERE `training_needs_analysis_entries`.`id` = $training_needs_analysis_entries_id"; 
    $mysqli->query($sql);
    echo json_encode('success');
}

elseif (isset($_POST["deleteEntry"])) {
    // $data = [];
    $id = $_POST['id'];

    $sql = "DELETE FROM `training_needs_analysis_entries` WHERE `training_needs_analysis_entries`.`id` = '$id'";
    $mysqli->query($sql);
    echo json_encode('success');
}

elseif (isset($_POST["deleteEntry"])) {
    // $data = [];
    $id = $_POST['id'];

    $sql = "DELETE FROM `training_needs_analysis_entries` WHERE `training_needs_analysis_entries`.`id` = '$id'";

    $mysqli->query($sql);

    echo json_encode('success');
}


elseif (isset($_POST["addNewEntry"])) {
    $data = [];
    $training_needs_analysis_entries_id = $_POST['training_needs_analysis_entries'];
    $formData = $_POST['formData'];

    $highlights = $_POST['highlights'];
    $performance_issues = $_POST['performance_issues'];
    $performance_issues_others = $_POST['others'];
    $areas_of_improvement = $_POST['areas_of_improvement'];

    $sql = "UPDATE `training_needs_analysis_entries` SET `personneltrainings_id`='$personneltrainings_id', `highlights` = '$highlights',`performance_issues` = '$performance_issues' ,`performance_issues_others`= '$performance_issues_others' WHERE `training_needs_analysis_entries`.`training_needs_analysis_entries_id` = '$personneltrainings_id'"; 

    $mysqli->query($sql);
}
function formatDate($numeric_date)
{
    if (!$numeric_date) return NULL;
    $date = new DateTime($numeric_date);
    $strDate = $date->format('M d, Y');
    return $strDate;
}


