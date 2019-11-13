<?php $title = "Comparative Data";
require "_connect.db.php"; 
require "header.php";?>

<script type="text/javascript" src="scripts/Lister.js"></script>
<!-- <script type="text/javascript" src="scripts/Departments.js"></script> -->

<script type="text/javascript">
    var yearState = "all",
        education = new Lister("Education"),
        training = new Lister("Training"),
        experience = new Lister("Experience"),
        eligibility = new Lister("Eligibility"),
        // office = new Departments("Office"),
        fields = {
          itemNo: {
            identifier  : 'itemNo',
            rules: [
              {
                type   : 'empty',
                prompt : 'Field empty! Please enter the item number.'
              }
            ]
          },
          position: {
            identifier  : 'position',
            rules: [
              {
                type   : 'empty',
                prompt : 'Field empty! Please enter the position'
              }
            ]
          },
          sg: {
            identifier  : 'sg',
            rules: [
              {
                type   : 'empty',
                prompt : 'SG empty!'
              }
            ]
          },
          office: {
            identifier  : 'office',
            rules: [
              {
                type   : 'empty',
                prompt : 'Please select the assigned office'
              }
            ]
          },
          // dateVacated: {
          //   identifier  : 'dateVacated',
          //   rules: [
          //     {
          //       type   : 'empty',
          //       prompt : 'Please indicate date vacated'
          //     }
          //   ]
          // }
        }; 

 $(document).ready(function() {
  // $.each($(".inputLister"), function(index, val) {
     /* iterate through array or object */
  // });
    $("#table_search").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#tableBody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

    $("#sortYear").dropdown({
      onChange: function(value, text, $choice){
        yearState = value;
        console.log(yearState);
        $(load(yearState));
      }
    });

    $(load(yearState));
    $(autoEnter);

    $("#education").html(education.render());
    $("#training").html(training.render());
    $("#experience").html(experience.render());
    $("#eligibility").html(eligibility.render());
    // $("#office").html(office.render());
    $("#sortYear").dropdown();


    $('#officeDropdown').dropdown();

 });

function load(year){
  $("#tableBody").load('comparativeData_proc.php',{
    load: true, 
    yearState: year
  } ,
    function(){
    /* Stuff to do after the page is loaded */
    $(clearFormData);
  });
  
}

function addModalFunc(){
  clearFormData();
  $("#addNewForm").form({
        on: "submit",
        inline: true,
        keyboardShortcuts: false,
        onSuccess: function(e){
          e.preventDefault();
          data = getInputValues();
          // post
          console.log('submit Data',data);
          $.post('comparativeData_proc.php', {
            addNew: true,
            data0: data[0],
            data1: data[1]
          }, function(data, textStatus, xhr) {
            console.log('textStatus',textStatus);
            console.log('xhr',xhr);
            $("#addNew").modal("hide");
            $(load(yearState));
          });
        },
        fields: fields
      });

  $("#addNew>.header").html("<i class='icon add'></i> Add New Vacant Position");
  $("#addNew").modal({
      closable:false,
      onApprove: function(e){
        return false;
      }
    }).modal("show");
}


function getValues(id){

  dataArr = [];

  $.ajax({
    url: 'comparativeData_proc.php',
    async: false, 
    type: 'POST',
    dataType: 'json',
    data: {
      getValues: true,
      rspvac_id: id
    },
  })
  .done(function(data) {
    // console.log(data);
      // console.log(array);
      $.each(data, function(index, val) {
         dataArr[index] = val;
         // console.log(dataArr);
      });
  })
  .fail(function() {
    console.log("error");
  })
  .always(function() {
    // console.log("complete");
  });
  return dataArr;
}

function getInputValues(){
  data = [];
  data0 = [
      $("input[name='position']").val(),
      $("input[name='itemNo']").val(),
      $("input[name='sg']").val(),
      // $("input[name='office']").val(),
      $("#officeDropdown").dropdown("get value"),
      $("input[name='dateVacated']").val(),
      $("input[name='dateOfInterview']").val()
    ];
  data1 = [];
  $.each(objArray, function(index, val) {
      data1.push(objArray[objArray[index]]);           
  });
  data = [data0,data1];
  console.log('getInputValues',data);
  return data;
}

