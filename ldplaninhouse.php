<?php $title = "L&D Plan In-house Trainings"; require_once "header.php"; require_once "_connect.db.php";
  // get year 
  $ldplan_id = $_GET["ldplan_id"];

  $sql = "SELECT `year` FROM `ldplan` WHERE `ldplan_id` = '$ldplan_id'";
  $result = $mysqli->query($sql);
  $row = $result->fetch_assoc();
  $year = $row["year"];

?>

<script type="text/javascript">
  $(document).ready(function() {
    // $(addNew);
    $(load);

    $("#table_search").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#tableBody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

  });

  function load(){
    $("#tableBody").load('ldplaninhouse_proc.php',{
      load: true,
      ldplan_id: <?php echo $ldplan_id; ?>
    } ,
      function(){
      /* Stuff to do after the page is loaded */
    });

    $.post('ldplaninhouse_proc.php', {
        getTrainings: true}, 
      function(data, textStatus, xhr) {
      var content = jQuery.parseJSON(data);
      $('.getTrainings').search({
        source: content,
        searchOnFocus: false
      });
    });
  }

  function addNew(){
    $("#modal_new").modal({
      closable: false,
      onHidden: function (){
        $(clear);
      },
      onDeny: function (){
        $(clear);
      },
      onApprove: function (){
        $.post('ldplaninhouse_proc.php', {
          addNew: true,
          ldplan_id: <?php echo $ldplan_id;?>,
          training: $("#title_add").val(),
          goal: $("#goal_add").val(),
          numHours: $("#hrs_add").val(),
          participants: $("#participants_add").val(),
          activities: $("#methods_add").val(),
          evaluation: $("#eval_add").val(),
          frequency: $("#freq_add").val(),
          budgetReq: $("#budget_add").val(),
          partner: $("#participants_add").val(),
        }, function(data, textStatus, xhr) {
          $(load);
          $(msg_added);
        });
      }
    }).modal("show");
  }

  function editRow(ldpinhousetrainings_id){
    $.post('ldplaninhouse_proc.php', {
      getRowData: true,
      ldpinhousetrainings_id: ldpinhousetrainings_id
    }, function(data, textStatus, xhr) {
          var array = jQuery.parseJSON(data);
          $("#title_edit").val(array.training);
          $("#goal_edit").val(array.goal);
          $("#hrs_edit").val(array.numHours);
          $("#participants_edit").val(array.participants);
          $("#methods_edit").val(array.activities);
          $("#eval_edit").val(array.evaluation);
          $("#freq_edit").val(array.frequency);
          $("#budget_edit").val(array.budgetReq);
          $("#partner_edit").val(array.partner);
          
          $("#modal_edit").modal({
            onApprove: function (){
              $.post('ldplaninhouse_proc.php', {
                editRow: true,
                ldpinhousetrainings_id: ldpinhousetrainings_id,
                title_edit: $("#title_edit").val(),
                goal_edit: $("#goal_edit").val(),
                hrs_edit: $("#hrs_edit").val(),
                participants_edit: $("#participants_edit").val(),
                methods_edit: $("#methods_edit").val(),
                eval_edit: $("#eval_edit").val(),
                freq_edit: $("#freq_edit").val(),
                budget_edit: $("#budget_edit").val(),
                partner_edit: $("#partner_edit").val(),
              }, function(data, textStatus, xhr) {
                $(load);
                $(msg_saved);
              });
            }
          }).modal("show");
    });
  }

  function deleteRow(ldpinhousetrainings_id){
    $("#modal_delete").modal({
      onApprove: function (){
        $.post('ldplaninhouse_proc.php', {
          deleteRow: true,
          ldpinhousetrainings_id: ldpinhousetrainings_id
        }, function(data, textStatus, xhr) {
          $(load);
          $(msg_deleted);
        });
      }
    }).modal("show");
  }

  function clear(){
    $("#title_add").val("");
    $("#goal_add").val("");
    $("#hrs_add").val("");
    $("#participants_add").val("");
    $("#methods_add").val("");
    $("#eval_add").val("");
    $("#freq_add").val("");
    $("#budget_add").val("");
    $("#partner_add").val("");
  }
</script>

<?php
  require_once "message_pop.php";
?>

<div class="ui container">
  <div class="ui borderless blue inverted mini menu noprint">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
    <div class="item">
     <h3><i class="icon compass outline"></i>L&D Plan In-house Trainings <?php echo $year;?></h3>
   </div>
   <div class="right item">
      <button class="ui icon button green" onclick="addNew()"><i class="icon plus"></i>Add</button>
      <button onclick="print()" class="blue ui icon button" title="Back" style="margin-right: 5px;">
        <i class="icon print"></i> Print
      </button>
      <div class="ui icon fluid input" style="width: 300px;">
        <input id="table_search" type="text" placeholder="Search...">
        <i class="search icon"></i>
      </div>
   </div>
</div>
</div>
<div class="ui fluid container" style="padding: 20px;">
<h4 align="center" class="printOnly">LEARNING & DEVELOPMENT PLAN FOR <?php echo $year;?><br>IN-HOUSE TRAININGS</h4>
<style type="text/css">
  .headers {
    padding: 2px !important;
    font-size: 12px !important;
  }
</style>
  <table class="ui very compact celled structured small selectable table">
    <thead>
      <tr style="text-align: center;"> 
        <th class="headers">No.</th>
        <th class="headers">Title of Training</th>
        <th class="headers">Training Goal/Objectives</th>
        <th class="headers">No. Hours</th>
        <th class="headers">Target Participants</th>
        <th class="headers">Learning Methods/Activities</th>
        <th class="headers">Evaluation/Evidence of Learning</th>
        <th class="headers">Frequency</th>
        <th class="headers">Budgetary Requirements</th>
        <th class="headers">Training Institution/Partner</th>
        <th class="headers noprint"></th>
      </tr>
    </thead>
    <tbody id="tableBody"></tbody>
  </table>
