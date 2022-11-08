<?php
require_once "_connect.db.php";
require_once "./libs/config_class.php";
$user = new Employee_data();
$user->set_emp(21615);
$user->set_period(2);

$strategic_function_rating = 0;
if ($user->fileStatus['formType'] != "3") {
    $strategic_function_rating = $user->strategic_totalAv;
}

$data = [
    $user->strategic_totalAv,
    $user->core_totalAv,
    $user->support_totalAv
];

$final_numerical_rating = 0;
foreach ($data as  $value) {
    $final_numerical_rating +=  $value;
}

echo $final_numerical_rating;

echo "<pre>";
print_r($data);
echo "</pre> <br/>";
// echo $data = $pms->get_numerical_rating();
