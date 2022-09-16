<?php
require_once "header.php";
$sql = "SELECT `applicant_id`,`num_years_in_gov` FROM `rsp_applicants`;";

$res = $mysqli->query($sql);
$data = [];
while ($row = $res->fetch_assoc()) {
    $arr = unserialize($row['num_years_in_gov']);
    // array_unshift($arr, );
    $priv = ["Private" => ""];
    $arr = $priv + $arr;
    $data[] = [
        "applicant_id" => $row["applicant_id"],
        "num_years_in_gov" => serialize($arr)
    ];
}

foreach ($data as $key => $row) {
    $mysqli->query("UPDATE `rsp_applicants` SET `num_years_in_gov` = '$row[num_years_in_gov]' WHERE `rsp_applicants`.`applicant_id` = $row[applicant_id];");
}


?>
<pre>
    <?php
    print_r($data);
    ?>
</pre>