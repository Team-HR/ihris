<?php

require "_connect.db.php";

$sql = "SELECT * FROM employees";
$result = $mysqli->query($sql);

while($row = $result->fetch_assoc())
{
    $employee_id = $row["employees_id"];
    $position_id = $row["position_id"];
    echo $employee_id."<br>";
    echo $position_id."<br>";
    appointEmployee($mysqli,$employee_id,$position_id);
}

function appointEmployee($mysqli,$employee_id,$position_id){
    if ($position_id) 
    {
        $sql = "UPDATE plantillas SET incumbent = '$employee_id' WHERE position_id = '$position_id'";
        $mysqli->query($sql);
    }
}
