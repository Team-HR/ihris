<?php $title = "Request and Communications"; require_once "header.php"; require_once "_connect.db.php";?>

<script type="text/javascript">
  var employeesArray = [],
  othersArray = [],
  dateReceived = "",
  sortByYear = "all",
  sortByDept = "all";
  $(document).ready(function() {
    // alert("Disregard this message. Thank you.");
    var loading_el = $("#loading_el"),
        tableBody1 = $("#tableBody1");

    $("#sortYear").dropdown({
      onChange: function(value){
        sortByYear = value;
        load(sortByYear,sortByDept);
      }
    });

    $("#filter_deptConerned").dropdown({
      onChange: function (){
        $("#clearFilter").show();
        $("#clearFilter").addClass('loading');
        $("#tableBody1").html(loading_el);
        $("#table_search").val("");
        if ($(this).dropdown("get value") == "") {
          sortByDept = "all";

          $("#clearFilter").hide();
        } else {
          sortByDept = $(this).dropdown("get value");
        }
        $(load(sortByYear,sortByDept));
      },
    });

    $("#clearFilter").click(function(event) {
      $('#filter_deptConerned').dropdown('restore defaults');
      $(this).hide();
    });


    $("#inputAddType").dropdown();
    $("#editInputType").dropdown();
    $("#addDeptsList").dropdown();
    $("#editDeptsList").dropdown();

    $(load(sortByYear,sortByDept));
    
// search listAdded Start
    $("#inputSearchAdded").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $(".listAdded .item").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
// search listAdded End
// search listToAdd Start
    $("#inputSearchToAdd").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $(".listToAdd .item").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
// search listToAdd End
// search listAdded Start
    $("#inputSearchAddedEdit").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $(".listAddedEdit .item").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
// search listAdded End
// search listToAdd Start
    $("#inputSearchToEdit").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $(".listToAddEdit .item").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
// search listToAdd End

    $("#table_search").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#tableBody1 tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

  });

  function load(year,department_ids){

    $.post('reqsandcoms_proc.php', {
      load: true,
      year: year,
      department_ids: department_ids
    }, function(data, textStatus, xhr) {
      $("#tableBody1").html(data);
      $("#clearFilter").removeClass('loading');
    });
  }

  function addModalFunc(){
    $(loadListToAdd);
    $("#addModal").modal({
      closable: false,
      onDeny: function(){
        $(clear);
      },
      onApprove: function(){
        $.post('reqsandcoms_proc.php', {
          add: true,
          source: $("#addInputSource").val(),
          department_ids: $("#addInputDepartments").val(),
          subject: $("#addInputSubject").val(),
          fromDate: $("#addInputDate0").val(),
          toDate: $("#addInputDate1").val(),
          venue: $("#inputAddVenue").val(),
          type: $("#inputAddType").val(),
          employeesArray: employeesArray,
          othersArray: othersArray,
        }, function(data, textStatus, xhr) {
          $(clear);
          $(load(sortByYear,sortByDept));
          $(addedMsg);
        });
      }
    }).modal('setting', 'transition', 'scale').modal("show");
  }