</div>
<!-- addnew modal start -->
<div class="ui modal" id="modal_new">
  <div class="header">Add New</div>
  <div class="content">
    <div class="ui form">
      <div class="fields">
        <div class="eight wide field">
          <label>Title of Training:</label>
          <!-- <textarea id="title_add" rows="3" placeholder="Title of training..."></textarea> -->

<div class="ui search getTrainings">
  <div class="ui icon input">
    <input id="title_add" class="prompt" type="text" placeholder="Search/Add Training...">
  </div>
  <div class="results"></div>
</div>

        </div>
        <div class="eight wide field">
          <label>Training Goal/Objective:</label>
          <textarea id="goal_add" rows="3" placeholder="Goal/Objective of training..."></textarea>
        </div>
      </div>
      <div class="fields">
        <div class="four wide field">
            <label>Total Number of Training Hours:</label>
            <input id="hrs_add" type="text" placeholder="Hrs">
        </div>
        <div class="four wide field"></div>
        <div class="eight wide field">
            <label>Target Participants:</label>
            <textarea id="participants_add" rows="3" type="text" placeholder="Participants..."></textarea>
        </div>
      </div>
      <div class="fields">
        <div class="eight wide field">
          <label>Learning Methods/Activities:</label>
          <textarea id="methods_add" rows="3" placeholder="Learning Methods/Activities..."></textarea>
        </div>
        <div class="eight wide field">
          <label>Evaluation/Evidence of Learning:</label>
          <textarea id="eval_add" rows="3" placeholder="Evaluation/Evidence of Learning..."></textarea>
        </div>
      </div>
      <div class="fields">

        <div class="four wide field">
          <label>Frequency:</label>
          <textarea id="freq_add" rows="3" type="text" placeholder="Frequency..."></textarea>
        </div>

        <div class="four wide field">
          <label>Budgetary Requirements:</label>
          <textarea id="budget_add" rows="3" type="text" placeholder="Budgetary Requirements..."></textarea>
        </div>

        <div class="eight wide field">
          <label>Training Institution/Partner:</label>
          <textarea id="partner_add" rows="3" type="text" placeholder="Training Institution/Partner..."></textarea>
        </div>

      </div>
    </div>
  </div>
  <div class="actions">
    <div class="ui approve tiny basic button">Save</div>
    <div class="ui cancel tiny basic button">Cancel</div>
  </div>
</div>
<!-- addnew modal end -->
<!-- edit modal start -->
<div class="ui modal" id="modal_edit">
  <div class="header">Edit</div>
  <div class="content">
    <div class="ui form">
      <div class="fields">
        <div class="eight wide field">
          <label>Title of Training:</label>
          <!-- <textarea id="title_edit" rows="3" placeholder="Title of training..."></textarea> -->

<div class="ui search getTrainings">
  <div class="ui icon input">
    <input id="title_edit" class="prompt" type="text" placeholder="Search/Add Training...">
  </div>
  <div class="results"></div>
</div>

        </div>
        <div class="eight wide field">
          <label>Training Goal/Objective:</label>
          <textarea id="goal_edit" rows="3" placeholder="Goal/Objective of training..."></textarea>
        </div>
      </div>
      <div class="fields">
        <div class="four wide field">
            <label>Total Number of Training Hours:</label>
            <input id="hrs_edit" type="text" placeholder="Hrs">
        </div>
        <div class="four wide field"></div>
        <div class="eight wide field">
            <label>Target Participants:</label>
            <textarea id="participants_edit" rows="3" type="text" placeholder="Participants..."></textarea>
        </div>
      </div>
      <div class="fields">
        <div class="eight wide field">
          <label>Learning Methods/Activities:</label>
          <textarea id="methods_edit" rows="3" placeholder="Learning Methods/Activities..."></textarea>
        </div>
        <div class="eight wide field">
          <label>Evaluation/Evidence of Learning:</label>
          <textarea id="eval_edit" rows="3" placeholder="Evaluation/Evidence of Learning..."></textarea>
        </div>
      </div>
      <div class="fields">

        <div class="four wide field">
          <label>Frequency:</label>
          <textarea id="freq_edit" rows="3" type="text" placeholder="Frequency..."></textarea>
        </div>

        <div class="four wide field">
          <label>Budgetary Requirements:</label>
          <textarea id="budget_edit" rows="3" type="text" placeholder="Budgetary Requirements..."></textarea>
        </div>

        <div class="eight wide field">
          <label>Training Institution/Partner:</label>
          <textarea id="partner_edit" rows="3" type="text" placeholder="Training Institution/Partner..."></textarea>
        </div>

      </div>
    </div>
  </div>
  <div class="actions">
    <div class="ui approve tiny basic button">Save</div>
    <div class="ui cancel tiny basic button">Cancel</div>
  </div>
</div>
<!-- edit modal end -->
<!-- delete modal start -->
<div class="ui mini modal" id="modal_delete">
  <div class="header"></div>
  <div class="content">
    Are you sure you want to delete this entry?
  </div>
  <div class="actions">
    <div class="ui approve tiny basic button">Yes</div>
    <div class="ui cancel tiny basic button">No</div>
  </div>
</div>
<!-- delete modal end -->
<?php require_once "footer.php";?>

