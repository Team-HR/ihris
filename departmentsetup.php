<?php 
	$title = "Departments"; 
	require_once "header.php";
?>
<script type="text/javascript">
$(document).ready(function() {
        $("#tabs .item").tab();
        $("#dept_search").on("keyup", function() {
          var value = $(this).val().toLowerCase();
          $("#dept_table tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
          });
        });
        $(load);
        $("#clearBtn").click(function(event) {
          $("#newDept").val("");
        });
  });
  
  function load(){
    $("#tableContent").load("departmentsetup_proc.php",{
      load: true
    });
  }
  
  function addDept(){
    $.post("departmentsetup_proc.php",{
      addDepartment:true,
      newDept: $("#newDept").val()
    },function(data,status){
      $(load);
      $("#newDept").val("");
    });
  }
  
  function editDept(department_id,department){
    // alert(department_id+" and "+department);
    $("#editDeptInput").val(department);
    $("#renameModal").modal({
      onApprove: function(){
        // alert($("#editDeptInput").val());
        $.post('departmentsetup_proc.php', {
          editDepartment: true,
          department_id: department_id,
          department: $("#editDeptInput").val(),
        }, function(data, textStatus, xhr) {
          /*optional stuff to do after success */
          // alert(data);
          $(load);
        });

      },
    }).modal('show');

  }
  function deleteRow(department_id){
    $("#deleteModal").modal({
      onApprove: function(){
        $.post('departmentsetup_proc.php', {
          deleteDepartment: true,
          department_id: department_id,
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
          $(addDept);
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
<!-- savae msg alert end -->
<div class="ui container">
<!-- add dept start -->
<div id="addModal" class="ui tiny modal">
  <!-- <i class="close icon"></i> -->
  <div class="header">
    Add Department
  </div>
  <div class="content">
<div class="ui form">
    <div class="field">
    <div class="ui action input">
      <input id="newDept" type="text" placeholder="New Department">
      <button id="clearBtn" class="ui button">Clear</button>
    </div>
    </div>
</div>
  </div>
  <div class="actions">
    <div class="ui deny button mini">
      Cancel
    </div>
    <div class="ui approve blue right labeled icon button mini">
      Save
      <i class="checkmark icon"></i>
    </div>
  </div>
</div>
<!-- add dept end -->
<!-- rename dept start -->
<div id="renameModal" class="ui mini modal">
  <!-- <i class="close icon"></i> -->
  <div class="header">
    Edit/Rename Department
  </div>
  <div class="content">
    <div class="ui left icon fluid input">
		  <input id="editDeptInput" type="text">
		  <i class="building outline icon"></i>
		</div>
  </div>
  <div class="actions">
    <div class="ui deny button mini">
      Cancel
    </div>
    <div class="ui blue right labeled icon  approve button mini">
      Save
      <i class="checkmark icon"></i>
    </div>
  </div>
</div>
<!-- rename dept end -->
<!-- delete dept start -->
<div id="deleteModal" class="ui mini modal">
  <!-- <i class="close icon"></i> -->
  <div class="header">
    Delete Department
  </div>
  <div class="content">
    <p>Are you sure you want to delete this department?</p>
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

<div class="ui container">
  
<div class="ui borderless blue inverted mini menu">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
  <div class="item">
  	<h3><i class="building icon"></i> Department Setup</h3>
  </div>
  <div class="right item">
    <div class="ui right input">
      <button class="ui icon mini green button" onclick="addModalFunc()" style="margin-right: 5px;" title="Add New Department"><i class="icon plus"></i>Add</button>
      <div class="ui icon fluid input" style="width: 300px;">
        <input id="dept_search" type="text" placeholder="Search...">
        <i class="search icon"></i>
    </div>
    </div>
  </div>
</div>

<div class="ui top attached tabular menu" id="tabs">
  <a class="item active" data-tab="departments">Department</a>
  <!-- <a class="item" data-tab="sections">Sections</a> -->
</div>
<div class="ui bottom attached segment tab active" data-tab="departments">
  <div id="tableContent"></div>
</div>
<div class="ui bottom attached segment tab" data-tab="sections">
  <div id="sectionsContainer"></div>
</div>

</div>
</div>
<?php 
	require_once "footer.php";
?>
