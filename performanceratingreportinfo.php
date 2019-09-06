<?php $title = "Performance Rating Report"; require_once "header.php";
require_once "_connect.db.php";
$prr_id = $_GET["prr_id"];
$type = $_GET["type"];
?>

<script type="text/javascript">
$(document).ready(function() {
  $(load);
  $(Depshow)
  $('.menu .item').tab();

});
function _(el){
  return document.getElementById(el)
}
function Depshow(){
  if(_("depView").value=="") {
    _("_table").style.visibility = "hidden";
  }else{
    _("_table").style.visibility = "visible";
  }
}
function load(){
  $.post('performanceratingreportinfo_proc.php', {
    load: true,
    prr_id: <?php echo $prr_id;?>,
    type: "<?php echo $type;?>"
  }, function(data, textStatus, xhr) {
    $("#tableDiv").html(data);
  });
}
function load2(i){

  $.post('umbra/prrDepartmentData.php', {
    dep:f(i.name)['departments'].value,
    prrc_id:<?=$_GET['prr_id']?>
  }, function(data, textStatus, xhr) {
    $('#DepartmentBody').html(data);
    Depshow();
  });
  return(false);
}
function addNew(){
  $("#dropdown_period_add").dropdown({showOnFocus: false});
  $("#dropdown_type_add").dropdown({showOnFocus: false});
  $("#modal_add").modal({
    closable: false,
    onDeny: function (){
      $(clear);
    },
    onApprove: function (){
      $.post('performanceratingreport_proc.php', {
        addNew: true,
        dropdown_period_add: $("#dropdown_period_add").dropdown("get value"),
        input_year_add: $("#input_year_add").val(),
        dropdown_type_add: $("#dropdown_type_add").dropdown("get value"),
        input_agency_add: $("#input_agency_add").val(),
        input_address_add: $("#input_address_add").val(),
      }, function(data, textStatus, xhr) {
        $(load);
      });
    }
  }).modal("show");
}
function clear(){
  $("#dropdown_period_add").dropdown("clear defaults");
  $("#dropdown_type_add").dropdown("clear defaults");
  $("#input_year_add").val("");
  $("#input_agency_add").val("");
  $("#input_address_add").val("");
}
function stateColor(id,empId,prr_id,Scolor){
  eventColor = event;
  $.post('umbra/PrrSaveRate.php', {
    prrList: id,
    prr_id: prr_id,
    empId: empId,
    Scolor:Scolor
  }, function(data, textStatus, xhr) {
    if(data==1){
      if(Scolor=="C"){
        back = "CYAN";
      }else if(Scolor=='Y'){
        back = 'YELLOW';
      }else if(Scolor=='W'){
        back = 'WHITE';
      }
      eventColor.srcElement.parentElement.parentElement.style.background = back;
    }
  });
}

function ratingModal(id,empId,prr_id){
  $('#rating_modal').modal('show');
  $("#rating_modal").html("<center><img style='transform: scale(0.1); margin-top: -200px;' src='assets/images/loading.gif'></center>");
  $.post('umbra/ratingAjaxForm.php', {
    prrList: id,
    prr_id: prr_id,
    empId: empId
  }, function(data, textStatus, xhr) {
    if(textStatus=="success"){
      $("#rating_modal").html(data)
    }else{
      $("#rating_modal").html("<center><h1>Something went Wrong</h1></center>");
    }

  });
}

function adrate(i){
  inputedData = parseFloat(i.value);
  if(inputedData>5){
    i.value=5;
    $("#adjectiveRate").val("Outstanding");
  }
  if (inputedData<=1) {
    $("#adjectiveRate").val("P");
  }else if(inputedData<=2&&inputedData>=0){
    $("#adjectiveRate").val("US");
  }else if(inputedData<=3 && inputedData>=2){
    $("#adjectiveRate").val("S");
  }else if(inputedData<=4 && inputedData>=3){
    $("#adjectiveRate").val("VS");
  }else if(inputedData<=5 && inputedData>=4){
    $("#adjectiveRate").val("O");
  }else{
    $("#adjectiveRate").val("Undefined value");
  }
}

