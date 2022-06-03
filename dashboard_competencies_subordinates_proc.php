<?php

require_once "_connect.db.php";
require_once "libs/NameFormatter.php";

session_start();

if (isset($_POST['get_subordinates'])) {
    $year = $_POST['year'];
    $supervisory = $_SESSION['supervisory'];
    $superior_id = $supervisory["superior_id"];
    $supervisor_employee_id =  $_SESSION['employee_id'];
    $department_id =  $_SESSION['department_id'];
    $sql = "SELECT
        `superiors_records`.`id` AS `superior_records_id`,
        `superiors_records`.`employee_id`,
        `employees`.`office_id`,
        `superiors_records`.`superior_id`,
        `employees`.`id`,
        `employees`.`employment_status`,
        `employees`.`ext_name`,
        `employees`.`first_name`,
        `employees`.`last_name`,
        `employees`.`middle_name`,
        `employees`.`nature_of_assignment`,
        `employees`.`position_id`,
        `positions`.`position_id`,
        `positions`.`position`,
        `positions`.`functional`
        FROM `superiors_records` 
        LEFT JOIN `employees` 
        ON `superiors_records`.`employee_id` = `employees`.`id` 
        LEFT JOIN `positions`
        ON `employees`.`position_id` = `positions`.`position_id`
        WHERE `superior_id` = '$superior_id';";

    $result = $mysqli2->query($sql);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $employee_id = $row["employee_id"];
        $ext_name = $row["ext_name"];
        $first_name = $row["first_name"];
        $last_name = $row["last_name"];
        $middle_name = $row["middle_name"];
        $name_formatter = new NameFormatter($first_name, $last_name, $middle_name, $ext_name);
        $row["full_name"] = mb_convert_case($name_formatter->getFullName(), MB_CASE_UPPER, "UTF-8");
        $row["datasets"] = get_datasets_data($mysqli, $row["employee_id"], $supervisor_employee_id, $department_id, $year);
        $row["is_sup_assessed"] = check_if_subordinate_exists($mysqli, $employee_id, $supervisor_employee_id, $department_id, $year);
        $data[] = $row;
    }


    usort($data, function ($a, $b) {
        return strcmp($a["full_name"], $b["full_name"]);
    });

    echo json_encode($data);
} elseif (isset($_POST["submit_subordinate_assessment"])) {
    $form_data = $_POST["form_data"];
    $employee_id = intval($form_data["employee_id"]);
    $supervisor_employee_id = $_SESSION["employee_id"];
    $department_id = $_SESSION["department_id"];
    $year = date("Y");

    // check if employee was already assessed,
    // if return return existing and abort saving
    if (check_if_subordinate_exists($mysqli, $employee_id, $supervisor_employee_id, $department_id, $year)) {
        echo json_encode(["status" => "existing", "message" => "Employee was already assessed for current year."]);
        return null;
    }
    // check if competency_scores is set and complete,
    // if false return ivalid and abort saving
    if (!isset($form_data["competency_scores"]) || count((array)$form_data["competency_scores"]) < 24) {
        echo json_encode(["status" => "invalid", "message" => "Competencies not completely assessed. Form not saved."]);
        return null;
    }

    // saving of form data proceeds
    $form_data["supervisor_employee_id"] = $supervisor_employee_id;
    $form_data["department_id"] = $department_id;
    $form_data["employee_id"] = $employee_id;

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

    $sql = "INSERT INTO `competency_supervisor_assessed_records` (`id`, `employee_id`, `supervisor_employee_id`, `department_id`, `name`, `year`, `adaptability`, `continuous_learning`, `communication`, `organizational_awareness`, `creative_thinking`, `networking_relationship_building`, `conflict_management`, `stewardship_of_resources`, `risk_management`, `stress_management`, `influence`, `initiative`, `team_leadership`, `change_leadership`, `client_focus`, `partnering`, `developing_others`, `planning_and_organizing`, `decision_making`, `analytical_thinking`, `results_orientation`, `teamwork`, `values_and_ethics`, `visioning_and_strategic_direction`, `created_at`, `updated_at`) VALUES (NULL, $employee_id, $supervisor_employee_id, $department_id, NULL, $year, '$adaptability','$continuous_learning','$communication','$organizational_awareness','$creative_thinking','$networking_relationship_building','$conflict_management','$stewardship_of_resources','$risk_management','$stress_management','$influence','$initiative','$team_leadership','$change_leadership','$client_focus','$partnering','$developing_others','$planning_and_organizing','$decision_making','$analytical_thinking','$results_orientation','$teamwork','$values_and_ethics','$visioning_and_strategic_direction', current_timestamp(), current_timestamp())";

    $mysqli->query($sql);

    echo json_encode(["status" => "success", "message" => "Data successfully saved!"]);
    return null;
} elseif (isset($_POST["check_if_subordinate_exists"])) {
    $form_data = $_POST["form_data"];
    $employee_id = intval($form_data["employee_id"]);
    $supervisor_employee_id = $_SESSION["employee_id"];
    $department_id = $_SESSION["department_id"];
    $year = date("Y");
    // check if employee was already assessed,
    // if return return existing and abort saving
    if (check_if_subordinate_exists($mysqli, $employee_id, $supervisor_employee_id, $department_id, $year)) {
        echo json_encode(["status" => true, "message" => "Employee was already assessed for current year."]);
        return null;
    }
    echo json_encode(["status" => false, "message" => "Employee has not been assessed."]);
    return null;
}


function check_if_subordinate_exists($mysqli, $employee_id, $supervisor_employee_id, $department_id, $year)
{
    $sql = "SELECT `id` FROM `competency_supervisor_assessed_records` WHERE `employee_id` = '$employee_id' AND `supervisor_employee_id` = '$supervisor_employee_id' AND `department_id` = '$department_id' AND `year` = '$year'";
    $result = $mysqli->query($sql);
    $num_rows = $result->num_rows;
    if ($num_rows > 0) return true;
    return false;
}

function get_datasets_data($mysqli, $employee_id, $supervisor_employee_id, $department_id, $year)
{
    $year = $year;
    // get self assessed competencies for indicated year
    $sql = "SELECT * FROM `competency_self_assessed_records` WHERE `employee_id` = '$employee_id' AND `year` = '$year'  ";
    $result = $mysqli->query($sql);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $rand_color = rand_color();
        $data[] = [
            "label" => "Self-assessed", //$row["year"],
            "borderColor" => "#00c506",
            "backgroundColor" => "#00c506" . "32",
            "borderWidth" => 1,
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

    // get supervisor assessed competencies for indicated year
    $sql = "SELECT * FROM `competency_supervisor_assessed_records` WHERE `employee_id` = '$employee_id' AND `supervisor_employee_id` = '$supervisor_employee_id' AND `department_id` = '$department_id' AND `year` = '$year'";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
        $rand_color = rand_color();
        $data[] = [
            "label" => "Supervisor-assessed", //$row["year"],
            "borderColor" => "#eb0000",
            "backgroundColor" => "#eb0000" . "32",
            "borderWidth" => 1,
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
    return $data;
}

function rand_color()
{
    return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
}
