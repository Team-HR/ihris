<?php

//TEST TO GET ALL EMPLOYEES COMPETENCY DATA
require_once 'libs/Competency.php';
$competency = new Competency();

// echo count($competency->getData('VisioningandStrategicDirection',1));

?>
<div class="ui basic segment">
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

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

      

<div class="ui grid">
  <div class="eight wide column">
    <!-- <canvas id="AdaptabilityChart" style="height: 200px; "></canvas> -->
    <div id="piechart_3d" style="height: 400px;"></div>
  </div>
  <div class="eight wide column">
    <!-- <canvas id="AdaptabilityBarChart" style="height: 200px;"></canvas> -->
    <div id="columnchart_material" style="height: 400px;"></div>
  </div>
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
</div>

<?php
echo $AdaptabilityChartDataMale;
?>

<script type="text/javascript">

  var theData = <?=$AdaptabilityChartData?>;
  var theDataM = <?=$AdaptabilityChartDataMale?>;
  var theDataF = <?=$AdaptabilityChartDataFemale?>;

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

  // echo json_encode($arr_percent);
?>                             

$('#lvl1').html(<?=$arr_percent[0]?>);
$('#lvl2').html(<?=$arr_percent[1]?>);
$('#lvl3').html(<?=$arr_percent[2]?>);
$('#lvl4').html(<?=$arr_percent[3]?>);
$('#lvl5').html(<?=$arr_percent[4]?>);

  google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Levels', 'Male', 'Female'],
          ['Level 1', theDataM[0], theDataF[0]],
          ['Level 2', theDataM[1], theDataF[1]],
          ['Level 3', theDataM[2], theDataF[2]],
          ['Level 4', theDataM[3], theDataF[3]],
          ['Level 5', theDataM[4], theDataF[4]]
        ]);

        var options = {
          chart: {
            title: 'Number of Employees according to Gender',
            subtitle: 'Based on conducted competency-based survey of 2018.',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }


      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChartPie);
      function drawChartPie() {
        var data = google.visualization.arrayToDataTable([
          ['Level', 'Percent'],
          ['Level 1', <?=$arr_percent[0]?>],
          ['Level 2', <?=$arr_percent[1]?>],
          ['Level 3', <?=$arr_percent[2]?>],
          ['Level 4', <?=$arr_percent[3]?>],
          ['Level 5', <?=$arr_percent[4]?>]
        ]);

        var options = {
          // chart: {
          //   title: 'Number of Employees according to Gender',
          //   subtitle: 'Based on conducted competency-based survey of 2018.',
          // },
          title: 'Percentage of Employees per Level',
          // subtitle: 'Based on conducted competency-based survey of 2018.',
          is3D: true,
        };

        var chartPie = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chartPie.draw(data, options);
      }



</script>
