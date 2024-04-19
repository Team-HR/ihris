<?php

require_once "_connect.db.php";

if (isset($_POST["get_list_done"])) {
  $sql = "SELECT * FROM `pds_personal` LEFT JOIN `employees` ON `pds_personal`.`employee_id` = `employees`.`employees_id` LEFT JOIN `department` ON `employees`.`department_id` = `department`.`department_id` WHERE `pds_personal`.`birthdate` != '' AND `pds_personal`.`blood_type` != '' AND `pds_personal`.`res_city` != '';
  ";
  $res = $mysqli->query($sql);
  $data = [];

  while ($row = $res->fetch_assoc()) {
    $data[] = $row;
  }

  echo json_encode($data);
}
