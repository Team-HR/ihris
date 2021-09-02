<?php

require_once "libs/models/Competency.php";
require_once "competency_requests.ajax.php";
require_once "_connect.db.php";

$competency = new Competency;
$competencies = $competency->competencies;

// sample data miss Lea Aspera
$self_assessed_scores = $comp->get_self_assessed_record(1)["data"];
$sup_assessed_scores = $comp->get_sup_assessed_record(1)["data"];

// print("<pre>".print_r($self,true)."</pre>");
echo json_encode($self_assessed_scores);
echo "<br/>";

$data = $comp->gen_report($self_assessed_scores,$sup_assessed_scores);

print("<pre>".print_r($data,true)."</pre>");



