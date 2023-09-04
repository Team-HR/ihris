<?php
require_once "_connect.db.php";

if (isset($_POST["load"])) {
  // auto add current year start
  $currentYear = date('Y');
  $sql = "SELECT DISTINCT `year` FROM `ldactivities` WHERE `year` = $currentYear";
  $result = $mysqli->query($sql);
  if ($result->num_rows == 0) {
    $sql_lst = "INSERT INTO `ldactivities` (`act_id`, `year`, `type`, `allocatedBudget`) VALUES (NULL, '$currentYear', 'LGU Sponsored Training', '0')";
    $sql_cdp = "INSERT INTO `ldactivities` (`act_id`, `year`, `type`, `allocatedBudget`) VALUES (NULL, '$currentYear', 'Capability Development Program', '0')";
    $mysqli->query($sql_lst);
    $mysqli->query($sql_cdp);
  }
  // auto add current year end
  $sql = "SELECT DISTINCT `year` FROM `ldactivities` ORDER BY `ldactivities`.`year` DESC";
  $result = $mysqli->query($sql);

while ($row = $result->fetch_assoc()) {
  $year = $row["year"];
      
  $sql1 = "SELECT `act_id` FROM `ldactivities` WHERE `year` = '$year' AND `type` = 'LGU Sponsored Training'";
  $result1 = $mysqli->query($sql1);
  $row1 = $result1->fetch_assoc();
  $lst_id = $row1["act_id"];

  $sql1 = "SELECT `act_id` FROM `ldactivities` WHERE `year` = '$year' AND `type` = 'Capability Development Program'";
  $result1 = $mysqli->query($sql1);
  $row1 = $result1->fetch_assoc();
  $cdp_id = $row1["act_id"];

?>
  <tr>
    <td><a href="lgusponsoredtraining.php?act_id=<?php echo $lst_id;?>" class="ui fluid mini basic button"><?php echo $year;?></a></td>
    <td><a href="capabilitydevelopmentprogram.php?act_id=<?php echo $cdp_id;?>" class="ui fluid mini basic button"><?php echo $year;?></a></td>
  </tr>
<?php
  }

}

?>