function f(el){
  return  document.forms[el];
}

function rateDataSave(i){
  prrList = f(i.name)['prrList'].value;
  empId = f(i.name)['empId'].value;
  prr_id = f(i.name)['prr_id'].value;
  appraisalType = f(i.name)['appraisalType'].value;
  appraisalDate = f(i.name)['appraisalDate'].value;
  numericalRating = f(i.name)['numericalRating'].value;
  adjectiveRate = f(i.name)['adjectiveRate'].value;
  remarks = f(i.name)['remark'].value;
  comments = f(i.name)['comment'].value;
  DataSub = f(i.name)['DataSub'].value;

  $.post('umbra/PrrSaveRate.php', {
    prrList : prrList,
    empId : empId,
    prr_id : prr_id,
    appraisalType : appraisalType,
    appraisalDate : appraisalDate,
    numericalRating : numericalRating,
    adjectiveRate : adjectiveRate,
    remarks : remarks,
    comments : comments,
    DataSub : DataSub
  }, function(data, textStatus, xhr) {
    if (textStatus=='success') {
      load();
      $('#rating_modal').modal('hide');
    }
  });

  return(false);

}

function find(i){
  $("#tableBody tr").filter(function(index) {
    $(this).toggle($(this).text().toLowerCase().indexOf(i.value.toLowerCase())>-1)
  });
}
function removePerInfo(i){
  el = event.srcElement;
  con = confirm("Are you sure?");
  if(con){
    $.post('umbra/PrrRemoveRate.php', {
      prrDataRemove:i
    }, function(data, textStatus, xhr) {
      if(data==1){
        el.parentElement.parentElement.remove();
      }
    });
  }
}

</script>
<?php
$title = title($mysqli);

?>
<div class="ui container">
  <div class="ui borderless blue inverted mini menu noprint">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
    <div class="item">
      <h3><i class="icon line chart"></i> PERFORMANCE RATING REPORT <span>(<?=$title['period']?> <?=$title['year']?>)</span></h3>
    </div>
    <div class="right item">
      <div class="ui right input">
        <button class="ui icon blue mini button" onclick="print()" style="margin-right: 10px; width: 70px;"><i class="icon print"></i> Print</button>
        <!--       <div class="ui icon fluid input" style="width: 300px;">
        <input id="_search" type="text" placeholder="Search..." onkeyup="find(this)">
        <i class="search icon"></i>
      </div> -->
    </div>
  </div>
