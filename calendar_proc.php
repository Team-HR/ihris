<?php
require '_connect.db.php';

if (isset($_POST["getCalendarData"])) {

  $events = array();
  $sql = "SELECT * FROM `personneltrainings` RIGHT JOIN `trainings` on `personneltrainings`.`training_id` = `trainings`.`training_id`";
  $result = $mysqli->query($sql);
  while ($row = $result->fetch_assoc()) {
    $personneltrainings_id = $row["personneltrainings_id"];
    $training = $row["training"];
    $startDate = $row["startDate"];
    $endDate = $row["endDate"];
    // $startDate = $startDate;
    $timeStart = $row["timeStart"];
    $timeEnd = $row["timeEnd"];
    $groupId = null;

if ($startDate !== $endDate) {
  /*
  commented this out since time is already given	
		$date = new DateTime($endDate);
		$date->modify('+1 day');
		$endDate = $date->format('Y-m-d');
  */
    $groupId = $personneltrainings_id;
}

if ($timeStart !== null) {
      $startDate .= "T".$timeStart;
    } else {
      $startDate .= "T08:00:00";
    }

if ($timeEnd !== null) {
      $endDate .= "T".$timeEnd;
    } else {
      $endDate .= "T17:00:00";
    }

    $inside_events = array(
      'groupId' => $groupId,
      'title' => $training, 
      'start' => $startDate, 
      'end' => $endDate,
      'color' => "#4075a9",
      'url' => "personneltrainingspreview.php?personneltrainings_id=".$personneltrainings_id
      
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

// $date = new DateTime('2000-12-31');
// $date->modify('+1 day');
// echo $date->format('Y-m-d') . "\n";	

} 
