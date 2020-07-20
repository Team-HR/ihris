<?php 
  $title = "Plantilla"; 
  require_once "header.php"; 
?>


<script type="text/javascript">

    $("#editIncumbent").dropdown();
    $("#editDept").dropdown();

  $(document).ready(function() {
    var loading = $("#loading_el");

    // $("#addPos").dropdown();
    // $("#addIncumbent").dropdown();
    // $("#addDept").dropdown();
    // $("#addOffice").dropdown();
    // $("#addSchedule").dropdown();
    // $("#addVacator").dropdown();
    //$("#addReason").dropdown();
    // $("#addSupervisor").dropdown();
    // $("#addAbolish").dropdown();

      $("#data_search").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#plantilla_table tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });


    $(".dropdown").dropdown({
      fullTextSearch:true,
    })
    
    $(load);

  });


  function load(){
    $("#tableContent").load("plantilla_proc.php",{
      load: true
    });
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

  function vacateRow(id,item_no,incumbent,endService,reason_of_vacancy,other){

    $("#editItem").val(item_no);
    $("#editIncumbent").val(incumbent);

    $("#vacateModal").modal({
      onApprove: function(){
        $.post('plantilla_proc.php', {
          vacatePos: true,
          id:id,
          incumbent: $("#editIncumbent").val(),
          endService: $("#addEnd").val(),
          reason_of_vacancy: $("#addReason").val(),
          other: $("#addOther").val(),   
        }, function(data, textStatus, xhr) {
          /*optional stuff to do after success */
          $(load);

        });
      }
    }).modal("show");
  }
 
  function addPlantillas(){
    $.post("plantilla_proc.php",{
      addPlantilla:true,
      position: $("#addPos").val(),
      incumbent: $("#addIncumbent").val(),
      department: $("#addDept").val(),
      office: $("#addOffice").val(),
      step: $("#addStep").val(),
      schedule: $("#addSchedule").val(),
      item_no: $("#addItem").val(),
      page_no: $("#addPage").val(),
      original_appointment: $("#addOriginal").val(),
      last_promotion: $("#addLastPromo").val(),
      casual_promotion: $("#addCasualPromo").val(),
      vacated_by: $("#addVacator").val(),
      reason_of_vacancy: $("#addReason").val(),
      other: $("#addOther").val(),
      supervisor: $("#addSupervisor").val(),
      abolish: $("#addAbolish").val(),
    },function(data,status){  
      $(load);
  
    });
  } 


  function addModalFunc(){
    $("#addModal").modal({
        onApprove : function() {
          $(addPlantillas);
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

 

  function deleteRow(id){
    $("#deleteModal").modal({
      onApprove: function(){
        $.post('plantilla_proc.php', {
          deleteData: true,
          id: id,
        }, function(data, textStatus, xhr) {
          /*optional stuff to do after success */
          $(load);
        });
      }
    }).modal("show");
  }
  
</script>
<!-- savae msg alert start -->
<div id="saveMsg" class="" style="top: 15px; display: none; position: fixed; z-index: 10; width: 100%; left: 0; text-align: center;">
  <div class="ui center green inverted aligned segment" style="width: 100px; margin-left: auto; margin-right: auto;">
    <i class="checkmark icon"></i> Added!
  </div>
</div>

<!-- vacate modal start-->
<div id="vacateModal" class="ui mini modal">
  <i class="close icon"></i>
  <div class="header">
   Vacate Position
  </div>
  <div class= "ui content">
       <div class="ui form">

             <div class="field">
                  <label>Incumbent:</label>  
                 <input type="text" id="editItem" disabled> </input>
             </div>

              <div class="field">
                  <label>Position:</label>  
                 <input type="text" id="editPos" disabled> </input>
             </div>

               <div class="field">
                  <label>Last day of service:</label>
                  <input type="date" name="" id="addEnd">
               </div>
      
               <div class="field">
                   <label>Reason of Vacancy:</label>
                      <select id="addReason" class="ui search dropdown" >
                        <option value="">---</option>
                          <option value="Transfer">Transfer</option>
                          <option value="promotion">Promotion</option>
                          <option value="Retirement">Retirement</option>
                          <option value="Others">Others:</option>
                      </select>  
               </div>

               <div class="field">
                   <label>Add other reason:</label>
                     <input type="text" name="" id="addOther" placeholder="Add other reason..">
             </div>
      </div>

   </div> 
  <div class="actions">
    <div class="ui deny button mini">
      No
    </div>
    <div class="ui blue right labeled icon approve button mini">
      Yes
      <i class="checkmark icon"></i>
    </div>
  </div>
</div>

<!-- vacate modal end -->


<!----add data---->
<div class="ui container">
<div id="addModal" class="ui small modal">
  <div class="header">
   Plantilla Detail
  </div>
<div class="content">
  <div class="ui form">
    <div class="two fields">
        <div class="nine wide field">
          <label>Employee:</label> 
             <select class= "ui search dropdown" id="addIncumbent">
                    <option value="">Employee:</option>
                  <?php
                    $result = $mysqli->query("SELECT * FROM `employees`");
                        while ($row = $result->fetch_assoc()) {
                          $employees_id = $row["employees_id"];
                          $firstName = $row["firstName"];
                          $middleName = $row["middleName"];
                          $lastName = $row["lastName"];
                          $extName = $row["extName"];
                                print "<option value=\"{$employees_id}\">{$firstName} {$middleName} {$lastName} {$extName}</option>";
                          }
                  ?>
              </select>
      </div>

  <div class="eight wide field">
          <label>Position:</label>
             <select class= "ui search dropdown" id="addPos">
                    <option value="">Select Position</option>
                  <?php
                    $result = $mysqli->query("SELECT * FROM `positiontitles`");
                        while ($row = $result->fetch_assoc()) {
                          $position_id = $row["position"];
                          $position = $row["position"];
                          $functional = $row["functional"];
                                print "<option value=\"{$position_id}\">{$position} ({$functional})</option>";
                          }
                  ?>
              </select>
</div>

        
  </div>

   <div class="two fields">
        <div class="eight wide field">
          <label>Department:</label>
             <select class= "ui search dropdown" id="addDept">
                    <option value="">Select Office</option>
                  <?php
                    $result = $mysqli->query("SELECT * FROM `department`");
                        while ($row = $result->fetch_assoc()) {
                          $department_id = $row["department_id"];
                          $department = $row["department"];
                                print "<option value=\"{$department_id}\">{$department}</option>";
                          }
                  ?>
              </select>
        </div>


        <div class="eight wide field">
          <label>Office Assignment:</label>
              <select class= "ui search dropdown" id="addOffice">
                    <option value="">Select Office</option>
                  <?php
                    $result = $mysqli->query("SELECT * FROM `department`");
                        while ($row = $result->fetch_assoc()) {
                          $department_id = $row["department_id"];
                          $department = $row["department"];
                                print "<option value=\"{$department_id}\">{$department}</option>";
                          }
                  ?>
              </select>
        </div>
        
  </div>

  <div class="four fields">
  
      <div class="four wide field">
         <label>Step No.</label>
          <input  id="addStep" type="number" placeholder="No">
      </div>

   
       <div class="four wide field">
            <label>Item No:</label>
              <input  id="addItem" type="text" placeholder="Item No">
        </div>
        
        <div class="four wide field">
            <label>Page No:</label>
              <input id="addPage"  type="number" placeholder="Page">
        </div>


      <div class="four wide field">
         <label>Salary Shedule</label>
           <select id="addSchedule" class="ui search dropdown">
                <option value="">---</option>
                <option value="1">1st Class</option>
                <option value="2">2nd Class</option>
            </select>
      </div>
    
  </div>

    <div class="three fields">
      <div class="eight wide field">
      <label>Original Appointment</label>
        <input  id="addOriginal" type="date" >
      </div>
      <div class="eight wide field">
      <label>Last Promotion:</label>
        <input  id="addLastPromo" type="date">
      </div>
      <div class="eight wide field">
      <label>Casual Promotion:</label>
        <input  id="addCasualPromo" type="date">
      </div>
  </div>
  
  
  <div class="two fields">
      <div class="eight wide field">
          <label>Supervisor:</label>

            <select class= "ui search dropdown" id="addSupervisor">
                    <option value="">Supervisor:</option>
                  <?php
                    $result = $mysqli->query("SELECT * FROM `employees`");
                        while ($row = $result->fetch_assoc()) {
                          $employees_id = $row["employees_id"];
                          $firstName = $row["firstName"];
                          $middleName = $row["middleName"];
                          $lastName = $row["lastName"];
                          $extName = $row["extName"];
                                print "<option value=\"{$employees_id}\">{$firstName} {$middleName} {$lastName} {$extName}</option>";
                          }
                  ?>
              </select>
     </div>
  
        <div class="eight wide field">
          <label>Abolish ?:</label>
            <select class="ui search dropdown" id="addAbolish">
              <option value="">---</option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
          </select>     
        </div>
  </div>

  </div>
</div>
  <div class="actions">
    <div class="ui deny button mini">
      No
    </div>
    <div class="ui blue right labeled icon approve button mini">
      Yes
      <i class="checkmark icon"></i>
    </div>
  </div>
</div>
</div>
<!-- end of adding -->


<!----edit data---->

<div class="ui container">
<div id="editModal" class="ui small modal">
  <div class="header">
   Edit Plantilla Detail
  </div>
<div class="content">
  <div class="ui form">

    <div class="two fields">
        <!-- <div class="nine wide field">
          <label>Employee:</label>  
         <select  class= "ui search dropdown" id="editIncumbent">
                    <option>Employee:</option>  
                       <?php
                          $result = $mysqli->query("SELECT * FROM `employees`");
                              while ($row = $result->fetch_assoc()) {
                                $employees_id = $row["employees_id"];
                                $firstName = $row["firstName"];
                                $middleName = $row["middleName"];
                                $lastName = $row["lastName"];
                                $extName = $row["extName"];
                                      print "<option value=\"{$employees_id}\">{$firstName} {$middleName} {$lastName} {$extName}</option>";
                                }
                  ?>
             </select>
     </div> -->

   <div class="eight wide field">
          <label>Position:</label>
             <select class= "ui search dropdown" id="editPos">
                    <option value="">Select Position</option>
                      <?php
                        $result = $mysqli->query("SELECT * FROM `positiontitles`");
                            while ($row = $result->fetch_assoc()) {
                              $position_id = $row["position_id"];
                              $position = $row["position"];
                              $functional = $row["functional"];
                                    print "<option value=\"{$position_id}\">{$position} ({$functional})</option>";
                              }
                      ?>
              </select>
</div>


        
  </div>

   <div class="two fields">
       

        <div class="eight wide field">
          <label>Department:</label>
             <select class= "ui search dropdown" id="editDept" >
                    <option value="">Select Department</option>
                  <?php
                    $result = $mysqli->query("SELECT * FROM `department`");
                        while ($row = $result->fetch_assoc()) {
                          $department_id = $row["department_id"];
                          $department = $row["department"];
                                print "<option value=\"{$department_id}\">{$department}</option>";
                          }
                  ?>
              </select>
        </div>


        <div class="eight wide field">
          <label>Office Assignment:</label>
              <select class= "ui search dropdown" id="editOffice">
                    <option value="">Select Office</option>
                  <?php
                    $result = $mysqli->query("SELECT * FROM `department`");
                        while ($row = $result->fetch_assoc()) {
                          $department_id = $row["department_id"];
                          $department = $row["department"];
                                print "<option value=\"{$department_id}\">{$department}</option>";
                          }
                  ?>
              </select>
        </div>
        
  </div>

  <div class="four fields">
   

      <div class="four wide field">
         <label>Step No.</label>
          <input  id="editStep" type="number" placeholder="Step No">
      </div>

   
       <div class="four wide field">
            <label>Item No:</label>
              <input  id="editItem" >
        </div>
        
        <div class="four wide field">
            <label>Page No:</label>
              <input id="editPage"  type="number" placeholder="Page">
        </div>


      <div class="four wide field">
         <label>Salary Shedule</label>
           <select id="editSchedule" class="ui search dropdown">
                <option value="">---</option>
                <option value="1">1st Class</option>
                <option value="2">2nd Class</option>
            </select>
      </div>
    
  </div>

    <div class="three fields">
      <div class="eight wide field">
      <label>Original Appointment</label>
        <input  id="editOriginal" type="date">
      </div>
      <div class="eight wide field">
      <label>Last Promotion:</label>
        <input  id="editLastPromo" type="date" >
      </div>
      <div class="eight wide field">
      <label>Casual Promotion:</label>
        <input  id="editCasualPromo" type="date">
      </div>
  </div>
  
  <div class="three fields">
    <div class="eight wide field">
          <label>Vacated by::</label>
            <select class= "ui search dropdown" id="editVacator"> 
                    <option value="">Employee:</option>
                  <?php
                    $result = $mysqli->query("SELECT * FROM `employees`");
                        while ($row = $result->fetch_assoc()) {
                          $employees_id = $row["employees_id"];
                          $firstName = $row["firstName"];
                          $middleName = $row["middleName"];
                          $lastName = $row["lastName"];
                          $extName = $row["extName"];
                                print "<option value=\"{$employees_id}\">{$firstName} {$middleName} {$lastName} {$extName}</option>";
                          }
                  ?>
              </select>
     </div>
  
      <div class="five wide field">
        <label>Reason of Vacancy:</label>
            <select id="editReason" class="ui search dropdown" >
              <option value="">---</option>
                <option value="Transfer">Transfer</option>
                <option value="promotion">Promotion</option>
                <option value="Retirement">Retirement</option>
                <option value="Others">Others</option>
            </select>
        </div>

         <div class="five wide field">
           <label>-</label>
             <input  id="editOther" type="text" placeholder="Other reason" value="">        
          </div>

  </div>
 
  <div class="two fields">
      <div class="eight wide field">
          <label>Supervisor:</label>

            <select class= "ui search dropdown" id="editSupervisor">
                    <option value="">Supervisor:</option>
                  <?php
                    $result = $mysqli->query("SELECT * FROM `employees`");
                        while ($row = $result->fetch_assoc()) {
                          $employees_id = $row["employees_id"];
                          $firstName = $row["firstName"];
                          $middleName = $row["middleName"];
                          $lastName = $row["lastName"];
                          $extName = $row["extName"];
                                print "<option value=\"{$employees_id}\">{$firstName} {$middleName} {$lastName} {$extName}</option>";
                          }
                  ?>
              </select>
     </div>
  
        <div class="eight wide field">
          <label>Abolish ?:</label>
            <select class="ui search dropdown" id="editAbolish">
              <option value="">---</option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
          </select>     
        </div>
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
<!-- end of editing





<!----load table data---->
<div class="ui segment" :class="loader">
  <div class="ui container">
  <div class="ui borderless blue inverted mini menu">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
    <div class="item">
      <h3><i class="notebook icon"></i>Plantilla</h3>
    </div>
    <div class="right item">
      <!-- 
      <button onclick="addModalFunc()" class="circular blue ui icon button" style="margin-right: 10px;" title="Add New Personnel">
        <i class="icon plus circle"></i>
      </button> -->
    <div class="ui right input">
      <button class="ui icon mini green button" onclick="addModalFunc()" style="margin-right: 5px;" title="Add Detail"><i class="icon plus"></i>Add</button>
       <a class="ui icon mini green button" href="plantilla_vacantpos.php" style="margin-right: 5px;" title="View Vacant Positions">View Vacant Positions</a>
      <div class="ui icon fluid input" style="width: 300px;">
        <input id="data_search" type="text" placeholder="Search...">
        <i class="search icon"></i>
      </div>
    </div>
    </div>
  </div>
<div class="ui container" style="min-height: 6190px;">
<table id="plantilla_table" class="ui teal selectable very compact small striped table">
  <thead>
    <tr style="text-align: center;">
      <th rowspan="2"></th>
      <th rowspan="2">Item No.</th>
      <th rowspan="2">Page No.</th>
      <th rowspan="2">Position Title</th>
      <th rowspan="2">Functional Title</th>
      <th colspan="2">Level</th>
      <th rowspan="2">SG</th>
      <th rowspan="2">Basic Salary</th>
      <th rowspan="2">Department</th>
      <th rowspan="2">Incumbent</th>
      <th rowspan="2">Reason of Vacancy</th>
      <th rowspan="2">Vacated By</th>
      <th rowspan="2">
      </th>
    </tr>
      <tr style="text-align: center;">
        <th>Category</th>
        <th>Position</th>
      </tr>
  </thead>
        <tbody id="tableContent">
              <tr id="loading_el">
              <td colspan="20" style="text-align: center; font-size: 32px; color: lightgrey; padding: 100px;"><!-- FETCHING DATA... -->
                <img src="assets/images/loading.gif" style="height: 50px; margin-top: -100px;">
                <br>
                <br>
                <span>fetching data...</span>
              </td>
            </tr>
        </tbody>
</table>

  </div>
    </div>
  </div>
</div>
<?php 
	require_once "footer.php";
?>
