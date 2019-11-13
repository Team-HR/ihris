<?php
// require_once 'libs/Competency.php';
require_once '_connect.db.php';
require_once 'libs/NameFormatter.php';



$types = array(
'Adaptability',
'ContinousLearning',
'Communication',
'OrganizationalAwareness',
'CreativeThinking',
'NetworkingRelationshipBuilding',
'ConflictManagement',
'StewardshipofResources',
'RiskManagement',
'StressManagement',
'Influence',
'Initiative',
'TeamLeadership',
'ChangeLeadership',
'ClientFocus',
'Partnering',
'DevelopingOthers',
'PlanningandOrganizing',
'DecisionMaking',
'AnalyticalThinking',
'ResultsOrientation',
'Teamwork',
'ValuesandEthics',
'VisioningandStrategicDirection'
);




$competencies = array();

// print_r($competencies);


foreach ($types as $type) {
  $levels = array(
      1 => array(),
      2 => array(),
      3 => array(),
      4 => array(),
      5 => array()
    );

  foreach ($levels as $level => $ids) {

    
    // $sql = "SELECT `employees_id`,`firstName`,`lastName`,`middleName`,`extName` FROM `competency` LEFT JOIN `employees` ON `competency`.`employees_id` = `employees`.`employees_id` WHERE `$competency` = '$level'";
    $sql = "SELECT `competency`.`employees_id`,`employees`.`firstName`,`employees`.`lastName`,`employees`.`middleName`,`employees`.`extName` FROM `competency` LEFT JOIN `employees` ON `competency`.`employees_id` = `employees`.`employees_id` WHERE `competency`.`$type` = '$level' ORDER BY `employees`.`lastName` ASC";

    //     SELECT `competency`.`employees_id`,`employees`.`firstName`,`employees`.`lastName`,`employees`.`middleName`,`employees`.`extName` FROM `competency` LEFT JOIN `employees` ON `competency`.`employees_id` = `employees`.`employees_id` WHERE `competency`.`Adaptability` = '2'  
    // ORDER BY `employees`.`lastName` ASC
    
    $result = $mysqli->query($sql);
      while ($row = $result->fetch_assoc()) {
        $employees_id = $row["employees_id"];
        array_push($levels[$level], array('employees_id'=>$employees_id,'fullName'=>(new NameFormatter($row["firstName"],$row["lastName"],$row["middleName"],$row["extName"]))->getFullName()));
    }
    
  }


  $competencies[$type] = $levels;

}


// return $competencies;

// var_dump($competencies['Adaptability'][3]);


// foreach ($competencies as $competency => $lvls) {
//   echo "COMPETENCY: $competency";
//   echo "<br>";

// foreach ($lvls as $key => $value) {
//   echo "LEVEL: $key COUNT: ".count($value);
//   echo "<br>";
//   foreach ($value as $employees) {
//     // foreach ($employees as $id => $val) {
//     //     echo $id."  =>  ".$val;
//     //     echo "<br>";
//     //   }  
//     print_r($employees);
//     echo "<br>";
//   }
  
// }



// }

?>