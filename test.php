<?php
require_once "_connect.db.php";
$sql = "SELECT `rspcomp_id`, `rsp_comparative`.`applicant_id`, `name`,`age`,`gender`,`num_years_in_gov`,`civil_status`,`education`,`training`,`experience`,`eligibility`,`awards`,`records_infractions` FROM `rsp_applicants` LEFT JOIN `rsp_comparative`ON `rsp_comparative`.`applicant_id` = `rsp_applicants`.`applicant_id` WHERE `rspvac_id` = '74'";
$result = $mysqli->query($sql);
$data = [];
while ($row = $result->fetch_assoc()) {

    $experience = unserialize($row['experience']);
    usort($experience, function ($item1, $item2) {
        return $item2[3] <=> $item1[3];
    });
    $data[] = $experience;
}

echo "<pre>" . print_r($data, true) . "</pre>";
