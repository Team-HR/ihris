<?php
$title = "Plantilla Details";
require_once "header.php";
$id = $_GET["id"];

// $sql = "SELECT *,`plantillas`.`position_id` AS `post_id` ,`plantillas`.`department_id` AS `dept_id`,`appointments`.`casual_promotion` AS `casualPromotion`
//                      FROM `plantillas` 
//                      LEFT JOIN `department` ON `plantillas`.`department_id` = `department`.`department_id`  
//                      LEFT JOIN `positiontitles` ON `plantillas`.`position_id` = `positiontitles`.`position_id` 
//                      LEFT JOIN `employees` ON `plantillas`.`incumbent`= `employees`.`employees_id`
//                      LEFT JOIN appointments ON `plantillas`.`id` = `appointments`.`plantilla_id`
//                      LEFT JOIN statement_of_duties ON plantillas.position_id = statement_of_duties.position_id 
//                      WHERE `id` = '$id'";  
$sql = "SELECT *,`plantillas`.`position_id` AS `post_id` ,`plantillas`.`department_id` AS `dept_id`,`appointments`.`casual_promotion` AS `casualPromotion`
                       FROM `plantillas` 
                       LEFT JOIN `department` ON `plantillas`.`department_id` = `department`.`department_id`  
                       LEFT JOIN `positiontitles` ON `plantillas`.`position_id` = `positiontitles`.`position_id` 
                       LEFT JOIN `appointments` ON `plantillas`.`incumbent` = `appointments`.`appointment_id`
                       LEFT JOIN `employees` ON `appointments`.`employee_id`= `employees`.`employees_id`
                       WHERE `plantillas`.`id` = '$id'";


$result = $mysqli->query($sql);
$row = $result->fetch_assoc();

$sql2 = "SELECT appointments.appointment_id, 
      employees.employees_id, 
      employees.firstName, 
      employees.lastName, 
      employees.middleName, 
      employees.extName, 
      appointments.reason_of_vacancy,
      appointments.employee_id
    FROM plantillas LEFT JOIN appointments ON plantillas.vacated_by = appointments.appointment_id LEFT JOIN employees ON appointments.employee_id = employees.employees_id
    WHERE
      plantillas.id = '$row[id]'";

$sql2 = $mysqli->query($sql2);
$sql2 = $sql2->fetch_assoc();

$sql3 = "SELECT
      appointments.appointment_id, 
      employees.employees_id, 
      employees.firstName, 
      employees.lastName, 
      employees.middleName, 
      employees.extName,
      appointments.employee_id
    FROM
      plantillas LEFT JOIN appointments ON plantillas.incumbent = appointments.appointment_id LEFT JOIN employees ON appointments.employee_id = employees.employees_id
    WHERE
      plantillas.id = '$row[id]'";
$sql3 = $mysqli->query($sql3);
$sql3 = $sql3->fetch_assoc();


$sql4 = "SELECT * FROM  `plantillas` LEFT JOIN `qualification_standards` ON `plantillas`.`position_id`= `qualification_standards`.`position_id` WHERE `plantillas`.`id`='$id' ";
$sql4 = $mysqli->query($sql4);
$sql4 = $sql4->fetch_assoc();


$sql6 = "SELECT
      employees.employees_id, 
      employees.firstName, 
      employees.lastName, 
      employees.middleName, 
      employees.extName
    FROM
      appointments
      INNER JOIN
      employees
      ON 
      appointments.supervisor = employees.employees_id
      WHERE
      appointments.appointment_id = '$row[appointment_id]'";
$sql6 = $mysqli->query($sql6);
$sql6 = $sql6->fetch_assoc();

