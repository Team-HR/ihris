<?php
require_once "_connect.db.php";
require_once "libs/PcrFinalNumericalRatingController.php";
require_once "libs/CascadePcrController.php";

$pcr_final_numerical_rating = new PcrFinalNumericalRatingController();

// echo json_encode($pcr_final_numerical_rating->getFinalNumericalRating($employee_id,1));
// echo "</br>";

$cascade_pcr = new CascadePcrController();
// $data = [];

$department_id = isset($_GET["department_id"])?$_GET["department_id"]:null;

$cascade_pcr->set_period_id(1);
$data = $cascade_pcr->get_cascaded_pcr_report($department_id);



// $employee_id = 31350;
// $data = $pcr_final_numerical_rating->get_final_numerical_rating($employee_id,1);

?>
<br>
<pre>
    <?php
    print_r($data);
    ?>
</pre>