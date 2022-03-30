<?php 
// personnelCompetenciesSurvey_proc.php
require_once "_connect.db.php";

if (isset($_POST["success"])) {

  $datetime = date('Y-m-d H:m:s');
  $scoresArray = $_POST["scoresArray"];
  $employees_id = $_POST["employees_id"];
  $inputName = addslashes($_POST["inputName"]);

  $scores = "";
  $total  = 0;
  foreach ($scoresArray as $key => $value) {
    $scores .= ",'$value'";
    $total += $value;
  }
    $scores .= ",'$total'";
    
  $sql = "INSERT INTO `competency` (`competency_id`, `employees_id`, `datetime`, `Adaptability`, `ContinousLearning`, `Communication`, `OrganizationalAwareness`, `CreativeThinking`, `NetworkingRelationshipBuilding`, `ConflictManagement`, `StewardshipofResources`, `RiskManagement`, `StressManagement`, `Influence`, `Initiative`, `TeamLeadership`, `ChangeLeadership`, `ClientFocus`, `Partnering`, `DevelopingOthers`, `PlanningandOrganizing`, `DecisionMaking`, `AnalyticalThinking`, `ResultsOrientation`, `Teamwork`, `ValuesandEthics`, `VisioningandStrategicDirection`,`totalPoints`,`inputName`) VALUES (NULL, '$employees_id', '$datetime' $scores, '$inputName')";
  $mysqli->query($sql);

}