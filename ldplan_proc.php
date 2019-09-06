<?php

if (isset($_POST["load"])) {
  check();
}


function check(){
  require "_connect.db.php";

  $sql = "SELECT DISTINCT `year` FROM `ldplan` ORDER BY `year` DESC";
  $result = $mysqli->query($sql);

  $currentYear = date('Y');

  // if none, create entry automatically
  if ($result->num_rows == 0) {
    $year = $currentYear."-".($currentYear+2);
    addNew($year);
  } else {

  $counter= 0;
  // check if year is already included in db
  while ($row = $result->fetch_assoc()) {
  
  $year = $row["year"];
  $years = explode("-", $year);
  $years[2] = $years[1];
  $years[1] = $years[0]+1;

    if (in_array($currentYear, $years)) {
      $counter++;
    }
        
  }

  if ($counter < 1) {
    $year = $currentYear."-".($currentYear+2);
    addNew($year);
  }
}
  load();
}

function addNew($year){
  require "_connect.db.php";
  $sql1 = "INSERT INTO `ldplan` (`ldplan_id`, `type`, `year`) VALUES (NULL, 'IN-HOUSE TRAININGS', '$year')";
  $sql2 = "INSERT INTO `ldplan` (`ldplan_id`, `type`, `year`) VALUES (NULL, 'LGU SPONSORED TRAININGS', '$year')";

  $mysqli->query($sql1);
  $mysqli->query($sql2);
}

function load(){
  require "_connect.db.php";
  $sql = "SELECT DISTINCT `year` FROM `ldplan` ORDER BY `year` DESC";
  $result = $mysqli->query($sql);

  while ($row = $result->fetch_assoc()) {
    $year = $row["year"];

    $sql1 = "SELECT `ldplan_id` FROM `ldplan` WHERE `year` = '$year' AND `type` = 'IN-HOUSE TRAININGS'";
    $result1 = $mysqli->query($sql1);
    $row1 = $result1->fetch_assoc();
    $type0 = $row1["ldplan_id"];

    $sql1 = "SELECT `ldplan_id` FROM `ldplan` WHERE `year` = '$year' AND `type` = 'LGU SPONSORED TRAININGS'";
    $result1 = $mysqli->query($sql1);
    $row1 = $result1->fetch_assoc();
    $type1 = $row1["ldplan_id"];

?>
<tr>
  <td>
    <a href="ldplaninhouse.php?ldplan_id=<?php echo $type0;?>" class="ui fluid basic button"><?php echo $year;?></a>
  </td>
  <td>
    <a href="ldplanlgusponsored.php?ldplan_id=<?php echo $type1;?>" class="ui fluid basic button"><?php echo $year;?></a>
  </td>
</tr>
<?php

  }

}

?>
