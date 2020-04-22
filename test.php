<?php
require_once '_connect.db.php';
// $data = array();
// $sql = <<<SQL

//     SELECT
//         employees.employees_id,
//         UPPER(CONCAT( employees.lastName, ', ', employees.firstName, ' ', employees.middleName, ' ', employees.extName )) AS fullName,
//         CONCAT_WS(', ',prr.period, prr.year) AS period,
//         prr.type,
//         prrlist.comments 
//     FROM
//         employees
//     LEFT JOIN prrlist ON employees.employees_id = prrlist.employees_id
//     LEFT JOIN prr ON prrlist.prr_id = prr.prr_id
//     WHERE
//         employees.`status` = 'ACTIVE' 
//         -- AND prrlist.comments <> '' 
//     ORDER BY
//         employees.lastName ASC,
//         prr.period DESC

// SQL;

// $result = $mysqli->query($sql);
// while($row = $result->fetch_assoc()){
//     $id = $row['employees_id'];
//     $prr = [
//         'period' => $row['period'],
//         'type' => $row['type'],
//         'comments' => $row['comments']
//     ];

//     if (!array_key_exists('id_'.$id,$data)){
//         $data['id_'.$id] = [
//         'id' => $id,
//         'fullName' => $row['fullName'],
//         'prr' => [$prr]
//         ];
//     } else $data['id_'.$id]['prr'][] = $prr;
// }

// print("<pre>".print_r($data,true)."</pre>");

$sql = <<< SQL
SELECT
	COUNT(personneltrainings_id) AS num_trainings,
-- 	startDate,
	MONTH(startDate) AS month,
	YEAR(startDate) AS year
FROM
	personneltrainings
GROUP BY
	MONTH(startDate)
ORDER BY
-- MONTH(startDate) ASC,	
YEAR(startDate) ASC
SQL;

$data = [];
$res = $mysqli->query($sql);

while ($row = $res->fetch_assoc()) {
	$year = $row['year'];
	$months = [
		'month' => $row['month'],
		'num_trainings' => $row['num_trainings']
	];

	if (!array_key_exists('year_'.$year, $data)) {
		$data['year_'.$year] = [
			'year'	=> $year,
			'months' => [
				$months['month'] => $months
			]
		];
	} else $data['year_'.$year]['months'][$months['month']] = $months;
}

echo json_encode($data);
// print("<pre>".print_r($data,true)."</pre>");


