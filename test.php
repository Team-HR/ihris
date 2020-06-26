<?php
require "_connect.db.php";
$department_id = "1";
$year = "all";

$permanent = array(
    get_num($mysqli,$department_id,"PERMANENT","MALE",$year,true),
    get_num($mysqli,$department_id,"PERMANENT","FEMALE",$year,true),
    get_num($mysqli,$department_id,"PERMANENT","MALE",$year,false),
    get_num($mysqli,$department_id,"PERMANENT","FEMALE",$year,false)
);

$casual = array(
    get_num($mysqli,$department_id,"CASUAL","MALE",$year,true),
    get_num($mysqli,$department_id,"CASUAL","FEMALE",$year,true),
    get_num($mysqli,$department_id,"CASUAL","MALE",$year,false),
    get_num($mysqli,$department_id,"CASUAL","FEMALE",$year,false)
);

echo json_encode(array($permanent, $casual));
// echo json_encode($data);
// print("<pre>".print_r($data,true)."</pre>");

function get_num($mysqli,$id,$stat,$gen,$year,$bool){
	if ($id !== "all") {
		$filterByDept = "department_id = '$id' AND";
	} else {
		$filterByDept = "";
	}
	if ($year !== "all") {
		$filterByYear = "WHERE year(startDate) = '$year'";
        $filterByYear2 = "AND year(fromDate) = '$year'";
        $filterByYear3 = "YEAR(date_conducted) = '$year' AND";
	} else {
		$filterByYear = "";
		$filterByYear2 = "";
        $filterByYear3 = "";
	}
	// if ($bool == true) {
	// 	$in = "IN";
	// } else {
	// 	$in = "NOT IN";
	// }

	$sql = "SELECT * FROM `employees` WHERE $filterByDept employmentStatus = '$stat' AND gender = '$gen' AND `status` = 'ACTIVE'";
    $total = 0;
    $result = $mysqli->query($sql);
    $total = $result->num_rows;

    $sql = "SELECT * FROM `employees` WHERE $filterByDept employmentStatus = '$stat' AND gender = '$gen' AND `status` = 'ACTIVE' AND employees_id IN (SELECT `employees_id` FROM `personneltrainingslist` WHERE `personneltrainings_id` IN (SELECT `personneltrainings_id` FROM `personneltrainings` $filterByYear))
	UNION
	SELECT * FROM `employees` WHERE $filterByDept employmentStatus = '$stat' AND gender = '$gen' AND `status` = 'ACTIVE' AND employees_id IN (SELECT `employees_id` FROM `requestandcomslist` WHERE `controlNumber` IN (SELECT `controlNumber` FROM `requestandcoms` WHERE `isMeeting` != 'yes' $filterByYear2))
    UNION
    SELECT * FROM `employees` WHERE $filterByDept employmentStatus = '$stat' AND gender = '$gen' AND `status` = 'ACTIVE' AND employees_id IN (SELECT feedbacking_emp AS employees_id FROM `ihris_dev`.`spms_feedbacking` WHERE $filterByYear3 date_conducted <> '0000-00-00' OR date_conducted <> NULL)
    ";
    
    $in = 0;
    $result = $mysqli->query($sql);
	$in = $result->num_rows;
    
    $notIn = $total>$in?($total-$in):$in;

	return $bool?$in:$notIn;

}