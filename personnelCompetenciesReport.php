<?php $title = "Competency Report"; require_once "header.php"; require_once "_connect.db.php";?>
<script type="text/javascript">

  var dept_filters = "";
  var overall_chart_data = [];
  var overall_chart;
  $(document).ready(function() {
    var loading = $('#loading_el');
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
    
    $("#mulitipleFilters").dropdown({
      onChange: function (){
        loadingBtn = '<div class="ui active mini inline loader"></div> Loading...';
        $("#num_rows").html(loadingBtn);
        $("#clearFilter").show();
        $("#clearFilter").addClass('loading');
        $("#tableBody").html(loading); 
        dept_filters = $(this).dropdown('get values');
        $(load(dept_filters));
        $("#employee_search").val("");
        if ($(this).dropdown("get value") == "") {
          dept_filters = "";
          $("#clearFilter").hide();
        }
      },
    });


    $("#clearFilter").click(function(event) {
      $('#mulitipleFilters').dropdown('restore defaults');
      $(this).hide();
      dept_filters = "";
    });

    // $(load);
    
    $(load(dept_filters));

     overall_chart = $("#overall_chart");
     var config = {
                        type: 'line',
                        data: {
                            labels: [
                              'Adaptability',
                              'ContinousLearning',
                              'Communication',
                              'OrganizationalAwareness',
                              'CreativeThinking',
                              'NetworkingRelationshipBuilding',
                              'ConflictManagement',
                              'StewardshipofResources',
                              'RiskManagement',
                              'StressManagement',
                              'Influence',
                              'Initiative',
                              'TeamLeadership',
                              'ChangeLeadership',
                              'ClientFocus',
                              'Partnering',
                              'DevelopingOthers',
                              'PlanningandOrganizing',
                              'DecisionMaking',
                              'AnalyticalThinking',
                              'ResultsOrientation',
                              'Teamwork',
                              'ValuesandEthics',
                              'VisioningandStrategicDirection'
                            ],
                            datasets: [{
                                label: 'Level',
                                data: overall_chart_data,
                                backgroundColor: [
                                  '#055bc821',
                                ],
                                borderColor: [
                                  '#055bc8',
                                ],
                                fill: false,
                                borderWidth: 1,
                                lineTension: 0,
                            }]
                        },
                        options: {
                            responsive: true,
                            title: {
                                    display: false,
                                    text: "Overall "
                            },
                            legend: {
                                    display: true,  
                            },
                            scales: {
                                yAxes: [{
                                    scaleLabel: {
                                        display: false,
                                        labelString: 'Level'
                                    },
                                    ticks: {
                                        beginAtZero:false,
                                        stepSize: 1
                                    }
                                }],
                                xAxes: [{
                                display: true,
                                ticks:{
                                  autoSkip: false
                                }
                              }],
                            },
    }
};
    
    overallChart = new Chart(overall_chart, config);

  });



  function getNumOfStatus(filters){
    $.post('personnelCompetenciesReport_proc.php', {
      getNumOfStatus: true,
      filters: filters
    }, function(data, textStatus, xhr) {
      // $("#total_rows").html(array.total);
      $("#num_rows").html(data);
    });
  }

  function load(filters){
      $.post('personnelCompetenciesReport_proc.php', {
        load: true,
        filters: filters,
      }, function(data, textStatus, xhr) {
        /*optional stuff to do after success */
        $("#tableBody").html(data);
        $(getNumOfStatus(filters));
        $("#clearFilter").removeClass('loading');

        $.post('personnelCompetenciesReport_proc.php', {
            get_average_data: true,
            filters: filters
          }, function(data, textStatus, xhr) {
            /*optional stuff to do after success */
            overall_chart_data = data;
            console.log(overall_chart_data);
            overallChart.update();
          });

      });


    // $("#num_rows").load('personnelCompetenciesReport_proc.php',{
    //   get_rows: true,
    // },
    //   function(){
    //     // $("#num_rows").load('personnelCompetenciesReport_proc.php',{
    //     //   get_rows: true,
    //     // }
    // });
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



<div class="ui container" style="width: 1300px; margin-bottom: 20px;">
  <div class="ui borderless blue inverted mini menu noprint">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
    <div class="item">
     <h3><i class="icon chart line"></i>Competency Report</h3>
   </div>
    <div class="right item" style="width: 45%;"></div>
  </div>
</div>

<div class="ui container" style="background-color: white; width: 1300px;">
<div class="ui segment">
<div class="ui top attached tabular menu" id="tabs">
  <a class="item" data-tab="reportindepth">In-Depth Survey Report</a>
  <a class="item active" data-tab="report">Survey Report</a>
  <a class="item" data-tab="job_c">Job Competecy</a>
</div>
<div class="ui bottom attached tab" data-tab="reportindepth">
  <?php
    require_once 'personnelCompetenciesReport_indepth_report.php';
  ?>
</div>
<div class="ui bottom attached tab active" data-tab="report">
  <div id="snum_rows" class="ui basic segment" style="font-size: 24px;">
    <i class="icon info blue tiny circle"></i><span id="num_rows" style="font-size: 13px; color: grey; font-style: italic;"><div class="ui active mini inline loader"></div> Loading...</span>
  </div>
<!-- start filter -->


<!-- <h1>charthere!</h1> -->
<!-- <div class="ui grid center aligned">
  <div class="eight wide column"> -->
    <canvas id="overall_chart"></canvas>
  <!-- </div>
</div> -->

<div class="ui multiple dropdown" id="mulitipleFilters" style="margin-left: 20px;">
  <input type="hidden" name="filters">
  <button id="clearFilter" style="display: none;" class="ui mini button">Clear</button>
  <i class="filter blue icon"></i>
  <span class="text">Filter Table</span>
  <div class="menu">
    <div class="ui icon search input">
      <i class="search icon"></i>
      <input type="text" placeholder="Search tags...">
    </div>
    <div class="divider"></div>
    <div class="header">
      <i class="tags icon"></i>
      Tag Label
    </div>
    <div class="scrolling menu">

      <div class="item" data-value="gender=MALE">
        <div class="ui blue empty circular label"></div>
        Male
      </div>
      <div class="item" data-value="gender=FEMALE">
        <div class="ui pink empty circular label"></div>
        Female
      </div>
      <div class="item" data-value="type=PERMANENT">
        <div class="ui yellow empty circular label"></div>
        Permanent
      </div>
      <div class="item" data-value="type=CASUAL">
        <div class="ui orange empty circular label"></div>
        Casual
      </div>
      <div class="item" data-value="level=1">
        <div class="ui purple empty circular label"></div>
        Level 1
      </div>
      <div class="item" data-value="level=2">
        <div class="ui purple empty circular label"></div>
        Level 2
      </div>
      <div class="item" data-value="nature=RANK & FILE">
        <div class="ui purple empty circular label"></div>
        Rank & File
      </div>
      <div class="item" data-value="nature=SUPERVISORY">
        <div class="ui purple empty circular label"></div>
        Supervisory
      </div>
      <div class="item" data-value="category=Technical">
        <div class="ui purple empty circular label"></div>
        Technical
      </div>
      <div class="item" data-value="category=Aministrative">
        <div class="ui purple empty circular label"></div>
        Aministrative
      </div>
      <div class="item" data-value="category=Key Position">
        <div class="ui purple empty circular label"></div>
        Key Position
      </div>
      <div class="item" data-value="ldn2018=ldn2018">
        <div class="ui purple empty circular label"></div>
        LDN ASSESSMENT 2018
      </div>

<?php
  
  require '_connect.db.php';
  $sql = "SELECT * FROM `department` ORDER BY `department` ASC";
  $result = $mysqli->query($sql);
  while ($row = $result->fetch_assoc()) {
?>

      <div class="item" data-value="<?= "dept_id=".$row['department_id']?>">
        <div class="ui green empty circular label"></div>
        <?= $row['department']?>
      </div>

<?php }


?>


    </div>
  </div>
</div>
<!-- end filter -->

  <style type="text/css">
    table {
      border-collapse: collapse;
    }
    .datatr:hover {
      background-color: #cbffc0;
    }
    td {
      border: 1px solid #5ea3ff;
      text-align: center;
    }
    th.rotate {
      height: 83px;
      white-space: nowrap;
    }
    th.rotate > div {
      transform: 
        translate(18px, 51px)
        rotate(315deg);
      width: 30px;

    }
    th.rotate > div > span {
      border-bottom: 1px solid #5ea3ff;
      padding: 5px 10px;
    }
    tr:nth-child(even) {
      background-color: #edf3fb;
    }

  </style>

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
    <tbody id="tableBody">
        <tr id="loading_el">
          <td colspan="27" style="width: 1087px; text-align: center; font-size: 32px; color: lightgrey; padding: 100px;"><!-- FETCHING DATA... -->
            <img src="assets/images/loading.gif" style="height: 50px; margin-top: -100px;">
            <br>
            <span>Fetching data...</span>
          </td>
        </tr>

    </tbody>
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
</div>
</div>

<?php require_once "footer.php";?>