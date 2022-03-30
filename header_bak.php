<?php
require '_connect.db.php';

  $events = array();
  $sql = "SELECT * FROM `personneltrainings` RIGHT JOIN `trainings` on `personneltrainings`.`training_id` = `trainings`.`training_id`";
  $result = $mysqli->query($sql);
  while ($row = $result->fetch_assoc()) {
    $personneltrainings_id = $row["personneltrainings_id"];
    $training = $row["training"];
    $startDate = $row["startDate"];
    $endDate = $row["endDate"];
    $startDate = $startDate."T08:00:00";
    $groupId = null;

if ($startDate !== $endDate) {
      $endDate = $endDate."T12:00:00";
      $groupId = $personneltrainings_id;
    }

    $inside_events = array(
      'groupId' => $groupId,
      'title' => $training, 
      'start' => $startDate, 
      'end' => $endDate,
      'url' => "../hris/personneltrainingspreview.php?personneltrainings_id=".$personneltrainings_id
      
    );

    array_push($events, $inside_events);
  }

  $sql = "SELECT * FROM `requestandcoms` WHERE `isMeeting` != 'yes' AND `isMeeting` != ''";
  $result = $mysqli->query($sql);
  while ($row = $result->fetch_assoc()) {

    $subject = $row["subject"];
    $fromDate = $row["fromDate"];
    $toDate = $row["toDate"];

    $fromDate = $fromDate."T08:00:00";
if ($fromDate !== $toDate) {
      $toDate = $toDate."T17:00:00";
    }

    $inside_events = array(
      'title' => $subject, 
      'start' => $fromDate, 
      'end' => $toDate
    );

    // array_push($events, $inside_events);
  }


  echo json_encode($events);
?>,