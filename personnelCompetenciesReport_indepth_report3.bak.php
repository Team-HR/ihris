<?php

//TEST TO GET ALL EMPLOYEES COMPETENCY DATA
require_once 'libs/Competency.php';
$competency = new Competency();

// echo count($competency->getData('VisioningandStrategicDirection',1));

?>
<br>
<select class="ui dropdown">
        <option>Adaptability</option>
        <option>Continous Learning</option>
        <option>Communication</option>
        <option>Organizational Awareness</option>
        <option>Creative Thinking</option>
        <option>Networking/Relationship Building</option>
        <option>Conflict Management</option>
        <option>Stewardship of Resources</option>
        <option>Risk Management</option>
        <option>Stress Management</option>
        <option>Influence</option>
        <option>Initiative</option>
        <option>Team Leadership</option>
        <option>Change Leadership</option>
        <option>Client Focus</option>
        <option>Partnering</option>
        <option>Developing Others</option>
        <option>Planning and Organizing</option>
        <option>Decision Making</option>
        <option>Analytical Thinking</option>
        <option>Results Orientation</option>
        <option>Teamwork</option>
        <option>Values and Ethics</option>
        <option>Visioning and Strategic Direction</option>
</select>

<div class="ui segment">
  <h2 class="ui blue header">Adaptability</h2>
  <p>Adjusting own behaviors to work efficiently and effectively in light of new information, changing situations and/or different environments.</p>
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
      <th colspan="2"><i class="icon certificate" style="color: #39e600"></i>Level 1 <br><b id="lvl1" style="color: green;"></b><i>% <br>Recognizes how change will affect work</i></th>
      <th colspan="2"><i class="icon certificate" style="color: #099a9a"></i>Level 2 <br><b id="lvl2" style="color: green;"></b><i>% <br>Adapts one's work to a situation</i></th>
      <th colspan="2"><i class="icon certificate" style="color: #ff3300"></i>Level 3 <br><b id="lvl3" style="color: green;"></b><i>% <br>Adapts to a variety of changes</i></th>
      <th colspan="2"><i class="icon certificate" style="color: #ffcc00"></i>Level 4 <br><b id="lvl4" style="color: green;"></b><i>% <br>Adapts to large, complex and/or frequent changes</i></th>
      <th colspan="2"><i class="icon certificate" style="color: #0099cc"></i>Level 5 <br><b id="lvl5" style="color: green;"></b><i>% <br>Adapts organizational strategies</i></th>
    </tr>
<!--     <tr>
      <?php
for ($i=1; $i <=5 ; $i++) { 
  echo "<th>M</th><th>F</th>";
}
      ?>
    </tr> -->
  </thead>
  <tbody>
    <tr>
<?php
  
  $AdaptabilityChartData = array();
  $AdaptabilityChartDataMale = array();
  $AdaptabilityChartDataFemale = array();

for ($i=1; $i <=5 ; $i++) { 
  
  $competency_arr = $competency->getData('Adaptability',$i);
  $competency_male = $competency->getDataMale('Adaptability',$i);
  $competency_female = $competency->getDataFemale('Adaptability',$i);


  $count = count($competency_arr);
  $countMale = count($competency_male);
  $countFemale = count($competency_female);

  
  array_push($AdaptabilityChartData, $count);
  array_push($AdaptabilityChartDataMale, $countMale);
  array_push($AdaptabilityChartDataFemale, $countFemale);

  $html = "<td>";
  $html .= "<h5 class='ui centered header compac'>".$countMale." M <br>TOTAL:</h5>";
  $html .= "<div class='ui celled selection list compac'>";
  // $html .= "<li>$i</li>";
 
foreach ($competency_male as $employee) {
  // <a href='".$employee["employees_id"]."'><i class='blue address book icon'></i></a> 
  $html .= "<a href='employeeinfo.php?employees_id=$employee[employees_id]' target='_blank' class='item' style='color: black;'>".$employee["fullName"]."</a>";
}


  $html .= "</div></td>";

  $html .= "<td>";
  $html .= "<h5 class='ui centered header compac'>".$countFemale." F <br>$count</h5>";
  $html .= "<div class='ui celled selection list compac'>";
  // $html .= "<li>$i</li>";
 // <a href='".$employee["employees_id"]."'><i class='blue address book icon'></i></a>
foreach ($competency_female as $employee) {
  $html .= "<a href='employeeinfo.php?employees_id=$employee[employees_id]' target='_blank' class='item' style='color: black;'>".$employee["fullName"]."</a>";
}


  $html .= "</div></td>";




  echo $html;
}

$AdaptabilityChartData = json_encode($AdaptabilityChartData);
$AdaptabilityChartDataMale = json_encode($AdaptabilityChartDataMale);
$AdaptabilityChartDataFemale = json_encode($AdaptabilityChartDataFemale);

?>

    </tr>
  </tbody>
</table>




<script type="text/javascript">
      jQuery(document).ready(function($) {
        $(".ui.dropdown").dropdown({
          onChange: function(val){
            alert(val);
          }
        });
      });
     var ctx = document.getElementById("AdaptabilityChart");
     var ctx2 = document.getElementById("AdaptabilityBarChart")
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
                                data: 
                                <?=$AdaptabilityChartDataMale;?>,
                                backgroundColor: [
                                  '#055bc821',
                                ],
                                borderColor: [
                                '#055bc8',
                                ],
                                fill: true,
                                borderWidth: 2,
                            },
{
                                label: 'Female',
                                data: <?=$AdaptabilityChartDataFemale;?>,
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
                                        labelString: 'Number of Personnels'
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
                                label: 'Personnels',
                                data: 
                                <?php

                                $arr = json_decode($AdaptabilityChartData);
                                $arr_percent = array();
                                $total=0;
                                foreach ($arr as $value) {
                                  $total += $value;
                                }
                                foreach ($arr as $value) {
                                  $percent = number_format((($value/$total)*100), 2, '.', '');
                                  array_push($arr_percent, $percent);
                                }

                                echo json_encode($arr_percent);

                                ?>,
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
                            //             labelString: 'Number of Personnels'
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
                                    text: "Percentage of Personnels per Level"
                                },
                                legend: {
                                    display: true,  
                                },
    }
};

var ldnLsaCharts = new Chart(ctx, config);
var ldnLsaBarCharts = new Chart(ctx2, config2);


$('#lvl1').html(<?=$arr_percent[0]?>);
$('#lvl2').html(<?=$arr_percent[1]?>);
$('#lvl3').html(<?=$arr_percent[2]?>);
$('#lvl4').html(<?=$arr_percent[3]?>);
$('#lvl5').html(<?=$arr_percent[4]?>);
</script>