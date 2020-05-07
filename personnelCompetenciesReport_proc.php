  <?php
require_once "_connect.db.php";


if (isset($_POST["load"])) {
  $filters = $_POST["filters"];
  $sql = construct_sql($filters);
 /* 
 $sql0 = "SELECT * FROM `department` WHERE `department_id` IN (SELECT `department_id` FROM `employees` WHERE `employees_id` IN (SELECT `employees_id` FROM `competency`))";
 */
 $result = $mysqli->query($sql);
 $counter = 0;
 $compTotal = array();
 for ($i=0; $i < 24 ; $i++) {
  $compTotal[] = 0;
 }
 $num_rows = $result->num_rows;
 while ($row = $result->fetch_assoc()) {
  // while ($row = $result->fetch_array(MYSQLI_NUM)) {
    $counter++;
    $competency_id = $row['competency_id'];
    $employees_id = $row['employees_id'];
    if ($employees_id != 0) {
// get name start
      if (!empty($row['extName'])) {
        $extName = ", ".$row['extName'];
      } else {
        $extName = "";
      }

      $fullName = $row['lastName'].", ".$row['firstName']." ".$row['middleName']." ".$extName." ";

    } else {
      $fullName = "Unidentified! Please see input in db...";
    }

    $datetime = $row['datetime'];
    $comp0 = $row['Adaptability'];
    $comp1 = $row['ContinousLearning'];
    $comp2 = $row['Communication'];
    $comp3 = $row['OrganizationalAwareness'];
    $comp4 = $row['CreativeThinking'];
    $comp5 = $row['NetworkingRelationshipBuilding'];
    $comp6 = $row['ConflictManagement'];
    $comp7 = $row['StewardshipofResources'];
    $comp8 = $row['RiskManagement'];
    $comp9 = $row['StressManagement'];
    $comp10 = $row['Influence'];
    $comp11 = $row['Initiative'];
    $comp12 = $row['TeamLeadership'];
    $comp13 = $row['ChangeLeadership'];
    $comp14 = $row['ClientFocus'];
    $comp15 = $row['Partnering'];
    $comp16 = $row['DevelopingOthers'];
    $comp17 = $row['PlanningandOrganizing'];
    $comp18 = $row['DecisionMaking'];
    $comp19 = $row['AnalyticalThinking'];
    $comp20 = $row['ResultsOrientation'];
    $comp21 = $row['Teamwork'];
    $comp22 = $row['ValuesandEthics'];
    $comp23 = $row['VisioningandStrategicDirection'];
    $total  = $row['totalPoints'];


    $compTotal[0] += $comp0;
    $compTotal[1] += $comp1;
    $compTotal[2] += $comp2;
    $compTotal[3] += $comp3;
    $compTotal[4] += $comp4;
    $compTotal[5] += $comp5;
    $compTotal[6] += $comp6;
    $compTotal[7] += $comp7;
    $compTotal[8] += $comp8;
    $compTotal[9] += $comp9;
    $compTotal[10] += $comp10;
    $compTotal[11] += $comp11;
    $compTotal[12] += $comp12;
    $compTotal[13] += $comp13;
    $compTotal[14] += $comp14;
    $compTotal[15] += $comp15;
    $compTotal[16] += $comp16;
    $compTotal[17] += $comp17;
    $compTotal[18] += $comp18;
    $compTotal[19] += $comp19;
    $compTotal[20] += $comp20;
    $compTotal[21] += $comp21;
    $compTotal[22] += $comp22;
    $compTotal[23] += $comp23;


    ?>
    <tr class="datatr">
      <td><?php echo "$counter. ";?></td>
      <td><i class="icon clock outline popup" title="<?php echo dateToStr($datetime)?>"></i><a href="employeeinfo.php?employees_id=<?=$employees_id?>" target="_blank"><i class="blue address book icon"></i></a></td>
      <td style="text-align: left;"><?php echo $fullName;?></td>
      <?php
      for ($i=0; $i < 24 ; $i++) {
        $data = ${"comp".$i};
          if ($data == 3) { 
            echo "<td sytle=\"background-color: #88baecd1; color: white;\">$data</td>";
          }
          elseif ($data == 4) {
            echo "<td style=\"background-color: #016dd8c4; color: white;\">$data</td>";
          }
          elseif ($data == 5) {
            echo "<td style=\"background-color: #016dd8; color: white;\">$data</td>";
          }
          else {
              echo "<td>$data</td>"; 
          }
      }
      ?>
      <!-- <td style="font-weight: bold;"><?php echo $total;?></td> -->
    </tr>
    <?php

  // }

 }

 ?>
<tr class="datatr" style="font-weight: bold; color: green">
  <td colspan="3">AVERAGE:</td>
        <?php
      for ($i=0; $i < 24 ; $i++) {
        $data = round($compTotal[$i]/$num_rows);
          if ($data == 3) { 
            echo "<td sytle=\"background-color: #88baecd1; color: white;\">$data</td>";
          }
          elseif ($data == 4) {
            echo "<td style=\"background-color: #016dd8c4; color: white;\">$data</td>";
          }
          elseif ($data == 5) {
            echo "<td style=\"background-color: #016dd8; color: white;\">$data</td>";
          }
          else {
              echo "<td>$data</td>"; 
          }
      }
      ?>
</tr>

 <?php

}

