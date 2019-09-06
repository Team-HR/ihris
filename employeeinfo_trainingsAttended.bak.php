<?php
require_once "_connect.db.php";

$employees_id = $_GET["employees_id"];

$sql = "SELECT * FROM `personneltrainingslist` WHERE `employees_id` = '$employees_id'";
$result = $mysqli->query($sql);
?>
  <script type="text/javascript">
    $(document).ready(function(){
      $(function() {
        $("#myTable").tablesorter({
          sortList: [[2,1]]
        });
      });
    });
</script>
  <table id="myTable" class="ui very basic celled table tablesorter" style="font-size: 12px">
    <thead>
    <tr>
        <th>Title of Training</th>
        <!-- <th>Remarks</th> -->
        <th>Date</th>
        <th>No. of Hours</th>
        <th>Venue</th>
    </tr>
    </thead>
    <tbody>
<?php

if (empty($result->num_rows)) {
?>
  <tr>
    <td colspan="5" style="text-align: center">No Trainings Attended</td>
  </tr>
<?php
}
while ($row = $result->fetch_assoc()) { 
  $personneltrainings_id = $row["personneltrainings_id"];
  $sqlFetchData = "SELECT * FROM `personneltrainings` WHERE `personneltrainings_id` = '$personneltrainings_id'";
  $resultFetchData = $mysqli->query($sqlFetchData);
  $rowFetchData = $resultFetchData->fetch_assoc();
  $training_id = $rowFetchData["training_id"];
  $startDate = $rowFetchData["startDate"];
  $endDate = $rowFetchData["endDate"];
  $numHours = $rowFetchData["numHours"];
  $venue = $rowFetchData["venue"];
  $remarks = $rowFetchData["remarks"];
  //get training title start
  $sqlGetTitle = "SELECT * FROM `trainings` WHERE `training_id` = $training_id";
  $resultGetTitle = $mysqli->query($sqlGetTitle);
  $rowGetTitle = $resultGetTitle->fetch_assoc();
  $trainingTitle = $rowGetTitle["training"];
  //get training title end

  ?>
  <tr>
    <td><?php echo "$trainingTitle";?></td>
    <!-- <td><?php echo $remarks;?></td> -->
    <td>
      <?php 
      // echo date("F d", strtotime($startDate))." - ".date("d, Y", strtotime($endDate));-+4
      if ($numHours == "8") {
        # code...
        echo date("F d, Y", strtotime($startDate));
      } else {
        echo date("F d", strtotime($startDate))." - ".date("d, Y", strtotime($endDate));
      }
      ?>    
    </td>
    <td><?php echo $numHours;?></td>
    <td><?php echo $venue;?></td>
  </tr>
  <?php
  }
  //for training request below
  $sqlGetControlNum = "SELECT * FROM `requestandcomslist` WHERE `employees_id` = '$employees_id'";
$resultGetControlNum = $mysqli->query($sqlGetControlNum);
while ($rowGetControlNum = $resultGetControlNum->fetch_assoc()) {
  $controlNumber = $rowGetControlNum["controlNumber"];
  $sqlFetchDataTrainingRequest = "SELECT * FROM `requestandcoms` WHERE `controlNumber` = '$controlNumber' AND `isMeeting` = 'no'"; 
  $resultFetchDataTrainingRequest = $mysqli->query($sqlFetchDataTrainingRequest);

  if ($resultFetchDataTrainingRequest->num_rows != 0) {
      # code...

    $rowResultFetchDataTrainingRequest = $resultFetchDataTrainingRequest->fetch_assoc();
  $training = addslashes($rowResultFetchDataTrainingRequest["subject"]);
  $remarks = addslashes($rowResultFetchDataTrainingRequest["remarks"]);
  $fromDate = $rowResultFetchDataTrainingRequest["fromDate"];
  $toDate = $rowResultFetchDataTrainingRequest["toDate"];
  $venue = addslashes($rowResultFetchDataTrainingRequest["venue"]);
  $numHours =  getNumHours($fromDate,$toDate);

  ?>
  <tr>
    <td><?php echo "$training";?></td>
    <!-- <td><?php echo $remarks;?></td> -->
    <td>
      <?php 
      if ($numHours == "8") {
        # code...
        echo date("F d, Y", strtotime($fromDate));
      } else {
        echo date("F d", strtotime($fromDate))." - ".date("d, Y", strtotime($toDate));
      }
      ?>    
    </td>
    <td><?php echo $numHours;?></td>
    <td><?php echo $venue;?></td>
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
?>