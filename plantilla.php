<?php 
  $title = "Plantilla"; 
  require_once "header.php";
?>
<script type="text/javascript">

  $(document).ready(function() {
    var loading = $("#loading_el");

    $("#addPos").dropdown();
    $("#addIncumbent").dropdown();
    $("#addDept").dropdown();
    $("#addOffice").dropdown();
    $("#addSchedule").dropdown();
    $("#addVacator").dropdown();
    $("#addReason").dropdown();
    $("#addSupervisor").dropdown();
    $("#addAbolish").dropdown();


    
    $(load);
  });
  
  function load(){
    $("#tableContent").load("plantilla_proc.php",{
      load: true
    });
  }

 
  function addPlantilla(){
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
      $(clear);
    });
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
    function addModalFunc(){
    $("#addModal").modal({
        onApprove : function() {
          $(addPlantilla);
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
</script>
<!-- savae msg alert start -->
<div id="saveMsg" class="" style="top: 15px; display: none; position: fixed; z-index: 10; width: 100%; left: 0; text-align: center;">
  <div class="ui center green inverted aligned segment" style="width: 100px; margin-left: auto; margin-right: auto;">
    <i class="checkmark icon"></i> Added!
  </div>
</div>
<!-- save msg alert end -->
<div id="editSuccess" class="" style="top: 15px; display: none; position: fixed; z-index: 10; width: 100%; left: 0; text-align: center;">
  <div class="ui center green inverted aligned segment" style="width: 100px; margin-left: auto; margin-right: auto;">
    <i class="checkmark icon"></i> Edit successful!
  </div>
</div>

<!-- delete pos start -->
<div id="deleteModal" class="ui mini modal">
  <i class="close icon"></i>
  <div class="header">
    Deleting Data
  </div>
  <div class="content">
    <p>Are you sure you want to delete this data?</p>
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
<!-- delete pos end -->

<!----add data---->
<div class="ui container">
<div id="addModal" class="ui small modal">
  <div class="header">
   Plantilla Detail
  </div>
<div class="content">
  <div class="ui form">

    <div class="two fields">
        <div class="eight wide field">
          <label>Employee:</label>
            <input  id="addIncumbent" list="employees" name="employees" type="text" placeholder="Select Employee">
                  <datalist id="employees">    
                     <?php $result = $mysqli->query("SELECT * FROM `employees`");
                       while ($row= $result->fetch_assoc()){
                          $employees_id = $row["employees_id"];
                          $firstName = $row["firstName"];
                          $middleName = $row["middleName"];
                          $lastName = $row["lastName"];
                          $extName = $row["extName"];
                          
                          print "<option value=\"{$employees_id}\"> {$firstName} {$middleName} {$lastName} {$extName}</option>";
                        }
                ?>
            </datalist>
     </div>


         <div class="eight wide field">
      <label>Position:</label>
      <!-- <input id="editPosInput" type="text" placeholder="Position"> -->
        <input  id="addPos" list="positions" name="position" type="text" placeholder="Position">
          <datalist id="positions">
          <?php
          $result = $mysqli->query("SELECT * FROM `positiontitles`");
              while ($rsltRow = $result->fetch_assoc()) {
                      $position_id = $rsltRow["position_id"];
                      $position = $rsltRow["position"];
                      $functional = $rsltRow["functional"];
                  print " <option value=\"{$position_id}\"> {$position} - {$functional}";
                  } 
          ?>
          </datalist>
    </div>

        
  </div>

   <div class="two fields">
       

        <div class="eight wide field">
          <label>Department:</label>
    <input  id="addDept" list="department" name="department" type="text" placeholder="Department">
              <datalist id="department">
                    <option value="">Select Department</option>
                  <?php
                    $result = $mysqli->query("SELECT * FROM `department`");
                      while ($row = $result->fetch_assoc()) {
                          $department_id = $row["department_id"];
                          $department = $row["department"];
                              print "<option value=\"{$department_id}\">{$department}</option>";
                          }
                  ?>
              </datalist>
        </div>


        <div class="eight wide field">
          <label>Office Assignment:</label>
              <select id="addOffice">
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
         <label>Salary Shedule</label>
           <select id="addSchedule">
                <option value="">---</option>
                <option value="1">1st Class</option>
                <option value="2">2nd Class</option>
            </select>
      </div>

      <div class="four wide field">
         <label>Step No.</label>
          <input  id="addStep" type="number" placeholder="No" autocomplete="off" required="">
      </div>

   
       <div class="four wide field">
            <label>Item No:</label>
              <input  id="addItem" type="text" placeholder="Item No" autocomplete="off" required="">
        </div>
        
        <div class="four wide field">
            <label>Page No:</label>
              <input id="addPage"  type="number" placeholder="Page" autocomplete="off" required="">
        </div>
    
  </div>

    <div class="three fields">
      <div class="eight wide field">
      <label>Original Appointment</label>
        <input  id="addOriginal" type="date" autocomplete="off" required="">
      </div>
      <div class="eight wide field">
      <label>Last Promotion:</label>
        <input  id="addLastPromo" type="date" autocomplete="off" required="">
      </div>
      <div class="eight wide field">
      <label>Casual Promotion:</label>
        <input  id="addCasualPromo" type="date" autocomplete="off" required="">
      </div>
  </div>
  
  <div class="three fields">
    <div class="eight wide field">
          <label>Vacated by::</label>
            <input  id="addVacator" list="employees" name="employees" type="text" placeholder="Select Vacator">
                  <datalist id="employees">    
                     <?php $result = $mysqli->query("SELECT * FROM `employees`");
                       while ($row= $result->fetch_assoc()){
                          $employees_id = $row["employees_id"];
                          $firstName = $row["firstName"];
                          $middleName = $row["middleName"];
                          $lastName = $row["lastName"];
                          $extName = $row["extName"];
                          
                          print "<option value=\"{$employees_id}\"> {$firstName} {$middleName} {$lastName} {$extName}</option>";
                        }
                ?>
            </datalist>
     </div>
  
      <div class="five wide field">
        <label>Reason of Vacancy:</label>
            <select id="addReason">
                <option value="">---</option>
                <option value="transfer">Transfer</option>
                <option value="promotion">Promotion</option>
                <option value="retirement">Retirement</option>
                <option value="others">Others</option>    
            </select>
        </div>

         <div class="five wide field">
           <label>-</label>
             <input  id="addOther" type="text" placeholder="Other reason" >        
          </div>

  </div>
 
  <div class="two fields">
      <div class="eight wide field">
          <label>Supervisor:</label>
            <input  id="addSupervisor" list="employees" name="employees" type="text" placeholder="Select Supersvisor">
                  <datalist id="employees">    
                     <?php $result = $mysqli->query("SELECT * FROM `employees`");
                       while ($row= $result->fetch_assoc()){
                          $employees_id = $row["employees_id"];
                          $firstName = $row["firstName"];
                          $middleName = $row["middleName"];
                          $lastName = $row["lastName"];
                          $extName = $row["extName"];
                          
                          print "<option value=\"{$employees_id}\"> {$firstName} {$middleName} {$lastName} {$extName}</option>";
                        }
                ?>
            </datalist>
     </div>
  
        <div class="eight wide field">
          <label>Abolish ?:</label>
            <select class="ui fluid dropdown" id="addAbolish">
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
<!-- end of adding -->


<!----edit--->
<div id="editModal" class="ui small modal">
  <div class="header">
  Edit Plantilla Detail
  </div>
<div class="content">
  <div class="ui form">

    <div class="two fields">
        <div class="eight wide field">
          <label>Employee:</label>
              <!-- <input id="inputPos" type="text" placeholder="Position"> -->
                  <select id="editIncumbent">
                     <option value="">Employee Name</option>
                     <?php $result = $mysqli->query("SELECT * FROM `employees`");
                       while ($row= $result->fetch_assoc()){
                          $employees_id = $row["employees_id"];
                          $firstName = $row["firstName"];
                          $middleName = $row["middleName"];
                          $lastName = $row["lastName"];
                          $extName = $row["extName"];
                          
                          print "<option value=\"{$employees_id}\"> {$firstName} {$middleName} {$lastName} {$extName}</option>";
                        }
                ?>
            </select>
     </div>
        
        <div class="eight wide field">
          <label>Department:</label>
              <select id="editDept">
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
  </div>

  <div class="four fields">
     <div class="eight wide field">
        <label>Position:</label>
          <select id="editPos">
        <!-- <input id="inputPos" type="text" placeholder="Position"> -->
          <option value="">Position</option>
               <?php $result = $mysqli->query("SELECT * FROM `positiontitles` ORDER BY `position` ASC");
              while ($row= $result->fetch_assoc()){
                    $position_id = $row["position_id"];
                    $position = $row["position"];
                    $salary = $row["salary"];
                    if ($row["functional"] == "") {
                      $functional = $row["functional"];
                    } else {
                      $functional = " - ".$row["functional"];
                    }
                   print "<option value= \"{$position_id}\">$position $functional</option>";
                  }
                ?>
            </select>
     </div>

      <div class="three wide field">
         <label>Step No.</label>
          <input  id="editStep" type="number" placeholder="No" autocomplete="off" required="">
      </div>

       <div class="three wide field">
            <label>Item No:</label>
              <input  id="editItem" type="text" placeholder="Item No" autocomplete="off" required="">
        </div>
        
        <div class="three wide field">
            <label>Page No:</label>
              <input id="editPage"  type="number" placeholder="Page" autocomplete="off" required="">
        </div>
    
  </div>

    <div class="three fields">
      <div class="eight wide field">
      <label>Original Appointment</label>
        <input  id="editOriginal" type="date" placeholder="Select Department" autocomplete="off" required="">
      </div>
      <div class="eight wide field">
      <label>Last Promotion:</label>
        <input  id="editastPromo" type="date" placeholder="Select Department" autocomplete="off" required="">
      </div>

  </div>
  
  <div class="four fields">
    <div class="seven wide field">
      <label>Vacated By:</label>
       
                  <select id="editVacator">
                      <option value="">Vacated by</option>
                     <?php $result = $mysqli->query("SELECT * FROM `employees`");
                    while ($row= $result->fetch_assoc()){
                          $employees_id = $row["employees_id"];
                          $firstName = $row["firstName"];
                          $middleName = $row["middleName"];
                          $lastName = $row["lastName"];
                          $extName = $row["extName"];
                          
                        
                            print "<option value=\"{$firstName} {$middleName} {$lastName} {$extName}\"> {$firstName} {$middleName} {$lastName} {$extName}</option>";
                        }
                ?>
            </select>
    </div>

  
      <div class="four wide field">
        <label>Reason of Vacancy:</label>
            <select id="editReason">
                <option value="">---</option>
                <option value="transfer">Transfer</option>
                <option value="promotion">Promotion</option>
                <option value="retirement">Retirement</option>
                <option value="others">Others</option>    
            </select>
        </div>

      <div class="five wide field">
          <label> - </label>
            <input  id="editOther" type="text" placeholder="Other reason" >
      </div>
  </div>
 
  <div class="two fields">
        <div class="eight wide field">
          <label>Supervisor:</label>
             <select id="editSupervisor">
                     <option value="">Supervisor</option>
                     <?php $result = $mysqli->query("SELECT * FROM `employees`");
                       while ($row= $result->fetch_assoc()){
                          $employees_id = $row["employees_id"];
                          $firstName = $row["firstName"];
                          $middleName = $row["middleName"];
                          $lastName = $row["lastName"];
                          $extName = $row["extName"];

                            print "<option value=\"{$firstName} {$middleName} {$lastName} {$extName}\"> {$firstName} {$middleName} {$lastName} {$extName}</option>";
                          }
                ?>
            </select>
        </div>

        <div class="eight wide field">
          <label>Abolish ?:</label>
            <select class="ui fluid dropdown" id="editAbolish">
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
      Update
      <i class="checkmark icon"></i>
    </div>
  </div>
</div>


<!----end---->


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
      <th rowspan="2"></th>
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
