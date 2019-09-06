  <?php
require_once "_connect.db.php";



if (isset($_POST["load"])) {
 $sql0 = "SELECT * FROM `department` WHERE `department_id` IN (SELECT `department_id` FROM `employees` WHERE `employees_id` IN (SELECT `employees_id` FROM `competency`))";
 $result0 = $mysqli->query($sql0);
 $counter = 0;
 while ($row0 = $result0->fetch_assoc()) {
  $department_id = $row0["department_id"];
  $department = $row0["department"];

?>
<tr>
  <td colspan="27" style="text-align: left; padding: 5px; background-color: #4075a9; color: white; font-weight: bold;">
    <?php echo $department;?>
  </td>
</tr>
<?php

$sql = "SELECT * FROM `competency` WHERE `employees_id` IN (SELECT `employees_id` FROM `employees` WHERE `department_id` = '$department_id')";


// $sql = "SELECT * FROM `competency`";
  $result = $mysqli->query($sql);
  ?>

<script type="text/javascript">
  $(document).ready(function() {
    $('.popup').popup();
  });
</script>


  <?php
  while ($row = $result->fetch_array(MYSQLI_NUM)) {
    $counter++;
    $competency_id = $row[0];
    $employees_id = $row[1];
    if ($employees_id != 0) {

// get name start
    $sql1 = "SELECT * FROM `employees` WHERE `employees_id` = '$employees_id'";
    $result1 = $mysqli->query($sql1);

    $row1 = $result1->fetch_assoc();

    if (!empty($row1['extName'])) {
      $extName = ", ".$row1['extName'];
    } else {
      $extName = "";
    }

    $fullName = $row1['lastName'].", ".$row1['firstName']." ".$row1['middleName']." ".$extName." ";
// get name end

    } else {
      $fullName = "Unidentified! Please see input in db...";
    }


    $datetime = $row[2];
    $comp0 = $row[3];
    $comp1 = $row[4];
    $comp2 = $row[5];
    $comp3 = $row[6];
    $comp4 = $row[7];
    $comp5 = $row[8];
    $comp6 = $row[9];
    $comp7 = $row[10];
    $comp8 = $row[11];
    $comp9 = $row[12];
    $comp10 = $row[13];
    $comp11 = $row[14];
    $comp12 = $row[15];
    $comp13 = $row[16];
    $comp14 = $row[17];
    $comp15 = $row[18];
    $comp16 = $row[19];
    $comp17 = $row[20];
    $comp18 = $row[21];
    $comp19 = $row[22];
    $comp20 = $row[23];
    $comp21 = $row[24];
    $comp22 = $row[25];
    $comp23 = $row[26];
    $total  = $row[27];

    ?>
    <tr>
      <td><?php echo "$counter. ";?></td>
      <td><i class="icon clock outline popup" data-content="<?php echo dateToStr($datetime)?>"></i></td>
      <td style="text-align: left;"><?php echo $fullName;?></td>
      <?php
      for ($i=0; $i < 24 ; $i++) {
        $data = ${"comp".$i};
          if ($data == 3) { 
            echo "<td style=\"background-color: #88baecd1; color: white;\">$data</td>";
          }
          elseif ($data == 4) {
            echo "<td style=\"background-color: #016dd8c4; color: white;\">$data</td>";
          }
          elseif ($data == 5) {
            echo "<td style=\"background-color: #016dd8; color: white;\">$data</td>";
          }
          else {
              echo "<td>$data</td>"; 
          }
      }
      ?>
      <!-- <td style="font-weight: bold;"><?php echo $total;?></td> -->

    </tr>
    <?php

  }

 }

  $sql_none = "SELECT * FROM `department` WHERE `department_id` NOT IN (SELECT `department_id` FROM `employees` WHERE `employees_id` IN (SELECT `employees_id` FROM `competency`))";
  $result_none = $mysqli->query($sql_none);
  while ($row_none = $result_none->fetch_assoc()) {
    $department = $row_none["department"];
?>

<tr>
  <td colspan="27" style="text-align: left; padding: 5px; background-color: #4075a9; color: white;">
    <?php echo $department;?>
  </td>
</tr>
<tr>
  <td colspan="27" style="text-align: left; padding: 5px; color: grey;">
    None
  </td>
</tr>

<?php
  }
}

elseif (isset($_POST['load_positions'])) {
  $sql = "SELECT DISTINCT `position` FROM `positiontitles` ORDER BY `position` ASC";
  $result = $mysqli->query($sql);
  while ($row = $result->fetch_assoc()) {
      // $position_id = $row["position_id"];
      $position =  $row["position"];
      // $function =  $row["functional"];
?>

<div class="item" data-value="<?php echo $position; ?>"><?php echo $position; ?></div>

<?php

  }
}

elseif (isset($_POST['load_functions'])) {
  $position = $_POST['position'];
  $sql = "SELECT DISTINCT `functional` FROM `positiontitles` WHERE `position` = '$position'";
  $result = $mysqli->query($sql);
  while ($row = $result->fetch_assoc()) {
      $functional = $row["functional"];
?>

<div class="item" data-value="<?php echo $functional; ?>"><?php echo $functional; ?></div>

<?php
  }
}