elseif (isset($_POST["fetchData"])) {

  $data = [];
  $filters = [
    ['Key Position', 'Rank & File', 'Male'],
    ['Key Position', 'Rank & File', 'Female'],
    ['Key Position', 'Supervisory', 'Male'],
    ['Key Position', 'Supervisory', 'Female'],
    ['Administrative', 'Rank & File', 'Male'],
    ['Administrative', 'Rank & File', 'Female'],
    ['Administrative', 'Supervisory', 'Male'],
    ['Administrative', 'Supervisory', 'Female'],    
    ['Technical', 'Rank & File', 'Male'],
    ['Technical', 'Rank & File', 'Female'],
    ['Technical', 'Supervisory', 'Male'],
    ['Technical', 'Supervisory', 'Female']
];

  $queries = [];
  foreach ($filters as $filter) {
      $sql = "WHERE category = '$filter[0]' AND natureOfAssignment = '$filter[1]' AND gender = '$filter[2]'";
      $queries[] = $sql;
  }
  
  $sql_ave = <<<SQL
  SELECT 
  ROUND(AVG(`competency`.`Adaptability`)) 'adaptability',
  ROUND(AVG(`competency`.`ContinousLearning`)) 'continuous_learning',
  ROUND(AVG(`competency`.`Communication`)) 'communication',
  ROUND(AVG(`competency`.`OrganizationalAwareness`)) 'organizational_awareness',
  ROUND(AVG(`competency`.`CreativeThinking`)) 'creative_thinking',
  ROUND(AVG(`competency`.`NetworkingRelationshipBuilding`)) 'networking_relationship_building',
  ROUND(AVG(`competency`.`ConflictManagement`)) 'conflict_management',
  ROUND(AVG(`competency`.`StewardshipofResources`)) 'stewardship_of_resources',
  ROUND(AVG(`competency`.`RiskManagement`)) 'risk_management',
  ROUND(AVG(`competency`.`StressManagement`)) 'stress_management',
  ROUND(AVG(`competency`.`Influence`)) 'influence',
  ROUND(AVG(`competency`.`Initiative`)) 'initiative',
  ROUND(AVG(`competency`.`TeamLeadership`)) 'team_leadership',
  ROUND(AVG(`competency`.`ChangeLeadership`)) 'change_leadership',
  ROUND(AVG(`competency`.`ClientFocus`)) 'client_focus',
  ROUND(AVG(`competency`.`Partnering`)) 'partnering',
  ROUND(AVG(`competency`.`DevelopingOthers`)) 'developing_others',
  ROUND(AVG(`competency`.`PlanningandOrganizing`)) 'planning_and_organizing',
  ROUND(AVG(`competency`.`DecisionMaking`)) 'decision_making',
  ROUND(AVG(`competency`.`AnalyticalThinking`)) 'analytical_thinking',
  ROUND(AVG(`competency`.`ResultsOrientation`)) 'results_orientation',
  ROUND(AVG(`competency`.`Teamwork`)) 'teamwork',
  ROUND(AVG(`competency`.`ValuesandEthics`)) 'values_and_ethics',
  ROUND(AVG(`competency`.`VisioningandStrategicDirection`)) 'visioning_and_strategic_direction'
  FROM
  `competency`
  LEFT JOIN `employees` ON `competency`.`employees_id` = `employees`.`employees_id` LEFT JOIN `positiontitles` ON `employees`.`position_id` = `positiontitles`.`position_id` 
  SQL;
  
  $sql_emp = <<<SQL
  SELECT 
      -- `employees`.`employees_id`,
      CONCAT(`employees`.`lastName`,', ',`employees`.`firstName`,' ',`employees`.`middleName`,' ',`employees`.`extName`) AS fullName
  FROM
  `competency`
  LEFT JOIN `employees` ON `competency`.`employees_id` = `employees`.`employees_id` LEFT JOIN `positiontitles` ON `employees`.`position_id` = `positiontitles`.`position_id` 
  SQL;
  
  foreach ($queries as $qk => $qry) {
      $key = $filters[$qk][0].";".$filters[$qk][1];
      //get the average competency
      $result = $mysqli->query($sql_ave.$qry);
      $data_fltrs = [$filters[$qk][0],$filters[$qk][1]];
      $data_ave = $result->fetch_assoc();
      // now get the list of employees
      $data_emps = [];
      $result = $mysqli->query($sql_emp.$qry." ORDER BY `employees`.`lastName` ASC");
      while ($emp = $result->fetch_assoc()) {
          $data_emps[] = $emp['fullName'];   
      }
  
      if (!array_key_exists($key, $data)) {
          //male
          $data[$key]['filters'] = $data_fltrs;
          $data[$key]['male'] = [
              'average' => $data_ave,
              'employees' => $data_emps
          ];
    } else {
          $data[$key]['female'] = [
              'average' => $data_ave,
              'employees' => $data_emps
          ];
      }
  }
  
  echo json_encode($data);
}

