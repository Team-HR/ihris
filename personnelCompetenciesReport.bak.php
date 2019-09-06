<?php $title = "Competency Report"; require_once "header.php"; require_once "_connect.db.php";?>
<script type="text/javascript">
  $(document).ready(function() {
    $('.popup').popup();
    $("#tabs .item").tab();
    $("#position_drop").dropdown({
      fullTextSearch: true,
      onChange: function(value, text, $choice){
        $("#function_drop_menu").load('personnelCompetenciesReport_proc.php', {
          load_functions: true,
          position: value
        }, function(data, textStatus, xhr) {
          $("#function_drop").dropdown("restore defaults");
        });
      }
    });
    $("#position_drop_menu").load('personnelCompetenciesReport_proc.php', {
      load_positions: true,
    });
    $(load);
  });
  function load(){
    console.log("load");
    $("#tableBody").load('personnelCompetenciesReport_proc.php',{
      load: true,
    },
      function(){
        // $("#num_rows").load('personnelCompetenciesReport_proc.php',{
        //   get_rows: true,
        // }
    });
    $("#num_rows").load('personnelCompetenciesReport_proc.php',{
      get_rows: true,
    },
      function(){
        // $("#num_rows").load('personnelCompetenciesReport_proc.php',{
        //   get_rows: true,
        // }
    });
  }
  function btn_search(){
    var position = $("#position_drop").dropdown("get value"),
        functional = $("#function_drop").dropdown("get value");
    if (position === '' && functional === '') {
      alert('Please select a position and function to start search.');
    } 
    // else if (functional === '') {
    //   alert('Please select a function to start search.');
    // }
    else {
      $.post('personnelCompetenciesReport_proc.php', {
        getResults: true,
        position: position,
        function: functional,
      }, function(data, textStatus, xhr) {
        $("#tableBody1").html(data);
      });
    }
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
     <h3><i class="icon chart line"></i>Competency Report</h3>
   </div>

  <div class="right item" style="width: 45%;">
    
  </div>


  </div>
</div>
<div class="ui container" style="padding: 20px;">
  <style type="text/css">
    table {
      border-collapse: collapse;
    }
    td {
      border: 1px solid lightgrey ;
      text-align: center;
    }
    th.rotate {
      height: 140px;
      white-space: nowrap;
    }
    th.rotate > div {
      transform: 
        translate(18px, 51px)
        rotate(315deg);
      width: 30px;
    }
    th.rotate > div > span {
      border-bottom: 1px solid #ccc;
      padding: 5px 10px;
    }
  </style>
<div class="ui top attached tabular menu" id="tabs">
  <a class="item active" data-tab="report">Survey Report</a>
  <a class="item" data-tab="job_c">Job Competecy</a>
</div>
<div class="ui bottom attached tab active" data-tab="report">
  <div id="snum_rows" class="ui basic segment" style="font-size: 24px;">
    <i class="icon info blue tiny circle"></i><span id="num_rows" style="font-size: 13px; color: grey; font-style: italic;"></span>
</div>
  <table class="" style="margin-top: 50px;">
    <thead>
      <tr>
        <th class="rotate"></th>
        <th style="vertical-align: bottom;"></th>
        <th style="vertical-align: bottom;"></th>
        <th class="rotate"><div><span>Adaptability</span></div></th>
        <th class="rotate"><div><span>Continous Learning</span></div></th>
        <th class="rotate"><div><span>Communication</span></div></th>
        <th class="rotate"><div><span>Organizational Awareness</span></div></th>
        <th class="rotate"><div><span>Creative Thinking</span></div></th>
        <th class="rotate"><div><span>Networking/Relationship Building</span></div></th>
        <th class="rotate"><div><span>Conflict Management</span></div></th>
        <th class="rotate"><div><span>Stewardship of Resources</span></div></th>
        <th class="rotate"><div><span>Risk Management</span></div></th>
        <th class="rotate"><div><span>Stress Management</span></div></th>
        <th class="rotate"><div><span>Influence</span></div></th>
        <th class="rotate"><div><span>Initiative</span></div></th>
        <th class="rotate"><div><span>Team Leadership</span></div></th>
        <th class="rotate"><div><span>Change Leadership</span></div></th>
        <th class="rotate"><div><span>Client Focus</span></div></th>
        <th class="rotate"><div><span>Partnering</span></div></th>
        <th class="rotate"><div><span>Developing Others</span></div></th>
        <th class="rotate"><div><span>Planning and Organizing</span></div></th>
        <th class="rotate"><div><span>Decision Making</span></div></th>
        <th class="rotate"><div><span>Analytical Thinking</span></div></th>
        <th class="rotate"><div><span>Results Orientation</span></div></th>
        <th class="rotate"><div><span>Teamwork</span></div></th>
        <th class="rotate"><div><span>Values and Ethics</span></div></th>
        <th class="rotate"><div><span>Visioning and Strategic Direction</span></div></th>
      </tr>
    </thead>
    <tbody id="tableBody"></tbody>
  </table>
</div>
<div class="ui bottom attached tab container" data-tab="job_c" style="min-height: 500px;">
<div class="ui form" style="margin-top: 20px;">
<div class="fields">
  <div class="eight wide field">
    <label>Select Position:</label>
    <div class="ui fluid search selection dropdown" id="position_drop">
      <input type="hidden" name="position">
        <i class="dropdown icon"></i>
        <div class="default text">
          Select Position
        </div>
      <div class="menu" id="position_drop_menu"></div>
    </div>
  </div>
  <div class="four wide field">
    <label>Select Function:</label>
    <div class="ui fluid search selection dropdown" id="function_drop">
      <input type="hidden" name="position">
        <i class="dropdown icon"></i>
        <div class="default text">
          Select Function
        </div>
      <div class="menu" id="function_drop_menu"></div>
    </div>
  </div>
</div>
  <button class="ui mini button blue" onclick="btn_search()">Search</button>
</div>
  <table class="" style="margin-top: 50px;">
    <thead>
      <tr>
        <th class="rotate"></th>
        <th style="vertical-align: bottom;"></th>
        <th style="vertical-align: bottom; min-width: 200px;"></th>
        <th class="rotate"><div><span>Adaptability</span></div></th>
        <th class="rotate"><div><span>Continous Learning</span></div></th>
        <th class="rotate"><div><span>Communication</span></div></th>
        <th class="rotate"><div><span>Organizational Awareness</span></div></th>
        <th class="rotate"><div><span>Creative Thinking</span></div></th>
        <th class="rotate"><div><span>Networking/Relationship Building</span></div></th>
        <th class="rotate"><div><span>Conflict Management</span></div></th>
        <th class="rotate"><div><span>Stewardship of Resources</span></div></th>
        <th class="rotate"><div><span>Risk Management</span></div></th>
        <th class="rotate"><div><span>Stress Management</span></div></th>
        <th class="rotate"><div><span>Influence</span></div></th>
        <th class="rotate"><div><span>Initiative</span></div></th>
        <th class="rotate"><div><span>Team Leadership</span></div></th>
        <th class="rotate"><div><span>Change Leadership</span></div></th>
        <th class="rotate"><div><span>Client Focus</span></div></th>
        <th class="rotate"><div><span>Partnering</span></div></th>
        <th class="rotate"><div><span>Developing Others</span></div></th>
        <th class="rotate"><div><span>Planning and Organizing</span></div></th>
        <th class="rotate"><div><span>Decision Making</span></div></th>
        <th class="rotate"><div><span>Analytical Thinking</span></div></th>
        <th class="rotate"><div><span>Results Orientation</span></div></th>
        <th class="rotate"><div><span>Teamwork</span></div></th>
        <th class="rotate"><div><span>Values and Ethics</span></div></th>
        <th class="rotate"><div><span>Visioning and Strategic Direction</span></div></th>
      </tr>
    </thead>
    <tbody id="tableBody1">
      <tr>
        <td colspan="27" style="padding: 20px; font-weight: bold; color: grey;">Please make a search.</td>
      </tr>
    </tbody>
  </table>
</div>
<?php require_once "footer.php";?>