<?php 
	$title = "Positions"; 
	require_once "header.php";
?>

<div class="ui container">

  <div class="ui borderless blue inverted mini menu">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
    <div class="item">
      <h3><i class="briefcase icon"></i>Report on Plantilla</h3>
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

<table id="pos_table" class="ui teal selectable very compact small striped table">
  <thead>
    <tr>
      <th></th>
      <th>Position Title</th>
      <th>Functional</th>
      <th>Level</th>
      <th>Category</th>
      <th>Salary Grade</th>
      <th>Schedule</th>
      <th></th>
    </tr>
  </thead>
  <tbody id="tableContent">
  </tbody>
</table>

  </div>
</div>
<?php 
	require_once "footer.php";
?>
