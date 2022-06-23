<?php
require "_connect.db.php";

if (isset($_GET["get_department_data"])) {
    $department_id = $_GET['department_id'];

    $data = [];
    if ($department_id == "all") {
        $sql = "SELECT * FROM `for_engagement`";
    } else {
        $sql = "SELECT * FROM `for_engagement` WHERE `department_id` = '$department_id'";
    }
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'department_id' => $row['department_id'],
            'communication' => $row['communication'],
            'logistics' => $row['logistics'],
            'relationships' => $row['relationships'],
            'support' => $row['support'],
            'consistently' => $row['consistently'],
            'improvement' => $row['improvement']
        ];
    }
    echo json_encode($data);
} elseif (isset($_POST["getDepartments"])) {
    $data = [];
    $sql = "SELECT * FROM `department` WHERE `department`.`department_id` IN(
        SELECT DISTINCT `for_engagement`.`department_id` from `for_engagement` where
         `for_engagement`.`department_id`);";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "id" => $row["department_id"],
            "name" => $row["department"],
        ];
    }
    echo json_encode($data);
} elseif (isset($_POST["getSuccessful_role"])) {
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
        $sql = "SELECT * FROM `for_engagement`";
    } else {
        $sql = "SELECT * FROM `for_engagement` WHERE `department_id` = '$department_id'";
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
        'communication' => [],
        'logistics' => [],
        'relationships' => [],
        'support' => [],
        'successful_role' => [],
        'consistently' => [],
        'improvement' => []
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