elseif (isset($_POST["get_average_data"])) {
  // wip get average data
  $filters = $_POST["filters"];
  $sql = construct_sql($filters);
  $result = $mysqli->query($sql);
  // $compTotal = array();
  // for ($i=0; $i < 24 ; $i++) {
  //   $compTotal[] = 0;
  // }
   $num_rows = $result->num_rows;
   $compTotal = array(
    'Adaptability'=>0,
    'Continous_Learning'=>0,
    'Communication'=>0,
    'Organizational_Awareness'=>0,
    'Creative_Thinking'=>0,
    'Networking_Relationship_Building'=>0,
    'Conflict_Management'=>0,
    'Stewardship_of_Resources'=>0,
    'Risk_Management'=>0,
    'Stress_Management'=>0,
    'Influence'=>0,
    'Initiative'=>0,
    'Team_Leadership'=>0,
    'Change_Leadership'=>0,
    'Client_Focus'=>0,
    'Partnering'=>0,
    'Developing_Others'=>0,
    'Planning_and_Organizing'=>0,
    'Decision_Making'=>0,
    'Analytical_Thinking'=>0,
    'Results_Orientation'=>0,
    'Teamwork'=>0,
    'Values_and_Ethics'=>0,
    'Visioning_and_Strategic_Direction'=>0
   );
 while ($row = $result->fetch_assoc()) {
    $datetime = $row['datetime'];
    $compTotal['Adaptability'] += $row['Adaptability'];
    $compTotal['Continous_Learning'] += $row['ContinousLearning'];
    $compTotal['Communication'] += $row['Communication'];
    $compTotal['Organizational_Awareness'] += $row['OrganizationalAwareness'];
    $compTotal['Creative_Thinking'] += $row['CreativeThinking'];
    $compTotal['Networking_Relationship_Building'] += $row['NetworkingRelationshipBuilding'];
    $compTotal['Conflict_Management'] += $row['ConflictManagement'];
    $compTotal['Stewardship_of_Resources'] += $row['StewardshipofResources'];
    $compTotal['Risk_Management'] += $row['RiskManagement'];
    $compTotal['Stress_Management'] += $row['StressManagement'];
    $compTotal['Influence'] += $row['Influence'];
    $compTotal['Initiative'] += $row['Initiative'];
    $compTotal['Team_Leadership'] += $row['TeamLeadership'];
    $compTotal['Change_Leadership'] += $row['ChangeLeadership'];
    $compTotal['Client_Focus'] += $row['ClientFocus'];
    $compTotal['Partnering'] += $row['Partnering'];
    $compTotal['Developing_Others'] += $row['DevelopingOthers'];
    $compTotal['Planning_and_Organizing'] += $row['PlanningandOrganizing'];
    $compTotal['Decision_Making'] += $row['DecisionMaking'];
    $compTotal['Analytical_Thinking'] += $row['AnalyticalThinking'];
    $compTotal['Results_Orientation'] += $row['ResultsOrientation'];
    $compTotal['Teamwork'] += $row['Teamwork'];
    $compTotal['Values_and_Ethics'] += $row['ValuesandEthics'];
    $compTotal['Visioning_and_Strategic_Direction'] += $row['VisioningandStrategicDirection'];
    $total  = $row['totalPoints'];
}
    $data = array();

  foreach ($compTotal as $key => $value) {
    if ($num_rows != 0) {
      $data[] = array(
        'competency' => $key,
        'value'=>round($value/$num_rows)
      );
    } else {
      $data[] = array(
        'competency' => $key,
        'value'=>0
      );
    }
  }

  echo json_encode($data);
}
// get data by gender start
elseif (isset($_POST["get_average_data_by_gender"])) {
  $filters = $_POST["filters"];
  $data = array(
    'male' => getData($filters,"MALE",$mysqli),
    'female' => getData($filters,"FEMALE",$mysqli)
  );
  echo json_encode($data);
}
// get data by gender end

