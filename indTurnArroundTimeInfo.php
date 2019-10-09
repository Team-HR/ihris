<?php 

$title = "Individual Turn Around Time";
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

<link href="jquery_datepick_5.1.0/css/redmond.datepick.css" rel="stylesheet"> 
<script src="jquery_datepick_5.1.0/js/jquery.plugin.min.js"></script>
<script src="jquery_datepick_5.1.0/js/jquery.datepick.js"></script>
<script type="text/javascript">
 
var datesArr = [],
    datePickerBtn = [],
    dateContainer = [];
 $(document).ready(function() {

    $("#table_search").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#tableBody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

    $(load);

    $("#sortYear").dropdown();
    $('#officeDropdown').dropdown();

 });


function load(){
  $.post('indTurnArroundTimeInfo_proc.php',{
    load: true,
    rspvac_id: <?=$rspvac_id?>
  },function(data){
    arr = JSON.parse(data);
    $("#itemNoTitle").html(arr.itemNo);
    $("#positiontitle").html(arr.position);
    $("#salaryGrade").html(arr.sg);
    $("#educationTitle").html(arr.education);
    $("#officeTitle").html(arr.office);
    $("#trainingTitle").html(arr.training);
    $("#experienceTitle").html(arr.experience);
    $("#eligibilityTitle").html(arr.eligibility);
    $(loadList);
  });
  
}

function loadList(){


  $.post('indTurnArroundTimeInfo_proc.php',{
    loadList: true,
    rspvac_id: <?=$rspvac_id?>
  },function(data){
    $("#tableBody").html(data);

    loadDatePicker();

  });
}
  

function loadDatePicker (){

  var arrLikeBtn = document.querySelectorAll(".datePickerBtn");
  var arrLikeContainer = document.querySelectorAll(".dateContainer");
  var arrLikeNumDays = document.querySelectorAll(".numDays");

  datePickerBtn = Array.prototype.slice.call(arrLikeBtn);
  dateContainer = Array.prototype.slice.call(arrLikeContainer);
  numDays = Array.prototype.slice.call(arrLikeNumDays);

$.each(datePickerBtn, function(index, val) {
  datesArr[index] = [];
  $(this).datepick({
    showOnFocus: false,
    dateFormat: 'yyyy-mm-dd',
    multiSelect: 999, 
    onSelect: function (){
      
      dates = $(this).datepick("getDate");
      arr = [];
      
      if (dates.length !== 0) {

        for (var i = 0; i < dates.length; i++) { 
          arr.push($.datepick.formatDate('yyyy-mm-dd',dates[i]));
        } 
        datesArr[index] = arr;
      } else {
        datesArr[index] = [];

      }

      $.post('indTurnArroundTimeInfo_proc.php', {
        rspvac_id: <?=$rspvac_id?>,
        compactDates: true,
        datesAll: datesArr,
        dates: arr,
      }, function(data, textStatus, xhr) {
        if (data) {

            $(dateContainer[index]).html("");
            $(dateContainer[index]).html(data);

          } else {

            $(dateContainer[index]).html("");

          }

          updateNumberOfDays(index);

        });

    },
      showTrigger: '<button type="button" class="ui basic mini button icon trigger">' + 
    '<img src="jquery_datepick_5.1.0/img/calendar.gif" alt="Popup"></button>'
  })


});


$.post('indTurnArroundTimeInfo_proc.php',{
    getITATDates: true, 
    rspvac_id: <?=$rspvac_id?>
  },

  function(data){
    var json = jQuery.parseJSON(data);
    datesArr = json;
    console.log(datesArr);
    $.each(datePickerBtn, function(index, val) {
      if (datesArr[index] !== null) {
        $(this).datepick('setDate',datesArr[index]);
      } else {
        $(dateContainer[index]).html("<i style='color: lightgrey;'>N/A</i>");
      }
      updateNumberOfDays(index);
    });

    loadCos();
  
});


}


