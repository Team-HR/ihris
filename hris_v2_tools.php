<?php
$title = "HRIS_V2 Tools";
require_once "header.php";
?>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<div class="ui container">

  <div class="ui borderless blue inverted mini menu">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
    <div class="item">
      <h3><i class="database icon"></i> HRIS_V2 Tools</h3>
    </div>
  </div>

  <div class="ui top attached tabular menu" id="tabs">
    <a class="item active" data-tab="pds_sync">PDS Sync</a>
    <!-- <a class="item" data-tab="sections">Sections</a> -->
  </div>
  <div class="ui bottom attached segment tab active" data-tab="pds_sync">
    <div id="tableContent"></div>
  </div>
  <div class="ui bottom attached segment tab" data-tab="sections">
    <div id="sectionsContainer"></div>
  </div>

</div>
</div>
<?php
require_once "footer.php";
?>