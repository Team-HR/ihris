<?php

//	Apache/2.4.39 (Win64) OpenSSL/1.0.2s PHP/7.1.31
//	DevelopmentYear 2019 -
//	@Author
//	** pascual Tomulto
// 	** message me @https://www.facebook.com/pascual.tomulto.54
//  ** messageCode "PCR Help"
//	heart the program miss with it carefully
//	to the next programmer
//  your better then I am ; I know nothing
//  we only need logic That is our power
//	great achievements start from useless ideas  " God Bless "
//	crazy is what we are
// date_default_timezone_set("Asia/Manila");
// $host = "localhost";
// $usernameDb = "admin";
// // $password = "teamhrmo2019";
// $password = "teamhrmo2019";
// $database = "ihris";
// $mysqli = new mysqli($host, $usernameDb, $password, $database);
// $mysqli->set_charset("utf8");
class Employee_data
{
	public $accountStatus;
	private $rsmStatus;
	private $emp_ID;
	private $per_ID;
	private $coreData;
	private $period;
	private $EmpInfo;
	public $hide;
	public $hideCol;
	public $fileStatus;
	public $budgetView;
	public $accountableView;
	public $authorization;
	private $percent;
	private $supportPercent;
	private $strtPercent;

	// properties made for core function

	public $core_countEmpty;
	public $core_countTotal;
	public $core_totalAv;
	private $coreView;

	// properties made for support function

	private $supportView;
	public $support_countEmpty;
	public $support_totalAv;

	// properties made for strategic function

	private $strategicView;
	private $strtBtn;
	public $strategic_totalAv;
	public $strategic_count;

	//properties for the comment

	private $commentData;
	private $comment;
	public $commentCount;

	//signatories

	private $signa_form;
	public $signatoriesCount;

	// pmt 

	private $pmt = false;
	private $mysqli;

	// method for my objects

	function __construct($mysqli)
	{
		$this->mysqli = $mysqli;
	}
	private function load()
	{
		$this->file_status();
		// $this->comment();
		// $this->signatories();
		$this->coreRow();
		$this->supportFunctionTr();
		$this->strategicTr();
	}
	public function set_hide($h)
	{
		$this->hide = $h;
		$this->load();
	}
	public function set_emp($emp)
	{
		$this->emp_ID = $emp;
		// getting all the data of the employee
		$sql = "SELECT * from employees
		left join department on employees.department_id=department.department_id
		left join positiontitles on employees.position_id=positiontitles.position_id
		where employees_id='$this->emp_ID'";
		$sql = $this->mysqli->query($sql);
		if (!$sql) {
			die($this->error);
		}
		$this->EmpInfo = $sql->fetch_assoc();
		$authSql = "SELECT * FROM `spms_accounts` where employees_id='$this->emp_ID'";
		$authSql = $this->mysqli->query($authSql);
		$authSql = $authSql->fetch_assoc();
		if ($authSql['type'] == "") {
			$this->authorization = "";
		} else {
			$this->authorization = explode(',', $authSql['type']);
		}
	}

	public function set_period($per)
	{
		$this->per_ID = $per;
		//retriving all the data of period
		$sql = "SELECT  * from spms_mfo_period where mfoperiod_id='$this->per_ID'";
		$sql = $this->mysqli->query($sql);
		if (!$sql) {
			die($this->error);
		}
		$this->period = $sql->fetch_assoc();
		$this->load();
	}
	public function set_periodMY($m, $y)
	{
		//retriving all the data of period
		$sql = "SELECT  * from spms_mfo_period where month_mfo='$m' and year_mfo='$y'";
		$sql = $this->mysqli->query($sql);
		if (!$sql) {
			die($this->error);
		}
		$data = $sql->fetch_assoc();
		$this->per_ID = $data['mfoperiod_id'];
		$this->period = $data;
		$this->coreData = $this->coreAr();
		$this->load();
	}

	private function get_percent()
	{
		return $this->percent;
	}

	private function get_supportPercent()
	{
		return $this->supportPercent;
	}

	private function get_strtPercent()
	{
		$dat = $this->strtPercent;
		if ($dat == "20") {
			$dat .= "%";
		}
		return $dat;
	}

