<?php
$title = "Plantilla Details"; 
require_once "header.php";
$id = $_GET["id"];

  
$sql = "SELECT *,`plantillas`.`position_id` AS `post_id` ,`plantillas`.`department_id` AS `dept_id` ,`plantillas`.`schedule` AS `sched` 

                     FROM `plantillas` LEFT JOIN `department` ON `plantillas`.`department_id` = `department`.`department_id`  
                    LEFT JOIN `positiontitles` ON `plantillas`.`position_id` = `positiontitles`.`position_id` 
                    LEFT JOIN `employees` ON `plantillas`.`incumbent`= `employees`.`employees_id`  WHERE `id` = '$id';
      ";  

$result = $mysqli->query($sql);
$counter = 0;
while ($row = $result->fetch_assoc()) {

   $sql2 = "SELECT * FROM  `plantillas` LEFT JOIN `employees` ON `plantillas`.`vacated_by`= `employees`.`employees_id` WHERE `vacated_by` ='$row[vacated_by]' ";
    $sql2 = $mysqli->query($sql2);
    $sql2 = $sql2 ->fetch_assoc();

   $sql4= "SELECT * FROM  `plantillas` LEFT JOIN `qualification_standards` ON `plantillas`.`position_id`= `qualification_standards`.`position_id` WHERE `plantillas`.`id`='$id' "; 
    $sql4 = $mysqli->query($sql4);
    $sql4 = $sql4 ->fetch_assoc();

    $sql5= "SELECT *  FROM  `plantillas` LEFT JOIN `statement_of_duties` ON `plantillas`.`position_id`= `statement_of_duties`.`position_id` WHERE `plantillas`.`id`='$id' "; 
    $sql5 = $mysqli->query($sql5);
    $sql5 = $sql5 ->fetch_assoc();

  $id = $sql5["id"];
  $level = $row["level"];
  $category = $row["category"];
  $item_no = $row["item_no"];
  
  $position= addslashes($row["position"]);
  $functional= $row["functional"];
  $department= $row["department"];
 
    $firstName  = $row["firstName"];
    $lastName = $row["lastName"];
    
    if ($row["middleName"] == "") {
      $middleName = "";
    } else {
      $middleName = $row["middleName"];
      $middleName = $middleName[0]." ";
    }

    $extName  = strtoupper($row["extName"]);
    $exts = array('JR','SR');

    if (in_array(substr($extName,0,2), $exts)) {
      $extName = " ";

    } else {
      $extName = " ".$extName;
    }
    
    if (!$lastName) {
      $lastName = "<i style='color:grey'>N/A</i>";
    }
    
    $fullname = (" $firstName $middleName $lastName ").$extName;
   $step= $row["step"];
   $vacated_by= $row["vacated_by"];
   $abolish= $row["abolish"];

}
if (isset($_POST["addWorkStatement"])) {

  $no = $_POST["no"];
  $percentile = $_POST["percentile"];
  $workstatement = $_POST["workstatement"];

    $sql5 = "INSERT INTO `statement_of_duties` (`id`, `position_id`, `no`, `percentile`, `workstatement`) VALUES (NULL, NULL,  '$no', '$percentile', '$workstatement',)";
    $mysqli->query($sql5);
    echo $mysqli->error;
}

?>


<script type="text/javascript">

$(document).ready(function() {  
        $("#tabs .item").tab();

  });

function load(){
    $("#tableContent").load("plantilla_proc.php",{
      load: true
    });
  }
function addWorkStatement(){
    $.post("plantilla_detail.php",{
      addWorkStatement:true,
      no: $("#addNo").val(),
      percentile: $("#addPercentile").val(),
      workstatement: $("#addWorkStatement").val(),
    },function(data,status){  
      $(load);
  
    });
  } 
  function addModalFunc(){
    $("#addModal").modal({
        onApprove : function() {
          $(addWorkStatement);
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
  
  }

   function editRow(id,position,incumbent,department,office, step, schedule,item_no,page_no,original_appointment,last_promotion,casual_promotion,
                      vacated_by,reason_of_vacancy,other,supervisor,abolish){

    // alert(position);
    $("#editPos").dropdown('set selected',position);
    $("#editDept").dropdown('set selected',department);
    $("#editIncumbent").dropdown('set selected',incumbent);
    $("#editOffice").val(office).change();
    $("#editStep").val(step);
    $("#editSchedule").dropdown('set selected',schedule);
    $("#editItem").val(item_no);
    $("#editPage").val(page_no);
    $("#editOriginal").val(original_appointment);
    $("#editLastPromo").val(last_promotion);
    $("#editCasualPromo").val(casual_promotion);
    $("#editVacator").dropdown('set selected',vacated_by);
    $("#editReason").dropdown('set selected',reason_of_vacancy);
    $("#editOther").val(other);
    $("#editSupervisor").dropdown('set selected',supervisor);
    $("#editAbolish").dropdown('set selected',abolish);


    $("#editModal").modal({
      onApprove: function(){

        // alert($("#editDeptInput").val());
        $.post('plantilla_proc.php', {
          editPlantilla: true,
          id: id,
          position: $("#editPos").val(),
          incumbent: $("#editIncumbent").val(),
          department: $("#editDept").val(),
          office: $("#editOffice").val(),
          schedule: $("#editSchedule").val(),
          step: $("#editStep").val(),
          item_no: $("#editItem").val(),
          page_no: $("#editPage").val(),
          original_appointment: $("#editOriginal").val(),
          last_promotion: $("#editLastPromo").val(),
          casual_promotion: $("#editCasualPromo").val(),
          vacated_by: $("#editVacator").val(),
          reason_of_vacancy: $("#editReason").val(),
          other: $("#editOther").val(),
          supervisor: $("#editSupervisor").val(),
          abolish: $("#editAbolish").val(),

        }, function(data, textStatus, xhr) {
          // alert(data);
         $(load);
        });
      },
    }).modal('show');

  }

</script>

<div id="saveMsg" class="" style="top: 15px; display: none; position: fixed; z-index: 10; width: 100%; left: 0; text-align: center;">
  <div class="ui center green inverted aligned segment" style="width: 100px; margin-left: auto; margin-right: auto;">
    <i class="checkmark icon"></i> Added!
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
          <h4 style="color: white;"><?php echo $position?> (<?=$functional?>)</h4>
        </div>
        <!--- <h3><i class=" icon"></i> Department Setup</h3>---->
      </div>     
</div>



<?php 
 require_once "footer.php";
?>
