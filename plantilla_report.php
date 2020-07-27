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
                <select class="ui dropdown" id="status" v-model="status">
                  <option value="permanent">Permanent</option>
                  <option value="casual">Casual</option>
                </select>
              </div>
              <div class="four wide field">
                <label>Gender:</label>
                <select id="gender" class="ui dropdown" v-model="gender">
                  <option value="all">All</option>
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
                <input id="date_of_printing" type="date" v-model="as_of_date">
              </div>
              <div class="field">
                <label>Department:</label>
                <select id="dept" class="ui fluid search dropdown" v-model="department_id">
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
            <button @click="generate_report" class="ui green button" type="submit">
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


  new Vue({
    el: "#app",
    data: {
      status: "permanent",
      gender: "all",
      as_of_date: "",
      department_id: "",
    },
    methods: {
      generate_report() {
        // var tab = window.open('plantilla_report_print.php?department_id=' + $department_id, '_blank');
        if (this.status == 'permanent') {
          var url = `plantilla_report_print.php?status=${this.status}&gender=${this.gender}&date=${this.as_of_date}&department_id=${this.department_id}`
          window.open(url, '_blank')
        } else {
          alert('Generate Casual Plantilla Report')
        }
      }
    },
    mounted() {
      $("#dept").dropdown({
        fullTextSearch: true
      });
      $("#status").dropdown();
      $("#gender").dropdown();
      this.as_of_date = new Date().toDateInputValue();
    }
  })
</script>

<?php
require_once "footer.php";
?>