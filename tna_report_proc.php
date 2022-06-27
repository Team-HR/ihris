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
} elseif (isset($_POST["getDepartments"])) {
    $personneltrainings_id = $_POST['personneltrainings_id'];
    $data = [];
    $sql = "SELECT * FROM `department` WHERE `department`.`department_id` IN(
        SELECT DISTINCT `training_needs_analysis_entries`.`department_id` from `training_needs_analysis_entries` where
         `training_needs_analysis_entries`.`personneltrainings_id` = '$personneltrainings_id' );";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "id" => $row["department_id"],
            "name" => $row["department"],
        ];
    }
    echo json_encode($data);
} elseif (isset($_GET["get_department_data"])) {
    $department_id = $_GET['department_id'];
    $personneltrainings_id = $_GET['personneltrainings_id'];
    $data = [];
    if($department_id =="all"){
        $sql = "SELECT * FROM `training_needs_analysis_entries` where `personneltrainings_id` = '$personneltrainings_id'";
    }else{
        $sql = "SELECT * FROM `training_needs_analysis_entries` WHERE `department_id` = '$department_id'";
    }
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
        $data[] = [ 
            'highlights' => $row['highlights'],
            'performance_issues_others' => $row['performance_issues_others'],
            'areas_of_improvement' => $row['areas_of_improvement']
        ];
    }
    echo json_encode($data);
}

elseif (isset($_POST["getSuccessful_role"])) {
    $roles = [
        [
            'role' => 'yes',
            'count' => 0
        ],
        [
            'role' => 'no',
            'count' => 0
        ]
    ];
    $department_id = $_POST["department_id"];
    if ($department_id == "all") {
        $sql = "SELECT * FROM `training_needs_analysis_entries`";
    } else {
        $sql = "SELECT * FROM `training_needs_analysis_entries` WHERE `department_id` = '$department_id'";
    }
    // $sql = "SELECT * FROM `for_engagement`";
    $res = $mysqli->query($sql);

    $data = [];
    while ($row = $res->fetch_assoc()) {
        $data[] = $row["successful_role"];
    }
    foreach ($data as $key => $arr) {
        $data[$key] = json_decode($arr);
    }
    foreach ($data as $arr) {
        foreach ($arr as $perfIssue) {
            foreach ($roles as $key => $role) {
                if ($perfIssue === $role['role']) {
                    $roles[$key]['count'] += 1;
                    continue;
                }
            }
        }
    }

    $chartData = [
        'labels' => [],
        'data' => []
    ]; 

    foreach ($roles as $role) {
        $chartData['labels'][] = $role['role'];
        $chartData['data'][] = $role['count'];
    }

    echo json_encode($chartData);
} elseif (isset($_POST["get_for_engagement"])) {
    // $department_id = $_POST['department_id'];
    $data = [
        'highlights' => [],
        'performance_issues' => [],
        'performance_issues_others' => [],
        'areas_of_improvement' => []
    ];

    $sql = "SELECT * FROM `for_engagement`";
    $res = $mysqli->query($sql);

    while ($row = $res->fetch_assoc()) {
        if (!empty($row['communication'])) {
            $data['communication'][] = $row['communication'];
        }
        if (!empty($row['logistics'])) {
            $data['logistics'][] = $row['logistics'];
        }
        if (!empty($row['relationships'])) {
            $data['relationships'][] = $row['relationships'];
        }
        if (!empty($row['support'])) {
            $data['support'][] = $row['support'];
        }
        if (!empty($row['successful_role'])) {
            $data['successful_role'][] = $row['successful_role'];
        }
        if (!empty($row['consistently'])) {
            $data['consistently'][] = $row['consistently'];
        }
        if (!empty($row['improvement'])) {
            $data['improvement'][] = $row['improvement'];
        }
    }

    echo json_encode($data);
}


function formatDate($numeric_date)
{
    if (!$numeric_date) return NULL;
    $date = new DateTime($numeric_date);
    $strDate = $date->format('M d, Y');
    return $strDate;
}