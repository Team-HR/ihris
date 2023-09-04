<?php $title = "L&D Activities"; require_once "header.php"; require_once "_connect.db.php";?>

<script type="text/javascript">
  $(document).ready(function() {
    $(load);
  });

function load(){
  $("#tableBody").load('ldactivities_proc.php',{
    load: true
  });
}

</script>
<!-- menu starts here -->
<div class="ui container">
  <div class="ui borderless blue inverted mini menu noprint">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
    <div class="item">
      <!-- TITLE -->
     <h3><i class="icon book"></i> Learning and Development Activities</h3>
   </div>
  </div>
</div>
<!-- menu ends here -->

<!-- content here start -->
<div class="ui container" style="padding: 20px;">
  <style type="text/css">
    tr {
      text-align: center;
    }
  </style>
  <table class="ui very compact celled small table">
    <thead>
      <tr>
        <th>LGU SPONSORED TRAININGS</th>
        <th>CAPABILITY DEVELOPMENT PROGRAMS</th>
      </tr>
    </thead>
    <tbody id="tableBody">
    </tbody>
  </table>
</div>
<!-- content here end -->


<?php require_once "footer.php";?>