function setInputValues(dataArr){
  $("input[name='position']").val(dataArr[0]);
  $("input[name='itemNo']").val(dataArr[1]);
  $("input[name='sg']").val(dataArr[3]);
  $("#officeDropdown").dropdown("set selected",dataArr[3]);
  $("input[name='dateVacated']").val(dataArr[4]);
  $("input[name='dateOfInterview']").val(dataArr[5]);
  
  $.each(objArray, function(index, val) {
     /* iterate through array or object */
     if (arr = dataArr[index+6]) {
      objArray[objArray[index]] = arr;
     } else if (dataArr[index+6] === null){
      objArray[objArray[index]] = [];
     }
     console.log(objArray[objArray[index]]);
     // if (objArray[objArray[index]] === null) {
     //  objArray[]
     // }
     createList(objArray[index]);
  });
}



function editFunc(id){
  clearFormData();
  var inputArr = getValues(id);
  console.log(inputArr);
  setInputValues(inputArr);

  $("#addNewForm").form({
        on: "submit",
        inline: true,
        keyboardShortcuts: false,
        onSuccess: function(e){
        e.preventDefault();
        data = getInputValues();
        // post
        $.post('comparativeData_proc.php', {
          editEntry: true,
          id: id,
          data0: data0,
          data1: data1
        }, function(data, textStatus, xhr) {
          $("#addNew").modal("hide");
          $(load(yearState));
        });
        console.log('editEditor');
      },
      fields: fields
    });


  // $(".formModal .header").html("Edit");
  var editModal = new $(".formModal");
  $("#addNew>.header").html("<i class='icon edit'></i> Edit Vacant Position");
  editModal.modal({
    closable: false,
    onApprove: function(){
      getInputValues();
      return false;
    // console.log(editModal.val());
    // $("input[name='position']").val(),
    // $("input[name='sg']").val(),
    // $("input[name='office']").val(),
    // $("input[name='dateVacated']").val()
    },
    onDeny: function(){
      clearFormData();
    }
  }).modal("show");  
}

function deleteFunc(id){

  $("#deleteModal").modal({
    onApprove: function(){
      $.post('comparativeData_proc.php', {
        deleteFunc: true,
        rspvac_id: id
      }, function(data, textStatus, xhr) {
        /*optional stuff to do after success */
        $(load(yearState));
      });
    }
  }).modal("show");
}

function clearFormData(){
  $(".addNewForm").each(function(index, el) {
    $(this).form("reset");
    // console.log(this);
  });
  
  $.each($("input"), function(index, val) {
     /* iterate through array or object */
     $(this).val("");
  });
  education.resetLister();
  training.resetLister();
  experience.resetLister();
  eligibility.resetLister();
}
</script>

<div class="ui mini modal" id="deleteModal">
  <div class="header">
    <i class="icon trash"> </i> Delete Vacant Position
  </div>
  <div class="content">
    Are you sure you want to delete this vacant position?
  </div>
  <div class="actions">
    <button class="ui tiny basic button approve"><i class="icon check"></i> Yes</button>
    <button class="ui tiny basic button deny"><i class="icon cancel"></i> No</button>
  </div>
</div>

<!-- modal add new vacant position start -->
<!-- id="addNew" -->
<div class="ui modal formModal" id="addNew">
  <div class="header">
    

  </div>
  <div class="content">
    <form class="ui form addNewForm" id="addNewForm" method="POST">
      <div class="four wide field">
          <label>CSC Item Number:</label>
          <input type="text" name="itemNo" placeholder="CSC Item Number">
      </div>
      <div class="fields">
        <div class="eight wide field">
          <label>Title of Position:</label>
          <input type="text" name="position" placeholder="Title of Position">
        </div>
        <div class="two wide field">
          <label>SG:</label>
          <input type="number" name="sg" placeholder="Salary G">
        </div>
        <div class="six wide field" id="office">
          <label>Office:</label>
          <!-- <input type="text" name="office" placeholder="Assigned Office"> -->
          <div class="ui selection dropdown" id="officeDropdown">
            <input type="hidden" name="office">
            <i class="dropdown icon"></i>
            <div class="default text">Select Office</div>
            <div class="menu">
