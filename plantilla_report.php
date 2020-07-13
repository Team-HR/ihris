<?php
$title = "Plantilla Report";
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
      <!-- <div class="ui right input">
      <button class="ui icon mini green button" onclick="addModalFunc()" style="margin-right: 5px;" title="Add New Department"><i class="icon plus"></i>Add</button>
      <div class="ui icon fluid input" style="width: 300px;">
        <input id="pos_search" type="text" placeholder="Search...">
        <i class="search icon"></i>
      </div>
    </div> -->
      <!-- <div class="ui icon fluid input">
        <input id="pos_search" type="text" placeholder="Search...">
        <i class="search icon"></i>
      </div> -->
    </div>
  </div>
  <div class="ui container segment" s>

    <h4 class="ui header">Generate report by:</h4>
    <hr>
    <div class="ui form">

      <div class="fields">
        <div class="field">
          <label>Employment Status:</label>
          <select class="ui dropdown" id="status">
            <option value="permanent" selected>Permanent</option>
            <option value="casual">Casual</option>
          </select>
        </div>


        <!-- <div class="inline fields">
          <label>Employment Status:</label>

          <div class="field">
            <div class="ui checkbox">
              <input checked id="regularTick" type="radio" name="status" value="regular">
              <label for="regularTick">Regular</label>
            </div>
          </div>
          <div class="field">
            <div class="ui checkbox">
              <input id="casualTick" type="radio" name="status" value="casual">
              <label for="casualTick">Casual</label>
            </div>
          </div>
        </div> -->

        <div class="field">
          <label>Gender:</label>

          <select id="gender" class="ui compact dropdown">
            <option value="all" selected>All</option>
            <option value="m">Male</option>
            <option value="f">Female</option>
          </select>
        </div>

        <div class="field">
          <label>As of Date:</label>
          <input id="date" type="date">
        </div>

        <div class="field">
          <label>Department:</label>
          <select id="dept" class="ui fluid dropdown" style="width: 100%;">
            <option value="">Select Department</option>
            <?php
            $result = $mysqli->query("SELECT * FROM `department`");
            while ($row = $result->fetch_assoc()) {
              $department_id = $row["department_id"];
              $department = $row["department"];
              print "<option value=\"{$department_id}\">{$department}</option>";
            }
            ?>
          </select>
        </div>
      </div>


      <!-- <div class="actions"> -->

        <button class="ui green button" type="submit">
          Generate
        </button>

        <!-- <div class="ui deny button">
              Cancel
            </div> -->
      <!-- </div> -->
    </div>
  </div>
</div>

<script type="text/javascript">
  var dept_filters = "";

  $("#dept").dropdown();
  $("#status").dropdown();
  $("#gender").dropdown();
  $(".ui .checkbox").checkbox();
</script>

<?php
require_once "footer.php";
?>