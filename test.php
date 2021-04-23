<?php
require_once "_connect.db.php";





$data = [];

$tnas = getTNAdata($mysqli);
// $trainings = getTrainings($mysqli);

// foreach ($trainings as $training) {
//     $departments = array();
//     $countDepartments = 0;
//     $training_id = $training["training_id"];


//     foreach ($tnas as $tna) {
//         $department_id = $tna["department_id"];
//         $department = $tna["department"];
//         $training_ids = $tna["training_ids"];

//         foreach ($training_ids as $tr_id) {
//             if ($tr_id == $training_id) {
//                 $departments[] = array(
//                     "department_id" => $department_id,
//                     "department" => $department,
//                 );
//                 $countDepartments += 1;
//                 break;
//             }
//         }
//     }

//     $datum = array(
//         "training_id" => $training_id,
//         "training" => $training["training"],
//         "countDepartments" => $countDepartments,
//         "departments" => $departments
//     );

//     array_push($data,$datum);
// }


// // var_dump($data);
// // echo "Before Sort:<br>";
// // print("<pre>" . print_r($data, true) . "</pre>");

// usort($data, "sortArrayDesc");
// $sortedData = usort($data, fn($a, $b) => $a["countDepartments"] <=> $b["countDepartments"]);
// echo "After Sort:<br>";
print("<pre>" . print_r($tnas, true) . "</pre>");

// echo json_encode($data);


function getDepartmentsWithTraining($mysqli, $training_id)
{
    $departments = array();



    return $departments;
}


function getTrainings($mysqli)
{

    $data = [];
    $sql = "SELECT * FROM `trainings` ORDER BY `trainings`.`training_id` ASC";
    $result = $mysqli->query($sql);

    while ($row = $result->fetch_assoc()) {
        $training_id = $row["training_id"];
        $training = $row["training"];
        $datum = array(
            "training_id" => $training_id,
            "training" => $training
        );
        array_push($data, $datum);
    }

    return $data;
}


function getTNAdata($mysqli)
{
    $data = [];
    $sql = "SELECT `tna`.*, `department`.`department` FROM `tna` LEFT JOIN `department` ON `tna`.`department_id` = `department`.`department_id`";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
        $training_ids = unserialize($row["all_trs"]);
        $training_ids_manager = unserialize($row["manager_trs"]);
        $training_ids_staff = unserialize($row["staff_trs"]);
        $training_ids_merged = array_merge($training_ids, $training_ids_manager, $training_ids_staff);
        array_push($data, $training_ids_merged);
    }
    $merged_array = [];
    foreach ($data as $dat) {
        $merged_array = array_merge($merged_array, $dat);
    }
    return array_values(array_unique($merged_array));
}

function sortArrayDesc($a, $b) {
    return $b["countDepartments"] <=> $a["countDepartments"];
}

