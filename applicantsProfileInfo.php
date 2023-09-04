<?php 
  $title = "Applicants' Profile";
  require "_connect.db.php"; 
  require "header.php";

if ($rspvac_id = $_GET["rspvac_id"]) {
  
  $sql = "SELECT * FROM `rsp_vacant_positions` WHERE `rspvac_id` = ?";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("i",$rspvac_id);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($rspvac_id, $positiontitle, $sg, $office, $dateVacated, $education, $training, $experience, $eligibility, $datetime_added);
  $stmt->fetch();
  $stmt->close();
}
    


?>
<script type="text/javascript" src="scripts/Lister.js"></script>
<script type="text/javascript">
  var training = new Lister("Training"),
      experience = new Lister("Experience"),
      eligibility = new Lister("Eligibility");
  // $(document).keypress(function(e){
  //   if (e.which == 13){
  //     $("#submitBtn").click();
  //   }
  // });


  $(document).ready(function() {
      $(autoEnter);
      // $("#sortYear").dropdown();

      $("#trainingsAttendedAdd").html(training.render());
      $("#experienceAdd").html(experience.render());
      $("#eligibilityAdd").html(eligibility.render());
      
      
      $(load);
      $(addFunc);
  });  


  function load(){
    $.post('applicantsProfileInfo_proc.php',{
      load: true,
      rspvac_id: <?=$rspvac_id?>
    },function(data){
      arr = JSON.parse(data);
      $("#positiontitleView").html(arr.position);
      $("#departmentView").html(arr.office);
      // $("#education").html(data.) 
      // $("#experience").html(data.)
      // $("#training").html(data.)
      // console.log(arr.eligibility);
      elig = arr.eligibility;
      view = "";
      elig.forEach( function(element, index) {
        // statements
          view += " ***";
          view += elig[index];

      });

      // console.log(view);
      $("#eligibilityView").html(view);
      // $(clearFormData);
      $("#tableBody").html(arr.view);

    });
  
  }

  function getInputValues(){
  data = [];
  data0 = [
      $("input[name='nameAdd']").val(),
      $("input[name='addressAdd']").val(),
      $("input[name='ageAdd']").val(),
      $("input[name='mobileNumAdd']").val(),
      $("input[name='schoolAdd']").val(),
      $("input[name='educationAdd']").val(),
      $("textarea[name='remarksAdd']").val()
    ];
  data1 = [];
  $.each(objArray, function(index, val) {
      data1.push(objArray[objArray[index]]);           
  });
  data = [data0,data1];
  console.log(data);

  return data;
}

  function addFunc(){

    $("#addNewForm").form({
        on: "submit",
        inline: true,
        keyboardShortcuts: false,
        onSuccess: function(e){
          e.preventDefault();
          data = getInputValues();
          // post
          console.log('submit',data);
          $.post('applicantsProfileInfo_proc.php', {
            addNew: true,
            rspvac_id: <?=$rspvac_id?>,
            data0: data[0],
            data1: data[1]
          }, function(data, textStatus, xhr) {
            $("#addModal").modal("hide");
            $(load);
          });
        },
        // fields: fields
      });

    // nameAdd = $("input[name='nameAdd']").val();
    // addressAdd = $("input[name='addressAdd']").val();
    // ageAdd = $("input[name='ageAdd']").val();
    // mobileNumAdd = $("input[name='mobileNumAdd']").val();
    // schoolAdd = $("input[name='schoolAdd']").val();
    // educationAdd = $("input[name='educationAdd']").val();

    $("#addModal").modal({
      closable: false,
      onDeny: function (){
        $(clearFormData);
      },
      onApprove: function (){
        // console.log(nameAdd);
        return false;
      }
    }).modal("show");
  }

  function clearFormData(){
    $(".addNewForm").each(function(index, el) {
      $(this).form("reset");
      // console.log(this);
    });
    
    $.each($("input"), function(index, val) {
       /* iterate through array or object */
       $(this).val("");
    });
    // education.resetLister();
    training.resetLister();
    experience.resetLister();
    eligibility.resetLister();
  }
</script>

<div class="ui mini modal" id="deleteModal">
  <div class="header">
    <i class="icon trash"> </i> Delete Vacant Position
  </div>
  <div class="content">
    Are you sure you want to delete this vacant position?
  </div>
  <div class="actions">
    <button class="ui tiny basic button approve"><i class="icon check"></i> Yes</button>
    <button class="ui tiny basic button deny"><i class="icon cancel"></i> No</button>
  </div>
</div>

