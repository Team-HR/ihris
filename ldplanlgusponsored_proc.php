<?php
require_once "_connect.db.php";

// vueing start
if (isset($_POST["getItems"])) {
  $data = array();
  $ldplan_id = $_POST["ldplan_id"];
  $sql = "SELECT * FROM `ldplgusponsoredtrainings` WHERE `ldplan_id` = '$ldplan_id'";
  $result = $mysqli->query($sql);

  while ($row = $result->fetch_assoc()) {
    $ldplgusponsoredtrainings_id = $row["ldplgusponsoredtrainings_id"];
    $ldplan_id = $row["ldplan_id"];
    $training_id = $row["training_id"];

    $sql1 = "SELECT `training` FROM `trainings` WHERE `training_id` = '$training_id'";
    $result1 = $mysqli->query($sql1);
    $row1 = $result1->fetch_assoc();
    $training = $row1["training"];

    $goal = $row["goal"];
    $numHours = $row["numHours"];
    $participants = $row["participants"];
    $training_id = $row["training_id"];
    $targetParticipants = getTargetParticipants($mysqli, $training_id);
    $activities = $row["activities"];
    $evaluation = $row["evaluation"];
    $evaluation = $evaluation; //str_replace("\n", "<br/>", $evaluation);
    $frequency = $row["frequency"];
    $budgetReq = $row["budgetReq"];
    $partner = $row["partner"];
    // added for vue
    $budget = json_decode($row["budget"]);
    $venue = $row["venue"];


    $datum = array(
      "ldplgusponsoredtrainings_id" => $ldplgusponsoredtrainings_id,
      "training" => $training,
      "goal" => $goal,
      "numHours" => $numHours,
      "participants" => $participants,
      "targetParticipants" => $targetParticipants,
      "activities" => $activities,
      "evaluation" => $evaluation,
      "frequency" => $frequency,
      "budgetReq" => $budgetReq,
      "partner" => $partner,
      "budget" => $budget,
      "venue" => $venue,
    );

    array_push($data, $datum);
  }

  echo json_encode($data);
}
// update budget start
elseif (isset($_POST["updateBudget"])) {
  $ldplgusponsoredtrainings_id = $_POST["ldplgusponsoredtrainings_id"];
  $budget = $_POST["budget"];
  $b = [];
  if ($budget["allocated"] == "" || $budget["allocated"] == 0 ) {
    $b = NULL;
    $budget = NULL;
  } else {
    $b = $budget;
    $budget = $mysqli->real_escape_string(json_encode($budget));
  }
  $sql = "UPDATE `ldplgusponsoredtrainings` SET `budget` = '$budget' WHERE `ldplgusponsoredtrainings_id` = '$ldplgusponsoredtrainings_id'";
  $mysqli->query($sql);
  echo json_encode($b);
}
// update budget end
// vueing end
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
} elseif (isset($_POST["addNew"])) {
  $ldplan_id = $_POST["ldplan_id"];
  $training = $mysqli->real_escape_string($_POST["training"]);
  $goal = $mysqli->real_escape_string($_POST["goal"]);
  $numHours = $_POST["numHours"];
  $participants = $mysqli->real_escape_string($_POST["participants"]);
  $activities = $mysqli->real_escape_string($_POST["activities"]);
  $evaluation = $mysqli->real_escape_string($_POST["evaluation"]);
  $frequency = $mysqli->real_escape_string($_POST["frequency"]);
  // $budgetReq = $_POST["budgetReq"]; //deprecated
  $budgetReq = NULL;
  $partner = $mysqli->real_escape_string($_POST["partner"]);
  $currentDate = date('Y-m-d H:i:s');
  
  
  $budget = $_POST["budget"];

  if ($budget["allocated"] == "" || $budget["allocated"] == 0 ) {
    $budget = NULL;
  } else {
    $budget = $mysqli->real_escape_string(json_encode($budget));
  }
  
  $venue = $mysqli->real_escape_string($_POST["venue"]);

  $sql = "SELECT `training_id` FROM `trainings` WHERE `training` = '$training'";
  $result = $mysqli->query($sql);
  if ($result->num_rows == 0) {
    $training = $mysqli->real_escape_string($training);
    $sql1 = "INSERT INTO `trainings` (`training`, `dateAdded`) VALUES ('$training', '$currentDate')";
    $mysqli->query($sql1);
    $training_id = $mysqli->insert_id;
  } else {
    $row = $result->fetch_assoc();
    $training_id = $row["training_id"];
  }

  $sql = "INSERT INTO `ldplgusponsoredtrainings` (`ldplgusponsoredtrainings_id`, `ldplan_id`, `training_id`, `goal`, `numHours`, `participants`,`activities`, `evaluation`, `frequency`, `budgetReq`,`partner`,`budget`,`venue`) VALUES (NULL, '$ldplan_id', '$training_id', '$goal', '$numHours', '$participants', '$activities', '$evaluation', '$frequency', '$budgetReq', '$partner', '$budget', '$venue')";

  $mysqli->query($sql);
  echo json_encode("added");
} elseif (isset($_POST["getRowData"])) {
  $ldplgusponsoredtrainings_id = $_POST["ldplgusponsoredtrainings_id"];
  $sql = "SELECT * FROM `ldplgusponsoredtrainings` WHERE `ldplgusponsoredtrainings_id` = '$ldplgusponsoredtrainings_id'";
  $result = $mysqli->query($sql);
  $row = $result->fetch_assoc();

  $ldplgusponsoredtrainings_id = $row["ldplgusponsoredtrainings_id"];
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
    'ldplgusponsoredtrainings_id' => $ldplgusponsoredtrainings_id,
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
} elseif (isset($_POST["editRow"])) {

  $ldplgusponsoredtrainings_id = $_POST["ldplgusponsoredtrainings_id"];
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

  $goal = $mysqli->real_escape_string($_POST["goal_edit"]);
  $numHours = $mysqli->real_escape_string($_POST["hrs_edit"]);
  $participants = $mysqli->real_escape_string($_POST["participants_edit"]);
  $activities = $mysqli->real_escape_string($_POST["methods_edit"]);
  $evaluation = $mysqli->real_escape_string($_POST["eval_edit"]);
  $frequency = $mysqli->real_escape_string($_POST["freq_edit"]);
  // $budgetReq = $_POST["budget_edit"]; //deprecated
  $budgetReq = NULL;
  $partner = $mysqli->real_escape_string($_POST["partner_edit"]);
  $budget = $mysqli->real_escape_string(json_encode($_POST["budget"]));
  $venue = $mysqli->real_escape_string($_POST["venue"]);

  $sql = "UPDATE `ldplgusponsoredtrainings` SET
    `training_id` = '$training_id',
    `goal` = '$goal',
    `numHours` = '$numHours',
    `participants` = '$participants',
    `activities` = '$activities',
    `evaluation` = '$evaluation',
    `frequency` = '$frequency',
    `budgetReq` = '$budgetReq',
    `partner` = '$partner',
    `budget` = '$budget',
    `venue` = '$venue' 
    WHERE `ldplgusponsoredtrainings_id` = '$ldplgusponsoredtrainings_id'";

  $mysqli->query($sql);
  echo json_encode("success");
} elseif (isset($_POST["deleteRow"])) {
  $ldplgusponsoredtrainings_id = $_POST["ldplgusponsoredtrainings_id"];
  $sql = "DELETE FROM `ldplgusponsoredtrainings` WHERE `ldplgusponsoredtrainings_id` = '$ldplgusponsoredtrainings_id'";
  $mysqli->query($sql);
}


