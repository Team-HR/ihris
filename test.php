<?php
require "_connect.db.php";

$sql = "SELECT
-- *
positiontitles.position,
positiontitles.functional,
plantillas.item_no,
positiontitles.salaryGrade AS salary_grade,
plantillas.step,
plantillas.`schedule`,
'' AS monthly_salary,
-- 	plantillas.actual_salary,
-- ( plantillas.actual_salary / 12 ) AS monthly_salary,
qualification_standards.education,
qualification_standards.experience,
qualification_standards.training,
qualification_standards.eligibility,
qualification_standards.competency,
qualification_standards.others,
department.department 
FROM
	plantillas
	LEFT JOIN positiontitles ON plantillas.position_id = positiontitles.position_id
	LEFT JOIN qualification_standards ON qualification_standards.position_id = positiontitles.position_id
	LEFT JOIN department ON plantillas.department_id = department.department_id 
WHERE
`plantillas`.`id` IN (SELECT `publications`.`plantilla_id` FROM publications)
AND	plantillas.incumbent IS NULL 
	AND plantillas.abolish IS NULL
ORDER BY
    positiontitles.position ASC";
$stmt = $mysqli->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$data = array();

while ($row = $result->fetch_assoc()) {
    $row["monthly_salary"] = getMonthlySalary($mysqli,$row["salary_grade"],$row["step"],$row["schedule"]);
    $data [] = $row;
}

print("<pre>".print_r($data,true)."</pre>");
// $sg = 10;
// $step = 5;
// $schedule = 1;
// $monthly_salary = getMonthlySalary($mysqli,$sg,$step,$schedule);

// echo $monthly_salary;

function getMonthlySalary($mysqli,$sg,$step,$schedule) {
    $monthly_salary = 0;
    if(empty($sg) || empty($step) || empty($schedule)) return false;
    $sql = "SELECT id FROM `ihris_dev`.`setup_salary_adjustments` WHERE schedule = ? AND active = '1'";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i',$schedule);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $parent_id = 0;
    $parent_id = $row["id"];
    $stmt->close();
    if (empty($parent_id)) return false;
    $sql = "SELECT monthly_salary FROM `ihris_dev`.`setup_salary_adjustments_setup` WHERE parent_id = ? AND salary_grade = ? AND step_no = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('iii',$parent_id,$sg,$step);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();  
    $monthly_salary = $row["monthly_salary"];
    return $monthly_salary?number_format($monthly_salary,2,'.',','):"NOT FOUND";
}