$id = $row["id"];
$statement_id = isset($row["statement_id"]) ? $row["statement_id"] : '';
$no = isset($row["no"]) ? $row["no"] : '';
$workstatement = isset($row["workstatement"]) ? $row["workstatement"] : '';
$level = $row["level"];
$category = $row["category"];
$item_no = $row["item_no"];
$position = addslashes($row["position"]);
$functional = addslashes($row["functional"]);
$department = $row["department"];
$department_id = $row["department_id"];
$office_assignment = $row["office_assignment"];
$date_of_appointment = $row["date_of_appointment"];
$casual_promotion = $row["casualPromotion"];
$date_of_last_promotion = $row["date_of_last_promotion"];
$step = $row["step"];
$abolish = $row["abolish"];
$no = isset($row["no"]) ? $row["no"] : '';
$percentile = isset($row["percentile"]) ? $row["percentile"] : '';
$workstatement = isset($row["workstatement"]) ? $row["workstatement"] : '';
if (!$row['reason_of_vacancy']) {
  $reason_of_vacancy = "<i style='color:grey'>N/A</i>";
} else {
  $reason_of_vacancy = addslashes($sql2["reason_of_vacancy"]);
}

if (!$row['incumbent']) {
  $incumbent = "<i style='color:grey'>N/A</i>";
} else {
  $incumbent = $sql3['firstName'] . " " . $sql3['middleName'] . " " . $sql3['lastName'] . " " . $sql3['extName'];
}

if (!$row['supervisor']) {
  $supervisor = "<i style='color:grey'>N/A</i>";
} else {
  $supervisor =  $sql6['firstName'] . " " . $sql6['middleName'] . " " . $sql6['lastName'] . " " . $sql6['extName'];
}

if (!$row['vacated_by']) {
  $vacated_by = "<i style='color:grey'>N/A</i>";
} else {
  $vacated_by =  $sql2['firstName'] . " " . $sql2['middleName'] . " " . $sql2['lastName'] . " " . $sql2['extName'];
}


if (isset($_POST["addDuties"])) {

  $no = $_POST["no"];
  $percentile = $_POST["percentile"];
  $workstatement = $_POST["workstatement"];

  $sql = "INSERT INTO `statement_of_duties` (`id`, `position_id`, `no`, `percentile`, `workstatement`) VALUES (NULL, NULL,  '$no', '$percentile', '$workstatement',)";
  $mysqli->query($sql);
  echo $mysqli->error;
} elseif (isset($_POST["deleteData"])) {
  $statement_id = $_POST["statement_id"];
  $sql = "DELETE FROM `statement_of_duties` WHERE `statement_of_duties`.`statement_id` = '$statement_id'";
  $mysqli->query($sql);
} elseif (isset($_POST["editData"])) {
  $statement_id = $_POST["statement_id"];
  $no = $_POST["no"];
  $percentile = $_POST["percentile"];
  $workstatement = $_POST["workstatement"];
  $sql = "UPDATE `statement_of_duties` SET
                       `no` = '$no',  
                       `percentile` = '$percentile',
                       `workstatement` = '$workstatement'
                      
                       WHERE `statement_id` = '$statement_id' ";
  $mysqli->query($sql);
  echo $mysqli->error;
}

?>