function getTargetParticipants($mysqli, $id)
{
  $data = [];
  // $sql = "SELECT"
  // $data = $training_id;
  // start
  $tnas = getTNAdata($mysqli);
  $trainings = getTrainings($mysqli);

  foreach ($trainings as $training) {
    $departments = array();
    $countDepartments = 0;
    $training_id = $training["training_id"];


    foreach ($tnas as $tna) {
      $department_id = $tna["department_id"];
      $department = $tna["department"];
      $training_ids = $tna["training_ids"];

      foreach ($training_ids as $tr_id) {
        if ($tr_id == $training_id) {
          $departments[] = array(
            "department_id" => $department_id,
            "department" => $department,
          );
          $countDepartments += 1;
          break;
        }
      }
    }

    $datum = array(
      "training_id" => $training_id,
      "training" => $training["training"],
      "countDepartments" => $countDepartments,
      "departments" => $departments
    );

    array_push($data, $datum);
  }
  // end
  $targetParticipant = [];
  foreach ($data as $tr) {
    if ($tr["training_id"] == $id) {
      $targetParticipant = $tr;
      break;
    }
  }

  // getDepartments

  $training_id = $id;
  $departments = $targetParticipant["departments"];

  return getParticipants($mysqli, $training_id, $departments);
  // return $targetParticipants;
}


