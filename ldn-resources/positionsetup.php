<?php 
	$title = "Positions"; 
	require_once "header.php";
?>
<script type="text/javascript">
    $(document).ready(function() {
    $("#inputPos").dropdown();
    $("#levelDropDown").dropdown();
    $("#levelDropDownEdit").dropdown();
    $("#catDropDown").dropdown();
    $("#catDropDownEdit").dropdown();

    $("#pos_search").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#tableContent tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

    $(load);
  });
  
  function load(){
    $("#tableContent").load("positionsetup_proc.php",{
      load: true
    });
  }
    function clear() {
      $("#inputPos").val("");
      $("#inputFunc").val("");
      $("#levelDropDown").dropdown('restore defaults');
      $("#catDropDown").dropdown('restore defaults');
      $("#salaryGrade").val("");
    }

  function addPos(){
    $.post("positionsetup_proc.php",{
      addPosition:true,
      position: $("#inputPos").val(),
      functional: $("#inputFunc").val(),
      level: $("#levelDropDown").val(),
      category: $("#catDropDown").val(),
      salaryGrade: $("#salaryGrade").val(),
    },function(data,status){
      $(load);
      $(clear);
    });
  }

  function editPos(position_id,position,functional,level,category,salaryGrade){
    $("#editPosInput").val(position);
    $("#editFuncInput").val(functional);
    $("#levelDropDownEdit").val(level).change();
    $("#catDropDownEdit").val(category).change();
    $("#salaryGradeEdit").val(salaryGrade);

    $("#renameModal").modal({
      onApprove: function(){
        // alert($("#editDeptInput").val());
        $.post('positionsetup_proc.php', {
          editPosition: true,
          position_id: position_id,
          position: $("#editPosInput").val(),
          functional: $("#editFuncInput").val(),
          level: $("#levelDropDownEdit").val(),
          category: $("#catDropDownEdit").val(),
          salaryGrade: $("#salaryGradeEdit").val(),
        }, function(data, textStatus, xhr) {
          // $(load);
          // alert(data);
          $(load);
        });

      },
    }).modal('show');

  }
  function deleteRow(position_id){
    $("#deleteModal").modal({
      onApprove: function(){
        $.post('positionsetup_proc.php', {
          deletePosition: true,
          position_id: position_id,
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
          $(addPos);
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
<!-- add pos start -->
<div id="addModal" class="ui mini modal">
  <i class="close icon"></i>
  <div class="header">
    Add New Position
  </div>
  <div class="content">
<div class="ui form">
  <div class="fields">
    <div class="eight wide field">
      <label>Position:</label>
      <!-- <input id="inputPos" type="text" placeholder="Position"> -->
        <input  id="inputPos" list="Positions" name="position" type="text" placeholder="Position" autocomplete="off" required="">
          <datalist id="Positions">
          <?php
          require_once "_connect.db.php";
          $result = $mysqli->query("SELECT * FROM `positiontitles`");
              while ($rsltRow = $result->fetch_assoc()) {
                      print "<option value=\"{$rsltRow['position']}\">";
                  }
          ?>
          </datalist>
    </div>
    <div class="eight wide field">
      <label>Functional:</label>
      <input id="inputFunc" type="text" placeholder="Functional">
    </div>
  </div>
  <div class="fields">
    <div class="four wide field">
      <label>Level:</label>
      <select name="level" class="ui  fluid dropdown" id="levelDropDown">
        <option value="">Level</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
      </select>
    </div>
    <div class="seven wide field">
      <label>Category:</label>
      <select name="category" class="ui  fluid dropdown" id="catDropDown">
        <option value="">Category</option>
        <option value="Technical">Technical</option>
        <option value="Administrative">Administrative</option>
        <option value="Key Position">Key Position</option>
      </select>
    </div>
    <div class="five wide field">
      <label>Salary Grade:</label>
      <input id="salaryGrade" type="text" placeholder="SG">
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
<!-- add pos end -->
<!-- rename pos start -->
<div id="renameModal" class="ui mini modal">
  <i class="close icon"></i>
  <div class="header">
    Edit Position
  </div>
  <div class="content">

<div class="ui form">
  <!-- <div class="fields"> -->
    <div class="field">
      <label>Position:</label>
      <!-- <input id="editPosInput" type="text" placeholder="Position"> -->
        <input  id="editPosInput" list="positions" name="position" type="text" placeholder="Position" autocomplete="off" required="">
          <datalist id="positions">
          <?php
          $result = $mysqli->query("SELECT * FROM `positiontitles`");
              while ($rsltRow = $result->fetch_assoc()) {
                      print "<option value=\"{$rsltRow['position']}\">";
                  }
          ?>
          </datalist>
    </div>
    <div class="field">
      <label>Functional:</label>
      <input id="editFuncInput" type="text" placeholder="Functional">
    </div>
    <div class="fields">
      <div class="three wide field">
        <label>Level:</label>
        <select name="level" class="ui fluid dropdown" id="levelDropDownEdit">
          <option value="">lvl</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
        </select>
      </div>
      <div class="twelve wide field">
        <label>Category:</label>
        <select name="category" class="ui fluid dropdown" id="catDropDownEdit">
          <option value="">Category</option>
          <option value="Technical">Technical</option>
          <option value="Administrative">Administrative</option>
          <option value="Key Position">Key Position</option>
        </select>
      </div>
      <div class="three wide field">
        <label>SG:</label>
        <input id="salaryGradeEdit" type="text" placeholder="sg">
      </div>
    </div>
</div>

  </div>
  <div class="actions">
    <div class="ui deny button mini">
      Cancel
    </div>
    <div class="ui blue right labeled icon approve button mini">
      Save
      <i class="checkmark icon"></i>
    </div>
  </div>
</div>
<!-- rename pos end -->
<!-- delete pos start -->
<div id="deleteModal" class="ui mini modal">
  <i class="close icon"></i>
  <div class="header">
    Delete Position
  </div>
  <div class="content">
    <p>Are you sure you want to delete this Position?</p>
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
<div class="ui container">

  <div class="ui borderless blue inverted mini menu">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
    <div class="item">
      <h3><i class="briefcase icon"></i>Position Setup</h3>
    </div>
    <div class="right item">
      <!-- 
      <button onclick="addModalFunc()" class="circular blue ui icon button" style="margin-right: 10px;" title="Add New Personnel">
        <i class="icon plus circle"></i>
      </button> -->
    <div class="ui right input">
      <button class="ui icon mini green button" onclick="addModalFunc()" style="margin-right: 5px;" title="Add New Department"><i class="icon plus"></i>Add</button>
      <div class="ui icon fluid input" style="width: 300px;">
        <input id="pos_search" type="text" placeholder="Search...">
        <i class="search icon"></i>
      </div>
    </div>
      <!-- <div class="ui icon fluid input">
        <input id="pos_search" type="text" placeholder="Search...">
        <i class="search icon"></i>
      </div> -->


    </div>
  </div>
  <div class="ui container" style="min-height: 6190px;">
    <div></div>

<table id="pos_table" class="ui teal selectable very compact small striped table">
  <thead>
    <tr>
      <th></th>
      <th>Position Title</th>
      <th>Functional</th>
      <th>Level</th>
      <th>Category</th>
      <th>Salary Grade</th>
      <th></th>
    </tr>
  </thead>
  <tbody id="tableContent">
  </tbody>
</table>

  </div>
</div>
</div>
<?php 
	require_once "footer.php";
?>
