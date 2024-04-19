<?php
$title = "PDS Report";
require_once "header.php";
?>
<div id="app" class="ui segment">
  <div class="ui fluid container">
    <div class="ui borderless blue inverted mini menu">
      <div class="left item" style="margin-right: 0px !important;">
        <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
          <i class="icon chevron left"></i> Back
        </button>
      </div>
      <div class="item">
        <h3><i class="highlighter icon"></i>PDS Report</h3>
      </div>
      <div class="right item">
        <div class="ui right input">
        </div>
        <div class="ui right input">

        </div>
      </div>
    </div>

    <table class="ui selectable very compact mini striped structured celled table">

    </table>
  </div>
</div>
<script>
  new Vue({
    el: "#app",
    data: {

    },
    methods: {},
    mounted() {
      $.ajax({
        type: "post",
        url: "pds_completion_report.proc.php",
        data: {
          get_list_done: true
        },
        dataType: "json",
        success: (response) => {
          console.log(response);
        },
        async: false,
      });
    },
  });
</script>
<?php
require_once "footer.php";
?>