function getParticipants($mysqli, $training_id, $departments)
{
  $training_id = $training_id;
  $departments = count($departments) > 0 ? $departments : [];
  $data = [];
  // if (count($departments)==0) return $data;

  foreach ($departments as $dept) {

    $department_id = $dept["department_id"];
    $department = $dept["department"];

    $managers = [];
    $staffs = [];
    $all = [];



    $haveManagerTraining = false;
    $sql = "SELECT * FROM `tna` WHERE `department_id` = '$department_id'";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
      $trs = unserialize($row["manager_trs"]);
      foreach ($trs as $tr) {
        if ($tr == $training_id) {
          $haveManagerTraining = true;
          break;
        }
      }
    }



    $haveStaffTraining = false;
    $sql = "SELECT * FROM `tna` WHERE `department_id` = '$department_id'";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
      $trs = unserialize($row["staff_trs"]);
      foreach ($trs as $tr) {
        if ($tr == $training_id) {
          $haveStaffTraining = true;
          break;
        }
      }
    }


    $haveAllTraining = false;
    $sql = "SELECT * FROM `tna` WHERE `department_id` = '$department_id'";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
      $trs = unserialize($row["all_trs"]);
      foreach ($trs as $tr) {
        if ($tr == $training_id) {
          $haveAllTraining = true;
          break;
        }
      }
    }

    if ($haveManagerTraining && $haveStaffTraining) {
      $haveAllTraining = true;
    }



    if ($haveManagerTraining && $haveAllTraining != true) {
      $sql3 = "SELECT * FROM `employees` WHERE `natureOfAssignment` = 'SUPERVISORY' AND `status`='ACTIVE' AND `department_id` = '$department_id' AND `employees_id` NOT IN (SELECT `employees_id` FROM `personneltrainingslist` WHERE `personneltrainings_id` IN (SELECT `personneltrainings_id` FROM `personneltrainings` WHERE `training_id` = '$training_id'))";
      $result3 = $mysqli->query($sql3);
      while ($row3 = $result3->fetch_assoc()) {
        $firstName = $row3["firstName"];
        $middleName = $row3["middleName"];
        $lastName = $row3["lastName"];
        $extName = $row3["extName"];
        $employee_fullName = "$lastName, $firstName $middleName $extName";
        $managers[] = $employee_fullName;
      }
    }



    if ($haveStaffTraining && $haveAllTraining != true) {
      $sql3 = "SELECT * FROM `employees` WHERE `natureOfAssignment` != 'SUPERVISORY' AND `status`='ACTIVE' AND `department_id` = '$department_id' AND `employees_id` NOT IN (SELECT `employees_id` FROM `personneltrainingslist` WHERE `personneltrainings_id` IN (SELECT `personneltrainings_id` FROM `personneltrainings` WHERE `training_id` = '$training_id'))";
      $result3 = $mysqli->query($sql3);
      while ($row3 = $result3->fetch_assoc()) {
        $firstName = $row3["firstName"];
        $middleName = $row3["middleName"];
        $lastName = $row3["lastName"];
        $extName = $row3["extName"];

        $employee_fullName = "$lastName, $firstName $middleName $extName";
        $staffs[] = $employee_fullName;
      }
    }



    // haveManagerTraining
    // haveStaffTraining
    // haveAllTraining
    if ($haveAllTraining || $haveManagerTraining && $haveStaffTraining) {
      $sql3 = "SELECT * FROM `employees` WHERE `department_id` = '$department_id' AND `status`='ACTIVE' AND `employees_id` NOT IN (SELECT `employees_id` FROM `personneltrainingslist` WHERE `personneltrainings_id` IN (SELECT `personneltrainings_id` FROM `personneltrainings` WHERE `training_id` = '$training_id'))";
      $result3 = $mysqli->query($sql3);
      while ($row3 = $result3->fetch_assoc()) {
        $firstName = $row3["firstName"];
        $middleName = $row3["middleName"];
        $lastName = $row3["lastName"];
        $extName = $row3["extName"];

        $employee_fullName = "$lastName, $firstName $middleName $extName";
        $all[] = $employee_fullName;
      }
    }

    $datum = [
      "department" => $department,
      "managers" => $managers,
      "staffs" => $staffs,
      "all" => $all
    ];

    array_push($data, $datum);
  }


  return $data;
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
    $department_id = $row["department_id"];
    $department = $row["department"];
    $datum = array(
      "department_id" => $department_id,
      // "training_ids" => $training_ids,
      // "training_ids_manager" => $training_ids_manager,
      // "training_ids_staff" => $training_ids_staff,
      "training_ids" => $training_ids_merged,
      "department" => $department
    );
    array_push($data, $datum);
  }
  return $data;
}

?>