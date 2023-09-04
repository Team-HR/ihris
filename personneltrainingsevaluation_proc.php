<?php
require_once "_connect.db.php";

if (isset($_POST["addEntry"])) {
	$value = $_POST["value"];
	$sqlValues = "";

	foreach ($value as $itemScore) {
		$sqlValues .= " ,'".addslashes($itemScore)."'";
	}

	$personneltrainings_id = $_POST["personneltrainings_id"];
	$dateTimeAdded = date('Y-m-d H:m:s');
	$sql = "INSERT INTO `personneltrainingseval` (`personneltrainings_id`, `dateTimeAdded`, `subj_matter_1_rating`, `subj_matter_2_rating`, `subj_matter_3_rating`, `subj_matter_4_rating`, `subj_matter_comment`, `presentation_1_rating`, `presentation_2_rating`, `presentation_3_rating`, `presentation_4_rating`, `presentation_5_rating`, `presentation_comment`, `resource_pip_1_rating`, `resource_pip_2_rating`, `resource_pip_3_rating`, `resource_pip_4_rating`, `resource_pip_5_rating`, `resource_pip_comment`, `administrative_1_rating`, `administrative_2_rating`, `administrative_3_rating`, `administrative_4_rating`, `administrative_comment`, `overall_ass_1`, `overall_ass_2`, `overall_ass_3`, `overall_ass_4`, `overall_ass_5`, `assessment_1`, `assessment_2`, `assessment_3`, `assessment_4`, `assessment_5`) VALUES ('$personneltrainings_id', '$dateTimeAdded'".$sqlValues.")";
	}

	$mysqli->query($sql);
?>