<?php 

$title = "Comparative Data";
require "_connect.db.php"; 
require "header.php";

if ($rspvac_id = $_GET["rspvac_id"]) {
  
  $sql = "SELECT * FROM `rsp_vacant_positions` WHERE `rspvac_id` = ?";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("i",$rspvac_id);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($rspvac_id, $positiontitle, $itemNo, $sg, $office, $dateVacated, $dateOfInterview, $education, $training, $experience, $eligibility, $datetime_added);
  $stmt->fetch();
  $stmt->close();
}



?>

<!-- <script type="text/javascript" src="scripts/Departments.js"></script> -->

<script type="text/javascript">
 $(document).ready(function() {
  // $.each($(".inputLister"), function(index, val) {
     /* iterate through array or object */
  // });
    $("#table_search").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#tableBody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

    $(load);
    // $("#office").html(office.render());
    $("#sortYear").dropdown();


    $('#officeDropdown').dropdown();



 });

function load(){
  $.post('comparativeDataInfo_proc.php',{
    load: true,
    rspvac_id: <?=$rspvac_id?>
  },function(data){
    arr = JSON.parse(data);
    $("#itemNoTitle").html(arr.itemNo);
    $("#positiontitle").html(arr.position);
    $("#educationTitle").html(arr.education);
    $("#officeTitle").html(arr.office);
    $("#trainingTitle").html(arr.training);
    $("#experienceTitle").html(arr.experience);
    $("#eligibilityTitle").html(arr.eligibility);
    $(loadList);
  });
  
}

function loadList(){


  $.post('comparativeDataInfo_proc.php',{
    loadList: true,
    rspvac_id: <?=$rspvac_id?>
  },function(data){
    // arr = JSON.parse(data);
    // $("#positiontitle").html(arr.position);
    $("#tableBody").html(data);
    // $("#experience").html(data.)
    // $("#training").html(data.)
    // $("#eligibility").html(data.)
    // $(clearFormData);
  });
}

  function deleteEntry(id){
    $("#deleteModal").modal({
      onApprove: function (){
        $.post('comparativeDataInfo_proc.php', {
          deleteEntry: true,
          rspcomp_id: id,
        }, function(data, textStatus, xhr) {
          $(loadList);
        });
      },
    }).modal('show');
  }

  function dateInterviewed(id,interviewed){
    // alert(id)
    $("#inputDateInterviewed").val(interviewed);

    $('#dateInterviewedModal').modal({
      closable: false,
      onApprove: function(){
        // alert(id);
        $.post('comparativeDataInfo_proc.php', {
          dateInterviewed: true,
          id: id,
          date: $("#inputDateInterviewed").val()
        }, function(data, textStatus, xhr) {
          loadList();
        });

      }
    }).modal("show");
  }
</script>
<?php
require "rsp_addApplicant_modal.php";
?>
  <div class="ui mini modal" id="dateInterviewedModal">
    <div class="header">
      Date Interviewed
    </div>
    <div class="content">
    <div class="ui fluid input">
      <input type="date" id="inputDateInterviewed">
    </div>
      
    </div>
    <div class="actions">
      <div class="ui mini basic button deny">Cancel</div>
      <div class="ui mini basic button green approve">Save</div>
    </div>
  </div>

  <div class="ui mini modal" id="deleteModal">
    <div class="ui blue header"><i class="icon trash"></i> Unlist Applicant?</div>
    <div class="content"><p><span><i class="icon big blue warning"></i></span> Are you sure you want to unlist this applicant?</p></div>
    <div class="actions">
      <button class="ui tiny basic button approve"><i class="icon check"></i>Yes</button>
      <button class="ui tiny basic button deny"><i class="icon cancel"></i>No</button>
    </div>
  </div>
