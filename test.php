<?php
require_once "_connect.db.php";
require_once "libs/PcrFinalNumericalRatingController.php";
require_once "libs/CascadePcrController.php";

$pcr_final_numerical_rating = new PcrFinalNumericalRatingController();

// echo json_encode($pcr_final_numerical_rating->getFinalNumericalRating($employee_id,1));
// echo "</br>";

$cascade_pcr = new CascadePcrController();
$data = [];

$data = $cascade_pcr->get_cascaded_pcr_report();

?>
<pre>
    <?php
    print_r($data);
    ?>
</pre>