// edit starts
function updateFunc(controlNumber){
  $(loadListToAddEdit(controlNumber));
  $.post('reqsandcoms_proc.php', {
    getRowData: true,
    controlNumber: controlNumber,
  }, function(data, textStatus, xhr) {
    var array = jQuery.parseJSON(data);
    $("#editControlNumber").html(array.controlNumber);
    $("#dateReceivedEdit").html(array.dateReceived);
    $("#editInputSource").val(array.source);
    $("#editDeptsList").dropdown("set exactly",array.department_ids);
    $("#editInputSubject").val(array.subject);
    $("#editInputDate0").val(array.fromDate);
    $("#editInputDate1").val(array.toDate);
    $("#editInputVenue").val(array.venue);
    $("#editInputType").dropdown("set selected",array.type);
    employeesArray = array.employees_ids;
    othersArray = array.others_array;
    $.each(array.employees_ids, function(index, val) {
     $.post('reqsandcoms_proc.php', {
      popListEmployees_id: true,
      employees_id: val
    }, function(data, textStatus, xhr) {
     $(".listAddedEdit").append(data);
   });
   });

    if (array.others_array != "") {
      $("#editOthersDiv").show();
      $.each(array.others_array, function(index, val) {
       $.post('reqsandcoms_proc.php', {
        popListOthers: true,
        name: val
      }, function(data, textStatus, xhr) {
       $("#editOthersContainer").append(data);
     });
     });
    }
  });
  $("#editModal").modal({
    closable: false,
    onDeny: function (){
      $(clear);
    },
    onApprove: function(){
      $.post('reqsandcoms_proc.php', {
        edit: true,
        controlNumber: controlNumber,
        source: $("#editInputSource").val(),
        department_ids: $("#editInputDepartments").val(),
        subject: $("#editInputSubject").val(),
        fromDate: $("#editInputDate0").val(),
        toDate: $("#editInputDate1").val(),
        venue: $("#editInputVenue").val(),
        type: $("#editInputType").val(),
        employeesArray: employeesArray,
        othersArray: othersArray,
      }, function(data, textStatus, xhr) {
        $(clear);
        $(load(sortByYear,sortByDept));
        $(savedMsg);
      });
    }
  }).modal("show");
}

function addOtherEdit(){
  
  if ($("#editOthersContainer") != null) {
    $("#editOthersDiv").show();  
  }
  var name = $("#editInputOther").val();
  othersArray.push(name);
  $.post('reqsandcoms_proc.php', {
    addOtherEdit: true,
    name: name
  }, function(data, textStatus, xhr) {
    $("#editOthersContainer").append(data);
    $("#editInputOther").val("");
  });
}

function removeOtherEdit(elementid, name){
  var el = elementid;
  $('#'+ elementid).remove();

  othersArray = jQuery.grep(othersArray, function(value) {
    return value != name;
  });
  if ( $('#editOthersContainer').children().length == 0 ) {
    $("#editOthersDiv").hide();
  }
}

function loadListToAddEdit(controlNumber){
  $(".listToAddEdit").load('reqsandcoms_proc.php',{
    loadListToAddEdit: true,
    controlNumber: controlNumber
  },
  function(){
    /* Stuff to do after the page is loaded */
  }); 
}

function addToListEdit(employees_id){
  employeesArray.push(employees_id);
  $(".listAddedEdit").prepend($('#'+ employees_id));
  $('#'+ employees_id+" button").attr('onclick', 'removeFromListEdit('+employees_id+')');
  // $('#'+ employees_id+" button i").removeClass('add');
  // $('#'+ employees_id+" button i").addClass('times');
  $('#'+ employees_id+" button").html('Del');
}

function removeFromListEdit(employees_id){
  
  employeesArray = jQuery.grep(employeesArray, function(value) {
    return value != employees_id;
  });

  $(".listToAddEdit").prepend($('#'+ employees_id));
  $('#'+ employees_id+" button").attr('onclick', "addToListEdit('"+employees_id+"')");
  // $('#'+ employees_id+" button i").removeClass('times');
  // $('#'+ employees_id+" button i").addClass('add');
  $('#'+ employees_id+" button").html('Add');
}

  // edit end

  function deleteFunc(controlNumber){
    $("#deleteModal").modal({
      onApprove: function(){
        $.post('reqsandcoms_proc.php', {
          delete: true,
          controlNumber:controlNumber,
        }, function(data, textStatus, xhr) {
          $(load(sortByYear,sortByDept));
          $(deletedMsg);
        });
      },
    }).modal("show");
  }

  function addedMsg(){
  // save msg animation start 
  $("#addedMsg").transition({
    animation: 'fly down',
    onComplete: function () {
      setTimeout(function(){ $("#addedMsg").transition('fly down'); }, 1000);
    }
  });
  // save msg animation end
}

function savedMsg(){
  // edit msg animation start 
  $("#savedMsg").transition({
    animation: 'fly down',
    onComplete: function () {
      setTimeout(function(){ $("#savedMsg").transition('fly down'); }, 1000);
    }
  });
  // edit msg animation end
}