	public function get_emp($i)
	{
		$emp = $this->EmpInfo;
		return $emp[$i];
	}
	public function get_period($i)
	{
		$per = $this->period;
		return $per[$i];
	}
	private function get_fullname($id)
	{
		if (!is_numeric($id)) {
			return $id;
		}
		$sql = "SELECT * from employees where employees_id='$id'";
		$sql = $this->mysqli->query($sql);
		$sql = $sql->fetch_assoc();

		$firstName = isset($sql["firstName"]) ? $sql["firstName"] : "";
		$lastName = isset($sql["lastName"]) ? $sql["lastName"] : "";

		$middleName = " ";
		if (isset($sql["middleName"])) {
			$middleName = $sql["middleName"];
			if ($middleName == ".") {
				$middleName = " ";
			} else {
				if (strlen($middleName) > 0) {
					$middleName = " " . $middleName[0] . ". ";
				} else $middleName = " ";
			}
		}

		$extName = "";
		if (isset($sql["extName"])) {
			$extName = $sql["extName"];
			if ($extName) {
				$extName = strtoupper($extName);
				$extName = ", " . $extName . ".";
			}
		}


		$fullname =  mb_convert_case("$firstName$middleName$lastName$extName", MB_CASE_UPPER, "UTF-8");

		return $fullname;
	}

	// method made for reviewing status of the file

	private function file_status()
	{
		$perStatus = "SELECT * from spms_performancereviewstatus where period_id='$this->per_ID' and employees_id='$this->emp_ID'";
		$perStatus = $this->mysqli->query($perStatus);
		$countData = $perStatus->num_rows;
		$perStatus = $perStatus->fetch_assoc();
		# put values in $perStatus to prevent null errors
		if (!$perStatus) {
			$perStatus = [
				'performanceReviewStatus_id' => '',
				'period_id' => $this->per_ID,
				'employees_id' => $this->emp_ID,
				'ImmediateSup' => '',
				'DepartmentHead' => '',
				'HeadAgency' => '',
				'PMT' => '',
				'submitted' => '',
				'certify' => '',
				'approved' => '',
				'panelApproved' => '',
				'dateAccomplished' => '',
				'formType' => '',
				'department_id' => '',
				'assembleAll' => '',
			];
		}


		$this->fileStatus = $perStatus;

		$this->signatoriesCount = $countData;
		$accountId = $this->emp_ID;
		if (!isset($perStatus['panelApproved']) || $perStatus['panelApproved'] != "") {
			$this->hideCol = true;
		} else {
			// if employee 
			if ($accountId == $perStatus['employees_id']) {
				if (strtoupper($perStatus['submitted']) == "DONE") {
					$this->hideCol = true;
				} else {
					$this->hideCol = false;
				}
			}
			// for reviewers 
			// 1 - ipcr |2 - spcr |3 - dpcr |4 - division 
			elseif ($perStatus['formType'] == 1) {
				if ($accountId == $perStatus['PMT']) {
					if ($perStatus['panelApproved'] != "") {
						$this->hideCol = true;
					} else {
						$this->hideCol = false;
					}
				} elseif ($accountId == $perStatus['ImmediateSup']) {
					if ($perStatus['approved'] != "" || $perStatus['certify'] != "") {
						$this->hideCol = true;
					} else {
						$this->hideCol = false;
					}
				} elseif ($accountId == $perStatus['DepartmentHead']) {
					if ($perStatus['certify'] != "") {
						$this->hideCol = true;
					} else {
						$this->hideCol = false;
					}
				} elseif ($accountId == $perStatus['employees_id']) {
					if ($perStatus['approved'] != "" || $perStatus['certify'] != "") {
						$this->hideCol = true;
					}
				}
			} elseif ($perStatus['formType'] == 2 || $perStatus['formType'] == 4) {
				if ($accountId == $perStatus['DepartmentHead'] || $accountId == $perStatus['ImmediateSup']) {
					if ($perStatus['approved'] != "" || $perStatus['certify'] != "") {
						$this->hideCol = true;
					} elseif ($accountId == $perStatus['PMT']) {
						if ($perStatus['panelApproved'] != "") {
							$this->hideCol = true;
						} else {
							$this->hideCol = false;
						}	//pmt
					} else {
						$this->hideCol = false;
					}
				} elseif ($accountId == $perStatus['employees_id']) {
					if ($perStatus['approved'] != "" || $perStatus['certify'] != "") {
						$this->hideCol = true;
					}
				} else {
				}
			}
		}

		if (isset($perStatus['formType'])) {
			if ($perStatus['formType'] == 2) {
				$this->budgetView	 = 'display:none';
			} else if ($perStatus['formType'] == 1) {
				$this->budgetView = 'display:none';
				$this->accountableView = 'display:none';
			}
		}
	}
	public function get_status($i)
	{
		$dat = $this->fileStatus;
		return $dat[$i];
	}

	public function validate_rsm()
	{
		$period = $this->period;
		$department = $this->get_emp('department_id');
		$sql = "SELECT * `spms_rsmstatus` where `period_id`='$period[mfoperiod_id]' and `department_id`='$department'";
		$sql = mysql::query($sql);
		$this->rsmStatus = $sql->fetch_assoc();
	}

