<?php
/*
    Add two new columns after num_years_in_gov namely: 
    years_of_service_gov and years_of_service_priv with text as dataype and nullable
    Uncomment iterator function below to alter format of data
*/
require_once "_connect.db.php";

$sql = "SELECT * FROM `rsp_applicants`";

$res = $mysqli->query($sql);
$data = [];
while ($row = $res->fetch_assoc()) {
    $data[] = [
        "applicant_id" => $row["applicant_id"],
        "name" => $row["name"],
        // "age" => $row["age"],
        // "gender" => $row["gender"],
        // "civil_status" => $row["civil_status"],
        // "mobile_no" => $row["mobile_no"],
        // "address" => $row["address"],
        // "education" => $row["education"],
        // "school" => $row["school"],
        ########################################
        "experience" => $mysqli->real_escape_string(parse_experience($row["experience"])),
        // "experience" => parse_experience($row["experience"]),
        "training" => unserialize($row["training"]) ? $mysqli->real_escape_string(json_encode(unserialize($row["training"]))) : NULL,
        "num_years_in_gov" => $mysqli->real_escape_string(parse_years_in_service($row["num_years_in_gov"])),
        "years_of_service_gov" =>  $mysqli->real_escape_string(years_of_service($row["num_years_in_gov"])),
        // "years_of_service_priv" => NULL,
        "eligibility" => $row["eligibility"] && unserialize($row["eligibility"]) ? $mysqli->real_escape_string(json_encode(unserialize($row["eligibility"]))) : NULL,
        "awards" => $row["awards"] && unserialize($row["awards"]) ? $mysqli->real_escape_string(json_encode(unserialize($row["awards"]))) : NULL,
        "records_infractions" => $row["records_infractions"] && unserialize($row["records_infractions"]) ?  $mysqli->real_escape_string(json_encode(unserialize($row["records_infractions"]))) : NULL
        // "remarks" => $row["remarks"],
    ];
}

/*
    Iterator function
    Uncomment query iterator function from below to execute data alteration.
*/

// foreach ($data as $key => $row) {
//     $years_of_service_gov = $row['years_of_service_gov'] ? $row['years_of_service_gov'] : NULL;
//     $mysqli->query("UPDATE `rsp_applicants` SET 
//     `experience` = '$row[experience]',
//     `training` = '$row[training]',
//     `num_years_in_gov` = '$row[num_years_in_gov]',
//     `years_of_service_gov` = '$years_of_service_gov',
//     `eligibility` = '$row[eligibility]',
//     `awards` = '$row[awards]',
//     `records_infractions` = '$row[records_infractions]'
//     WHERE `rsp_applicants`.`applicant_id` = $row[applicant_id];");
// }

function parse_experience($arr)
{
    if (!$arr || !unserialize($arr)) return NULL;
    $data = [];
    $arr = unserialize($arr);
    $experiences = [];
    foreach ($arr as $key => $value) {
        # code...
        $datum = [
            "title" => $value[0],
            "status" => $value[1],
            "company" => $value[2],
            "from" => dateToString($value[3]),
            "to" => dateToString($value[4])
        ];
        $experiences[] = $datum;
    }

    $data = $experiences;
    $data = json_encode($data);
    return $data;
}

function dateToString($date_val)
{
    if ($date_val !== "") {
        $date = new DateTime($date_val);
        $res = $date->format('F d, Y');
        return $res ? $res : '';
    } elseif ($date_val == "") {
        return 'Present';
    }
}

function years_of_service($arr)
{
    if (!$arr) return NULL;
    $arr = unserialize($arr);
    $services = [];
    // check first if all status have data //
    $count = 0;
    foreach ($arr as $key => $value) {
        if ($value) {
            $count++;
        }
    }
    if (!$count) return null;
    foreach ($arr as $key => $value) {
        if ($key != "Private" && $value) {
            $services[] = [
                "status" => $key,
                "num_years" => $value,
            ];
        }
    }
    return json_encode($services);
}
function parse_years_in_service($arr)
{

    if (!$arr) return NULL;
    $data =  [];
    $arr = unserialize($arr);
    // return $arr;
    $services = [];
    // check first if all status have data //

    $count = 0;
    foreach ($arr as $key => $value) {
        if ($value) {
            $count++;
        }
    }

    if (!$count) return null;

    foreach ($arr as $key => $value) {
        if ($key != "Private" && $value) {
            $services[] = [
                "status" => $key,
                "length" => $value,
            ];
        }
    }

    $data[] = [
        "sector" => "Government",
        "services" => $services
    ];

    $data = json_encode($data);

    return $data;
}


?>
<pre>
    <?php
    print_r($data);
    ?>
</pre>;