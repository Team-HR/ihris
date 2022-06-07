<?php
require_once '_connect.db.php';
require_once 'libs/Competency.php';
$competency = new Competency();


if (isset($_POST["loadEmployees"])) {
	$compt = $_POST["competency"];
	// $compt = 'Adaptability';
	$competency_id = $compt+1;
	$data = array();
	$AdaptabilityChartData = array();
	$AdaptabilityChartDataMale = array();
	$AdaptabilityChartDataFemale = array();
	$tableRows_td = "";


// get title and dsc start
	$sql = "SELECT * FROM `competencies` WHERE `competencies`.`competency_id` = '$competency_id'";
	$result = $mysqli->query($sql);

	$row = $result->fetch_assoc();

	$competency_title = $row["competency"];
	$competency_dsc = $row["dsc"];
	$competency_lvl1 = $row["level1"];
	$competency_lvl2 = $row["level2"];
	$competency_lvl3 = $row["level3"];
	$competency_lvl4 = $row["level4"];
	$competency_lvl5 = $row["level5"];

// get title and dsc end


for ($i=1; $i <=5 ; $i++) { 
  
  $competency_arr = $competency->getData($compt,$i);
  $competency_male = $competency->getDataMale($compt,$i);
  $competency_female = $competency->getDataFemale($compt,$i);


  $count = count($competency_arr);
  $countMale = count($competency_male);
  $countFemale = count($competency_female);

  
  array_push($AdaptabilityChartData, $count);
  array_push($AdaptabilityChartDataMale, $countMale);
  array_push($AdaptabilityChartDataFemale, $countFemale);

  $td_html = "<td>";
  $td_html .= "<h5 class='ui centered header compac'>".$countMale." M <br>TOTAL:</h5>";
  $td_html .= "<div class='ui celled selection list compac'>";
  // $td_html .= "<li>$i</li>";
 
foreach ($competency_male as $employee) {
  // <a href='".$employee["employees_id"]."'><i class='blue address book icon'></i></a> 
  $td_html .= "<a href='employeeinfo.php?employees_id=$employee[employees_id]' target='_blank' class='item' style='color: black;'>".$employee["fullName"]."</a>";
}


  $td_html .= "</div></td>";

  $td_html .= "<td>";
  $td_html .= "<h5 class='ui centered header compac'>".$countFemale." F <br>$count</h5>";
  $td_html .= "<div class='ui celled selection list compac'>";
  // $td_html .= "<li>$i</li>";
 // <a href='".$employee["employees_id"]."'><i class='blue address book icon'></i></a>
foreach ($competency_female as $employee) {
  $td_html .= "<a href='employeeinfo.php?employees_id=$employee[employees_id]' target='_blank' class='item' style='color: black;'>".$employee["fullName"]."</a>";
}

  $td_html .= "</div></td>";
  $tableRows_td .= $td_html;

}

$arr_percent = array();
$total=0;
foreach ($AdaptabilityChartData as $value) {
  $total += $value;
}
foreach ($AdaptabilityChartData as $value) {
  $percent = number_format((($value/$total)*100), 2, '.', '');
  array_push($arr_percent, $percent);
}
// $arr_percent = json_encode($arr_percent);

$AdaptabilityChartData = json_encode($AdaptabilityChartData);
$AdaptabilityChartDataMale = $AdaptabilityChartDataMale;
$AdaptabilityChartDataFemale = $AdaptabilityChartDataFemale;

$data[] = $tableRows_td;
$data[] = $arr_percent;
$data[] = $AdaptabilityChartData;
$data[] = $AdaptabilityChartDataMale;
$data[] = $AdaptabilityChartDataFemale;
$data[] = array(
	'competency_title' => $competency_title,
	'competency_dsc' => $competency_dsc,
	'competency_lvl1' => '<i class="icon certificate" style="color: #39e600"></i>Level 1 <br><b style="color: green;">'.$arr_percent[0].'</b><i>% <br>'.$competency_lvl1.'</i>',
	'competency_lvl2' => '<i class="icon certificate" style="color: #099a9a"></i>Level 2 <br><b style="color: green;">'.$arr_percent[1].'</b><i>% <br>'.$competency_lvl2.'</i>',
	'competency_lvl3' => '<i class="icon certificate" style="color: #ff3300"></i>Level 3 <br><b style="color: green;">'.$arr_percent[2].'</b><i>% <br>'.$competency_lvl3.'</i>',
	'competency_lvl4' => '<i class="icon certificate" style="color: #ffcc00"></i>Level 4 <br><b style="color: green;">'.$arr_percent[3].'</b><i>% <br>'.$competency_lvl4.'</i>',
	'competency_lvl5' => '<i class="icon certificate" style="color: #0099cc"></i>Level 5 <br><b style="color: green;">'.$arr_percent[4].'</b><i>% <br>'.$competency_lvl5.'</i>'
);

 
echo json_encode($data);


}

?>