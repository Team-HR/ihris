<?php
 require '_connect.db.php';
$data['children'] = [];
    $sql = "SELECT `pds_children`.`child_name`,`pds_children`.`child_birthdate` FROM `pds_children` WHERE `pds_children`.`employee_id` = ?";
    // $employee_id = 2158;
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i',$employee_id);
    $stmt->execute();
 
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
    	$data['children'][] = $row;
    }

echo $result->num_rows;
echo "<pre>".print_r($data['children'],true)."</pre>";