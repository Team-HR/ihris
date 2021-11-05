<?php
    require_once "_connect.db.php";
    $employee_id = 21236;
    $employee_id = "%".$employee_id."%";
    $sql = "SELECT `mi_id`, `cf_ID`, `mi_incharge` FROM `spms_matrixindicators` WHERE `mi_incharge` LIKE ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $matrices = [];

    while ($row = $result->fetch_assoc()) {
        $matrices [] = $row;
    }

    $employees_corefunctions = [];

    // foreach ($matrices as $key => $value) {
    //     # code...
    // }

?>
<pre>
    <?php
    print_r($matrices);
    ?>
</pre>