function deletedMsg(){
  // delete msg animation start 
  $("#deletedMsg").transition({
    animation: 'fly down',
    onComplete: function () {
      setTimeout(function(){ $("#deletedMsg").transition('fly down'); }, 1000);
    }
  });
  // delete msg animation end 
}

function loadListToAdd(){
  $(".listToAdd").load('reqsandcoms_proc.php',{
    loadListToAdd: true,
  } ,
  function(){
    /* Stuff to do after the page is loaded */
  }); 
}

function addToList(employees_id){
  employeesArray.push(employees_id);
  $(".listAdded").prepend($('#'+ employees_id));
  $('#'+ employees_id+" button").attr('onclick', 'removeFromList('+employees_id+')');
  // $('#'+ employees_id+" button i").removeClass('add');
  // $('#'+ employees_id+" button i").addClass('times');
  $('#'+ employees_id+" button").html('Del');

}

function removeFromList(employees_id){
  
  employeesArray = jQuery.grep(employeesArray, function(value) {
    return value != employees_id;
  });

  $(".listToAdd").prepend($('#'+ employees_id));
  $('#'+ employees_id+" button").attr('onclick', "addToList('"+employees_id+"')");
  // $('#'+ employees_id+" button i").removeClass('times');
  // $('#'+ employees_id+" button i").addClass('add');
  $('#'+ employees_id+" button").html('Add');
}

function addOther(){
  if ($("#othersContainer") != null) {
    $("#othersDiv").show();
  }
  var name = $("#addInputOther").val();
  othersArray.push(name);
  $.post('reqsandcoms_proc.php', {
    addOther: true,
    name: name
  }, function(data, textStatus, xhr) {
    $("#othersContainer").append(data);
    $("#addInputOther").val("");
  });
}

function removeOther(elementid){
  var el = elementid;
  $('#'+ elementid).remove();
  othersArray = jQuery.grep(othersArray, function(value) {
    return value != el;
  });
  if ( $('#othersContainer').children().length == 0 ) {
    $("#othersDiv").hide();
  }
}

  // view start
  function viewFunc(controlNumber){
    
    $(loadViewRemarks(controlNumber));

    $.post('reqsandcoms_proc.php', {
      getRowData: true,
      controlNumber: controlNumber,
    }, function(data, textStatus, xhr) {
      var array = jQuery.parseJSON(data),
          type = array.type;
      $("#view0").html(array.controlNumberFormatted);
      $("#view1").html(array.dateReceived);
      $("#view2").html(array.source);
      $("#view3").html(array.subject);
      $("#view4").html(array.fromDateFormatted);
      $("#view5").html(array.toDateFormatted);
      if (type == "") {
        type = "<i style='color: red'>n/a</i>";
      }
      $("#view6").html(type);
      $("#view7").html(array.venue);
    });

    $("#listsField").load('reqsandcoms_proc.php',{
      getListsForView: true,
      controlNumber: controlNumber
    },
    function(){
      /* Stuff to do after the page is loaded */
    });

    
    $("#editRemarks").unbind().click(function(event) {
      $("#remarks_view_form").hide();
      $("#remarks_edit_form").show();
    });

    $("#cancelRemarks").unbind().click(function(event) {
      $("#remarks_edit_form").hide();
      $("#remarks_view_form").show();
    });

    // $("#saveRemarks").attr('onclick', "saveRemarks('"+controlNumber+"')");
    $("#saveRemarks").unbind().click(function(event) {
      
      $.post('reqsandcoms_proc.php', {
        saveRemarks: true,
        controlNumber: controlNumber,
        remarks: $("#remarks_edit").val(),
        carriedBy: $("#carriedBy_edit").val(),
        date: $("#date_edit").val(),
      }, function(data, textStatus, xhr) {
        $(loadViewRemarks(controlNumber));
        $("#remarks_edit_form").hide();   
        $("#remarks_view_form").show();
      });

    });

    $("#openModal").modal({
      onDeny: function(){
      $("#remarks_edit_form").hide();
      $("#remarks_view_form").show();
      }
    }).modal("show");
  }
  // view end

  function loadViewRemarks(controlNumber){
    $.post('reqsandcoms_proc.php', {
      loadViewRemarks: true,
      controlNumber: controlNumber
    }, function(data, textStatus, xhr) {
      var array = jQuery.parseJSON(data);
      dateFormatted = array.dateFormatted;
      $("#remarks_view").html(array.remarks);
      $("#carriedBy_view").html(array.carriedBy);
      // alert(dateFormatted);
      $("#date_view").html(dateFormatted);

      $("#remarks_edit").val(array.remarks);
      $("#carriedBy_edit").val(array.carriedBy);
      $("#date_edit").val(array.date);
    });
  }

  function clear(){
    employeesArray = [];
    othersArray = [];
    $("addInputSource").val("");
    $("addInputSubject").val("");
    $("addInputDate0").val("");
    $("addInputDate1").val("");
    $('#othersDiv').hide();
    $('#othersContainer').empty();
    $('#editOthersDiv').hide();
    $('#editOthersContainer').empty();
    $('.listAdded').empty();
    $('.listAddedEdit').empty();
    $("#inputAddType").dropdown('clear');
    $("#addDeptsList").dropdown('clear');
    $("#inputSearchAdded").val("");
    $("#inputSearchToAdd").val("");
    $("#inputSearchAddedEdit").val("");
    $("#inputSearchToEdit").val("");
  }

