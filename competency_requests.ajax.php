<?php
    require "_connect.db.php";

if (isset($_GET["get_records"])) {
    $data = [];
    $sql = "SELECT * FROM `competency_ondemand_self_assessed_records`";
    $request = $mysqli->query($sql);
    
    while ($row = $request->fetch_assoc()) {
        $data [] = $row;
    }
    echo json_encode($data);
} elseif (isset($_GET["get_self_assessed_record"])) {
    $id = $_GET["get_self_assessed_record"];
    if (!$id) echo json_encode(""); 
    
    $data = [];
    $id = $mysqli->real_escape_string($id);
    $sql = "SELECT * FROM `competency_ondemand_self_assessed_records` WHERE `id` = '$id'";
    $request = $mysqli->query($sql);
    $row = $request->fetch_assoc();

    $data["last_name"] = $row["last_name"];
    $data["first_name"] = $row["first_name"];
    $data["middle_name"] = $row["middle_name"];
    $data["ext_name"] = $row["ext_name"];
    $data["created_at"] = $row["created_at"];
    $data["data"][] = intval($row["adaptability"]);
    $data["data"][] = intval($row["continous_learning"]);
    $data["data"][] = intval($row["communication"]);
    $data["data"][] = intval($row["organizational_awareness"]);
    $data["data"][] = intval($row["creative_thinking"]);
    $data["data"][] = intval($row["networking_relationship_building"]);
    $data["data"][] = intval($row["conflict_management"]);
    $data["data"][] = intval($row["stewardship_of_resources"]);
    $data["data"][] = intval($row["risk_management"]);
    $data["data"][] = intval($row["stress_management"]);
    $data["data"][] = intval($row["influence"]);
    $data["data"][] = intval($row["initiative"]);
    $data["data"][] = intval($row["team_leadership"]);
    $data["data"][] = intval($row["change_leadership"]);
    $data["data"][] = intval($row["client_focus"]);
    $data["data"][] = intval($row["partnering"]);
    $data["data"][] = intval($row["developing_others"]);
    $data["data"][] = intval($row["planning_and_organizing"]);
    $data["data"][] = intval($row["decision_making"]);
    $data["data"][] = intval($row["analytical_thinking"]);
    $data["data"][] = intval($row["results_orientation"]);
    $data["data"][] = intval($row["teamwork"]);
    $data["data"][] = intval($row["values_and_ethics"]);
    $data["data"][] = intval($row["visioning_and_strategic_direction"]);

    echo json_encode($data);
} elseif (isset($_GET["get_sup_assessed_record"])) {
    $id = $_GET["get_sup_assessed_record"];
    if (!$id) echo json_encode(""); 
    
    $data = [];
    $id = $mysqli->real_escape_string($id);
    $sql = "SELECT * FROM `competency_ondemand_sup_assessed_records` WHERE `competency_ondemand_self_assessed_record_id` = '$id'";
    $request = $mysqli->query($sql);
    
    $row = $request->fetch_assoc();

    $data["assessor_name"] = $row["assessor_name"];
    $data["created_at"] = $row["created_at"];
    $data["data"][] = intval($row["adaptability"]);
    $data["data"][] = intval($row["continous_learning"]);
    $data["data"][] = intval($row["communication"]);
    $data["data"][] = intval($row["organizational_awareness"]);
    $data["data"][] = intval($row["creative_thinking"]);
    $data["data"][] = intval($row["networking_relationship_building"]);
    $data["data"][] = intval($row["conflict_management"]);
    $data["data"][] = intval($row["stewardship_of_resources"]);
    $data["data"][] = intval($row["risk_management"]);
    $data["data"][] = intval($row["stress_management"]);
    $data["data"][] = intval($row["influence"]);
    $data["data"][] = intval($row["initiative"]);
    $data["data"][] = intval($row["team_leadership"]);
    $data["data"][] = intval($row["change_leadership"]);
    $data["data"][] = intval($row["client_focus"]);
    $data["data"][] = intval($row["partnering"]);
    $data["data"][] = intval($row["developing_others"]);
    $data["data"][] = intval($row["planning_and_organizing"]);
    $data["data"][] = intval($row["decision_making"]);
    $data["data"][] = intval($row["analytical_thinking"]);
    $data["data"][] = intval($row["results_orientation"]);
    $data["data"][] = intval($row["teamwork"]);
    $data["data"][] = intval($row["values_and_ethics"]);
    $data["data"][] = intval($row["visioning_and_strategic_direction"]);

    echo json_encode($data);
}