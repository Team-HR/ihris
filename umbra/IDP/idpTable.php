<?php
$dataId  = $_GET["employees_id"];
$sql = "SELECT * FROM `prrlist` LEFT JOIN `prr` on `prrList`.`prr_id` = `prr`.`prr_id` where `prrList`.`employees_id`='$dataId' ORDER BY `prr`.`year` DESC";
$sql = $mysqli->query($sql);
echo $mysqli->error;
$view = "";
while($row = $sql->fetch_assoc()){
  $view .="
  <tr>
  <td>$row[year]</td>
  <td>$row[period]</td>
  <td>$row[numerical]</td>
  <td>$row[adjectival]</td>
  <td>$row[comments]</td>
  </tr>
  ";
}
?>
<table class="ui celled table" style="text-align:center">
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
    <?=$view?>
  </tbody>
</table>
