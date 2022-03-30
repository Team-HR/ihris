<br>
<div class="ui active inverted dimmer" id="inDepthDIVLoader" style="display: none; height: 768px;">
    <div class="ui large text loader">Loading</div>
</div>
<div style="display: none;" id="inDepthDIV">
<select class="ui dropdown" id="comptDropdown">
        <option value="0">Adaptability</option>
        <option value="1">Continous Learning</option>
        <option value="2">Communication</option>
        <option value="3">Organizational Awareness</option>
        <option value="4">Creative Thinking</option>
        <option value="5">Networking/Relationship Building</option>
        <option value="6">Conflict Management</option>
        <option value="7">Stewardship of Resources</option>
        <option value="8">Risk Management</option>
        <option value="9">Stress Management</option>
        <option value="10">Influence</option>
        <option value="11">Initiative</option>
        <option value="12">Team Leadership</option>
        <option value="13">Change Leadership</option>
        <option value="14">Client Focus</option>
        <option value="15">Partnering</option>
        <option value="16">Developing Others</option>
        <option value="17">Planning and Organizing</option>
        <option value="18">Decision Making</option>
        <option value="19">Analytical Thinking</option>
        <option value="20">Results Orientation</option>
        <option value="21">Teamwork</option>
        <option value="22">Values and Ethics</option>
        <option value="23">Visioning and Strategic Direction</option>
</select>

<div class="ui segment">
  <h2 class="ui blue header" id="competency_title"></h2>
  <p id="competency_dsc"></p>
</div>
<style type="text/css">
  th {
    text-align: center !important;
    vertical-align: top !important;
    padding: 0px !important;
  }
  td {
    vertical-align: top;
  }
  .compac {
    padding: 0px !important;
    margin: 0px !important;
  }
</style>

<div class="ui grid">
  <div class="eight wide column"><canvas id="AdaptabilityChart" style="height: 50px;"></canvas></div>
  <div class="eight wide column"><canvas id="AdaptabilityBarChart" style="height: 50px;"></canvas></div>
</div>

<table class="ui very small compact blue structured celled table">
  <thead>
    <tr>
      <th colspan="2" id="competency_lvl1"></th>
      <th colspan="2" id="competency_lvl2"></th>
      <th colspan="2" id="competency_lvl3"></th>
      <th colspan="2" id="competency_lvl4"></th>
      <th colspan="2" id="competency_lvl5"></th>
    </tr>
  </thead>
  <tbody>
    <tr id="tableRows"></tr>
  </tbody>
</table>
</div>



<script type="text/javascript">
  var ldnLsaCharts;
  var ldnLsaBarCharts;

  $(document).ready(function() {
    
    $(loadEmployees(0));

    $("#comptDropdown").dropdown({
      onChange: function(val){
        console.log(val);
        // console.log($(this).index());
        ldnLsaCharts.destroy();
        ldnLsaBarCharts.destroy();
        $(loadEmployees(val));
      }
    });
    
     // console.log(val);

  });


  function loadEmployees(competency){
    $("#inDepthDIV").hide();
    $("#inDepthDIVLoader").show();
    
    $.post('personnelCompetenciesReport_indepth_report_proc.php', {
      loadEmployees: true,
      competency: competency
    }, function(data, textStatus, xhr) {
      var arr = jQuery.parseJSON(data);
      $("#competency_title").html(arr[5].competency_title);
      $("#competency_dsc").html(arr[5].competency_dsc);

      $('#competency_lvl1').html(arr[5].competency_lvl1);
      $('#competency_lvl2').html(arr[5].competency_lvl2);
      $('#competency_lvl3').html(arr[5].competency_lvl3);
      $('#competency_lvl4').html(arr[5].competency_lvl4);
      $('#competency_lvl5').html(arr[5].competency_lvl5);

      $("#tableRows").html(arr[0]);
    

// start chart



     var ctx = $("#AdaptabilityChart");
     var ctx2 = $("#AdaptabilityBarChart");
     var config = {
                        type: 'line',
                        data: {
                            labels: [
                            "Level 1",
                            "Level 2",
                            "Level 3",
                            "Level 4",
                            "Level 5",
                            ],
                            datasets: [{
                                label: 'Male',
                                data: arr[3],
                                backgroundColor: [
                                  '#055bc821',
                                ],
                                borderColor: [
                                '#055bc8',
                                ],
                                fill: true,
                                borderWidth: 2,
                            },{
                                label: 'Female',
                                data: arr[4],
                                backgroundColor: [
                                '#e116ff4d',
                                ],
                                borderColor: [
                                
                                '#e116ff',
                                ],
                                fill: true,
                                borderWidth: 2,
                            }]
                        },
                        options: {
                            
                            scales: {
                                yAxes: [{
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Number of Personnel'
                                    },
                                    ticks: {
                                        beginAtZero:true,
                                        // max: 100,
                                        stepSize: 20
                                    }
                                }]
                            },//end of scales

                                title: {
                                    display: true,
                                    text: "Total Number of Males and Females per Level"
                                },
                                legend: {
                                    display: true,  
                                },
    }
};
var config2 = {
                        type: 'doughnut',
                        data: {
                            labels: [
                            "Level 1",
                            "Level 2",
                            "Level 3",
                            "Level 4",
                            "Level 5",
                            ],
                            datasets: [{
                                label: 'Personnel',
                                data: arr[1],
                                backgroundColor: [
                                  '#39e600',
                                  '#099a9a',
                                  '#ff3300',
                                  '#ffcc00',
                                  '#0099cc',
                                ],
                                borderColor: [
                                // '#00000',
                                // '#00000',
                                // '#055bc8',
                                // '#055bc8',
                                // '#055bc8',
                                ],
                                fill: true,
                                borderWidth: 2,
                            }]
                        },
                        options: {
                            
                            // scales: {
                            //     yAxes: [{
                            //         scaleLabel: {
                            //             display: false,
                            //             labelString: 'Number of Personnel'
                            //         },
                            //         ticks: {
                            //             display:false,
                            //             beginAtZero:true,
                            //             // max: 100,
                            //             stepSize: 20
                            //         }
                            //     }]
                            // },//end of scales

                                title: {
                                    display: true,
                                    text: "Percentage of Personnel per Level"
                                },
                                legend: {
                                    display: true,  
                                },
    }
};





// end chart
$("#inDepthDIVLoader").hide();
$("#inDepthDIV").show();


ldnLsaCharts = new Chart(ctx, config);
ldnLsaBarCharts = new Chart(ctx2, config2);

    });
  }



</script>