</script>

<!-- open start -->
<div id="openModal" class="ui fullscreen modal">
  <div class="header" id="openHeader"></div>  
  <div class="content">
    <div class="ui grid">
      <div class="six wide column">
        <table class="ui very basic table">
          <tr>
            <td><strong>Control Number:</strong></td>
            <td id="view0" colspan="3"></td>
          </tr>
          <tr>
            <td><strong>Date Received:</strong></td>
            <td id="view1" colspan="3"></td>
          </tr>
          <tr>
            <td><strong>Source (Agency/Organization):</strong></td>
            <td id="view2" colspan="3"></td>
          </tr>
          <tr>
            <td><strong>Subject/Title of Training:</strong></td>
            <td id="view3" colspan="3"></td>
          </tr>
          <tr>
            <td><strong>Date:</strong></td>
            <td id="view4"></td>
            <td><strong>to:</strong></td>
            <td id="view5"></td>
          </tr>
          <tr>
            <td><strong>Type:</strong></td>
            <td id="view6" colspan="3"></td>
          </tr>
          <tr>
            <td><strong>Venue:</strong></td>
            <td id="view7" colspan="3"></td>
          </tr>
        </table>
      </div>
      <div class="four wide column">
        <div class="ui form" id="listsField">

        </div>
      </div>
      <div id="remarks_form" class="six wide column">
       <div class="" id="remarks_view_form">
         <table class="ui very basic table">
           <tr>
            <th>Remarks:</th>
          </tr>
          <tr>
            <td id="remarks_view"></td>
          </tr>
          <tr>
            <th>Carried by:</th>
          </tr>
          <tr>
            <td id="carriedBy_view"></td>
          </tr>
          <tr>
            <th>Date:</th>
          </tr>
          <tr>
            <td id="date_view"></td>
          </tr>
        </table>

        <button class="ui tiny basic button" id="editRemarks">Edit</button>
      </div>
      <div class="ui form" id="remarks_edit_form" style="display: none;">
       <div class="field">
         <label>Remarks: </label>
         <textarea id="remarks_edit" placeholder="Remarks..." style="background-color: #eeffed;"></textarea>
       </div>
       <div class="field">
         <label>Carried By:</label>
         <input id="carriedBy_edit" type="text" name="carriedBy" placeholder="Carried by..." style="background-color: #eeffed;">
       </div>
       <div class="fields">
         <div class="eight wide field">
           <label>Date: </label>
           <input id="date_edit" type="date" name="date" style="background-color: #eeffed;">
         </div>
         <div class="eight wide field">
           
         </div>
       </div>
       <button class="ui tiny basic button" id="cancelRemarks">Cancel</button>
       <button class="ui tiny basic button" id="saveRemarks">Save</button>
     </div>
   </div>
 </div>
</div>
<div class="actions">
  <div class="ui deny button tiny">
    Close
  </div>
</div>
</div>

<!-- edit req/com end -->

<!-- open end -->