elseif (isset($_POST['load_positions'])) {
  $sql = "SELECT DISTINCT `position` FROM `positiontitles` ORDER BY `position` ASC";
  $result = $mysqli->query($sql);
  while ($row = $result->fetch_assoc()) {
      // $position_id = $row["position_id"];
      $position =  $row["position"];
      // $function =  $row["functional"];
?>

<div class="item" data-value="<?php echo $position; ?>"><?php echo $position; ?></div>

<?php

  }
}

elseif (isset($_POST['load_functions'])) {
  $position = $_POST['position'];
  $sql = "SELECT DISTINCT `functional` FROM `positiontitles` WHERE `position` = '$position'";
  $result = $mysqli->query($sql);
  while ($row = $result->fetch_assoc()) {
      $functional = $row["functional"];
?>

<div class="item" data-value="<?php echo $functional; ?>"><?php echo $functional; ?></div>

<?php
  }
}

elseif (isset($_POST["getNumOfStatus"])) {
    // get number of active/inactive start
  $filters = $_POST["filters"];
  $sql = construct_sql($filters);
  $result = $mysqli->query($sql);
  $total = $result->num_rows;

  // $json = array('total'=>$total);
  // echo json_encode($json);
  echo "$total result/s.";
}

elseif (isset($_POST["get_rows"])) {
  $sql = "SELECT `competency_id` FROM `competency`";
  $result = $mysqli->query($sql);
  $num_rows = $result->num_rows;
  $sql2 = "SELECT * FROM `employees` wHERE `status` = 'ACTIVE' AND `employmentStatus` = 'PERMANENT'";
  $result2 = $mysqli->query($sql2);
  $num_rows2 = $result2->num_rows;
  $left = $num_rows2 - $num_rows;

  echo "$num_rows/$num_rows2 personnels have taken the survey. $left haven't.";
}


