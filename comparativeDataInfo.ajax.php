<?php
require_once 'libs/ComparativeDataInfoController.php';

$compDataInfo = new ComparativeDataInfoController();

if (isset($_GET["load"])) {
    $data = $compDataInfo->get_vacant_position($_GET["rspvac_id"]);
    echo json_encode($data);
}

elseif (isset($_GET["load_list"])) {
    $data = [];
    $data = $compDataInfo->get_list_of_applicants($_GET["rspvac_id"]);
    echo json_encode($data);
}

elseif (isset($_GET["query"])) {
    $items = $compDataInfo->search_applicants_where_name_like($_GET["query"]);
    echo json_encode($items);
}

elseif (isset($_POST["save_new_applicant_submit"])) {
    $applicant = $_POST["applicant"];
    $rspvac_id = $_POST["rspvac_id"];
    // insert new applicant to rsp_applicants table
    $applicant_id = $compDataInfo->save_new_applicant_submit($applicant);
    // insert new applicant_id to rsp_comparative table
    $result = $compDataInfo->add_applicant_to_vacant_post($applicant_id, $rspvac_id);
    echo json_encode($result);
}