	public function get_final_numerical_rating()
	{
		$strategic_function_rating = 0;
		if ($this->fileStatus['formType'] != "3") {
			$strategic_function_rating = $this->strategic_totalAv;
		}

		$data = [
			$strategic_function_rating,
			$this->core_totalAv,
			$this->support_totalAv
		];


		$final_numerical_rating = 0;
		foreach ($data as  $value) {
			$final_numerical_rating +=  $value;
		}

		return $final_numerical_rating;
	}

	private function coreAr()
	{
		# for more compact and faster query
		# ... and `dep_id` = '$department_id'
		$fileStatus = $this->fileStatus;
		# department_id from spms_performancereviewstatus
		$department_id = isset($fileStatus["department_id"]) ? $fileStatus["department_id"] : "";
		# not recommended department_id from employees table
		// $department_id = $this->EmpInfo["department_id"];
		$main_Arr = [];
		$sql = "SELECT * from spms_corefunctions where parent_id='' and mfo_periodId='$this->per_ID' and `dep_id` = '$department_id' ORDER BY `spms_corefunctions`.`cf_count` ASC";
		$sql = $this->mysqli->query($sql);
		$parent = [[], [], []];
		while ($core = $sql->fetch_assoc()) {
			# parent core (no parent)
			$parent[0] = $core;
			# get success indicators
			$si = $this->si($core['cf_ID']);
			# check if parent has children
			$child = $this->q($core['cf_ID']);
			if ($child->num_rows) {
				$parent[2] = $this->coreAr_Child($core['cf_ID']);
			}
			if (count($si)) {
				$parent[1] = $si;
			}

			if (count($si) || $parent[2]) {
				array_push($main_Arr, $parent);
				$parent = [[], [], []];
			}
		}
		return $main_Arr;
	}
	private function coreAr_Child($dataId)
	{
		$main_Arr = [];
		$sql = $this->q($dataId);
		$parent = [[], [], []];
		while ($childCore = $sql->fetch_assoc()) {
			$parent[0] = $childCore;
			$si = $this->si($childCore['cf_ID']);
			$child = $this->q($childCore['cf_ID']);
			if ($child->num_rows) {
				$parent[2] = $this->coreAr_Child($childCore['cf_ID']);
			}
			if (count($si)) {
				$parent[1] = $si;
			}
			if (count($si) || $parent[2]) {
				array_push($main_Arr, $parent);
				$parent = [[], [], []];
			}
		}
		return $main_Arr;
	}

	private function q($i)
	{

		$sql = "SELECT * from spms_corefunctions where parent_id='$i' ORDER BY `spms_corefunctions`.`cf_count` ASC";
		$sql = $this->mysqli->query($sql);
		if (!$sql) {
			die($this->error);
		}
		return $sql;
	}

	private function si($siId)
	{
		$i = [];

		if (!$siId || $siId == null) return $i;

		$sqlSi1 = "SELECT * from spms_matrixindicators where cf_ID='$siId'";
		$sqlSi1 = $this->mysqli->query($sqlSi1);
		if (!$sqlSi1) {
			die($this->error);
		}
		while ($a = $sqlSi1->fetch_assoc()) {
			$incharge = explode(',', $a['mi_incharge']);

			if (in_array($this->emp_ID, $incharge)) {
				array_push($i, $a);
			}
		}

		return $i;
	}
	//methods for core function
	public function coreRow()
	{
		$this->percent = 0;
		$arr = $this->coreAr();
		// return $arr;
		$count0 = count($arr);
		$in0 = 0;
		$totalav = 0;
		while ($in0 < $count0) {
			$a1 = $arr[$in0][2];
			$child = $this->coreRow_child(5, $a1);
			$t0 = $this->Core_mfoRow(5, $arr[$in0]);
			$totalav += $t0[2] + $child[2];
			$in0++;
		}

		$this->core_totalAv	= $totalav;
	}

	private function Core_mfoRow($padding, $ar)
	{
		$cTotal = 0;
		$count = 0;
		$totalav = 0;
		$inSi = 0;
		$view = "";
		if (count($ar[1]) > 0) {
			while ($inSi < count($ar[1])) {
				if ($inSi == 0) {
					$row0 = $this->Core_siRow($padding, $ar[0], $ar[1][$inSi]);
					$count += $row0[1];
					$totalav += $row0[2];
					$cTotal += $row0[3];
				} else {
					$row1 = $this->Core_siRow($padding, ['cf_count' => '', 'cf_title' => ''], $ar[1][$inSi]);
					$count += $row1[1];
					$totalav += $row1[2];
					$cTotal += $row1[3];
				}
				$inSi++;
			}
		}
		$a = [$view, $count, $totalav, $cTotal];
		return $a;
	}

