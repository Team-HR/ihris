<?php
require "_connect.db.php";
$sql = "SELECT *FROM casual_plantillas_lists LEFT JOIN employees ON casual_plantillas_lists.employee_id=employees.employees_id LEFT JOIN positiontitles ON employees.position_id=positiontitles.position_id  WHERE plantilla_id = 22  ORDER BY lastName, firstName ASC";
$stmt = $mysqli->prepare($sql);
// $stmt->bind_param('i', $plantilla_id);
$stmt->execute();
$result = $stmt->get_result();
$data = array();
while ($row = $result->fetch_assoc()) {
    $row["first_name"] = $row["firstName"];
    $row["last_name"] = $row["lastName"];
    $row["middle_name"] = $row["middleName"];
    $row["ext_name"] = $row["extName"];
    $row["position_title"] = $row["position"];
    $row["sg"] = $row["pay_grade"];
    $row["employment_status"] = $row["employmentStatus"];
    $row["nature_of_appointment"] = $row["nature"];
    $data[] = $row;
}

echo str_pad(cal_days_in_month(CAL_GREGORIAN, 12, 2020), 2, "0", STR_PAD_LEFT);
echo "<pre>".print_r($data,true)."</pre>";