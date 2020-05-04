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

// $sql = <<< SQL
// SELECT
// 	COUNT(personneltrainings_id) AS num_trainings,
// -- 	startDate,
// 	MONTH(startDate) AS month,
// 	YEAR(startDate) AS year
// FROM
// 	personneltrainings
// GROUP BY
// 	MONTH(startDate)
// ORDER BY
// -- MONTH(startDate) ASC,	
// YEAR(startDate) ASC
// SQL;

// $data = [];
// $res = $mysqli->query($sql);

// while ($row = $res->fetch_assoc()) {
// 	$year = $row['year'];
// 	$months = [
// 		'month' => $row['month'],
// 		'num_trainings' => $row['num_trainings']
// 	];

// 	if (!array_key_exists('year_'.$year, $data)) {
// 		$data['year_'.$year] = [
// 			'year'	=> $year,
// 			'months' => [
// 				$months['month'] => $months
// 			]
// 		];
// 	} else $data['year_'.$year]['months'][$months['month']] = $months;
// }

// echo json_encode($data);
// print("<pre>".print_r($data,true)."</pre>");

// $data = [];
// $sql = <<<SQL
// SELECT `competency`.*,`employees`.*,`positiontitles`.* FROM `competency` LEFT JOIN `employees` ON `competency`.`employees_id` = `employees`.`employees_id` LEFT JOIN `positiontitles` ON `employees`.`position_id` = `positiontitles`.`position_id`
// WHERE
// `category` = 'Administrative'
// AND
// `gender` = 'FEMALE'
// SQL;
// $filter = "";
$filter = <<<SQL
WHERE
`category` = 'Administrative' AND
`gender` = 'FEMALE'
SQL;
// $filter = "";+

echo "Filter: ".($filter?$filter:'N/A')."<br>";
$sql = <<<SQL
SELECT 
ROUND(AVG(`competency`.`Adaptability`)) 'adaptability',
ROUND(AVG(`competency`.`ContinousLearning`)) 'continuous_learning',
ROUND(AVG(`competency`.`Communication`)) 'communication',
ROUND(AVG(`competency`.`OrganizationalAwareness`)) 'organizational_awareness',
ROUND(AVG(`competency`.`CreativeThinking`)) 'creative_thinking',
ROUND(AVG(`competency`.`NetworkingRelationshipBuilding`)) 'networking_relationship_building',
ROUND(AVG(`competency`.`ConflictManagement`)) 'conflict_management',
ROUND(AVG(`competency`.`StewardshipofResources`)) 'stewardship_of_resources',
ROUND(AVG(`competency`.`RiskManagement`)) 'risk_management',
ROUND(AVG(`competency`.`StressManagement`)) 'stress_management',
ROUND(AVG(`competency`.`Influence`)) 'influence',
ROUND(AVG(`competency`.`Initiative`)) 'initiative',
ROUND(AVG(`competency`.`TeamLeadership`)) 'team_leadership',
ROUND(AVG(`competency`.`ChangeLeadership`)) 'change_leadership',
ROUND(AVG(`competency`.`ClientFocus`)) 'client_focus',
ROUND(AVG(`competency`.`Partnering`)) 'partnering',
ROUND(AVG(`competency`.`DevelopingOthers`)) 'developing_others',
ROUND(AVG(`competency`.`PlanningandOrganizing`)) 'planning_and_organizing',
ROUND(AVG(`competency`.`DecisionMaking`)) 'decision_making',
ROUND(AVG(`competency`.`AnalyticalThinking`)) 'analytical_thinking',
ROUND(AVG(`competency`.`ResultsOrientation`)) 'results_orientation',
ROUND(AVG(`competency`.`Teamwork`)) 'teamwork',
ROUND(AVG(`competency`.`ValuesandEthics`)) 'values_and_ethics',
ROUND(AVG(`competency`.`VisioningandStrategicDirection`)) 'visioning_and_strategic_direction'
FROM
`competency`
LEFT JOIN `employees` ON `competency`.`employees_id` = `employees`.`employees_id` LEFT JOIN `positiontitles` ON `employees`.`position_id` = `positiontitles`.`position_id`
$filter
SQL;

$result = $mysqli->query($sql);
$data = $result->fetch_assoc();

$data = [];
$filters = [
    'category' => ['Key Position', 'Administrative', 'Technical'],
    'level' => [1,2,3],
    'nature_of_assignment' => ['RANK & FILE', 'SUPERVISORY'],
    'gender' => ['MALE','FEMALE']
];


$indeces = [];
$wheres = [];
$where = "WHERE";
$_i = 0;
foreach ($filters as $cat => $filter) {
    $_i++;
    $where .= " `".$cat."` = '".$filter[0]."'".($_i!==count($filters)?" AND":"");
}
echo $where;

print("<pre>".print_r($wheres,true)."</pre>");