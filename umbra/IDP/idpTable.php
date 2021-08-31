<?php
$dataId  = $_GET["employees_id"];
$sql = "SELECT * FROM `prrlist` LEFT JOIN `prr` on `prrlist`.`prr_id` = `prr`.`prr_id` where `prrlist`.`employees_id`='$dataId' ORDER BY `prr`.`year` DESC";
$sql = $mysqli->query($sql);
echo $mysqli->error;
$view = "";
if ($sql->num_rows) {
  while ($row = $sql->fetch_assoc()) {
    $view .= "
  <tr>
  <td>$row[year]</td>
  <td>$row[period]</td>
  <td>$row[numerical]</td>
  <td>$row[adjectival]</td>
  <td>$row[comments]</td>
  </tr>
  ";
  }
} else {
  $tableRow .= "
      <tr>
        <td colspan='3' style='color:grey; text-align: center;'>No Data</td>
      </tr>
    ";
}
?>
<table class="ui very basic celled table compact" style="text-align:center">
  <thead>
    <tr>
      <th>Year</th>
      <th>Period</th>
      <th>Numerical Rating</th>
      <th>Adjectival Rating</th>
      <th>Comments</th>
    </tr>
  </thead>
  <tbody>
    <?= $view ?>
  </tbody>
</table>