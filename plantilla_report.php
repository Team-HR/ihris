<?php
$title = "Plantilla Report";
require_once "header.php";
?>

<div class="ui container" id="app">
  <div class="ui borderless blue inverted mini menu">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
    <div class="item">
      <h3><i class="briefcase icon"></i>Report on Plantilla</h3>
    </div>
  </div>
  <div class="ui container segment">
    <h4 class="ui header">Generate report by:</h4>
    <hr>
    <div class="ui form">
      <div class="ui stackable grid">
        <div class="row">
          <div class="eight wide column">
            <div class="grouped fields">
              <div class="eight wide field">
                <label>Employment Status:</label>
                <select class="ui dropdown" id="status">
                  <option value="permanent" selected>Permanent</option>
                  <option value="casual">Casual</option>
                </select>
              </div>
              <div class="four wide field">
                <label>Gender:</label>
                <select id="gender" class="ui dropdown">
                  <option value="all" selected>All</option>
                  <option value="m">Male</option>
                  <option value="f">Female</option>
                </select>
              </div>
            </div>
          </div>
          <div class="eight wide column">
            <div class="grouped fields">
              <div class="eight wide field">
                <label>As of Date:</label>
                <input id="date_of_printing" type="date">
              </div>
              <div class="field">
                <label>Department:</label>
                <select id="dept" class="ui fluid dropdown">
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
          </div>
        </div>
        <div class="row">
          <div class="column">
            <button class="ui green button" type="submit">
              Generate
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0, 10);
  });

  $("#dept").dropdown();
  $("#status").dropdown();
  $("#gender").dropdown();

  $("#date_of_printing").val(new Date().toDateInputValue());
</script>

<?php
require_once "footer.php";
?>