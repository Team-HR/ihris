<?php
/*
    Add two new columns after num_years_in_gov namely: 
    years_of_service_gov and years_of_service_priv with text as dataype and nullable
    Uncomment iterator function below to alter format of data
*/
require_once "_connect.db.php";
$period_id = 11;
$department_id = 2;
$selected_period_id = 10;

$data = [];
$sql = "SELECT * FROM `spms_corefunctions` WHERE `mfo_periodId` = '$period_id' AND `dep_id` = '$department_id' AND `parent_id` = '';";
$result = $mysqli->query($sql);
while ($row = $result->fetch_assoc()) {
    // $data[] = [
    //   "core_function_data" => $row,
    //   "success_indicators" => get_success_indicators($mysqli, $row["cf_ID"])
    // ];
    $row["children"] = get_children($mysqli, $row['cf_ID']);
    $data[] = $row;
}

$data = [$data[29]];

$data = start_duplicating($mysqli, $data, $selected_period_id, "");

function get_children($mysqli, $cf_ID)
{
    $data = [];
    $sql = "SELECT * FROM `spms_corefunctions` WHERE `parent_id` ='$cf_ID'";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
        $row["children"] = get_children($mysqli, $row["cf_ID"]);
        $data[] = $row;
    }
    return $data;
}

function start_duplicating($mysqli, $data, $selected_period_id, $parent_id)
{
    foreach ($data as $key => $core_function) {
        $parent_id = $parent_id ? $parent_id : NULL;
        $cf_title = $mysqli->real_escape_string($core_function['cf_title']);
        $cf_count = $mysqli->real_escape_string($core_function['cf_count']);
        $sql = "INSERT INTO `spms_corefunctions`(`mfo_periodId`, `parent_id`, `dep_id`, `cf_count`, `cf_title`, `corrections`) VALUES ('$selected_period_id','$parent_id','$core_function[dep_id]','$cf_count','$cf_title','')";
        $mysqli->query($sql);
        $insert_id = $mysqli->insert_id;

        #get success indicators
        $success_idicators = get_success_indicators($mysqli, $core_function["cf_ID"]);
        foreach ($success_idicators as $success_idicator) {
            $sql = "INSERT INTO `spms_matrixindicators`(`cf_ID`, `mi_succIn`, `mi_quality`, `mi_eff`, `mi_time`, `mi_incharge`, `corrections`) VALUES ('$insert_id','$success_idicator[mi_succIn]','$success_idicator[mi_quality]','$success_idicator[mi_eff]','$success_idicator[mi_time]','$success_idicator[mi_incharge]','')";
            $mysqli->query($sql);
        }

        $data[$key]["children"] = start_duplicating($mysqli, $core_function["children"], $selected_period_id, $insert_id);
    }

    return $data;
}


function get_success_indicators($mysqli, $cf_ID)
{
    $data = [];
    $sql = "SELECT * FROM `spms_matrixindicators` WHERE `cf_ID` = '$cf_ID'";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}


?>

<pre>
    <?php
    print_r($data); ?>
</pre>