<?php
date_default_timezone_set("Asia/Manila");

$host = "localhost";
// $user = "ihris";
// $password = "7AqeLwwAfrpk307Q";
$user = "root";
$password = "teamhrmo2019";
$database = "hrnibai";

$mysqli2 = new mysqli($host, $user, $password, $database);
$mysqli2->set_charset("utf8");

// ######## DISPLAY ALL PHP ERRORS START
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// ######## DISPLAY ALL PHP ERRORS END

if (isset($_POST["get_data"])) {
    $data = [];
    $sql = "SELECT * FROM `rnr_survey_esib_records` ORDER BY `id` DESC";
    $res = $mysqli2->query($sql);
    while ($row = $res->fetch_assoc()) {
        if ($row['answers']) {
            if (unserialize($row['answers'])) {
                $datum = unserialize($row['answers']);
                $data[] = $datum["data"];
            }
        }
    }
    echo json_encode($data);
} elseif (isset($_POST["get_data_summary"])) {
    $data = [];
    $datus = array(
        array(
            'yes' => 0,
            'no' => 0,
            'no_answer' => 0
        ),
        array(
            'yes' => 0,
            'no' => 0,
            'no_answer' => 0
        ),
        array(
            'yes' => 0,
            'no' => 0,
            'no_answer' => 0
        ),
        array(
            'yes' => 0,
            'no' => 0,
            'no_answer' => 0
        ),
        array(
            'yes' => 0,
            'no' => 0,
            'no_answer' => 0
        ),
        array(
            'yes' => 0,
            'no' => 0,
            'no_answer' => 0
        ),
    );

    $performances = array(
        array(
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
            '6' => 0,
        ),
        array(
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
            '6' => 0,
        ),
        array(
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
            '6' => 0,
        ),
        array(
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
            '6' => 0,
        ),
    );

    $impacts = array(
        array(
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
        ),
        array(
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
        ),
        array(
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
        ),
    );

    $total = 0;


    $sql = "SELECT * FROM `rnr_survey_esib_records`";
    $res = $mysqli2->query($sql);
    while ($row = $res->fetch_assoc()) {
        if ($row['answers']) {
            if (unserialize($row['answers'])) {
                $datum = unserialize($row['answers']);
                $data[] = $datum["data"];
            }
        }
    }


    foreach ($datus as $key => $dat) {
        foreach ($data as $value) {
            if ($value[$key] == "Yes") {
                $datus[$key]['yes']++;
            } elseif ($value[$key] == "No") {
                $datus[$key]['no']++;
            } else {
                $datus[$key]['no_answer']++;
            }
        }
    }


    foreach ($performances as $key => $perf) {
        foreach ($data as $value) {
            if ($value[$key+6] == "1") {
                $performances[$key]['1']++;
            } elseif ($value[$key+6] == "2") {
                $performances[$key]['2']++;
            } elseif ($value[$key+6] == "3") {
                $performances[$key]['3']++;
            } elseif ($value[$key+6] == "4") {
                $performances[$key]['4']++;
            } elseif ($value[$key+6] == "5") {
                $performances[$key]['5']++;
            } elseif ($value[$key+6] == NULL) {
                $performances[$key]['6']++;
            }
        }
    }



    foreach ($impacts as $key => $impact) {
        foreach ($data as $value) {
            if ($value[$key+10] == "1") {
                $impacts[$key]['1']++;
            } elseif ($value[$key+10] == "2") {
                $impacts[$key]['2']++;
            } elseif ($value[$key+10] == "3") {
                $impacts[$key]['3']++;
            } elseif ($value[$key+10] == NULL) {
                $impacts[$key]['4']++;
            }
        }
    }

    echo json_encode(array(
        'datus' => $datus,
        'performances' => $performances,
        'impacts' => $impacts,
    ));
}
