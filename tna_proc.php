<?php
require "_connect.db.php";

if (isset($_POST["getAddedScheduledTrainings"])) {
  $data = [];
  $sql = "SELECT * FROM `training_needs_analysis` LEFT JOIN `personneltrainings` ON `training_needs_analysis`.`personneltrainings_id` = `personneltrainings`.`personneltrainings_id` LEFT JOIN `trainings` ON `personneltrainings`.`training_id` = `trainings`.`training_id` ORDER BY `personneltrainings`.`startDate` DESC;
  ";
  $res = $mysqli->query($sql);
  while ($row = $res->fetch_assoc()) {
    $row['startDate'] = formatDate($row['startDate']);
    $row['endDate'] = formatDate($row['endDate']);
    $data[] = $row;
  }
  echo json_encode($data);
} elseif (isset($_POST["getScheduledTrainings"])) {
  $data = [];
  $training = $_POST['training'];
  $sql = "SELECT `personneltrainings`.*,`trainings`.* FROM `personneltrainings` LEFT JOIN `trainings` ON `personneltrainings`.`training_id` = `trainings`.`training_id` WHERE `trainings`.`training` LIKE '%$training%' ORDER BY `personneltrainings`.`startDate` DESC LIMIT 5;";
  $res = $mysqli->query($sql);

  while ($row = $res->fetch_assoc()) {
    $row['startDate'] = formatDate($row['startDate']);
    $row['endDate'] = formatDate($row['endDate']);
    $data[] = $row;
  }

  foreach ($data as $key => $training) {
    $exists = checkIfExist($mysqli, $training['personneltrainings_id']);
    $data[$key]['isExisting'] = $exists;
  }

  echo json_encode($data);
} elseif (isset($_POST["addScheduledTraining"])) {
  $personneltrainings_id = $_POST['personneltrainings_id'];
  $sql = "INSERT INTO `training_needs_analysis` (`id`, `personneltrainings_id`, `created_at`) VALUES (NULL, '$personneltrainings_id', current_timestamp())";
  $mysqli->query($sql);
  echo json_encode($mysqli->insert_id);
}

// For Employee Engagement Proc

elseif(isset($_POST["addNewEntry"])){
  $form_entry = $_POST['form_entry'];
  $communication = $mysqli->real_escape_string($form_entry['communication']);
  $logistics = $mysqli->real_escape_string($form_entry['logistics']);
  $relationships = $mysqli->real_escape_string($form_entry['relationships']);
  $support = $mysqli->real_escape_string($form_entry['support']);
  $consistently = $mysqli->real_escape_string($form_entry['consistently']);
  $improvement = $mysqli->real_escape_string($form_entry['improvement']);

  $sql = "INSERT INTO `for_engagement`(`id`,`confronted_communication`,`confronted_logistics`,`confronted_relationships`,`confronted_support`,`consistently`,`improvement`) VALUES (NULL,'$communication','$logistics','$relationships','$support','$consistently','$improvement')";
  $mysqli->query($sql);
  echo json_encode( $form_entry);
}


// elseif(isset($_POST["getEntries"])){
//     $data = [];
//     $personneltrainings_id = $_POST['personneltrainings_id'];
//     $sql = "SELECT * FROM `training_needs_analysis_entries` WHERE `personneltrainings_id` = '$personneltrainings_id' ORDER BY `id` DESC";
//     $res = $mysqli->query($sql);
//     while ($row = $res->fetch_assoc()) {
//         $data[] = $row;
//     }
//     echo json_encode($data);
// }


function formatDate($numeric_date)
{
  if (!$numeric_date) return NULL;
  $date = new DateTime($numeric_date);
  $strDate = $date->format('M d, Y');
  return $strDate;
}


function checkIfExist($mysqli, $personneltrainings_id)
{
  $sql = "SELECT COUNT(`personneltrainings_id`) AS `count`
  FROM `training_needs_analysis`
  WHERE `personneltrainings_id` = '$personneltrainings_id';";

  $res = $mysqli->query($sql);
  $count = $res->fetch_assoc()['count'];
  if ($count > 0) return true;
  return false;
}


