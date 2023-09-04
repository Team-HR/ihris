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
// tna entry report starts here

elseif (isset($_POST["getPerformanceIssues"])) {

    $performanceIssues = [
        [
            'performanceIssue' => 'Initiative',
            'count' => 0
        ],
        [
            'performanceIssue' => 'Resourcefulness',
            'count' => 0
        ],
        [
            'performanceIssue' => 'Efficiency',
            'count' => 0
        ],
        [
            'performanceIssue' => 'Teamwork',
            'count' => 0
        ],
        [
            'performanceIssue' => 'Attitude Towards Colleagues',
            'count' => 0
        ],
        [
            'performanceIssue' => 'Time and Cost consciousness in Delivery of Service',
            'count' => 0
        ],
        [
            'performanceIssue' => 'Professionalism in Delivery of Service',
            'count' => 0
        ],
        [
            'performanceIssue' => 'Customer-Friendliness',
            'count' => 0
        ],
        [
            'performanceIssue' => 'Responsiveness',
            'count' => 0
        ],
        [
            'performanceIssue' => 'Punctuality',
            'count' => 0
        ]

    ];

    if (!isset($_POST["personneltrainings_id"])) {
        echo json_encode($performanceIssues);
        return null;
    }

    $personneltrainings_id = $_POST["personneltrainings_id"];
    $sql = "SELECT * FROM `training_needs_analysis_entries` WHERE `personneltrainings_id` = '$personneltrainings_id'";
    $res = $mysqli->query($sql);

    $data = [];
    while ($row = $res->fetch_assoc()) {
        $data[] = $row["performance_issues"];
    }

    foreach ($data as $key => $arr) {
        $data[$key] = json_decode($arr);
    }

    foreach ($data as $arr) {
        foreach ($arr as $perfIssue) {
            foreach ($performanceIssues as $key => $performanceIssue) {
                if ($perfIssue === $performanceIssue['performanceIssue']) {
                    $performanceIssues[$key]['count'] += 1;
                    continue;
                }
            }
        }
    }

    $chartData = [
        'labels' => [],
        'data' => []
    ];

    foreach ($performanceIssues as $performanceIssue) {
        $chartData['labels'][] = $performanceIssue['performanceIssue'];
        $chartData['data'][] = $performanceIssue['count'];
    }

    echo json_encode($chartData);
} elseif (isset($_POST["getHiglightsAndAreasNeedsImprovement"])) {

    $data = [
        'performance_issues_others' => [],
        'highlights' => [],
        'areas_of_improvement' => []
    ];

    if (!isset($_POST["personneltrainings_id"])) {
        echo json_encode($data);
        return null;
    }

    $personneltrainings_id = $_POST["personneltrainings_id"];
    $sql = "SELECT * FROM `training_needs_analysis_entries` WHERE `personneltrainings_id` = '$personneltrainings_id'";
    $res = $mysqli->query($sql);

    while ($row = $res->fetch_assoc()) {
        if (!empty($row['performance_issues_others'])) {
            $data['performance_issues_others'][] = $row['performance_issues_others'];
        }
        if (!empty($row['highlights'])) {
            $data['highlights'][] = $row['highlights'];
        }
        if (!empty($row['areas_of_improvement'])) {
            $data['areas_of_improvement'][] = $row['areas_of_improvement'];
        }
    }

    echo json_encode($data);
}
// tna entry report ends here


function formatDate($numeric_date)
{
    if (!$numeric_date) return NULL;
    $date = new DateTime($numeric_date);
    $strDate = $date->format('M d, Y');
    return $strDate;
}
