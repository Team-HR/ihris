<?php $title = "Performance Rating Report"; require_once "header.php";?>

<script type="text/javascript">
$(document).ready(function() {
  // $(modal_progress);
  // $("#modal_progress").modal({closable: false}).modal("show");
  $(load);
  $("#dropdown_period_add").dropdown({showOnFocus: false});
  $("#dropdown_type_add").dropdown({showOnFocus: false});

});
function load(){
  $.post('performanceratingreport_proc.php', {
    load: true
  }, function(data, textStatus, xhr) {
    $("#tableBody").html(data);
  });
}
function addNew(){
  $('#modal_progress').modal('show');
  $("#modal_add").modal({
    closable: false,
    onDeny: function (){
      $('#modal_progress').modal('hide');
      $(clear);
    },
    onApprove: function (){
      saveInterval =  setInterval(function () {
        CountSaveData();
      }, 500);
      $.post('performanceratingreport_proc.php', {
        addNew: true,
        dropdown_period_add: $("#dropdown_period_add").dropdown("get value"),
        input_year_add: $("#input_year_add").val(),
        dropdown_type_add: $("#dropdown_type_add").dropdown("get value"),
        input_agency_add: $("#input_agency_add").val(),
        input_address_add: $("#input_address_add").val(),
      }, function(data, textStatus, xhr) {
        if (data!='1') {
          clearInterval(saveInterval);
          alert(data);
        }else{
          clearInterval(saveInterval);
          $(load);
        }
        $('#modal_progress').modal('hide');
      });
    }
  }).modal("show");
}
function CountSaveData(){
  xml = new XMLHttpRequest();
  fd = new FormData();
  fd.append('savingCount',true);
  xml.onreadystatechange = function(){
    document.getElementById('savedData').innerHTML = this.responseText;
  }
  xml.open("POST","performanceratingreport_proc.php",true);
  xml.send(fd);
}
function clear(){
  $("#dropdown_period_add").dropdown("clear defaults");
  $("#dropdown_type_add").dropdown("clear defaults");
  $("#input_year_add").val("");
  $("#input_agency_add").val("");
  $("#input_address_add").val("");
}
</script>
<div class="ui segment" >
  <div class="ui container">
    <div class="ui borderless blue inverted mini menu noprint">
      <div class="left item" style="margin-right: 0px !important;">
        <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
          <i class="icon chevron left"></i> Back
        </button>
      </div>
      <div class="item">
        <h3><i class="icon line chart"></i> PERFORMANCE RATING REPORT</h3>
      </div>
      <div class="right item">
        <div class="ui right input">
          <button class="ui icon mini green button" onclick="addNew()" style="margin-right: 5px;"><i class="icon plus"></i>Add</button>
          <button class="ui icon blue mini button" onclick="print()" style="margin-right: 10px; width: 70px;"><i class="icon print"></i> Print</button>
          <div class="ui icon fluid input" style="width: 300px;">
            <input id="_search" type="text" placeholder="Search...">
            <i class="search icon"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="ui container" style="padding: 20px;">
    <table id="_table" class="ui very basic compact selectable small table">
      <thead>
        <tr>
          <th>Category</th>
          <th>Period</th>
          <th>Year</th>
          <th>For</th>
          <th>Options</th>
          <!-- <th></th> -->
        </tr>
      </thead>
      <tbody id="tableBody"></tbody>
    </table>

    <div class="ui tiny modal" id="modal_add">
      <div class="header">Add New</div>
      <div class="content">
        <div class="ui form">
          <div class="fields">
            <div class="six wide field">
              <label>Period:</label>
              <div class="ui selection compact dropdown" id="dropdown_period_add">
                <input type="hidden">
                <i class="dropdown icon"></i>
                <div class="default text">Period</div>
                <div class="menu">
                  <div class="item" data-value="January - June">January - June</div>
                  <div class="item" data-value="July - December">July - December</div>
                </div>
              </div>
            </div>
            <div class="four wide field">
              <label>Year:</label>
              <input type="text" id="input_year_add" placeholder="Year">
            </div>
            <div class="six wide field">
              <label>For (Permanent/Casual):</label>
              <div class="ui selection compact dropdown" id="dropdown_type_add">
                <input type="hidden">
                <i class="dropdown icon"></i>
                <div class="default text">Permanent/Casual</div>
                <div class="menu">
                  <div class="item" data-value="Permanent">Permanent</div>
                  <div class="item" data-value="Casual">Casual</div>
                </div>
              </div>
            </div>
          </div>

          <div class="eight wide field">
            <!-- <label>Agency Name:</label> -->
            <input type="hidden" id="input_agency_add" placeholder="Agency Name">
          </div>
          <div class="field">
            <!-- <label>Address:</<label></label>el> -->
            <input type="hidden" id="input_address_add" placeholder="Address">
          </div>

        </div>
      </div>
      <div class="actions">
        <div class="ui basic small button approve">Save</div>
        <div class="ui basic small button deny">Cancel</div>
      </div>
    </div>
  </div>
  <div class="ui basic modal" id="modal_progress">
    <div class="content">
      <div class="ui container center aligned">
        <img width="100" height="100" src="assets/images/loading.gif">
        <div class="ui basic segment">Saved! Populating list, please wait... <span id="savedData"></span> Saved </div>
      </div>
    </div>
  </div>
  <div class="ui inverted dimmer" id='DeleteDimmer'>
    <div class="ui text loader" style="top:100px;position:fixed">Deleting Data( <span id="leftCount">calculating</span> data left)</div>
  </div>
</div>
<script>
function deleteBtn() {
  con = confirm("Are you sure to remove this list?");
  if(con){
    $('#DeleteDimmer').dimmer({
      onShow:function(){
        window.onbeforeunload = function(){
          return "";
        }
      },
      closable:false
    }).dimmer("show");
    el = event.srcElement;
    xml = new XMLHttpRequest();
    fd = new FormData();
    fd.append('removePrrData',el.attributes['data-id'].value);
    // fd.append('countPrrData',el.attributes['data-id'].value);
    interval = setInterval(function () {
      countLeft(el);
    }, 500);
    xml.onreadystatechange = function(){
      console.log(this.responseText);
      if(this.responseText==1){
        clearInterval(interval);
        el.parentElement.parentElement.remove();
        window.onbeforeunload = null;
        $("#DeleteDimmer").dimmer("hide");
      }
    }
    xml.open("POST","performanceratingreport_proc.php",true);
    xml.send(fd);
  }
}
function countLeft(dataId){
  xml = new XMLHttpRequest();
  fd = new FormData();
  fd.append('countPrrData',dataId.attributes['data-id'].value);
  xml.onreadystatechange = function(){
    document.getElementById('leftCount').innerHTML  = this.responseText;
  }
  xml.open("POST","performanceratingreport_proc.php",true);
  xml.send(fd);
}
</script>
<?php require_once "footer.php";?>