<!-- add msg alert start -->
<div id="addedMsg" class="" style="top: 15px; display: none; position: fixed; z-index: 10; width: 100%; left: 0; text-align: center;">
  <div class="ui center green inverted aligned segment" style="width: 100px; margin-left: auto; margin-right: auto;">
    <i class="checkmark icon"></i> Added!
  </div>
</div>
<!-- add msg alert end -->


<!-- save msg alert start -->
<div id="savedMsg" class="" style="top: 15px; display: none; position: fixed; z-index: 10; width: 100%; left: 0; text-align: center;">
  <div class="ui center green inverted aligned segment" style="width: 100px; margin-left: auto; margin-right: auto;">
    <i class="checkmark icon"></i> Saved!
  </div>
</div>
<!-- save msg alert end -->

<!-- delete msg alert start -->
<div id="deletedMsg" class="" style="top: 15px; display: none; position: fixed; z-index: 10; width: 100%; left: 0; text-align: center;">
  <div class="ui center yellow inverted aligned segment" style="width: 120px; margin-left: auto; margin-right: auto;">
    <i class="checkmark icon"></i> Removed!
  </div>
</div>
<!-- delete msg alert end -->

<!-- add training start -->
<div id="addModal" class="ui fullscreen modal">
  <div class="header">
    New Request/Communications
  </div>
  <div class="content">
    <div class="ui grid">
      <div class="three column row">
        <div class="eight wide column">
          <div class="ui form">
            <div class="fields">
              <div class="eight wide field">
                <strong>Control Number:</strong> <span>HRMO - <?php echo date('Y');?> - <span>*****</span></span>
              </div>
              <div class="eight wide field">
                <strong>Date Received:</strong> <span><?php echo date('F d, Y');?></span>
              </div>

            </div>
            <div class="field">
              <label>Source (Agency/Organization):</label>
              <input id="addInputSource" type="text" placeholder="Agency/Organization">
            </div>
            <div class="field">
              <label>Subject/Title of Training:</label>
              <input id="addInputSubject" type="text" placeholder="Subject/Title of Training">
            </div>
            <div class="field">
              <label>Departments Concerned:</label>
              <!-- <input id="addInputDepartments" type="text" placeholder="Department/s"> -->
              <!-- start -->

              <div id="addDeptsList" class="ui fluid multiple selection dropdown">
                <input type="hidden" id="addInputDepartments" value="">
                <i class="dropdown icon"></i>
                <div class="default text">Select Department/s</div>
                <div class="menu">
                  <?php
                  $sql = "SELECT * FROM `department` ORDER BY `department` ASC";
                  $result = $mysqli->query($sql);
                  while ($row = $result->fetch_assoc()) {
                    $department_id = $row["department_id"];
                    $department = $row["department"];
                    ?>
                    <div class="item" data-value="<?php echo $department_id;?>"><?php echo $department;?></div>

                    <?php
                  }
                  ?>
                </div>
              </div>
              <!-- end -->
            </div>
            <div class="fields">
              <div class="five wide field">
                <label>Start Date:</label>
                <input id="addInputDate0" type="date" name="">
              </div>
              <div class="mini five wide field">
                <label>End Date:</label>
                <input id="addInputDate1" type="date" name="">
              </div>
              <div class="mini five wide field">
                <label>Type:</label>
                <select id="inputAddType" class="ui compact dropdown">
                  <option value="">Training/Meeting..</option>
                  <option value="no">Training</option>
                  <option value="yes">Meeting</option>
                  <option value="seminar">Seminar</option>
                  <option value="orientation">Orientation</option>
                  <option value="conference">Conference/Convention</option>
                </select>
              </div>
            </div>
            <div class="field">
              <label>Venue:</label>
              <input id="inputAddVenue" type="text" name="" placeholder="Venue">
            </div>
          </div>

        </div>
        <div class="four wide column">
          <div class="ui form">
            <div class="field">
              <label>Personnels Involved:</label>
              <div class="ui icon input">
                <input id="inputSearchAdded" type="text" placeholder="Search...">
                <i class="search icon"></i>
              </div>
            </div>
            
            <div class="listAdded ui middle aligned tiny list" style="overflow-y: scroll; max-height: 200px;">
            </div>

            <div id="othersDiv" style="display: none;">
              <div class="header">Other/s:</div>
              <div id="othersContainer" class="ui middle aligned tiny list"></div>
            </div>


          </div>
        </div>
        <div class="four wide column">
          <div class="ui form">
            <div class="field">
              <label>Personnel List:</label>
              <div class="ui icon input">
                <input id="inputSearchToAdd" type="text" placeholder="Search...">
                <i class="search icon"></i>
              </div>
            </div>
            <div class="field">
              <div class="listToAdd ui middle aligned tiny list" style="overflow-y: scroll; height: 300px;">
              </div>
            </div>
            <div class="field">
              <label>Others:</label>
              <div class="ui action input">
                <input id="addInputOther" type="text" placeholder="Add others here not listed above.">
                <button onclick="addOther()" class="ui basic icon button"><i class="icon add"></i></button>
              </div>
            </div>

          </div>
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
<!-- add training end -->

