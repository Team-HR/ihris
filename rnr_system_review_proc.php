<?php
date_default_timezone_set("Asia/Manila");

$host = "localhost";
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
    $sql = "SELECT * FROM `rnr_survey_esib_records`";
    $res = $mysqli2->query($sql);
    while ($row = $res->fetch_assoc()) {
        if ($row['answers']) {
            if (unserialize($row['answers'])) {
                $datum = unserialize($row['answers']);
$data [] = $datum["data"];
            }
        }
    }
    echo json_encode($data);
}