<!-- <div class="ui container" style="padding:/* 20px*/;"> -->
  <div class="ui containerA" style="padding-left: 20px; padding-right: 20px;">
  <div class="printOnly" style="padding-top: 5px !important;"></div>
  <div class="ui borderless blue inverted mini menu">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.location.href='comparativeData.php';" class="blue ui icon button noprint" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
    <div class="item">
     <h3><i class="pie chart icon"></i> Comparative Data <i class="caret right icon"></i> <?=$positiontitle;?></h3>
   </div>

    <div class="right item noprint">
      <button onclick="print()" class="blue ui icon button" title="Print" style="margin-right: 5px;">
        <i class="icon print"></i> Print
      </button>
<!--      <a class="ui blue icon button" title="Evaluation Report" style="margin-right: 5px;">
        <i class="icon chart bar"></i> Evaluation Report
      </a> -->
    </div>
</div>

  <!-- <div class="ui segments"> -->
    <style type="text/css">
      .actives{
        text-align: right !important;
        width: 175px;
        background-color: #f2f2f2;
        color: #4075a9;
      }
      .ui.tab.segment{
        min-height: 300px;
      }
    </style>

    <table class="ui very compact small celled table printCompactText" style="font-size: 14px;">
      <tr>
        <td class="actives">VACANT POSITION:</td>
        <td id="positiontitle"><i style="color: grey;">n/a</i></td>
        <td class="actives">CSC ITEM NO:</td>
        <td id="itemNoTitle"><i style="color: grey;">n/a</i></td>
      </tr>
      <tr>
        <td class="actives">EDUCATION:</td>
        <td id="educationTitle"><i style="color: grey;">n/a</i></td>
        <td class="actives">OFFICE:</td>
        <td id="officeTitle"><i style="color: grey;">n/a</i></td>
      </tr>
      <tr>
        <td class="actives">EXPERIENCE:</td>
        <td colspan="3" id="experienceTitle"><i style="color: grey;">n/a</i></td>
      </tr>
      <tr>
        <td class="actives">TRAINING:</td>
        <td colspan="3" id="trainingTitle"><i style="color: grey;">n/a</i></td>
      </tr>
      <tr>
        <td class="actives">ELIGIBILITY:</td>
        <td colspan="3" id="eligibilityTitle"><i style="color: grey;">n/a</i></td>
      </tr> 
    </table>

  <style type="text/css">
    .heads {
      padding: 2px !important;
    }
  </style>
<!--   <div class="ui modal" id="addApplicant">
    <div class="header">Testing Transitions</div>
    <div class="content" id="addApplicantContainer">
      <div class="ui form">
        <div class="field">
          <label>Name:</label>
          <input type="text" name="">
        </div>
      </div>
    </div>
    <div class="actions">
      <button class="ui tiny basic blue approve button">Save</button>
      <button class="ui tiny basic deny button">Close</button>
    </div>
  </div> -->

  <button onclick="addApplicant()" class="ui basic tiny green button noprint" title="Add applicant to the list"><i class="icon add"></i> Add Applicant</button>
  <table id="trTable" class="ui blue selectable structured celled very compact table printCompactText" style="font-size: 12px;">
    <thead>
      <tr style="text-align: center;">
        <th class="heads">No.</th>
        <th class="heads">Name</th>
        <th class="heads">Age</th>
        <th class="heads">Gender</th>
        <th class="heads">Years in <br> Gov't</th>
        <th class="heads">Civil Status</th>
        <th class="heads">Education</th>
        <th class="heads">Training</th>
        <th class="heads">Experience</th>
        <th class="heads">Eligibility</th>
        <th class="heads">Awards, Citations<br>Received</th>
        <th class="heads">Records <br>of<br> Infractions</th>
        <th class="heads noprint"></th>
      </tr>
    </thead>
    <tbody id="tableBody">
        <tr id="loading_el">
          <td colspan="13" style="text-align: center; font-size: 32px; color: lightgrey; padding: 100px;">
            <!-- FETCHING DATA... -->
            <img src="assets/images/loading.gif" style="height: 50px; margin-top: -100px;">
            <br>
            <span>Fetching data...</span>
          </td>
        </tr>
    </tbody>
  </table>
  <!-- </div> -->
</div>
<?php require_once "footer.php";?>
