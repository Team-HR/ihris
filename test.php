<?php
require_once "_connect.db.php";

$sql = "SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS  
WHERE TABLE_NAME = 'spms_performancereviewstatus'";

$result = $mysqli->query($sql);
$data = [];
while ($row = $result->fetch_assoc()) {
    $data [] = $row['column_name'];
}
// var_dump($data);
?>
<pre>
    <?php
        print_r($data);
    ?>
</pre>