<?php
  $sql = "SELECT * FROM `department` ORDER BY `department` ASC";

  $stmt = $mysqli->prepare($sql);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($department_id,$department);
  while ($stmt->fetch()) {
    echo "<div class=\"item\" data-value=\"$department_id\">$department</div>";
  }
?>
            </div>
          </div>
        </div>
      </div>

      <h4 class="ui dividing header">Qualification Standards</h4>
      <div class="fields">
        <div class="eight wide field" id="education"></div>
        <div class="eight wide field" id="training"></div>
      </div>
      <div class="fields">
        <div class="eight wide field" id="experience"></div>
        <div class="eight wide field" id="eligibility"></div>
      </div>
      <h4 class="ui dividing header"></h4>
      <div class="fields">
        <div class="four wide field">
          <label>Date Vacated:</label>
          <input type="date" name="dateVacated">
        </div>
        <div class="four wide field">
          <label>Date of Interview:</label>
          <input type="date" name="dateOfInterview">
        </div>
<!--     
        <div class="five wide field">
          <label>Date Published</label>
          <input type="date" name="">
        </div>
        <div class="five wide field">
          <label>Date Filled-Up</label>
          <input type="date" name="">
        </div>
-->
      </div>
      <div class="ui error message"></div>
    </form>

  </div>
  <div class="actions">
    <button form="addNewForm" type="button" onclick="$('#'+this.form.id).form('submit');" class="ui tiny basic button approve"><i class="icon save"></i> Save</button>
    <button class="ui tiny basic button deny"><i class="icon cancel"></i> Cancel</button>
  </div>
</div>
<!-- modal add new vacant position end -->

<div class="ui containerA" style="padding-left: 20px; padding-right: 20px;">
  <div class="ui borderless blue inverted mini menu">
    <div class="left item" style="margin-right: 0px !important;">
      <a href="index.php" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </a>
    </div>
    <div class="item">
     <h3><i class="pie chart icon"></i> Comparative Data</h3>
   </div>
   <div class="right item">
    <div class="ui right input">
      <button class="ui icon mini green button" onclick="addModalFunc()" style="margin-right: 5px;"><i class="icon plus"></i>Add New Vacant Position</button>
      <div style="padding: 0px; margin: 0px; margin-right: 5px;">
      <select id="sortYear" class="ui floating dropdown"> 
        <option value="">Filter by Year</option>
        <option value="all">All</option>
        <?php
//get year start
        
        $sql = "SELECT DISTINCT year(`dateVacated`) AS `years` FROM `rsp_vacant_positions` ORDER BY `years` DESC";
        $result = $mysqli->query($sql);
        while ($row = $result->fetch_assoc()) {
          $years = $row["years"];
          if (!$years) {
            $text = "Not Indicated";
          } else {
            $text = $years;
          }
          echo "<option value=\"$years\">$text</option>";
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

<div style="padding: /*20px*/;">
<style type="text/css">
  .heads {
    padding: 2px !important;
  }
</style>

  <table id="trTable" class="ui striped blue selectable structured celled very compact table" style="font-size: 12px;">
    <thead>
      <tr style="text-align: center;">

        <th class="heads" rowspan="2">No.</th>
        <th class="heads" rowspan="2">Link</th>
        <th class="heads" rowspan="2">Position</th>
        <th class="heads" rowspan="2">Item No</th>
        <th class="heads" rowspan="2">SG</th>
        <th class="heads" rowspan="2">Office</th>
        <th class="heads" colspan="4">Qualification Standards</th>
        <th class="heads" rowspan="2">Date Vacated</th>
        <th class="heads" rowspan="2">Date of Interview</th>
        <th class="heads" rowspan="2">Options</th>
<!--         <th rowspan="2">Date Published</th>
        <th rowspan="2">Date Filled-Up</th> -->
      </tr>
      <tr style="text-align: center;">
        <th class="heads">Education</th>
        <th class="heads">Experience</th>
        <th class="heads">Training</th>
        <th class="heads">Eligibility</th>
      </tr>

    </thead>
    <tbody id="tableBody">
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
</div>
<?php require_once "footer.php";?>
