<?php
$empId = $_GET['employees_id'];
$sql = "SELECT * FROM `cmremp` right join `cmrempdata` on `cmremp`.`cmrEmp_id`=`cmrempdata`.`cmremp_id` where `emp_id`= '$empId'  ORDER BY `cmrempdata`.`date` DESC";
$sql = $mysqli->query($sql);
echo $mysqli->error;
$tableRow = "";
if ($sql->num_rows) {
  while ($cath = $sql->fetch_assoc()) {
    $tableRow.= "
      <tr>
        <td>$cath[date]</td>
        <td>$cath[content]</td>
        <td>$cath[note]</td>
      </tr>
    ";
  }
} else {
  $tableRow.= "
      <tr>
        <td colspan='3' style='color:grey; text-align: center;'>No Data</td>
      </tr>
    ";
}
?>
<table class="ui very basic celled table compact">
  <thead>
    <tr>
      <th style="width:100px">Date</th>
      <th>Content/Highlight</th>
      <th>Note/Comments</th>
    </tr>
  </thead>
  <tbody>
      <?=$tableRow?>
  </tbody>
</table>
