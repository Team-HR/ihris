<?php 
  $title = "Plantilla"; 
  require_once "header.php"; 
?>
   

<script type="text/javascript">

    $("#incumbent").dropdown();
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

  function editRow(id,position,incumbent,department, step, schedule,item_no,abolish){

    // alert(position);
    $("#editPosition").dropdown('set selected',position);
    $("#editDept").dropdown('set selected',department); 
    $("#editStep").val(step);
    $("#editSchedule").dropdown('set selected',schedule);
    $("#editItem").val(item_no);
    $("#editAbolish").dropdown('set selected',abolish);
     $("#editIncumbent").dropdown('set selected',incumbent);
    $("#editModal").modal({
      onApprove: function(){

        // alert($("#editDeptInput").val());
        $.post('plantilla_proc.php', {
          editPlantilla: true,
          id: id,
          position: $("#editPosition").val(),
          incumbent: $("#editIncumbent").val(),
          department: $("#editDept").val(), 
          schedule: $("#editSchedule").val(),
          step: $("#editStep").val(),
          item_no: $("#editItem").val(),
          abolish: $("#editAbolish").val(),

        }, function(data, textStatus, xhr) {
          //alert(data);
         $(load);
          $("#updateMsg").transition({
            animation: 'fly down',
            onComplete: function () {
              setTimeout(function(){ $("#updateMsg").transition('fly down'); }, 1000);
            }
          });
        });
      },
    }).modal('show');

  }

  function vacateRow(plantilla_id,incumbent,position,endService,reason_of_vacancy,other){
    $("#incumbent").val(incumbent);
    $("#editPos").val(position);
    $("#vacateModal").modal({
      onApprove: function(){
        $.post('plantilla_proc.php', {
          vacatePos: true,
          plantilla_id:plantilla_id,
          incumbent: $("#incumbent").val(),
          endService: $("#addEnd").val(),
          reason_of_vacancy: $("#addReason").val(),
          other: $("#addOther").val(),   
        }, function(data, textStatus, xhr) {
          $(load);
          $("#vacateMsg").transition({
            animation: 'fly down',
            onComplete: function () {
              setTimeout(function(){ $("#vacateMsg").transition('fly down'); }, 1000);
            }
          });
         //alert(data);
        });
      }
    }).modal("show");
  }
 
  function addPlantillas(){
    $.post("plantilla_proc.php",{
      addPlantilla:true,
      position: $("#addPos").val(),
      department: $("#addDept").val(),
      step: $("#addStep").val(),
      schedule: $("#addSchedule").val(),
      item_no: $("#addItem").val(),
      abolish: $("#addAbolish").val(),
    },function(data,status){  
      $(load);
      //alert(data);
  
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
          $("#deleteMsg").transition({
            animation: 'fly down',
            onComplete: function () {
              setTimeout(function(){ $("#deleteMsg").transition('fly down'); }, 1000);
            }
          });
        });
      }
    }).modal("show");
  }
  
</script>
<!-- alerts start -->
<div id="saveMsg" class="" style="top: 15px; display: none; position: fixed; z-index: 10; width: 100%; left: 0; text-align: center;">
   <div class="ui center green inverted aligned segment" style="width: 100px; margin-left: auto; margin-right: auto;">
    Added
    </div>
</div>

<div id="deleteMsg" class="" style="top: 15px; display: none; position: fixed; z-index: 10; width: 100%; left: 0; text-align: center;">
   <div class="ui center red inverted aligned segment" style="width: 100px; margin-left: auto; margin-right: auto;">
   Deleted
   </div>
</div>

<div id="updateMsg" class="" style="top: 15px; display: none; position: fixed; z-index: 10; width: 100%; left: 0; text-align: center;">
   <div class="ui center yellow inverted aligned segment" style="width: 100px; margin-left: auto; margin-right: auto;">
   Updated
   </div>
</div>

<div id="vacateMsg" class="" style="top: 15px; display: none; position: fixed; z-index: 10; width: 100%; left: 0; text-align: center;">
   <div class="ui center orange inverted aligned segment" style="width: 100px; margin-left: auto; margin-right: auto;">
     Vacated
   </div>
</div>
<!-- end alerts -->

<!-- delete pos start -->
<div id="deleteModal" class="ui mini modal">
    <i class="close icon"></i>
    <div class="header">
      Delete Plantilla Details
    </div>
    <div class="content">
      <p>Are you sure you want to delete this details?</p>
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

<!-- vacate modal start-->
<div id="vacateModal" class="ui mini modal">
  <i class="close icon"></i>
  <div class="header">
  Vacate Position
  </div>
  <div class= "ui content">
       <div class="ui form">
            
                  <input type="text" id="incumbent"hidden > </input>
        
              <div class="field">
                  <label >Position Vacated:</label>  
                 <input type="text" id="editPos" disabled> </input>
             </div>

               <div class="field">
                  <label>Last day of service:</label>
                  <input type="date" name="" id="addEnd">
               </div>
      
               <div class="field">
                   <label>Reason of Vacancy:</label>
                      <select id="addReason" class="ui search dropdown">
                          <option value="">Select Reason</option>
                          <option value="Transfer">Transfer</option>
                          <option value="promotion">Promotion</option>
                          <option value="Retirement">Retirement</option>
                          <option value="Others:">Others</option>
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
<div id="addModal" class="ui mini modal">
  <div class="header">
   Plantilla Detail
  </div>
<div class="content">
  <div class="ui form">
   
            <div class="field">
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
              
                <div class="field">
                <label>Position:</label>
                   <select class= "ui search dropdown" id="addPos">
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
  <div class="two fields">
      <div class="field">
         <label>Step No.</label>
          <input  id="addStep" type="number" placeholder="No">
      </div>

   
       <div class="field">
            <label>Item No:</label>
              <input  id="addItem" type="text" placeholder="Item No">
        </div>
    
  </div>


      <div class="field">
         <label>Salary Shedule</label>
           <select id="addSchedule" class="ui search dropdown">
                <option value="">---</option>
                <option value="1">1st Class</option>
                <option value="2">2nd Class</option>
            </select>
      </div>

       <div class="field">
          <label>Abolish ?:</label>
            <select class="ui search dropdown" id="addAbolish">
              <option value="">---</option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
          </select>     
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
<div id="editModal" class="ui mini modal">
  <div class="header">
   Edit Plantilla Detail
  </div>
<div class="content">
  <div class="ui form">
        <div class="field">
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
     <div class="field">
            <label>Position:</label>
               <select class= "ui search dropdown" id="editPosition">
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

  <div class="two fields">
  
      <div class="field">
         <label>Step No.</label>
          <input  id="editStep" type="number" placeholder="Step No">
      </div>

   
       <div class="field">
            <label>Item No:</label>
              <input  id="editItem" >
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
              <option value="Yes">Yes</option>
              <option value="No">No</option>
          </select>     
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
      <h3><i class="briefcase icon"></i>Plantilla</h3>
    </div>
    <div class="right item">
      <!-- 
      <button onclick="addModalFunc()" class="circular blue ui icon button" style="margin-right: 10px;" title="Add New Personnel">
        <i class="icon plus circle"></i>
      </button> -->
    <div class="ui right input">
      <button class="ui icon mini green button" onclick="addModalFunc()" style="margin-right: 5px;" title="Add Detail"><i class="icon plus"></i>Add</button>
      <div class="ui icon fluid input" style="width: 300px;" >
        <input id="data_search" type="text" placeholder="Search..." > 
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