function updateNumberOfDays(index){
  if (datesArr[index] !== null) {
    if (index === 0) {
      if (datesArr[0].length === 0) {
        $(numDays[0]).html(0);
      } else {
        $(numDays[0]).html(datesArr[0].length-1);  
      }
    } else {
      $(numDays[index]).html(datesArr[index].length);    
    }
  } else {
    $(numDays[index]).html("0");
  }
  
  totalDays = 0;  
  $.each(datesArr, function(index1, value) {
      if (value !== null) {
        totalDays += value.length;
      }
  });

  $(".totalDays").html(totalDays);
}

function editCostOfSourcing(option){
 if (option === 'edit') {
  $(".costOfSourcing").attr('contentEditable', 'true').attr('onfocus', 'document.execCommand("selectAll",false,null)').focus();
  if ($(".costOfSourcing").text() === "N/A") {
    $(".costOfSourcing").text("");
  }
  //buttons display
  $("#cosBtnEdit").hide();
  $("#cosBtnSave").show();
  $("#cosBtnCancel").show();
 } else if (option === 'save'){
  $(".costOfSourcing").attr('contentEditable', 'false');
  //buttons display
  $("#cosBtnEdit").show();
  $("#cosBtnSave").hide();
  $("#cosBtnCancel").hide();
  saveCos();
 } else if (option === 'cancel'){
  $(".costOfSourcing").attr('contentEditable', 'false');
  
//buttons display
  $("#cosBtnEdit").show();
  $("#cosBtnSave").hide();
  $("#cosBtnCancel").hide();
  loadCos();
 }
  
}

function loadCos(){
  $.post('indTurnArroundTimeInfo_proc.php', {
    loadCos: true,
    rspvac_id: <?=$rspvac_id?>
  }, function(data, textStatus, xhr) {
    /*optional stuff to do after success */
    if (!data) {
      $(".costOfSourcing").html("<i style='color: lightgrey;'>N/A</i>");
    } else {
      $(".costOfSourcing").html(data);  
    }
    window.getSelection().removeAllRanges();
  });
}