elseif (isset($_POST['getResults'])) {
  $position = $_POST['position'];
  $function = $_POST['function'];

  $sql = "SELECT * FROM `positiontitles` WHERE `position` = '$position' AND `functional` = '$function'";
  $result = $mysqli->query($sql);
  $row = $result->fetch_assoc();
  $position_id = $row["position_id"];
  // echo json_encode($position_id);

  $sql = "SELECT * FROM `competency` WHERE `employees_id` IN (SELECT `employees_id` FROM `employees` WHERE `position_id` = '$position_id')";
  $result = $mysqli->query($sql);
  $counter = 0;
  $num_rows = $result->num_rows;
  if ($num_rows === 0) {
    ?>

<tr>
  <td colspan="27" style="text-align: center; color: grey; padding: 20px;">
    No results found.
  </td>
</tr>

    <?php
  }

while ($row = $result->fetch_array(MYSQLI_NUM)) {
    $counter++;
    $competency_id = $row[0];
    $employees_id = $row[1];
    if ($employees_id != 0) {

// get name start
    $sql1 = "SELECT * FROM `employees` WHERE `employees_id` = '$employees_id'";
    $result1 = $mysqli->query($sql1);

    $row1 = $result1->fetch_assoc();

    if (!empty($row1['extName'])) {
      $extName = ", ".$row1['extName'];
    } else {
      $extName = "";
    }

    $fullName = $row1['lastName'].", ".$row1['firstName']." ".$row1['middleName']." ".$extName." ";
// get name end

    } else {
      $fullName = "Unidentified! Please see input in db...";
    }

    $datetime = $row[2];
    $comp0 = $row[3];
    $comp1 = $row[4];
    $comp2 = $row[5];
    $comp3 = $row[6];
    $comp4 = $row[7];
    $comp5 = $row[8];
    $comp6 = $row[9];
    $comp7 = $row[10];
    $comp8 = $row[11];
    $comp9 = $row[12];
    $comp10 = $row[13];
    $comp11 = $row[14];
    $comp12 = $row[15];
    $comp13 = $row[16];
    $comp14 = $row[17];
    $comp15 = $row[18];
    $comp16 = $row[19];
    $comp17 = $row[20];
    $comp18 = $row[21];
    $comp19 = $row[22];
    $comp20 = $row[23];
    $comp21 = $row[24];
    $comp22 = $row[25];
    $comp23 = $row[26];
    $total  = $row[27];

    ?>
    <tr class="datatr">
      <td><?php echo "$counter. ";?></td>
      <td><i class="icon clock outline popup" data-content="<?php echo dateToStr($datetime)?>"></i></td>
      <td style="text-align: left;"><?php echo $fullName;?></td>

<script type="text/javascript">
  $(document).ready(function() {
    $('.popup').popup();
  });
</script>

      <?php
      // for ($i=0; $i < 24 ; $i++) {
      //   $data = ${"comp".$i};
      //   if ($data == 3) {
      //     echo "<td style=\"background-color: #ef7ca8; color: white;\">$data</td>";
      //   }
      //   elseif ($data == 4) {
      //     echo "<td style=\"background-color: #d500ff; color: white;\">$data</td>";
      //   }
      //   elseif ($data == 5) {
      //     echo "<td style=\"background-color: #6a226f; color: white;\">$data</td>";
      //   }
      //   else {
      //     echo "<td>$data</td>"; 
      //   }

      //   ${"total".$i} += $data;

      // }
      
      for ($i=0; $i < 24 ; $i++) {
        $data = ${"comp".$i};
          if ($data == 3) { 
            echo "<td style=\"background-color: #88baecd1; color: white;\">$data</td>";
          }
          elseif ($data == 4) {
            echo "<td style=\"background-color: #016dd8c4; color: white;\">$data</td>";
          }
          elseif ($data == 5) {
            echo "<td style=\"background-color: #016dd8; color: white;\">$data</td>";
          }
          else {
              echo "<td>$data</td>"; 
          }
          ${"total".$i} += $data;
      }


      ?>
    </tr>
    <?php
  }

  if ($num_rows !== 0) {
?>
<tr style="border: 5px solid green; ">
  <td colspan="3" style="font-weight: bold; color: green;">AVERAGE</td>
<?php
  for ($i=0; $i < 24 ; $i++) {
      $average = round((${"total".$i})/$num_rows);
      // for ($i=0; $i < 24 ; $i++) {
        // $data = ${"comp".$i};
          if ($average == 3) { 
            echo "<td style=\"background-color: #88baecd1; color: black;\">$average</td>";
          }
          elseif ($average == 4) {
            echo "<td style=\"background-color: #016dd8c4; color: white;\">$average</td>";
          }
          elseif ($average == 5) {
            echo "<td style=\"background-color: #016dd8; color: white;\">$average</td>";
          }
          else {
              echo "<td>$average</td>"; 
          }
          // ${"total".$i} += $data;
      // }


?>
<!--   <td style="font-weight: bold; color: green;"><?php
    echo round((${"total".$i})/$num_rows);
    ?>
  </td> -->
<?php
  }
?>
</tr>
<?php

  }

}