<script type="text/javascript">
  $(document).ready(function() {
    $("#tabs .item").tab();
  });

  function editDetailsModal() {
    $("#editPosition").dropdown('set selected', <?= $row['post_id'] ?>);
    $("#editDept").dropdown('set selected', <?= $row["dept_id"] ?>);
    $("#editStep").val(<?= $row['step'] ?>);
    $("#editSchedule").dropdown('set selected', <?= $row['schedule'] ?>);
    $("#editItem").val('<?= $item_no ?>');
    $("#editAbolish").dropdown('set selected', '<?= $abolish ?>');
    $("#originalAppointmentDate").val('<?= $date_of_appointment ?>');
    $("#casualPromotion").val('<?= $casual_promotion ?>');
    $("#lastPromotion").val('<?= $date_of_last_promotion ?>');
    $('#editDetailsModal').modal({
      onApprove: function() {
        // alert($("#editDeptInput").val());
        $.post('plantilla_proc.php', {
          editPlantilla: true,
          id: <?= $_GET['id'] ?>,
          incumbent: <?= $row['incumbent'] ?>,
          position: $("#editPosition").val(),
          department: $("#editDept").val(),
          schedule: $("#editSchedule").val(),
          step: $("#editStep").val(),
          item_no: $("#editItem").val(),
          abolish: $("#editAbolish").val(),
          originalAppointmentDate: $('#originalAppointmentDate').val(),
          casualPromotion: $('#casualPromotion').val(),
          date_of_last_promotion: $('#lastPromotion').val()
        }, function(data, textStatus, xhr) {
          window.location.reload();
        });
      },
    }).modal('show');
  }

  function fullScrnEmp(id) {
    document.getElementById("iframEmp").src = "employeeinfo.v2.php?employees_id=" + id;
    // $("#iframEmp")[0].attributes.src = "google.com";
    $("#fullScrnEmp").modal({
      onApprove: function() {
        window.location.reload();
      }
    }).modal('show');
  }


  /*function addRow(){
    $.post("plantilla_detail.php",{
      addDuties:true,
      no: $("#addNo").val(),
      percentile: $("#addPercentile").val(),
      workstatement: $("#addWorkStatement").val(),
    },function(data,status){  
      $(load);
      alert(data);
  
    });
  } 

  function addRowFunc(){
    $("#addModal").modal({
        onApprove : function() {
          $(addDuties);
        // save msg animation start 
          $("#saveMsg").transition({
            animation: 'fly down',
            onComplete: function () {
              setTimeout(function(){ $("#saveMsg").transition('fly down'); }, 1000);
            }
          });
        // save msg animation end
      }
    }).modal("show");
  
  }*/

  function deleteRow(statement_id) {
    $("#deleteModal").modal({
      onApprove: function() {
        $.post('plantilla_detail.php', {
          deleteData: true,
          statement_id: statement_id,
        }, function(data, textStatus, xhr) {

          window.location.reload();
        });
      }
    }).modal("show");
  }


  function editRow(statement_id, no, percentile, workstatement) {

    $("#editNo").val(no);
    $("#editPercentile").val(percentile);
    $("#editWorkstatement").val(workstatement);
    $("#editModal").modal({
      onApprove: function() {
        $.post('plantilla_detail.php', {
          editData: true,
          statement_id: statement_id,
          no: $("#editNo").val(),
          percentile: $("#editPercentile").val(),
          workstatement: $("#editWorkstatement").val(),
        }, function(data, textStatus, xhr) {
          window.location.reload();
        });
      }
    }).modal("show");
  }
</script>

<style type="text/css">
  .actives {
    background-color: #f2f2f2;
    color: #4075a9;
  }
</style>

