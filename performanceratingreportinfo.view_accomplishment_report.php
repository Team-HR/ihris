<?php
require_once "_connect.db.php";
require_once "libs/PcrClass.php";
require_once "libs/PcrTableClass.php";

$period_id = $_GET["period_id"];
$employees_id = $_GET["employees_id"];

$pcr =  new Pcr($mysqli);

$pcr->set_emp($employees_id);
$pcr->set_period($period_id);
$pcr->load();

$view = "";
$table = new PcrTableClass($pcr->hideCol);
$table->formType($pcr->get_status('formType'));

$pcr->hideNextBtn();

$rows = $pcr->get_strategicView() . $pcr->get_coreView() . $pcr->get_supportView();

$table->set_head($pcr->tableHeader());
$table->set_body($rows);
$table->set_foot($pcr->tableFooter() . "<br class='noprint'>" . $pcr->get_approveBTN());
$view = $table->_get();

echo $view;