function saveCos(){
  var cos = $(".costOfSourcing").text();
  console.log(cos);
  $.post('indTurnArroundTimeInfo_proc.php', {
    saveCos: true,
    rspvac_id: <?=$rspvac_id?>,
    cos: cos
  }, function(data, textStatus, xhr) {
    /*optional stuff to do after success */
    loadCos();
  });

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
      <button onclick="window.location.href='indTurnAroundTime.php';" class="blue ui icon button noprint" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
    <div class="item">
     <h3><i class="stopwatch icon"></i> Individual Turn Around Time <i class="caret right icon"></i> <?=$positiontitle;?></h3>
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

<!-- <button class="datePickerBtn" hidden=""></button>
<div class="dateContainer"></div> -->
    <table class="ui very compact mini celled table" style="font-size: 12px;">
      <tr>
        <td class="actives">POSITION:</td>
        <td id="positiontitle"><i style="color: grey;">n/a</i></td>
        <td class="actives">CSC ITEM NO:</td>
        <td id="itemNoTitle"><i style="color: grey;">n/a</i></td>
      </tr>
      <tr>
        <td class="actives">SALARY GRADE:</td>
        <td id="salaryGrade"><i style="color: grey;">n/a</i></td>
        <td class="actives">OFFICE:</td>
        <td id="officeTitle"><i style="color: grey;">n/a</i></td>
      </tr>
      <tr>
        <td class="actives" colspan="4" style="text-align: left !important;">QUALIFICATION STANDARDS:</td>
      </tr>
      <tr>
        <td class="actives">EDUCATION:</td>
        <td id="educationTitle"><i style="color: grey;">n/a</i></td>
        <td class="actives">TRAINING:</td>
        <td colspan="" id="trainingTitle"><i style="color: grey;">n/a</i></td>
      </tr>
      <tr>
        <td class="actives">EXPERIENCE:</td>
        <td colspan="" id="experienceTitle"><i style="color: grey;">n/a</i></td>
        <td class="actives">ELIGIBILITY:</td>
        <td colspan="" id="eligibilityTitle"><i style="color: grey;">n/a</i></td>
      </tr>
    </table>

  <style type="text/css">
    .heads {
      padding: 2px !important;
    }
    .thDP {
      padding: 2px !important; 
      text-align: center !important;
      /*background-color: white !important;*/
    }
  </style>

  <button onclick="addApplicant()" class="ui basic tiny green button noprint" title="Add applicant to the list"><i class="icon add"></i> Add Applicant</button>
  <table id="trTable" class="ui blue structured celled very compact table" style="font-size: /*12px*/;">
    <thead>
      <tr style="text-align: center; font-size: 12px;" class="printCompactText">
        <th class="heads">No.</th>
        <th class="heads">NAME OF APPLICANTS</th>
        <th class="heads">PUBLICATION PERIOD</th>
        <th class="heads">SCREENING OF APPLICANT (Paper Reliberation)</th>
        <th class="heads">SENDING OF NOTIFICATION/ DISQUALIFICATION</th>
        <th class="heads">POSTING OF QUALIFIED APPLICANTS</th>
        <th class="heads">CONDUCT OF INTERVIEW</th>
        <th class="heads">BACKGROUND INVESTIGATION</th>
        <th class="heads">RECOMMENDATION OF PSB FOR FINAL ACTION OF LCE</th>
        <th class="heads">APPOINTMENT PREPARATION</th>
        <th class="heads">OATH OF OFFICE</th>
        <th class="heads">TOTAL # OF DAYS</th>
        <th class="heads " style="width: 50px !important;">COST OF SOURCING<br><tt class="" style="font-size: 11px;">(Cost on Salary of PSB Members involved in the screening process, Background Investigation & Sending of notification/disqualification)</tt></th>
      </tr>
      <tr>
        <th class="thDP" colspan=""></th>
        <th class="thDP" colspan=""></th>
        <th class="thDP"><button class="datePickerBtn" hidden="" style="vertical-align: bottom;"></button></th>
        <th class="thDP"><button class="datePickerBtn" hidden="" style="vertical-align: bottom;"></button></th>
        <th class="thDP"><button class="datePickerBtn" hidden="" style="vertical-align: bottom;"></button></th>
        <th class="thDP"><button class="datePickerBtn" hidden="" style="vertical-align: bottom;"></button></th>
        <th class="thDP"><button class="datePickerBtn" hidden="" style="vertical-align: bottom;"></button></th>
        <th class="thDP"><button class="datePickerBtn" hidden="" style="vertical-align: bottom;"></button></th>
        <th class="thDP"><button class="datePickerBtn" hidden="" style="vertical-align: bottom;"></button></th>
        <th class="thDP"><button class="datePickerBtn" hidden="" style="vertical-align: bottom;"></button></th>
        <th class="thDP"><button class="datePickerBtn" hidden="" style="vertical-align: bottom;"></button></th>
        <th class="thDP" colspan=""></th>
        <th class="thDP" colspan="" id="cosBtnsContainer">
          
          <button id="cosBtnEdit" onclick="editCostOfSourcing('edit')" class="ui button mini basic icon" hidden="" style="vertical-align: bottom;"><i class="icon blue edit"></i>
          </button>

          <button id="cosBtnSave" onclick="editCostOfSourcing('save')" class="ui button mini basic icon" style="vertical-align: bottom; display: none;"><i class="icon green check"></i>
          </button>
          <button id="cosBtnCancel" onclick="editCostOfSourcing('cancel')" class="ui button mini basic icon" style="vertical-align: bottom; display: none;"><i class="icon red cancel"></i>
          </button>
        </th>
      </tr>
    </thead>
    <tbody id="tableBody" class="">
        <tr id="loading_el">
          <td colspan="14" style="text-align: center; font-size: 32px; color: lightgrey; padding: 100px;">
            <img src="assets/images/loading.gif" style="height: 50px; margin-top: -100px;">
            <br>
            <span>Fetching data...</span>
          </td>
        </tr>
    </tbody>
    <tfoot id="tfooter"></tfoot>
  </table>

</div>

<?php require_once "footer.php";?>