	private function coreRow_child($padding, $arr)
	{
		$index = 0;
		$childData = ["", "", "", ""];
		$view = "";
		$count = 0;
		$totalav = 0;
		$cTotal = 0;
		$padding += 15;
		while ($index < count($arr)) {
			$a2 = $arr[$index][2];
			$child = $this->coreRow_child($padding, $a2);
			$data = $this->Core_mfoRow($padding, $arr[$index]);
			$count += $data[1] + $child[1];
			$totalav += $data[2] + $child[2];
			$cTotal += $data[3] + $child[3];
			$index++;
		}
		$childData = [$view, $count, $totalav, $cTotal];
		return $childData;
	}

	private function Core_siRow($padding, $ar, $si)
	{
		$count = 0;
		$cTotal = 0;
		$a = 0;
		if ($si != "") {
			$check = "SELECT * from spms_corefucndata where p_id='$si[mi_id]' and empId='$this->emp_ID'";
			$check = $this->mysqli->query($check);
			if ($check->num_rows > 0) {
				$SiData = $check->fetch_assoc();
				$div = 0;
				if (!$SiData['disable']) {
					if ($SiData['Q'] != "") {
						$a += $SiData['Q'];
						$div += 1;
					}
					if ($SiData['E'] != "") {
						$a += $SiData['E'];
						$div += 1;
					}
					if ($SiData['T'] != "") {
						$a += $SiData['T'];
						$div += 1;
					}
					$a = ($a / $div) * ($SiData['percent'] / 100);
					$a = mb_substr($a, 0, 4);
				}


				$cTotal++;
			} else {
				$count++;
			}
		}
		$ar = ["", $count, $a, $cTotal];
		return $ar;
	}

	public function get_coreView()
	{
		return $this->coreView;
	}
	// methods for support function
	private function supportFunctionTr()
	{
		$this->supportPercent = 0;
		if ($this->get_status('formType') == '1' || $this->get_status('formType') == '5') {
			$sql = "SELECT * FROM `spms_supportfunctions` where `type`=1";
		} elseif ($this->get_status('formType') == '3') {
			$sql = "SELECT * FROM `spms_supportfunctions` where `type`=3";
		} else {
			$sql = "SELECT * FROM `spms_supportfunctions` where `type`=2";
		}
		$sql = $this->mysqli->query($sql);
		$col = "";
		if (!$this->hideCol) {
			$col = "<td class='noprint' ></td>";
		}
		$viewTr = "<tr style='background:#f7f70026'><td colspan='8'><b>Support Function</b></td><td class='noprint'></td>
		<td style='$this->budgetView'></td>
		<td style='$this->accountableView'></td>
		$col</tr>";
		$emp_count = 0;
		$totalAv = 0;
		while ($tr = $sql->fetch_assoc()) {
			$sqlSelect = "SELECT * from spms_supportfunctiondata where parent_id='$tr[id_suppFunc]' and emp_id='$this->emp_ID' and period_id='$this->per_ID'";
			$sqlSelect = $this->mysqli->query($sqlSelect);
			$sqlSelectCount = $sqlSelect->num_rows;
			if ($sqlSelectCount > 0) {
				$fdata = $sqlSelect->fetch_assoc();
				$av = 0;
				$per = $fdata['percent'] / 100;
				$q = 0;
				$e = 0;
				$t = 0;
				
				if ($fdata['Q'] != "") {
					$q = $fdata['Q'] * $per;
				}
				if ($fdata['E'] != "") {
					$q = $fdata['E'] * $per;
				}
				if ($fdata['T'] != "") {
					$q = $fdata['T'] * $per;
				}
				$av = $q + $e + $t;
				$this->supportPercent += $fdata['percent'];
				$totalAv += $av;
			} else {
				$emp_count++;
			}
		}
		$this->support_totalAv = $totalAv;
	}

	// method for stratgic function
	private function strategicTr()
	{
		$this->strtPercent = "N/A"; //previously N/A
		$sql = "SELECT * from spms_strategicfuncdata where period_id = '$this->per_ID' and emp_id = '$this->emp_ID'";
		$sql = $this->mysqli->query($sql);

		if (!$sql) {
			die($this->error);
		}

		$totalCount = 0;
		$totalAv = 0;
		while ($row = $sql->fetch_assoc()) {
			// $av = $row['Q']+$row['T'];
			$av = isset($row['average']) && $row['average'] > 0 ? $row['average'] : 0;

			$totalAv += $av;
			$totalCount++;
			if ($row['noStrat'] == "0") {
				$this->strtPercent = 20;
			}
		}
		if ($totalAv > 0) {
			$totalAv = $totalAv / $totalCount;
		} else {
			$totalAv = 0;
		}

		if ($totalAv > 0) {
			$totalAv = $totalAv * 0.20;
			# format only two decimal places
			$totalAv = number_format($totalAv, 2);
			# prevent rounding off value
			// $totalAv = intval(($totalAv * 100)) / 100;
		} else {
			$totalAv = 0;
		}
		$this->strategic_totalAv = $totalAv;
	}
}

##############################################
#####	 End of Employee_data Class  	######
##############################################
