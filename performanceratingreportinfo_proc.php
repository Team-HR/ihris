
<?php

require_once "_connect.db.php";
$prr_id = $_POST["prr_id"];
$type = $_POST["type"];
$year = "SELECT * from prr where prr_id='$prr_id'";
$year = $mysqli->query($year);
$year = $year->fetch_assoc();
$year = $year['year'];
$counter = substr($year,-2)."001";

function view($mysqli,$counter,$prr_id){
  $year = "SELECT * from prr where prr_id='$prr_id'";
  $year = $mysqli->query($year);
  $year = $year->fetch_assoc();
  $year = $year['year'];
  // $sql1 = "SELECT * from prrlist left join employees on prrlist.employees_id=employees.employees_id where prr_id='$prr_id'";
  //ako gi usob to ha
  $sql1 = "SELECT * from employees right join prrlist on employees.employees_id=prrlist.employees_id where prr_id='$prr_id' ORDER BY `gender` ASC,`lastName` ASC ";
  $result1 = $mysqli->query($sql1);
  $i=0;
  $tr="";
  while ($row1 = $result1->fetch_assoc()) {
    $employees_id = $row1['employees_id'];
    $lastName = $row1['lastName'];
    $firstName = $row1['firstName'];
    $middleName = $row1['middleName'];
    $extName = $row1['extName'];
    $gender = $row1['gender'];
    if ($result1->num_rows==0) {
      $i = 0;
    }else{
      $i=$row1['prrlist_id'];
    }
    if($row1['stages']=='Y'){
      $color = 'YELLOW';
    }else if($row1['stages']=='W'){
      $color = "WHITE";
    }else{
      $color = "CYAN";
    }

    $tr .= "
    <tr style='background:$color'>
    <td class='noprint'>
    <a href='employeeinfo.php?employees_id=$employees_id&spms' title='Open'> <i class='icon folder'></i> </a>
    </td>
    <td style='text-align:center'>".$counter++."</td>
    <td>".mb_convert_case($lastName,MB_CASE_TITLE, 'UTF-8')."</td>
    <td>".mb_convert_case($firstName,MB_CASE_TITLE, 'UTF-8')."</td>
    <td align='center'>".mb_convert_case($middleName[0],MB_CASE_TITLE, 'UTF-8')."</td>
    <td align='center'>$extName</td>
    <td align='center'>$gender[0]</td>
    <td style='width:100px;text-align:center'>".$row1['date_submitted']."</td>
    <td>$row1[appraisal_type]</td>
    <td style='width:100px;text-align:center'>$row1[date_appraised]</td>
    <td style='text-align:center'>$row1[numerical]</td>
    <td style='text-align:center'>$row1[adjectival]</td>
    <td>$row1[remarks]</td>
    <td class='noprint'>
    <button class='ui inverted green tiny icon button' onclick='ratingModal($i,$employees_id,$prr_id)'>
    <i class='edit icon' data-content='Add users to your feed'></i>
    </button>
    </td>
    <td class='noprint'>
    <button class='ui inverted blue tiny icon button' onclick='stateColor($i,$employees_id,$prr_id,\"C\")'>
    </button>
    </td>
    <td class='noprint'>
    <button class='ui inverted yellow tiny icon button' onclick='stateColor($i,$employees_id,$prr_id, \"Y\")'>
    </button>
    </td>
    <td class='noprint'>
    <button class='ui inverted black tiny icon button' onclick='stateColor($i,$employees_id,$prr_id,\"W\")'>
    </button>
    </td>
    <td class='noprint'>
    <button class='ui red icon button' onclick='removePerInfo($i)'><i class='trash alternate outline icon'></i>

    </button>
    </td>
    </tr>

    ";

  }

  return $tr;
}

