<?php
    require_once "_connect.db.php";
    $emp_id = $_GET["employees_id"];
    $sql = "SELECT * from `lm_logs` left join `employees` on `lm_logs`.`employees_id`=`employees`.`employees_id`
                                    left join `department` on `employees`.`department_id`=`department`.`department_id`
                                    left join `positiontitles` on `employees`.`position_id`=`positiontitles`.`position_id`
                                    where `lm_logs`.`employees_id` = '$emp_id'
                                      ";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $employees_id = $row["employees_id"];
    $fullName =$row['firstName']." ".$row['middleName']."".$row['lastName']." ".$row['extName'];   
    $department =$row["department"];  
    $position =$row["position"];   
    $firstDay =$row["dateActivated"]; 
    $filed =$row["dateApplied"]; 
    $leave =$row["leaveType"]; 
    $sp =$row["sp_type"]; 
    $total =$row["totalDays"];

?> 




