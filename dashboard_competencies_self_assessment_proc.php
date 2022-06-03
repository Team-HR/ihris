<?php
require_once "_connect.db.php";
session_start();

if (isset($_GET["get_data"])) {
    if (!isset($_GET["year"])) {
        return null;
    }
    $year = $_GET["year"];
    $where = "";
    if ($year > 0) {
        $where = "AND `year` = '$year'";
    }
    $employee_id = $_SESSION["employee_id"];
    $sql = "SELECT * FROM `competency_self_assessed_records` WHERE `employee_id` = '$employee_id' $where ORDER BY `year` ASC";
    $result = $mysqli->query($sql);
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $rand_color = rand_color();
        $data[] = [
            "label" => $row["year"],
            "borderColor" => $rand_color,
            "backgroundColor" => $rand_color . "32",
            "borderWidth" => 1,
            // "fill" => false,
            "data" => [
                intval($row["adaptability"]),
                intval($row["continuous_learning"]),
                intval($row["communication"]),
                intval($row["organizational_awareness"]),
                intval($row["creative_thinking"]),
                intval($row["networking_relationship_building"]),
                intval($row["conflict_management"]),
                intval($row["stewardship_of_resources"]),
                intval($row["risk_management"]),
                intval($row["stress_management"]),
                intval($row["influence"]),
                intval($row["initiative"]),
                intval($row["team_leadership"]),
                intval($row["change_leadership"]),
                intval($row["client_focus"]),
                intval($row["partnering"]),
                intval($row["developing_others"]),
                intval($row["planning_and_organizing"]),
                intval($row["decision_making"]),
                intval($row["analytical_thinking"]),
                intval($row["results_orientation"]),
                intval($row["teamwork"]),
                intval($row["values_and_ethics"]),
                intval($row["visioning_and_strategic_direction"]),
            ]
        ];
    }
    echo json_encode($data);
} elseif (isset($_GET["get_years_with_data"])) {
    $employee_id =  $_SESSION["employee_id"];
    $sql = "SELECT DISTINCT `year` FROM `competency_self_assessed_records` WHERE `employee_id` = '$employee_id' ORDER BY `year` DESC;";
    $result = $mysqli->query($sql);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row["year"];
    }
    echo json_encode($data);
} elseif (isset($_POST["submit_self_assessment"])) {
    $form_data = isset($_POST["form_data"])?$_POST["form_data"]:["competency_scores"=>[]];
    $year = $_POST["year"];
    $employee_id = $_SESSION["employee_id"];
    $department_id = $_SESSION["department_id"];
    // check if employee was already assessed,
    // if return return existing and abort saving
    // if (check_if_subordinate_exists($mysqli, $employee_id, $supervisor_employee_id, $department_id, $year)) {
    //     echo json_encode(["status" => "existing", "message" => "Employee was already assessed for current year."]);
    //     return null;
    // }
    // check if competency_scores is set and complete,
    // if false return ivalid and abort saving
    if (count((array)$form_data["competency_scores"]) < 24) {
        echo json_encode(["status" => "invalid", "message" => "Competencies not completely assessed. Form not saved."]);
        return null;
    }

    // saving of form data proceeds

    $adaptability = $form_data['competency_scores']['adaptability'];
    $continuous_learning = $form_data['competency_scores']['continuous_learning'];
    $communication = $form_data['competency_scores']['communication'];
    $organizational_awareness = $form_data['competency_scores']['organizational_awareness'];
    $creative_thinking = $form_data['competency_scores']['creative_thinking'];
    $networking_relationship_building = $form_data['competency_scores']['networking_relationship_building'];
    $conflict_management = $form_data['competency_scores']['conflict_management'];
    $stewardship_of_resources = $form_data['competency_scores']['stewardship_of_resources'];
    $risk_management = $form_data['competency_scores']['risk_management'];
    $stress_management = $form_data['competency_scores']['stress_management'];
    $influence = $form_data['competency_scores']['influence'];
    $initiative = $form_data['competency_scores']['initiative'];
    $team_leadership = $form_data['competency_scores']['team_leadership'];
    $change_leadership = $form_data['competency_scores']['change_leadership'];
    $client_focus = $form_data['competency_scores']['client_focus'];
    $partnering = $form_data['competency_scores']['partnering'];
    $developing_others = $form_data['competency_scores']['developing_others'];
    $planning_and_organizing = $form_data['competency_scores']['planning_and_organizing'];
    $decision_making = $form_data['competency_scores']['decision_making'];
    $analytical_thinking = $form_data['competency_scores']['analytical_thinking'];
    $results_orientation = $form_data['competency_scores']['results_orientation'];
    $teamwork = $form_data['competency_scores']['teamwork'];
    $values_and_ethics = $form_data['competency_scores']['values_and_ethics'];
    $visioning_and_strategic_direction = $form_data['competency_scores']['visioning_and_strategic_direction'];

    $sql = "INSERT INTO `competency_self_assessed_records` (`id`, `employee_id`, `department_id`, `name`, `year`, `adaptability`, `continuous_learning`, `communication`, `organizational_awareness`, `creative_thinking`, `networking_relationship_building`, `conflict_management`, `stewardship_of_resources`, `risk_management`, `stress_management`, `influence`, `initiative`, `team_leadership`, `change_leadership`, `client_focus`, `partnering`, `developing_others`, `planning_and_organizing`, `decision_making`, `analytical_thinking`, `results_orientation`, `teamwork`, `values_and_ethics`, `visioning_and_strategic_direction`, `created_at`, `updated_at`) VALUES (NULL, $employee_id, $department_id, NULL, $year, '$adaptability','$continuous_learning','$communication','$organizational_awareness','$creative_thinking','$networking_relationship_building','$conflict_management','$stewardship_of_resources','$risk_management','$stress_management','$influence','$initiative','$team_leadership','$change_leadership','$client_focus','$partnering','$developing_others','$planning_and_organizing','$decision_making','$analytical_thinking','$results_orientation','$teamwork','$values_and_ethics','$visioning_and_strategic_direction', current_timestamp(), current_timestamp())";

    $mysqli->query($sql);

    echo json_encode(["status" => "success", "message" => "Data successfully saved!", "test" => [
        $form_data, $year, $employee_id, $department_id
    ]]);
    return null;
}

function rand_color()
{
    return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
}