function dateToStr($numeric_date){
  $date = new DateTime($numeric_date);
  $strDate = $date->format('M. d, Y h:i:s a');
  return $strDate;
}


function construct_sql ($filters, $sortByGender=""){
  $gender_arr = array();
  $type_arr = array();
  $level_arr = array();
  $nature_arr = array();
  $category_arr = array();
  $ldn2018_arr = array();
  $dept_arr = array();
  
  $filters_sql = '';
  
  if ($filters) {
    foreach ($filters as $value) {
      $value_arr = explode("=", $value);
      $index = $value_arr[0];
      $el = $value_arr[1];
      if ($index === "gender") {
        array_push($gender_arr, $el);
      } elseif ($index === "type") {
        array_push($type_arr, $el);
      } elseif ($index === "level") {
        array_push($level_arr, $el);
      } elseif ($index === "nature") {
        array_push($nature_arr, $el);
      } elseif ($index === "category") {
        array_push($category_arr, $el);
      } elseif ($index === "ldn2018") {
        array_push($ldn2018_arr, $el);
      } elseif ($index === "dept_id") {
        array_push($dept_arr, $el);
      }
    } 
  
    $sql_arr = array();
    if ($gender_arr && !$sortByGender) {
      array_push($sql_arr, "employees.gender IN (".filter_val($gender_arr).")");
    } elseif (!$gender_arr && $sortByGender) {
      array_push($sql_arr, "employees.gender IN ('".$sortByGender."')");
    } elseif ($gender_arr && $sortByGender) {
      array_push($sql_arr, "employees.gender IN ('".$sortByGender."')");
    }
  
    if ($type_arr) {
      array_push($sql_arr, "employees.employmentStatus IN (".filter_val($type_arr).")");
    } 
    if ($level_arr) {
      array_push($sql_arr, "positiontitles.level IN (".filter_val($level_arr).")");
    } 
    if ($nature_arr) {
      array_push($sql_arr, "employees.natureOfAssignment IN (".filter_val($nature_arr).")");
    }
    if ($category_arr) {
      array_push($sql_arr, "positiontitles.category IN (".filter_val($category_arr).")");
    }
    if ($ldn2018_arr) {
      array_push($sql_arr, "employees.employees_id IN (SELECT `employees_id` FROM `individualAssReport`)");
    }
    if ($dept_arr) {
      array_push($sql_arr, "employees.department_id IN (".filter_val($dept_arr).")");
    }
  
    $i = 0;
    $filters_sql = " WHERE ";
    foreach ($sql_arr as $value) {
      $i++;
      $filters_sql .= $value;
      if (count($sql_arr)!== $i) {
        $filters_sql .= " AND ";
      }
    }
  } elseif (!$filters && $sortByGender) {
      $filters_sql = " WHERE employees.gender IN ('".$sortByGender."')";
  }
  
  $sql = "SELECT * FROM `competency` LEFT JOIN `employees` ON `competency`.`employees_id` = `employees`.`employees_id` LEFT JOIN `positiontitles` ON `employees`.`position_id` = `positiontitles`.`position_id` 
  $filters_sql
  ORDER BY `lastName` ASC";
  
  return $sql;
  }



