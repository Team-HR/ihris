<?php

require_once "_connect.db.php";
session_start();


if (isset($_POST["submitTest"])) {
    $items = $_POST["items"];

    $choices = ['A', 'B', 'C', 'D', 'E'];

    $answers = [];

    foreach ($items as $no => $item) {
        if ($no !== 24) {
            $answer = ($no + 1) . $choices[$item["answer"]];
            $answers[] = $answer;
        } else {
            // for item 24 with multi answer
            foreach ($item["answer"] as $c24) {
                $answer = ($no + 1) . $choices[$c24];
                $answers[] = $answer;
            }
        }
    }


    $employee_id = $_SESSION["employee_id"];
    $answers_json = json_encode($answers);

    $sql = "INSERT INTO `mbti_scoring_table_data` (`employee_id`, `answers`, `created_at`) VALUES ('$employee_id', '$answers_json', CURRENT_TIMESTAMP)";

    $res = $mysqli->query($sql);

    echo json_encode($answers);
} elseif ($_POST["getDataIfExisting"]) {
    $employee_id = $_SESSION["employee_id"];

    $sql = "SELECT * FROM `mbti_scoring_table_data` WHERE `employee_id` = '$employee_id' ORDER BY `created_at` DESC";
    $res = $mysqli->query($sql);
    $data = [];

    while ($row = $res->fetch_assoc()) {
        $answers =  json_decode($row["answers"]);
        $data[] = getPersonalityType($mysqli, $answers) + [
            "created_at" => $row["created_at"]
        ];
    }

    echo json_encode($data);
    return null;
}



function getPersonalityType($mysqli, $answers)
{
    $sql = "SELECT * FROM `mbti_scoring_table`";
    $res = $mysqli->query($sql);

    $mbti_scoring_table = [];

    while ($row = $res->fetch_assoc()) {
        $mbti_scoring_table[] = $row;
    }


    $data = [
        "E" => [
            "qc" => [],
            "total" => 0
        ],
        "I" => [
            "qc" => [],
            "total" => 0
        ],
        "S" => [
            "qc" => [],
            "total" => 0
        ],
        "N" => [
            "qc" => [],
            "total" => 0
        ],
        "T" => [
            "qc" => [],
            "total" => 0
        ],
        "F" => [
            "qc" => [],
            "total" => 0
        ],
        "J" => [
            "qc" => [],
            "total" => 0
        ],
        "P" => [
            "qc" => [],
            "total" => 0
        ],
    ];

    foreach ($answers as $answer) {
        foreach ($mbti_scoring_table as $ref) {
            if ($ref["code"] == $answer) {
                $data[$ref["type"]]["qc"][] = [
                    "code" => $ref["code"],
                    "points" => $ref["points"],
                ];
                $data[$ref["type"]]["total"]  += $ref["points"];
                break;
            }
        }
    }

    // compare
    $personalityType = "";
    # E/I in case of tie selec I
    $personalityType .= $data["E"]["total"] > $data["I"]["total"] ? "E" : "I";

    # S/N in case of tie selec N
    $personalityType .= $data["S"]["total"] > $data["N"]["total"] ? "S" : "N";

    # T/F in case of tie select T if male, F if female
    $employee_id = $_SESSION["employee_id"];
    $sql = "SELECT `gender` FROM `employees` WHERE `employees_id` = '$employee_id'";
    $res = $mysqli->query($sql);
    $row = $res->fetch_assoc();
    $gender = $row["gender"];

    if ($data["T"]["total"] == $data["F"]["total"]) {
        if ($gender == 'MALE') {
            $personalityType .= "T";
        } elseif ($gender == 'FEMALE') {
            $personalityType .= "F";
        } else {
            $personalityType .= " <score tied for T/F, select T if Male, F if Female> ";
        }
    } else {
        $personalityType .= $data["T"]["total"] > $data["F"]["total"] ? "T" : "F";
    }

    // $personalityType .= $data["T"]["total"] > $data["F"]["total"] ? "T" : "F";

    # J/P in case of tie select P
    $personalityType .= $data["J"]["total"] > $data["P"]["total"] ? "J" : "P";

    // echo json_encode([
    //     "raw" => $data,
    //     "personalityType" => $personalityType
    // ]);

    return [
        "raw" => $data,
        "personalityType" => $personalityType,
    ];
}
