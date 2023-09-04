<?php
    require_once "libs/Competency.php";
    $comp = new Competency;

if (isset($_GET["get_records"])) {
    echo json_encode($comp->get_records());
} elseif (isset($_GET["get_self_assessed_record"])) {
    $id = $_GET["get_self_assessed_record"];
    echo json_encode($comp->get_self_assessed_record($id));
} elseif (isset($_GET["get_sup_assessed_record"])) {
    $id = $_GET["get_sup_assessed_record"];
    echo json_encode($comp->get_sup_assessed_record($id));
} elseif (isset($_POST["generate_report"])) {
    $id = $_POST["generate_report"];
    $self_assessed_scores = $comp->get_self_assessed_record($id)["data"];
    $sup_assessed_scores = $comp->get_sup_assessed_record($id)["data"];
    echo json_encode($comp->gen_report($self_assessed_scores,$sup_assessed_scores));
}