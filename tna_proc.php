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

elseif (isset($_POST["addNewEntry"])) {
  $form_entry = $_POST['form_entry'];
  
  $communication = $mysqli->real_escape_string($form_entry['communication']);
  $department_id = $mysqli->real_escape_string($form_entry['department_id']);
  $logistics = $mysqli->real_escape_string($form_entry['logistics']);
  $relationships = $mysqli->real_escape_string($form_entry['relationships']);
  $support = $mysqli->real_escape_string($form_entry['support']);
  $successful_role = isset($form_entry['successful_role']) ?
  $form_entry['successful_role'] : [];
  $successful_role = $mysqli->real_escape_string(json_encode($successful_role));
  $consistently = $mysqli->real_escape_string($form_entry['consistently']);
  $improvement = $mysqli->real_escape_string($form_entry['improvement']);

  $sql = "INSERT INTO `for_engagement`(`id`,`department_id`,`communication`,`logistics`,`relationships`,`successful_role`,`support`,`consistently`,`improvement`,`created_at`) VALUES (NULL,'$department_id','$communication','$logistics','$relationships','$successful_role','$support','$consistently','$improvement',current_timestamp())";
  $mysqli->query($sql);
  echo json_encode($form_entry);
  
}
elseif (isset($_POST["update"])) {
  $for_engagement_id = $_POST['for_engagement_id'];

  $form_entry = $_POST['form_entry']; 
  $department_id = $form_entry['department_id'];
  $communication = $form_entry["communication"];
  $logistics = $form_entry["logistics"];
  $relationships = $form_entry['relationships'];
  $support = $form_entry['support'];
  $successful_role = ($form_entry['successful_role'] ? json_encode($form_entry["successful_role"]) : NULL);
  $consistently = $form_entry["consistently"];
  $improvement = $form_entry["improvement"];

  $sql = "UPDATE `for_engagement` SET `communication`='$communication',`logistics` ='$logistics',`relationships`='$relationships',`department_id`='$department_id',`support`='$support',`successful_role`='$successful_role',`consistently`='$consistently',`improvement`='$improvement' WHERE `for_engagement`.`id` = $for_engagement_id";
  // $mysqli->query($sql);
  echo json_encode($mysqli->query($sql));

}
elseif (isset($_POST["getDepartments"])) {
  $data = [];
  $sql = "SELECT * FROM department";
  $result = $mysqli->query($sql);
  while ($row = $result->fetch_assoc()) {
      $data[] = [
          "id" => $row["department_id"],
          "name" => $row["department"],
      ];
  }
  echo json_encode($data);
}
elseif(isset($_POST['getEntries'])){
  $data = [];
  $sql = "SELECT * FROM for_engagement";
  $res = $mysqli->query($sql);
  while($row = $res->fetch_assoc()){
    $data[] =$row;
  }
  echo json_encode($data);
}
elseif (isset($_POST["deleteEntry"])) {
  $id = $_POST['id'];
  $sql = "DELETE FROM `for_engagement` WHERE `for_engagement`.`id` = '$id'";

  $mysqli->query($sql);

  echo json_encode('success');
}

elseif (isset($_GET["pull_data"])) {
  if (!isset($_GET['for_engagement_id'])) {
      return null;
  }
  $id = $_GET['for_engagement_id'];
  $sql = "SELECT * FROM `for_engagement` WHERE `id` = '$id' ";
  $res = $mysqli->query($sql);
  $row = $res->fetch_assoc();
  $row['successful_role'] = json_decode($row['successful_role']);
  echo json_encode($row);
}


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
