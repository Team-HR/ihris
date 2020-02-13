<?php
require_once "_connect.db.php";
$employees_id = $_GET["employees_id"];
?>
  <script type="text/javascript">
    $(document).ready(function(){
        // $(function() {
        //   $("#myTable").tablesorter({
        //     sortList: [[2,1]]
        //   });
        // });
    });
</script>
  <table id="myTable" class="ui very basic celled table tablesorter" style="font-size: 12px">
    <thead>
    <tr>
        <th></th>
        <th>Title of Training</th>
        <!-- <th>Remarks</th> -->
        <th>Date</th>
        <th>No. of Hours</th>
        <th>Venue</th>
    </tr>
    </thead>
    <tbody>
<?php


$trainings_arr = createTrainings($mysqli, $employees_id, "all");

if (empty($trainings_arr)) {
?>
  <tr>
    <td colspan="6" style="text-align: center; color: grey; font-style: italic;">No Trainings Attended</td>
  </tr>
<?php
} else {
$counter = 1;
foreach ($trainings_arr as $key => $value) {
  $numHours = $value["numHours"];
  $startDate = $value["startDate"];
  $endDate = $value["endDate"];
?>
<tr>
    <td><?=$counter++.".)"?></td>
    <td><?=$value["training"]?></td>
    <td style="text-align: center;">
<?php
      if ($numHours === "8") {
        echo date("F d, Y", strtotime($startDate));
      } else {
        echo date("F d", strtotime($startDate))." - ".date("d, Y", strtotime($endDate));
      }
?>
    </td>
    <td style="text-align: center;"><?=$numHours?></td>
    <td><?=$value["venue"]?></td>
</tr>
<?php
  }
}
?>
    </tbody>                       
  </table>

<?php

function getNumHours($date_early,$date_late){
    $date1 = strtotime($date_early);
    $date2 = strtotime($date_late);
    $dateDiff = $date2 - $date1;
    $numHrs = (($dateDiff/ (60 * 60 * 24))*8)+8;
    return $numHrs;
}

function createTrainings($mysqli,$employees_id,$year){

  if ($year !== "all") {
    $filterByYear  = "AND year(personneltrainings.startDate) = '$year'";
    $filterByYear2  = "AND year(`requestandcoms`.`fromDate`) = '$year'";
  } else {
    $filterByYear = "";
    $filterByYear2 = "";
  }


    $arrMaster = array();
    $sql1 = "SELECT * FROM `personneltrainingslist`
        LEFT JOIN personneltrainings
            ON personneltrainingslist.personneltrainings_id = personneltrainings.personneltrainings_id
        LEFT JOIN trainings
            ON personneltrainings.training_id = trainings.training_id
        WHERE `personneltrainingslist`.`employees_id` = '$employees_id' $filterByYear";

    $result1 = $mysqli->query($sql1);
    while ($row1 = $result1->fetch_assoc()) {
        $training = $row1["training"];
        $startDate = $row1["startDate"];
        $endDate = $row1["endDate"];
        $numHours = $row1["numHours"];
        $remarks = $row1["remarks"];
        $venue = $row1["venue"];

        $insertArr = array(
            'training' => $training,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'numHours' => $numHours,
            'remarks' => $remarks,
            'venue' => $venue
        );

        array_push($arrMaster, $insertArr);
    }


    $sql2 = "SELECT * FROM `requestandcoms`
    LEFT JOIN `requestandcomslist`
        ON `requestandcoms`.`controlNumber` = `requestandcomslist`.`controlNumber`
        WHERE `requestandcomslist`.`employees_id` = '$employees_id' AND `requestandcoms`.`isMeeting` != 'yes' $filterByYear2";
    $result2 = $mysqli->query($sql2);
    while ($row2 = $result2->fetch_assoc()) {
        $training = $row2["subject"];
        $startDate = $row2["fromDate"];
        $endDate = $row2["toDate"];
        $numHours = getNumHours($startDate,$endDate);
        $remarks = $row2["remarks"];
        $venue = $row2["venue"];
        $insertArr = array(
            'training' => $training,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'numHours' => $numHours,
            'remarks' => $remarks,
            'venue' => $venue
        );

        array_push($arrMaster, $insertArr);
    } 
        usort($arrMaster, function($a, $b) {
            return $b['startDate'] <=> $a['startDate'];
        });
        
    return $arrMaster;
}

function dateToStr1($numeric_date){
    if ($numeric_date) {
      $date = new DateTime($numeric_date);
      $strDate = $date->format('F d, Y');
    } else {
      $strDate = "<i style=\"color:grey\">N/A</i>";
    }
      
    return $strDate;
}


?>