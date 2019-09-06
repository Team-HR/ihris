<?php
// $title = "Testing";
require '_connect.db.php';
$sql = "SELECT * FROM `employees` WHERE `employees`.`employees_id`IN (SELECT `employees_id` FROM `individualassreport`) AND `employees`.`employees_id` NOT IN (SELECT `employees_id` FROM `competency`) ORDER BY `lastName` ASC
";

$result = $mysqli->query($sql);
while ($row = $result->fetch_assoc()) {
    $employees_id = $row['employees_id'];
    if ($employees_id != 0) {
// get name start
      if (!empty($row['extName'])) {
        $extName = ", ".$row['extName'];
      } else {
        $extName = "";
      }

      $fullName = $row['lastName'].", ".$row['firstName']." ".$row['middleName']." ".$extName." ";

    } else {
      $fullName = "Unidentified! Please see input in db...";
    }

    echo "$fullName<br>";

}
