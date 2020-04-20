<?php
require '_connect.db.php';

$data = array();
$sql = <<<SQL

    SELECT
        employees.employees_id,
        UPPER(CONCAT( employees.lastName, ', ', employees.firstName, ' ', employees.middleName, ' ', employees.extName )) AS fullName,
        CONCAT_WS(', ',prr.period, prr.year) AS period,
        prr.type,
        prrlist.comments 
    FROM
        employees
    LEFT JOIN prrlist ON employees.employees_id = prrlist.employees_id
    LEFT JOIN prr ON prrlist.prr_id = prr.prr_id
    WHERE
        employees.`status` = 'ACTIVE' 
        -- AND prrlist.comments <> '' 
    ORDER BY
        employees.lastName ASC,
        prr.period DESC

SQL;

$result = $mysqli->query($sql);
$id0 = 'id_0';
while($row = $result->fetch_assoc()){
    $id = $row['employees_id'];
    $prr = [
        'period' => $row['period'],
        'type' => $row['type'],
        'comments' => $row['comments']
    ];

    if (!array_key_exists('id_'.$id,$data)){
        $data['id_'.$id] = [
        'id' => $id,
        'fullName' => $row['fullName'],
        'prr' => [$prr]
        ];
    } else $data['id_'.$id]['prr'][] = $prr;
}

print("<pre>".print_r($data,true)."</pre>");