</div>
</div>
<div class="ui container" style="padding: 20px; min-height: 14500px;">
  <style type="text/css">
  .customTable, tr,th,td{
    border: 1px solid grey;
    border-collapse: collapse;
    padding: 3px;
  }
  .customTable2, tr{
    width: 100%;
  }
  .noborder{
    border-top:1px solid white;
    border-bottom: 1px solid white;
    border-left: 1px solid white;

  }
  .noright{
    border-right: 1px solid white;
  }
  </style>
  <!-- <button class="ui button"> Populate List</button> -->

  <div class="ui top attached tabular menu noprint">
    <a class="item active" data-tab="first">Overall</a>
    <a class="item" data-tab="second">Department</a>
  </div>
  <div class="ui bottom attached tab segment active" style="border: none" data-tab="first">
    <div class="noprint" style="float: right;padding: 10px;background: black;border-radius:10px">
      <h5 style="color: white"><b>Legend</b></h5>
      <div style="color:cyan"><b>cyan</b> - not submited</div>
      <div style="color:yellow"><b>yellow</b> - reviewed</div>
      <div style="color:white"><b>white</b> - validated</div>
    </div>
    <div class="ui icon fluid input noprint" style="width: 300px;margin:auto">
      <input id="_search" type="text" placeholder="Search..." onkeyup="find(this)">
      <i class="search icon"></i>
    </div><br>
    <div style="text-align: center">
      <div style="width: 100%">
        <center>
          <div style="float:left;width:37%;">
            <img src="assets/images/bayawanLogo.png" width="90px" style="margin-left:50%;margin-top: 10px">
          </div>
          <div style="float: left;width:25%;">
            <h5>
              Republic of the Philippines<br>Province of Negros Oriental<br>CITY OF BAYAWAN
            </h5>
          </div>
          <div style="float: left;width:37%">

          </div>
          <div style="clear:both"></div>
        </center>
      </div>
      <div style="width:100%">
        <h3>
          <?=$title['period']?> <?=$title['year']?><br>
          PERFORMANCE RATING REPORT<br>
          <?=$_GET['type']?>
        </h3>
      </div>
      <br>
    </div>
    <p>Agency Name: <b> LGU-BAYAWAN CITY</b></p>
    <p>Address: <b> Bayawan City, Negros Oriental</b></p>
    <!-- <p>Legend</p> -->
    <div  id="tableDiv">
      <table class="customTable">
        <thead style="background-color: lightgrey;">
          <tr>
            <th rowspan="2"></th>
            <th rowspan="2">CSID</th>
            <th colspan="4">Employees Name</th>
            <th rowspan="2">Gender</th>
            <th rowspan="2">Date Submitted</th>
            <th rowspan="2">Appraisal Type</th>
            <th rowspan="2">Date Appraised (mm/dd/yy)</th>
            <th colspan="2">Rating</th>
            <th rowspan="2">Remarks</th>
            <th rowspan="2" colspan="4" class="noprint">Option</th>
          </tr>
          <tr>
            <th>Last Name</th>
            <th>Given Name</th>
            <th>Middle Name</th>
            <th>Name Ext.</th>
            <th>Numerical</th>
            <th>Adjectival</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          <tr style="text-align: center"><td colspan="14" style=""><img style="transform: scale(0.1); margin-top: -200px;" src="assets/images/loading.gif"></td></tr>
        </tbody>
      </table>
    </div>
    <br>
    <br>
    <!-- Modal Add Rating-->
    <div class="ui modal" id="rating_modal"></div>
  </div>
  <div class="ui bottom attached tab segment" style="border: none" data-tab="second">

    <form name="departmentsForm" class="noprint" onsubmit="return load2(this)" >
      <div class="ui form" style="margin-left: 26%">
        <label>Select Department</label>
        <div  class="ui fields">
          <div class="eight wide field">
            <select  class="ui dropdown" id="depView" name="departments">
              <option></option>
              <?php
              $sql = "SELECT * FROM `department`";
              $result = $mysqli->query($sql);
              while ($row = $result->fetch_assoc()) {
                echo "<option value='$row[department_id]'>$row[department]</option>";
              }
              ?>
            </select>
          </div>
          <div class="three wide field">
            <input class="ui primary button" type="submit" value="GO">
          </div>
        </div>
      </div>
    </form>


    <table id="_table" class="customTable customTable2">
      <thead style="background-color: lightgrey;">
        <tr>
          <th rowspan="2">NO.</th>
          <th colspan="4">Name</th>
          <th rowspan="2">Numerical Rating</th>
          <th rowspan="2">Adjectival Rating</th>
          <th rowspan="2">Comments</th>
        </tr>
        <tr>
          <th>Last Name</th>
          <th>Given Name</th>
          <th>MI</th>
          <th style="font-size:10px;width: 30px">Name Ext.</th>
        </tr>
      </thead>
      <tbody id="DepartmentBody"></tbody>
    </table>




  </div>

</div>




<?php require_once "footer.php";
function title($mysqli){
  $sql = "SELECT * from prr where prr_id = '$_GET[prr_id]'";
  $result = $mysqli->query($sql);
  $row = $result->fetch_assoc();
  return $row;
}



?>
