<?php
require_once 'libs/ComparativeDataController.php';

$compData = new ComparativeDataController();

if (isset($_GET["load"])) {
    $data = $compData->get_vacant_position($_GET["rspvac_id"]);
    echo json_encode($data);
}

elseif (isset($_GET["load_list"])) {
    $data = [];
    $data = $compData->get_list_of_applicants($_GET["rspvac_id"]);
    echo json_encode($data);
}

elseif (isset($_GET["query"])) {
    $items = $compData->search_applicants_where_name_like($_GET["query"]);
    echo json_encode($items);
}