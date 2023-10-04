<?php
require_once "_connect.db.php";
require_once "libs/NameFormatter.php";
require_once "libs/PcrClass.php";
require_once "libs/Pcr.php";
require_once "libs/PcrTableClass.php";

$period_id = $_GET["period_id"];
$employees_id = $_GET["employees_id"];

$employee_data =  new Employee_data;
// $pcr_table = new PcrTableClass(true);

$employee_data->set_emp($employees_id);
$employee_data->set_period($period_id);

// echo $employee_data->get_coreView();

// $employee_data->load();
$data = [];

#get spms_performancereviewstatus data
// $data["spms_performancereviewstatus"] = get_spms_performancereviewstatus($mysqli, $period_id, $employees_id);

#get employee employement information
// $data["employee"] = get_employee_info($mysqli, $employees_id);

// echo json_encode($data);
// $json2 = json_encode($employee_data->coreRow(), JSON_PRETTY_PRINT);
// echo "<pre>" . $json2 . "<pre/>";





$view = "";
$table = new PcrTableClass($employee_data->hideCol);
$table->formType($employee_data->get_status('formType'));

$employee_data->hideNextBtn();
$rows = $employee_data->get_strategicView() . $employee_data->get_coreView() . $employee_data->get_supportView();
$table->set_head($employee_data->tableHeader());
$table->set_body($rows);
$table->set_foot($employee_data->tableFooter() . "<br class='noprint'>" . $employee_data->get_approveBTN());
$view = $table->_get();
// if ($employee_data->core_countTotal > 0) {
// 	$step->set_disable($employee_data->hideCol);
// 	echo $step->_get();
// 	// json_encode($employee_data->update_prrlist()) .
echo $view;


// }





?>
<!-- <table> -->

<!-- tableHeader
get_strategicView
get_coreView
tableFooter -->
<!-- </table> -->

<?php
// echo $employee_data->get_strategicView();
function get_spms_performancereviewstatus($mysqli, $period_id, $employees_id)
{
  $sql = "SELECT * FROM `spms_performancereviewstatus` where `employees_id` = '$employees_id' AND `period_id` = '$period_id'";
  $res = $mysqli->query($sql);
  $row = $res->fetch_assoc();
  $formTypeName = "";
  $formType = $row["formType"];

  if ($formType == 1) {
    $formTypeName = "INDIVIDUAL PERFORMANCE COMMITMENT AND REVIEW (IPCR)";
  } else if ($formType == 2) {
    $formTypeName = "SECTION PERFORMANCE COMMITMENT AND REVIEW (SPCR)";
  } else if ($formType == 3) {
    $formTypeName = "DEPARTMENT PERFORMANCE COMMITMENT AND REVIEW (DPCR)";
  } else if ($formType == 4) {
    $formTypeName = "DIVISION SECTION PERFORMANCE COMMITMENT AND REVIEW (DIVISION SPCR)";
  }
  $row["formTypeName"] = $formTypeName;

  $row["supervisor"] = get_employee_info($mysqli, $row["ImmediateSup"]);
  $row["department_head"] = get_employee_info($mysqli, $row["DepartmentHead"]);


  return $row;
}


function get_employee_info($mysqli, $employees_id)
{
  $sql = "SELECT * FROM `employees` where `employees_id` = '$employees_id'";
  $res = $mysqli->query($sql);
  $row = $res->fetch_assoc();

  $firstName  = $row["firstName"];
  $lastName = $row["lastName"];
  $middleName = $row["middleName"];
  $extName = $row["extName"];

  $employee_name = new NameFormatter($firstName, $lastName, $middleName, $extName);
  $row["full_name"] = $employee_name->getFullNameStandardUpper();
  $row["position"] = get_postiion($mysqli, $row["position_id"]);
  $row["department"] = get_department($mysqli, $row["department_id"]);
  return $row;
}

function get_department($mysqli, $department_id)
{
  $sql = "SELECT * FROM `department` WHERE `department_id` = '$department_id'";
  $res = $mysqli->query($sql);
  $row = $res->fetch_assoc();
  return $row;
}

function get_postiion($mysqli, $position_id)
{
  $sql = "SELECT * FROM `positiontitles` WHERE `position_id` = '$position_id'";
  $res = $mysqli->query($sql);
  $row = $res->fetch_assoc();
  return $row;
}
