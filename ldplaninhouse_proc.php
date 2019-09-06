<?php
  require_once "_connect.db.php";

if (isset($_POST["load"])) {
    $ldplan_id = $_POST["ldplan_id"];
    $sql = "SELECT * FROM `ldpinhousetrainings` WHERE `ldplan_id` = '$ldplan_id'";
    $result = $mysqli->query($sql);
    if ($result->num_rows == 0) {
?>

<tr>
  <td colspan="10" style="color: lightgrey; text-align: center;">No Data Available</td>
</tr>

<?php
    } else {
    while ($row = $result->fetch_assoc()) {
      $ldpinhousetrainings_id = $row["ldpinhousetrainings_id"];
      $ldplan_id = $row["ldplan_id"];
      $training_id = $row["training_id"];

      $sql1 = "SELECT `training` FROM `trainings` WHERE `training_id` = '$training_id'";
      $result1 = $mysqli->query($sql1);
      $row1 = $result1->fetch_assoc();
      $training = $row1["training"];

      $goal = $row["goal"];
      $numHours = $row["numHours"];
      $participants = $row["participants"];
      $activities = $row["activities"];
      $evaluation = $row["evaluation"];
      $evaluation = str_replace("\n", "<br/>", $evaluation);
      $frequency = $row["frequency"];
      $budgetReq = $row["budgetReq"];
      $partner = $row["partner"];
?>
<tr>
  <td style="font-weight: bold;"><?php echo $training;?></td>
  <td><?php echo $goal;?></td>
  <td style="text-align: center;"><?php echo $numHours." hrs";?></td>
  <td><?php echo $participants;?></td>
  <td><?php echo $activities;?></td>
  <td><?php echo $evaluation;?></td>
  <td><?php echo $frequency;?></td>
  <td><?php echo $budgetReq;?></td>
  <td><?php echo $partner;?></td>
  <td class="right aligned noprint">
    <div class="ui mini basic icon buttons">
    <button class="ui button" title="Edit" onclick="editRow('<?php echo $ldpinhousetrainings_id;?>')"><i class="edit outline icon"></i></button>
    <button class="ui button" title="Delete" onclick="deleteRow('<?php echo $ldpinhousetrainings_id;?>')"><i class="trash alternate outline icon"></i></button>
      </div>
  </td>
</tr>
<?php
      }
    }
  }

elseif (isset($_POST["getTrainings"])) {
  
  $json = array();
  $inside_json = array();

  $sql = "SELECT * FROM `trainings`";
  $result = $mysqli->query($sql);
  while ($row = $result->fetch_assoc()) {
    $training_id = $row["training_id"];
    $training = $row["training"];
    
    $inside_json = array('title' => $training);
    array_push($json, $inside_json);
  }

  echo json_encode($json);

}

elseif (isset($_POST["addNew"])) {

  $ldplan_id = $_POST["ldplan_id"];
  $training = addslashes($_POST["training"]);
  $goal = addslashes($_POST["goal"]);
  $numHours = $_POST["numHours"];
  $participants = addslashes($_POST["participants"]);
  $activities = addslashes($_POST["activities"]);
  $evaluation = addslashes($_POST["evaluation"]);
  $frequency = addslashes($_POST["frequency"]);
  $budgetReq = $_POST["budgetReq"];
  $partner = addslashes($_POST["partner"]);
  $currentDate = date('Y-m-d H:i:s');

  $sql = "SELECT `training_id` FROM `trainings` WHERE `training` = '$training'";
  $result = $mysqli->query($sql);
  if ($result->num_rows == 0) {
    $training = addslashes($training);
    $sql1 = "INSERT INTO `trainings` (`training`, `dateAdded`) VALUES ('$training', '$currentDate')";
    $mysqli->query($sql1);
    $training_id = $mysqli->insert_id;
  } else {
    $row = $result->fetch_assoc();
    $training_id = $row["training_id"];
  }

  $sql ="INSERT INTO `ldpinhousetrainings` (`ldpinhousetrainings_id`, `ldplan_id`, `training_id`, `goal`, `numHours`, `participants`,`activities`, `evaluation`, `frequency`, `budgetReq`,`partner`) VALUES (NULL, '$ldplan_id', '$training_id', '$goal', '$numHours', '$participants', '$activities', '$evaluation', '$frequency', '$budgetReq', '$partner')";

  $mysqli->query($sql);

}