function Ov_rates($mysqli,$sql){
  $result = $mysqli->query($sql);
  $FO = 0;
  $FV = 0;
  $FS = 0;
  $FU = 0;
  $FP = 0;
  $FT = 0;
  $MO = 0;
  $MV = 0;
  $MS = 0;
  $MU = 0;
  $MP = 0;
  $MT = 0;
  while($row = $result->fetch_assoc()){
    $employees_id = $row["employees_id"];
    $sql1 ="SELECT * from prrlist where prr_id='$_POST[prr_id]' AND employees_id='$employees_id'";
    $result2 = $mysqli->query($sql1);
    $row2 = $result2->fetch_assoc();
    if($row['gender']=="MALE"){
      if ($row2['adjectival']=='O') {
        $MO++;
      }elseif ($row2['adjectival']=='VS') {
        $MV++;
      }elseif ($row2['adjectival']=='S') {
        $MS++;
      }elseif ($row2['adjectival']=='US') {
        $MU++;
      }else{
        $MP++;
      }
    }elseif ($row['gender']=="FEMALE") {
      if ($row2['adjectival']=='O') {
        $FO++;
      }elseif ($row2['adjectival']=='VS') {
        $FV++;
      }elseif ($row2['adjectival']=='S') {
        $FS++;
      }elseif ($row2['adjectival']=='US') {
        $FU++;
      }else{
        $FP++;
      }
    }
  }
  $FT = $FO+$FV+$FS+$FU+$FP;
  $MT = $MO+$MV+$MS+$MU+$MP;
  $a = array(
    'F'=>array('O'=>$FO,'V'=>$FV,'S'=>$FS,'U'=>$FU,'P'=>$FP,'T'=>$FT),
    'M'=>array('O'=>$MO,'V'=>$MV,'S'=>$MS,'U'=>$MU,'P'=>$MP,'T'=>$MT)
  );
  return $a;
}

function emp($mysqli){
  $sql = "SELECT * from employees";
  $sql = $mysqli->query($sql);
  $view = "";
  while ($row = $sql->fetch_assoc()) {
    $view.="<div class='item' data-value='$row[employees_id]'>$row[lastName] $row[firstName]</div>";
  }
  return $view;
}


?>

<script type="text/javascript">
$(document).ready(function() {
  $('.ui.sticky').sticky();
  $(".dropdown").dropdown({
    fullTextSearch: true
  });
});
function addempprr(i){
  empid = $('#empidprr').val();
  if(empid!=""){
    $.post('umbra/addemppage.php', {
      addemppage:true,
      empid:empid,
      prrid:i
    }, function(data, textStatus, xhr) {
      $(load);

    });
  }
}
</script>
<div class="ui sticky noprint" style="background:white;padding: 10px">
  
       <div class="ui icon fluid input noprint" style="width: 300px;margin:auto;z-index: 10px">
        <input id="_search" type="text" placeholder="Search..." onkeyup="find(this)">
        <i class="search icon"></i>
      </div><br>
 

  <h1 style="text-align: center">Add Employee</h1>
  <div class="ui fluid action input" >
    <div class="ui fluid search selection dropdown">
      <input type="hidden" id="empidprr">
      <i class="dropdown icon"></i>
      <div class="default text">Select Employee To add</div>
      <div class="menu">
        <?=emp($mysqli)?>
      </div>
    </div>
    <button class="ui button" onclick="addempprr(<?=$prr_id?>)">ADD</button>
  </div>
</div>
<br>
<table class="customTable">
  <thead style="background-color: lightgrey;">
    <tr>
      <th rowspan="2" class="noprint"></th>
      <th rowspan="2">CSID</th>
      <th colspan="4">Employees Name</th>
      <th rowspan="2">Gender</th>
      <th rowspan="2">Date Submitted</th>
      <th rowspan="2">Appraisal Type</th>
      <th rowspan="2">Date Appraised (mm/dd/yy)</th>
      <th colspan="2">Rating</th>
      <th rowspan="2">Remarks</th>
      <th rowspan="2" colspan="5" class="noprint">Option</th>
    </tr>
    <tr>
      <th>Last Name</th>
      <th>Given Name</th>
      <th>Middle Name</th>
      <th>Name Ext.</th>
      <th>Numerical</th>
      <th>Adjectival</th>
    </tr>
  </thead>
  <tbody id="tableBody">
    <?=view($mysqli,$counter,$prr_id)?>
  </tbody>
</table>