<div id="duties_app">

  <div class="ui overlay fullscreen modal" id="fullScrnEmp">
    <div class="header">Employee Information</div>
    <iframe class="content" id="iframEmp" src="" frameborder="0"></iframe>
    <div class="actions">
      <div class="ui approve button">DONE</div>
    </div>
  </div>
  <div class="ui container">
    <div class="ui borderless blue inverted mini menu">
      <div class="left item" style="margin-right: 0px !important;">
        <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
          <i class="icon chevron left"></i> Back
        </button>
      </div>

      <div class="item">
        <h4 style="color: white;">
          <?php
          echo $position;
          if ($functional) {
            echo "($functional)";
          }
          ?></h4>
      </div>
      <!--- <h3><i class=" icon"></i> Department Setup</h3>---->
    </div>
  </div>

  <br>


  <div class="ui segment container">
    <div class="ui top attached tabular menu" id="tabs">
      <a class="item active" data-tab="details">PLANTILLA DETAILS</a>
      <a class="item" data-tab="statement" @click="positionId=<?= $row['post_id'] ?>">STATEMENT OF DUTIES</a>
      <a class="item" data-tab="qualification">QUALIFICATION STANDARDS</a>
    </div>
    <div class="ui bottom attached segment tab active" data-tab="details">

      <table class="ui very compact small celled table" style="font-size: 12px;">
        <tr>
          <td class="actives">ITEM_NO</td>
          <td><?= $item_no ?></td>
        </tr>
        <tr>
          <td class="actives">POSITION TITLE</td>
          <td><?= $position ?></td>
        </tr>
        <tr>
          <td class="actives">FUNCTION</td>
          <td><?= $functional ?></td>
        </tr>
        <tr>
          <td class="actives">DEPARTMENT</td>
          <td><?= $department ?></td>
        </tr>
        <tr>
          <td class="actives">STEP NO</td>
          <td><?= $step ?></td>
        </tr>
        <td class="actives">ORIGINAL APPOINTMENT</td>
        <td><?= $date_of_appointment ?></td>
        <tr>
          <td class="actives">OFFICE ASSIGNMENT</td>
          <td><?= $office_assignment ?></td>
        </tr>
        <tr>
          <td class="actives">PAGE NO</td>
          <td></td>
        </tr>
        <tr>
          <td class="actives">LAST DATE OF PROMOTION</td>
          <td><?= $date_of_last_promotion ?></td>
        </tr>
        <tr>
          <td class="actives">INCUMBENT EMPLOYEE</td>
          <td><?= $incumbent ?>
            <a href="#" onclick="fullScrnEmp(<?= $row['employees_id'] ?>)">
              <i class="edit icon"></i>
            </a>
            <!-- <a href="employeeinfo.v2.php?employees_id=<?= $row['employees_id'] ?>" class="ui icon" target="_blank">
                      <i class="edit icon"></i>
                  </a> -->

          </td>
        <tr>
          <td class="actives">LEVEL / CATEGORY</td>
          <td><?= $category ?> / <?= $level ?></td>
        </tr>
        <tr>
          <td class="actives">VACATED BY</td>
          <td><?= $vacated_by ?></td>
        </tr>
        <tr>
          <td class="actives">REASON OF VACANCY</td>
          <td><?= $reason_of_vacancy ?></td>
        </tr>
        <tr>
          <td class="actives">SUPERVISOR</td>
          <td><?= $supervisor ?></td>
        </tr>
        <tr>
          <td class="actives">ABOLISH</td>
          <td><?= $abolish ?></td>
        </tr>
      </table>
      <!-- ********************************************************** -->
      <!-- ********************************************************** -->
      <!-- ********************************************************** -->
      <!-- **EDIT***EDIT***EDIT**EDIT******EDIT******EDIT************ -->
      <!-- ********************************************************** -->
      <!-- ********************************************************** -->
      <!-- ********************************************************** -->

      <div id="editDetailsModal" class="ui mini modal">
        <div class="header">
          Edit Plantilla Detail
        </div>
        <div class="content">
          <div class="ui form">
            <div class="field">
              <label>Department:</label>
              <select class="ui search dropdown" id="editDept">
                <option value="">Select Department</option>
                <?php
                $result = $mysqli->query("SELECT * FROM `department`");
                while ($dep = $result->fetch_assoc()) {
                  $department_id = $dep["department_id"];
                  $department = $dep["department"];
                  print "<option value=\"{$department_id}\">{$department}</option>";
                }
                ?>
              </select>
            </div>
            <div class="field">
              <label>Position:</label>
              <select class="ui search dropdown" id="editPosition">
                <option value="">Select Position</option>
                <?php
                $result = $mysqli->query("SELECT * FROM `positiontitles`");
                while ($posLoop = $result->fetch_assoc()) {
                  $position_id = $posLoop["position_id"];
                  $position = $posLoop["position"];
                  $functional = "";
                  if ($posLoop["functional"]) {
                    $functional = "(" . $posLoop["functional"] . ")";
                  }
                  print "<option value=\"{$position_id}\">{$position} {$functional}</option>";
                }
                ?>
              </select>
            </div>

            <div class="two fields">

              <div class="field">
                <label>Step No.</label>
                <input id="editStep" type="number" placeholder="Step No" autofocus>
              </div>


              <div class="field">
                <label>Item No:</label>
                <input id="editItem">
              </div>

            </div>


            <div class="field">
              <label>Salary Shedule</label>
              <select id="editSchedule" class="ui search dropdown">
                <option value="">---</option>
                <option value="1">1st Class</option>
                <option value="2">2nd Class</option>
              </select>
            </div>

            <div class="field">
              <label>Abolish ?:</label>
              <select class="ui search dropdown" id="editAbolish">
                <option value="">---</option>
                <option value="No" selected>No</option>
                <option value="Yes">Yes</option>
              </select>
            </div>

            <div class="field">
              <label>Original Appointment Date</label>
              <input type="date" id="originalAppointmentDate">
            </div>

            <div class="field">
              <label>Casual Promotion</label>
              <input type="date" id="casualPromotion">
            </div>

            <div class="field">
              <label>Date of Last Promotion</label>
              <input type="date" id="lastPromotion">
            </div>

          </div>
        </div>
        <div class="actions">
          <div class="ui deny button mini">
            Cancel
          </div>
          <div class="ui blue right labeled icon approve button mini">
            Update
            <i class="checkmark icon"></i>
          </div>
        </div>
      </div>



      <center>
        <button class="ui vertical animated positive button" onclick="editDetailsModal()">
          <div class="hidden content">
            <i class="pencil icon"></i>
          </div>
          <div class="visible content">
            Edit
          </div>
        </button>
      </center>

      <!-- ********************************************************** -->
      <!-- ********************************************************** -->
      <!-- ********************************************************** -->
      <!-- **EDIT***EDIT***EDIT**EDIT******EDIT******EDIT************ -->
      <!-- ********************************************************** -->
      <!-- ********************************************************** -->
      <!-- ********************************************************** -->


    </div>
    <div class="ui bottom attached segment tab" data-tab="statement">
      <!-- ang php js og uban pa na files na related sa statement 
                        of duties ani na page is location inside 
                        umbra/statementOfDutiesPlanttilla
                  -->
      <!-- sorry sa libog kay libog na ni daan :P :P -->
      <!-- by:Umbra -->
      <table class="ui celled table">
        <thead>
          <tr>
            <th>No.</th>
            <th>Work Statement</th>
            <th>Percent</th>
          </tr>
        </thead>
        <tbody>
          <template v-if="Duties.length">
            <tr v-for="(work,index) in Duties" :key="index">
              <td>{{work.no}}</td>
              <td>{{work.workstatement}}</td>
              <td>{{work.percentile}} %</td>
            </tr>
          </template>
          <template v-else>
            <tr>
              <td colspan="3">
                <h1 style="text-align:center">No Records</h1>
              </td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>
    <div class="ui bottom attached segment tab" data-tab="qualification">
      <div id="sectionsContainer">
        <div class="ui form">

          <table class="ui very compact small celled table" style="font-size: 12px;">
            <tbody>
              <tr>
                <td class="actives"><b>Education</b></td>
                <td><?= $sql4['education'] ?></td>
              </tr>
              <tr>
                <td class="actives"><b>Training</b></td>
                <td><?= $sql4['training'] ?></td>
              </tr>
              <tr>
                <td class="actives"><b>Experience</b></td>
                <td><?= $sql4['experience'] ?></td>
              </tr>
              <tr>
                <td class="actives"><b>Eligibility</b></td>
                <td><?= $sql4['eligibility'] ?></td>
              </tr>
              <tr>
                <td class="actives"><b>Competency</b></td>
                <td><?= $sql4['competency'] ?></td>
              </tr>
              <tr>
                <td class="actives"><b>Others</b></td>
                <td><?= $sql4['others'] ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div>
      </div>
    </div>
  </div>
</div>
<?php
require_once "footer.php";
?>
<script src="umbra/statementOfDutiesPlanttilla/plantilla_detail.js"></script>