<!-- edit req/com start -->
<div id="editModal" class="ui fullscreen modal">
  <div class="header">
    Edit Request/Communications
  </div>
  <div class="content">
    <div class="ui grid">
      <div class="three column row">
        <div class="eight wide column">
          <div class="ui form">
            <div class="fields">
              <div class="eight wide field">
                <strong>Control Number:</strong> <span>HRMO-<?php echo date('Y');?>-<span id="editControlNumber"></span></span>
              </div>
              <div class="eight wide field">
                <strong>Date Received:</strong> <span id="dateReceivedEdit"></span>
              </div>
            </div>
            <div class="field">
              <label>Source (Agency/Organization):</label>
              <input id="editInputSource" type="text" placeholder="Agency/Organization">
            </div>
            <div class="field">
              <label>Subject/Title of Training:</label>
              <input id="editInputSubject" type="text" placeholder="Subject/Title of Training">
            </div>
            <div class="field">
              <label>Departments Concerned:</label>
              <!-- <input id="editInputDepartments" type="text" placeholder="Department/s"> -->
              <div id="editDeptsList" class="ui fluid multiple selection dropdown">
                <input type="hidden" id="editInputDepartments" value="">
                <i class="dropdown icon"></i>
                <div class="default text">Select Department/s</div>
                <div class="menu">
                  <?php
                  $sql = "SELECT * FROM `department` ORDER BY `department` ASC";
                  $result = $mysqli->query($sql);
                  while ($row = $result->fetch_assoc()) {
                    $department_id = $row["department_id"];
                    $department = $row["department"];
                    ?>
                    <div class="item" data-value="<?php echo $department_id;?>"><?php echo $department;?></div>
                    <?php
                  }
                  ?>
                </div>
              </div>
            </div>
            <div class="fields">
              <div class="five wide field">
                <label>Start Date:</label>
                <input id="editInputDate0" type="date" name="">
              </div>
              <div class="five wide field">
                <label>End Date:</label>
                <input id="editInputDate1" type="date" name="">
              </div>
              <div class="five wide field">
                <label>Type:</label>
                <select id="editInputType" class="ui compact dropdown">
                  <option value="">Type</option>
                  <option value="no">Training</option>
                  <option value="yes">Meeting</option>
                  <option value="seminar">Seminar</option>
                  <option value="orientation">Orientation</option>
                  <option value="conference">Conference/Convention</option>
                </select>
              </div>
            </div>
            <div class="field">
              <label>Venue:</label>
              <input id="editInputVenue" type="text" name="" placeholder="Venue">
            </div>
          </div>

        </div>
        <div class="four wide column">
          <div class="ui form">
            <div class="field">
              <label>Personnels Involved:</label>
              <div class="ui icon input">
                <input id="inputSearchAddedEdit" type="text" placeholder="Search...">
                <i class="search icon"></i>
              </div>
            </div>
            
            <div class="listAddedEdit ui middle aligned tiny list" style="overflow-y: scroll; max-height: 200px;">
            </div>

            <div id="editOthersDiv" style="display: none;">
              <div class="header">Other/s:</div>
              <div id="editOthersContainer" class="ui middle aligned tiny list"></div>
            </div>


          </div>
        </div>
        <div class="four wide column">
          <div class="ui form">
            <div class="field">
              <label>Personnel List:</label>
              <div class="ui icon input">
                <input id="inputSearchToEdit" type="text" placeholder="Search...">
                <i class="search icon"></i>
              </div>
            </div>
            <div class="field">
              <div class="listToAddEdit ui middle aligned tiny list" style="overflow-y: scroll; height: 300px;">
              </div>
            </div>
            <div class="field">
              <label>Others:</label>
              <div class="ui action input">
                <input id="editInputOther" type="text" placeholder="Add others here not listed above.">
                <button onclick="addOtherEdit()" class="ui basic icon button"><i class="icon add"></i></button>
              </div>
            </div>

          </div>
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
<!-- edit req/com end -->