function getData($filters,$sortByGender,$mysqli){
  $sql = construct_sql($filters,$sortByGender);
  $result = $mysqli->query($sql);
   $num_rows = $result->num_rows;
   $compTotal = array(
    'Adaptability'=>0,
    'Continous_Learning'=>0,
    'Communication'=>0,
    'Organizational_Awareness'=>0,
    'Creative_Thinking'=>0,
    'Networking_Relationship_Building'=>0,
    'Conflict_Management'=>0,
    'Stewardship_of_Resources'=>0,
    'Risk_Management'=>0,
    'Stress_Management'=>0,
    'Influence'=>0,
    'Initiative'=>0,
    'Team_Leadership'=>0,
    'Change_Leadership'=>0,
    'Client_Focus'=>0,
    'Partnering'=>0,
    'Developing_Others'=>0,
    'Planning_and_Organizing'=>0,
    'Decision_Making'=>0,
    'Analytical_Thinking'=>0,
    'Results_Orientation'=>0,
    'Teamwork'=>0,
    'Values_and_Ethics'=>0,
    'Visioning_and_Strategic_Direction'=>0
   );
 while ($row = $result->fetch_assoc()) {
    $datetime = $row['datetime'];
    $compTotal['Adaptability'] += $row['Adaptability'];
    $compTotal['Continous_Learning'] += $row['ContinousLearning'];
    $compTotal['Communication'] += $row['Communication'];
    $compTotal['Organizational_Awareness'] += $row['OrganizationalAwareness'];
    $compTotal['Creative_Thinking'] += $row['CreativeThinking'];
    $compTotal['Networking_Relationship_Building'] += $row['NetworkingRelationshipBuilding'];
    $compTotal['Conflict_Management'] += $row['ConflictManagement'];
    $compTotal['Stewardship_of_Resources'] += $row['StewardshipofResources'];
    $compTotal['Risk_Management'] += $row['RiskManagement'];
    $compTotal['Stress_Management'] += $row['StressManagement'];
    $compTotal['Influence'] += $row['Influence'];
    $compTotal['Initiative'] += $row['Initiative'];
    $compTotal['Team_Leadership'] += $row['TeamLeadership'];
    $compTotal['Change_Leadership'] += $row['ChangeLeadership'];
    $compTotal['Client_Focus'] += $row['ClientFocus'];
    $compTotal['Partnering'] += $row['Partnering'];
    $compTotal['Developing_Others'] += $row['DevelopingOthers'];
    $compTotal['Planning_and_Organizing'] += $row['PlanningandOrganizing'];
    $compTotal['Decision_Making'] += $row['DecisionMaking'];
    $compTotal['Analytical_Thinking'] += $row['AnalyticalThinking'];
    $compTotal['Results_Orientation'] += $row['ResultsOrientation'];
    $compTotal['Teamwork'] += $row['Teamwork'];
    $compTotal['Values_and_Ethics'] += $row['ValuesandEthics'];
    $compTotal['Visioning_and_Strategic_Direction'] += $row['VisioningandStrategicDirection'];
    $total  = $row['totalPoints'];
}
    $data = array();

  foreach ($compTotal as $key => $value) {
    if ($num_rows != 0) {
      $data[] = array(
        'competency' => $key,
        'value'=>round($value/$num_rows)
      );
    } else {
      $data[] = array(
        'competency' => $key,
        'value'=>0
      );
    }
  }
  
  return $data;
  // $total = 0;
  // foreach ($data as $competency) {
  //   $total += $competency['value'];
  // }
  // return $total;
}











function filter_val($arr){
  if (count($arr)>0) {
    $str = "";
    $i=0;
    foreach ($arr as $value) {
      $str .= "'$value'";
      $i++;
      if (count($arr)!== $i) {
        $str .= ",";
      }
    }
    return $str;
  } else {
    return "";
  }
}

?>