elseif (isset($_POST['getResults'])) {
  $position = $_POST['position'];
  $function = $_POST['function'];

  $sql = "SELECT * FROM `positiontitles` WHERE `position` = '$position' AND `functional` = '$function'";
  $result = $mysqli->query($sql);
  $row = $result->fetch_assoc();
  $position_id = $row["position_id"];
  // echo json_encode($position_id);

  $sql = "SELECT * FROM `competency` WHERE `employees_id` IN (SELECT `employees_id` FROM `employees` WHERE `position_id` = '$position_id')";
  $result = $mysqli->query($sql);
  $counter = 0;
  $num_rows = $result->num_rows;
  if ($num_rows === 0) {
    ?>

<tr>
  <td colspan="27" style="text-align: center; color: grey; padding: 20px;">
    No results found.
  </td>
</tr>

    <?php
  }

while ($row = $result->fetch_array(MYSQLI_NUM)) {
    $counter++;
    $competency_id = $row[0];
    $employees_id = $row[1];
    if ($employees_id != 0) {

// get name start
    $sql1 = "SELECT * FROM `employees` WHERE `employees_id` = '$employees_id'";
    $result1 = $mysqli->query($sql1);

    $row1 = $result1->fetch_assoc();

    if (!empty($row1['extName'])) {
      $extName = ", ".$row1['extName'];
    } else {
      $extName = "";
    }

    $fullName = $row1['lastName'].", ".$row1['firstName']." ".$row1['middleName']." ".$extName." ";
// get name end

    } else {
      $fullName = "Unidentified! Please see input in db...";
    }


    $datetime = $row[2];
    $comp0 = $row[3];
    $comp1 = $row[4];
    $comp2 = $row[5];
    $comp3 = $row[6];
    $comp4 = $row[7];
    $comp5 = $row[8];
    $comp6 = $row[9];
    $comp7 = $row[10];
    $comp8 = $row[11];
    $comp9 = $row[12];
    $comp10 = $row[13];
    $comp11 = $row[14];
    $comp12 = $row[15];
    $comp13 = $row[16];
    $comp14 = $row[17];
    $comp15 = $row[18];
    $comp16 = $row[19];
    $comp17 = $row[20];
    $comp18 = $row[21];
    $comp19 = $row[22];
    $comp20 = $row[23];
    $comp21 = $row[24];
    $comp22 = $row[25];
    $comp23 = $row[26];
    $total  = $row[27];

    ?>
    <tr>
      <td><?php echo "$counter. ";?></td>
      <td><i class="icon clock outline popup" data-content="<?php echo dateToStr($datetime)?>"></i></td>
      <td style="text-align: left;"><?php echo $fullName;?></td>

<script type="text/javascript">
  $(document).ready(function() {
    $('.popup').popup();
  });
</script>

      <?php
      // for ($i=0; $i < 24 ; $i++) {
      //   $data = ${"comp".$i};
      //   if ($data == 3) {
      //     echo "<td style=\"background-color: #ef7ca8; color: white;\">$data</td>";
      //   }
      //   elseif ($data == 4) {
      //     echo "<td style=\"background-color: #d500ff; color: white;\">$data</td>";
      //   }
      //   elseif ($data == 5) {
      //     echo "<td style=\"background-color: #6a226f; color: white;\">$data</td>";
      //   }
      //   else {
      //     echo "<td>$data</td>"; 
      //   }

      //   ${"total".$i} += $data;

      // }
      
      for ($i=0; $i < 24 ; $i++) {
        $data = ${"comp".$i};
          if ($data == 3) { 
            echo "<td style=\"background-color: #88baecd1; color: white;\">$data</td>";
          }
          elseif ($data == 4) {
            echo "<td style=\"background-color: #016dd8c4; color: white;\">$data</td>";
          }
          elseif ($data == 5) {
            echo "<td style=\"background-color: #016dd8; color: white;\">$data</td>";
          }
          else {
              echo "<td>$data</td>"; 
          }
          ${"total".$i} += $data;
      }


      ?>
    </tr>
    <?php
  }

  if ($num_rows !== 0) {
?>
<tr style="border: 5px solid green; ">
  <td colspan="3" style="font-weight: bold; color: green;">AVERAGE</td>
<?php
  for ($i=0; $i < 24 ; $i++) {
      $average = round((${"total".$i})/$num_rows);
      // for ($i=0; $i < 24 ; $i++) {
        // $data = ${"comp".$i};
          if ($average == 3) { 
            echo "<td style=\"background-color: #88baecd1; color: black;\">$average</td>";
          }
          elseif ($average == 4) {
            echo "<td style=\"background-color: #016dd8c4; color: white;\">$average</td>";
          }
          elseif ($average == 5) {
            echo "<td style=\"background-color: #016dd8; color: white;\">$average</td>";
          }
          else {
              echo "<td>$average</td>"; 
          }
          // ${"total".$i} += $data;
      // }


?>
<!--   <td style="font-weight: bold; color: green;"><?php
    echo round((${"total".$i})/$num_rows);
    ?>
  </td> -->
<?php
  }
?>
</tr>
<?php

  }

} elseif (isset($_POST["get_rows"])) {
  $sql = "SELECT `competency_id` FROM `competency`";
  $result = $mysqli->query($sql);
  $num_rows = $result->num_rows;
  $sql2 = "SELECT * FROM `employees` wHERE `status` = 'ACTIVE' AND `employmentStatus` = 'PERMANENT'";
  $result2 = $mysqli->query($sql2);
  $num_rows2 = $result2->num_rows;
  $left = $num_rows2 - $num_rows;

  echo "$num_rows/$num_rows2 personnels have taken the survey. $left haven't.";
}

function dateToStr($numeric_date){
  $date = new DateTime($numeric_date);
  $strDate = $date->format('M. d, Y h:i:s a');
  return $strDate;
}

?>