<div id="cons">
  <p>Certified Correct:</p>
  <div style="text-align: center;width: 49%; float:left;">
    <p style="text-decoration: underline;line-height: 1px;font-weight:bolder;"> VERONICA GRACE P. MIRAFLOR </p>
    <p style="font-size: 10px;line-height: 1px"> HRMO IV </p>
    <p style="font-size: 10px"> (Signature over Printed Name) </p><br>
    <p style="line-height: 1px;font-size: 10px;">Date: ________________ </p>
    <p style="font-size: 10px;line-height: 1px;padding-left:25px">(mm/dd/yyyy) </p>
  </div>
  <div style="width: 49%; float:left;padding:0px 50px 0px 50px">
    <div style="font-size: 10px;border: 2px solid black;padding:10px">
      <p><span style="font-weight: bold">FOR CSC ACTION:</span> Please don't write anything beyond this point</p>
      <p style="font-weight: bolder;line-height:1px ">DOCUMENT TRACKING </p>
      <p style="text-align: center">Received by:________________ Date:_________ <br>Encoded by:________________  Date:_________ <br> Posted by:_________________   Date:_________</p>
    </div>
  </div>
  <div style="clear:both"></div>
  <div>
    <br>
    <?php
    $sql = "SELECT * from prrlist left join employees on prrlist.employees_id=employees.employees_id where prr_id='$prr_id'";
    $OV = Ov_rates($mysqli,$sql);
    ?>
    <table style="border-collapse: collapse;margin: auto;">
      <thead>
        <tr>
          <th class="noborder noright" style="width: 200px"></th>
          <th class="noborder" style="width: 50px"></th>
          <th style="width: 100px">Female</th>
          <th style="width: 100px">Male</th>
          <th style="width: 100px">Total</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td  class="noborder noright">OUTSTANDING</td>
          <td  class="noborder">=</td>
          <td style="text-align: center"><?=$OV['F']['O']?></td>
          <td style="text-align: center"><?=$OV['M']['O']?></td>
          <td style="text-align: center"><?=$OV['F']['O']+$OV['M']['O']?></td>
        </tr>
        <tr>
          <td  class="noborder noright">VERY SATISFACTORY </td>
          <td  class="noborder">=</td>
          <td style="text-align: center"><?=$OV['F']['V']?></td>
          <td style="text-align: center"><?=$OV['M']['V']?></td>
          <td style="text-align: center"><?=$OV['F']['V']+$OV['M']['V']?></td>
        </tr>
        <tr>
          <td  class="noborder noright">SATISFACTORY</td>
          <td  class="noborder">=</td>
          <td style="text-align: center"><?=$OV['F']['S']?></td>
          <td style="text-align: center"><?=$OV['M']['S']?></td>
          <td style="text-align: center"><?=$OV['F']['S']+$OV['M']['S']?></td>
        </tr>
        <tr>
          <td  class="noborder noright">UNSATISFACTORY</td>
          <td  class="noborder">=</td>
          <td style="text-align: center"><?=$OV['F']['U']?></td>
          <td style="text-align: center"><?=$OV['M']['U']?></td>
          <td style="text-align: center"><?=$OV['F']['U']+$OV['M']['U']?></td>
        </tr>
        <tr>
          <td  class="noborder noright">POOR</td>
          <td  class="noborder">=</td>
          <td style="text-align: center"><?=$OV['F']['P']?></td>
          <td style="text-align: center"><?=$OV['M']['P']?></td>
          <td style="text-align: center"><?=$OV['F']['P']+$OV['M']['P']?></td>
        </tr>
        <tr>
          <td class="noborder noright">TOTAL</td>
          <td class="noborder">=</td>

          <td style="text-align: center"><?=$OV['F']['T']?></td>
          <td style="text-align: center"><?=$OV['M']['T']?></td>
          <td style="text-align: center"><?=$OV['F']['T']+$OV['M']['T']?></td>
        </tr>
      </tbody>
    </table>
  </div>
  <!-- chart -->

  <br>
  <br>
  <br>
  <div style="width:800px;margin:auto;">
    <canvas id="myChart" width="200" height="200"></canvas>
  </div>
  <script>
  var ctx = document.getElementById('myChart');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Poor', 'UNSATISFACTORY', 'SATISFACTORY', 'VERY SATISFACTORY	', 'OUTSTANDING'],
      datasets: [{
        label: ['Performance Rating Report'],
        data: [
          <?=$OV['F']['P']+$OV['M']['P']?>,
          <?=$OV['F']['U']+$OV['M']['U']?>,
          <?=$OV['F']['S']+$OV['M']['S']?>,
          <?=$OV['F']['V']+$OV['M']['V']?>,
           <?=$OV['F']['O']+$OV['M']['O']?>],
        backgroundColor: [
          'rgba(231, 0, 0, 0.2)',
          'rgba(231, 115, 0, 0.2)',
          'rgba(231, 231, 0, 0.2)',
          'rgba(0, 231, 0, 0.2)',
          'rgba(0, 231, 231, 0.2)',
        ],
        borderColor: [
          'rgba(231, 0, 0, 1)',
          'rgba(231, 115, 0, 1)',
          'rgba(231, 231, 0, 1)',
          'rgba(0, 231, 0, 1)',
          'rgba(0, 231, 231, 1)',
        ],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    }
  });
  </script>
