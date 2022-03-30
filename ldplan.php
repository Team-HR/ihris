<?php $title = "L&D Plan "; require_once "header.php"; require_once "_connect.db.php";?>
<script type="text/javascript">
  $(document).ready(function() {
    $(load);
  });

  function load (){
    console.log("load");
    $("#tableBody").load('ldplan_proc.php',{
      load: true,
    },
      function(){
      // $(load);
    });
    
  }
</script>
<div class="ui container">
  <div class="ui borderless blue inverted mini menu noprint">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
    <div class="item">
     <h3><i class="icon compass outline"></i> Learning and Development Plan</h3>
   </div>
</div>
</div>
<div class="ui container" style="padding: 20px;">
  <style type="text/css">
    tr {
      text-align: center;
    }
  </style>
  <table class="ui very compact celled small table">
    <thead>
      <tr>
        <th style="width: 50%;">IN-HOUSE TRAININGS</th>
        <th style="width: 50%;">LGU SPONSORED TRAININGS</th>
      </tr>
    </thead>
    <tbody id="tableBody"></tbody>
    <tfoot>
      <tr>
        <!-- <td colspan="2"><button class="ui green fluid button" onclick="addNew()">New Plan</button></td> -->
      </tr>
    </tfoot>
  </table>

  <div class="ui mini modal" id="add_modal">
    <div class="header">New Plan</div>
    <div class="content">
      <div class="ui form">
        <div class="field">
          <label>Inclusive Years:</label>
          <input type="text" id="yearsAdd" placeholder="e.g. 1999-2001">
        </div>
      </div>
    </div>
    <div class="actions">
      <div class="ui approve tiny basic button">Approve</div>
      <div class="ui cancel tiny basic button">Cancel</div>
    </div>
  </div>

</div>
<?php require_once "footer.php";?>