<!-- modal add new vacant position start -->
<!-- id="addNew" -->
<div class="ui fullscreen modal scrollable formModal" id="addModal">
  <div class="header">
    <i class="blue icon user circle"></i> Add New Applicant
  </div>
  <div class="scrolling content">
    <form class="ui form addNewForm" id="addNewForm" method="POST">
    <div class="ui grid">
      <div class="three wide column">
        <!-- <div class="fields"> -->
        <div class="field">
          <label>Name:</label>
          <input type="text" name="nameAdd" placeholder="Enter fullname...">
        </div>
        <div class="field">
          <label>Address:</label>
          <input type="text" name="addressAdd" placeholder="Enter address...">
          <!-- <textarea name="addressAdd" rows="2" placeholder="Enter address..."></textarea> -->
        </div>
      <!-- </div> -->
        <div class="fields">
          <div class="five wide field">
            <label>Age:</label>
            <input type="number" name="ageAdd" placeholder="Age...">
          </div>
          <div class="eleven wide field">
            <label>Mobile No:</label>
            <input type="text" name="mobileNumAdd" placeholder="Enter mobile number...">
          </div>
          
          <!-- <textarea name="addressAdd" rows="2" placeholder="Enter address..."></textarea> -->
        </div>
        <div class="field">
            <label>School:</label>
            <input type="text" name="schoolAdd" placeholder="Enter school...">
          </div>

      <!-- <div class="fields"> -->
        
        <div class="field">
          <label>Education:</label>
          <input type="text" name="educationAdd" placeholder="Enter education...">
        </div>
        
      <!-- </div> -->
      </div>
      <div class="three wide column">
        <div class="field" id="trainingsAttendedAdd"></div>
      </div>
      <div class="four wide column">
        <div class="field" id="experienceAdd"></div>
      </div>
      <div class="three wide column">
        <div class="field" id="eligibilityAdd"></div>
      </div>
      <div class="three wide column">
        <div class="field">
          <label>Remarks:</label>
            <!-- <input type="text" name=""> -->
          <textarea rows="3" name="remarksAdd" placeholder="Remarks here..."></textarea>
        </div>
      </div>
      <!-- <h5 class="ui dividing header">Remarks:</h5> -->
      

    </div>
    
      <!-- <h4 class="ui dividing header">Personal Information</h4> -->
      <!-- <div class="fields"> -->

      <!-- </div> -->
      <!-- <h4 class="ui dividing header">Qualification Standards</h4> -->

<!-- 
      <h5 class="ui dividing header">Experience</h5>
      <div class="fields">
        <div class="six wide field">
          <label>Company:</label>
          <input type="text" name="" placeholder="Name of company...">
        </div>
        <div class="three wide field">
          <label>Inclusive Dates From:</label>
          <input type="date" name="" placeholder="Inclusive dates...">
        </div>
        <div class="three wide field">
          <label>Inclusive Dates To:</label>
          <input type="date" name="" placeholder="Inclusive dates...">
        </div>
        <div class="four wide field">
          <label>Position:</label>
          <input type="text" name="" placeholder="Positions...">
        </div>
        <div class="two wide field">
          <label>Status:</label>
          <input type="text" name="" placeholder="Status...">
        </div>
      </div>
      <button class="ui mini green basic button" type="button">Add</button>
      <div id="experienceContainer" style="border: 1px solid lightgrey; padding: 10px; margin-top: 10px; border-radius: 3px;">
        <div style="text-align: center">
          <i style="color: grey;">n/a</i>
        </div>
      </div> -->


      <div class="ui error message"></div>
    </form>

  </div>
  <div class="actions">
    <button form="addNewForm" type="button" onclick="$('#'+this.form.id).form('submit');" class="ui tiny basic button approve"><i class="icon save"></i> Save</button>
    <button class="ui tiny basic button deny"><i class="icon cancel"></i> Cancel</button>
  </div>
</div>
<!-- modal add new vacant position end -->

<!-- <div class="ui container" style="padding:/* 20px*/;"> -->
  <div class="ui containerA" style="padding-left: 20px; padding-right: 20px;">
  <div class="ui borderless blue inverted mini menu">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.location.href = 'applicantsProfile.php';" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
    <div class="item">
     <h3><i class="users icon"></i> Applicants' Profile</h3>
   </div>
   <div class="right item">
    <div class="ui right input">
       <button class="ui icon mini green button" onclick="addFunc()" style="margin-right: 5px;"><i class="icon plus"></i>Add Applicant</button>
<!--       <div style="padding: 0px; margin: 0px; margin-right: 5px;">
      <select id="sortYear" class="ui floating dropdown compact"> 
        <option value="">Filter by Year</option>
        <option value="all">All</option>
        <?php
          $sql = "SELECT DISTINCT year(`dateVacated`) AS `years` FROM `rsp_vacant_positions` ORDER BY `years` DESC";
          $result = $mysqli->query($sql);
          while ($row = $result->fetch_assoc()) {
            $years = $row["years"];
            echo "<option value=\"$years\">$years</option>";
          }
        ?>
      </select>
    </div> --> 
      <div class="ui icon fluid input" style="width: 300px;">
        <input id="table_search" type="text" placeholder="Search...">
        <i class="search icon"></i>
      </div>

    </div>
  </div>
</div>


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

    <table class="ui very compact small celled table" style="font-size: 12px;">
      <tr>
        <td class="actives">VACANT POSITION:</td>
        <td id="positiontitleView" style="font-weight: bold;"><i style="color: grey;">n/a</i></td>
      </tr>
      <tr>
        <td class="actives">DEPARTMENT:</td>
        <td id="departmentView"><i style="color: grey;">n/a</i></td>
      </tr>
        <td class="actives">ELIGIBILITY:</td>
        <td id="eligibilityView"><i style="color: grey;">n/a</i></td>
      </tr> 
    </table>

    <style type="text/css">
      .heads {
        padding: 2px !important;
        text-align: center !important;
      }
  </style>

  <table id="trTable" class="ui blue selectable structured celled very compact table" style="font-size: 12px;">
    <thead>
      <tr style="text-align: center;">
        <th rowspan="2" class="heads">Name</th>
        <th rowspan="2" class="heads">Address</th>
        <th rowspan="2" class="heads">Age</th>
        <th rowspan="2" class="heads">Mobile No.</th>
        <th rowspan="2" class="heads">School</th>
        <th rowspan="2" class="heads">Education</th>
        <th rowspan="2" class="heads">Trainings Attended</th>
        <th colspan="4" class="heads">Experience</th>
        <th rowspan="2" class="heads">Eligibility</th>
        <th rowspan="2" class="heads">Remarks</th>
      </tr>
      <tr>
        <th class="heads">Company</th>
        <th class="heads">Inclusive Dates</th>
        <th class="heads">Position</th>
        <th class="heads">Status</th>
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