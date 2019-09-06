
<?php
$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `subj_matter_1_rating` = '1'";
$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `subj_matter_1_rating` = '2'";
$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `subj_matter_1_rating` = '3'";
$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `subj_matter_1_rating` = '4'";
$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `subj_matter_1_rating` = '5'";

$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `subj_matter_2_rating` = '1'";
$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `subj_matter_2_rating` = '2'";
$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `subj_matter_2_rating` = '3'";
$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `subj_matter_2_rating` = '4'";
$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `subj_matter_2_rating` = '5'";

$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `subj_matter_3_rating` = '1'";
$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `subj_matter_3_rating` = '2'";
$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `subj_matter_3_rating` = '3'";
$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `subj_matter_3_rating` = '4'";
$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `subj_matter_3_rating` = '5'";

$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `subj_matter_4_rating` = '1'";
$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `subj_matter_4_rating` = '2'";
$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `subj_matter_4_rating` = '3'";
$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `subj_matter_4_rating` = '4'";
$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `subj_matter_4_rating` = '5'";
$result = $mysqli->query($sql);
echo $num_rows = $result->num_rows;