elseif (isset($_POST["getRowData"])) {
  $ldpinhousetrainings_id = $_POST["ldpinhousetrainings_id"];
  $sql = "SELECT * FROM `ldpinhousetrainings` WHERE `ldpinhousetrainings_id` = '$ldpinhousetrainings_id'";
  $result = $mysqli->query($sql);
  $row = $result->fetch_assoc();

  $ldpinhousetrainings_id = $row["ldpinhousetrainings_id"];
  $ldplan_id = $row["ldplan_id"];
  $training_id = $row["training_id"];

  $sql1 = "SELECT `training` FROM `trainings` WHERE `training_id` = '$training_id'";
  $result1 = $mysqli->query($sql1);
  $row1 = $result1->fetch_assoc();
  $training = $row1["training"];

  $goal = $row["goal"];
  $numHours = $row["numHours"];
  $participants = $row["participants"];
  $activities = $row["activities"];
  $evaluation = $row["evaluation"];
  $frequency = $row["frequency"];
  $budgetReq = $row["budgetReq"];
  $partner = $row["partner"];

  $json = array(
    'ldpinhousetrainings_id' => $ldpinhousetrainings_id,
    'ldplan_id' => $ldplan_id,
    'training' => $training,
    'goal' => $goal,
    'numHours' => $numHours,
    'participants' => $participants,
    'activities' => $activities,
    'evaluation' => $evaluation,
    'frequency' => $frequency,
    'budgetReq' => $budgetReq,
    'partner' => $partner
);
  echo json_encode($json);
}

elseif (isset($_POST["editRow"])) {
  
  $ldpinhousetrainings_id = $_POST["ldpinhousetrainings_id"];
  $training = addslashes($_POST["title_edit"]);
  $currentDate = date('Y-m-d H:i:s');

  $sql = "SELECT `training_id` FROM `trainings` WHERE `training` = '$training'";
  $result = $mysqli->query($sql);

  if ($result->num_rows == 0) {
    $training = addslashes($training);
    $sql1 = "INSERT INTO `trainings` (`training`, `dateAdded`) VALUES ('$training', '$currentDate')";
    $mysqli->query($sql1);
    $training_id = $mysqli->insert_id;
  } else {
    $row = $result->fetch_assoc();
    $training_id = $row["training_id"];
  }

  $goal = addslashes($_POST["goal_edit"]);
  $numHours = $_POST["hrs_edit"];
  $participants = addslashes($_POST["participants_edit"]);
  $activities = addslashes($_POST["methods_edit"]);
  $evaluation = addslashes($_POST["eval_edit"]);
  $frequency = addslashes($_POST["freq_edit"]);
  $budgetReq = $_POST["budget_edit"];
  $partner = $_POST["partner_edit"];

  $sql = "UPDATE `ldpinhousetrainings` SET
    `training_id` = '$training_id',
    `goal` = '$goal',
    `numHours` = '$numHours',
    `participants` = '$participants',
    `activities` = '$activities',
    `evaluation` = '$evaluation',
    `frequency` = '$frequency',
    `budgetReq` = '$budgetReq',
    `partner` = '$partner'
  WHERE `ldpinhousetrainings_id` = '$ldpinhousetrainings_id'";

  $mysqli->query($sql);
}

elseif (isset($_POST["deleteRow"])) {
  $ldpinhousetrainings_id = $_POST["ldpinhousetrainings_id"];
  $sql = "DELETE FROM `ldpinhousetrainings` WHERE `ldpinhousetrainings_id` = '$ldpinhousetrainings_id'";
  $mysqli->query($sql);
}


?>