<script type="text/javascript">
  $(document).ready(function() {
    $(".dropdown").dropdown();
    $('#addEmp').click(function(event) {
      $.post('umbra/cmr/configs.php', {
        empId :  $("#drp").dropdown('get value'),
        cmr : <?=$_GET['cmr']?>
      }, function(data, textStatus, xhr) {
          if(data=='1'){
            cmpEmpView(<?=$_GET['cmr']?>);
          }else{
            alert(data);
          }
      });
    });

    cmpEmpView(<?=$_GET['cmr']?>);


  });
</script>
 <div class="ui borderless blue inverted mini menu noprint">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
    <div class="item">
     <h3><i class="icon line chart"></i> COACHING AND MONITORING REPORT for Year <?=$_GET['cmReport']?><span></span></h3>
   </div>
   <div class="right item">
    <div class="ui right input">
    </div>  
  </div>
</div>
  <div class="ui action input" style="width:500PX;margin-left: 25%">
          <div class="ui fluid search selection dropdown" id="drp">
          <input type="hidden" name="Employee">
          <i class="dropdown icon"></i>
          <div class="default text">Employee</div>
          <div class="menu">
            <?=drpemp($mysqli)?>
          </div>
          </div>
        <div class="ui primary button" id="addEmp">ADD</div>
  </div>
<table class="ui celled table">
  <thead style="text-align: center">
    <tr>
      <th colspan="4">Fullname</th>
      <th rowspan="2">Department</th>
      <th rowspan="2">Position</th>
      <th rowspan="2">Options</th>
    </tr>
    <tr>
      <th>Lastname</th>
      <th>Given Name</th>
      <th>MI.</th>
      <th style="font-size:11px">Ext.<br>Name</th>
    </tr>
  </thead>
  <tbody id="cmpEmpView"> 
    <tr>
      <td colspan="7" style="text-align: center">
        <img src="assets/images/loading.gif" style="transform:scale(0.1);margin-top:-100px">
      </td>
    </tr>
  </tbody>
</table>
                                       <!-- Modal add -->
<div class="ui fullscreen modal" id="addcmrbtnModal">
    <center>
      <img src="assets/images/loading.gif" style="transform:scale(0.1);margin-top:-100px">
    </center>
</div>
                                       <!-- Modal add -->
<?php

function drpemp($mysqli){
  $emp = "SELECT * FROM employees where status='ACTIVE'";
  $emp = $mysqli->query($emp);
  $view = "   <div class='item' data-value=''></div>";
  while ($row = $emp->fetch_assoc()) {
    $view .= "
    <div class='item' data-value='$row[employees_id]'>$row[firstName] $row[lastName]</div>
    ";
  }
  return $view;
}
?>