<!-- delete training start -->
<div id="deleteModal" class="ui mini modal">
  <!-- <i class="close icon"></i> -->
  <div class="header">
    Delete Training
  </div>
  <div class="content">
    <p>Are you sure you want to delete this entry?</p>
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
<!-- delete training end -->
<div class="ui container">
  <div class="ui borderless blue inverted mini menu">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
    <div class="item">
     <h3><i class="icon fax"></i> Requests and Communications</h3>
   </div>
   <div class="right item">
    <div class="ui right input">
      <button class="ui icon mini green button" onclick="addModalFunc()" style="margin-right: 5px;"><i class="icon plus"></i>Add</button>
      <div style="padding: 0px; margin: 0px; margin-right: 5px;">
      <select id="sortYear" class="ui floating dropdown compact"> 
        <option value="">Filter by Year</option>
        <option value="all">All</option>
        <?php
//get year start
        require_once "_connect.db.php";
        $sql = "SELECT DISTINCT year(`dateReceived`) AS `years` FROM `requestandcoms` ORDER BY `years` DESC";
        $result = $mysqli->query($sql);
        while ($row = $result->fetch_assoc()) {
          $years = $row["years"];
          echo "<option value=\"$years\">$years</option>";
        }
//get year end
        ?>
      </select>
    </div>
      <div class="ui icon fluid input" style="width: 300px;">
        <input id="table_search" type="text" placeholder="Search...">
        <i class="search icon"></i>
      </div>
    </div>
  </div>
</div>
</div>
<div style="padding: 20px;">

<button id="clearFilter" style="display: none;" class="ui mini button">Clear</button>
<div class="ui multiple dropdown" id="filter_deptConerned" style="color: white">
  <input type="hidden" name="filters">
  <i class="icon filter"></i>
  <span class="text">Select Department/s to filter</span>
  <div class="menu">
    <div class="ui icon search input">
      <i class="search icon"></i>
      <input type="text" placeholder="Search tags...">
    </div>
    <div class="divider"></div>
    <div class="header">
      <i class="tags icon"></i>
      Select Department/s
    </div>
    <div class="scrolling menu">
<?php

    $sql = "SELECT * FROM department ORDER BY department ASC";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
        $department_id = $row["department_id"];
        $department = $row["department"];
        echo "<div class='item' data-value='$department_id'>$department</div>";
    }

?>
      </div>
    </div>
  </div>

  <table id="trTable" class="ui blue selectable striped structured celled very compact table" style="font-size: 12px;">
    <!-- <thead> -->
      <tr style="text-align: center;">
        <th>Control No.</th>
        <th>Date Recieved</th>
        <th>Source</th>
        <th>Department/s Concerned</th>
        <th>Subject/Training</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Venue</th>
        <th>Personnel/s Involved</th>
        <th>Type</th>
        <th>Options</th>
      </tr>
    <!-- </thead> -->
    <tbody id="tableBody1">
        <tr id="loading_el">
          <td colspan="11" style="text-align: center; font-size: 32px; color: lightgrey; padding: 100px;"><!-- FETCHING DATA... -->
            <img src="assets/images/loading.gif" style="height: 50px; margin-top: -100px;">
            <br>
            <span>Fetching data...</span>
          </td>
        </tr>
    </tbody>
  </table>
</div>



<?php require_once "footer.php";?>
