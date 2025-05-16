<?php
require_once "Controller.php";
// Leave Class 
## Table of content :)
## create object
## by
## var yourVar = new LeaveClass($hostname, $DbUsername, $password, $databaseName);

class LeaveRecordsController extends Controller
{
    #############################################
    // public var
    #############################################
    public $dateLeave = [];
    public $test = [];
    #############################################
    // private var
    #############################################
    private $summary;
    private $employee;
    #############################################
    // protected var
    #############################################
    protected $leaveMultipier = 0.002083333;
    protected $months = [
        1 => "January",
        2 => "Febuary",
        3 => "March",
        4 => "April",
        5 => "May",
        6 => "June",
        7 => "July",
        8 => "August",
        9 => "September",
        10 => "October",
        11 => "November",
        12 => "December"
    ];
    #############################################
    // __constact
    // mysqli is setup and ready to go!!
    #############################################
    // function __constact($hostname, $DbUsername, $password, $databaseName){
    //     mysqli::__constact($hostname, $DbUsername, $password, $databaseName);
    // }
    function __construct()
    {
        parent::__construct();
    }
    #############################################
    // public functions
    #############################################
    public function set_date($from, $to)
    {
        $from = explode("-", date('m-d-Y', $from));
        $to = explode("-", date('m-d-Y', $to));
        $f = array('m' => $from[0], 'd' => $from[1], 'y' => $from[2]);
        $t = array('m' => $to[0], 'd' => $to[1], 'y' => $to[2]);
        $this->dateLeave['from'] = $f;
        $this->dateLeave['to'] = $t;
    }
    public function set_employee($emp)
    {
        $this->employee = $emp;
        $this->dtrSummary();
    }
    public function get_equivalent($mins)
    {
        $c = $this->leaveMultipier;
        $equiv = $c * $mins;
        return round($equiv, 2);
    }

    public function get_summary()
    {
        return $this->summary;
    }
    #############################################
    // private functions
    #############################################
    public function json_dtrMonitoring()
    {
        $dateFrom = $this->dateLeave['from'];
        $dateTo = $this->dateLeave['to'];
        $dateFrom_c = $dateFrom['y'];
        $parent = [];
        while ($dateFrom_c <= $dateTo['y']) {
            $m = [];
            if ($dateFrom['y'] == $dateTo['y']) {
                $m = $this->monthDtr($dateFrom['m'], $dateTo['m'], $dateFrom_c);
            } elseif ($dateFrom_c == $dateTo) {
                $m = $this->monthDtr(1, $dateTo['m'], $dateFrom_c);
            } else {
                $m = $this->monthDtr($dateFrom['m'], 12, $dateFrom_c);
            }
            if ($m) {
                $parent[$dateFrom_c] = $m;
            }
            $dateFrom_c++;
        }
        $this->test[] = $parent;
    }
    private function monthDtr($start, $end, $year)
    {
        $months = [];
        while ($start <= $end) {
            $temp = [];
            if (strlen($start) < 2) {
                $start = "0" . $start;
            }
            $ym = $year . "-" . $start;
            $sql = "SELECT * FROM `dtrmanagement` where `dtr_date` like '$ym%' AND `emp_id`=$this->employee";
            $sql = $this->mysqli->query($sql);
            while ($a = $sql->fetch_assoc()) {
                $d = explode('-', date("Y-m-d", $a['dtr_date']));
                $temp[] = $a;
                // $temp[] = $sql->num_rows;
            }
            // if($temp){
            $months[$start] = $temp;
            // }
            $start++;
        }
        return $months;
    }
    private function dtrSummary()
    {
        $sql = "SELECT * from `dtrsummary` where `employee_id`='$this->employee' ORDER BY `dtrsummary`.`month` DESC";
        $sql = $this->mysqli->query($sql);
        $a = [];
        while ($dat = $sql->fetch_assoc()) {
            $dateString = $dat["month"];
            $dat["month"] = "";
            if ($dateString) {
                $myDateTime = DateTime::createFromFormat('Y-m', $dateString);
                $newDateString = $myDateTime->format('F Y');
                $dat["month"] = $newDateString;
            }
            
            $dat["equiTardy"] = compEquiv($dat["totalMinsTardy"]);
            $dat["equiUndertime"] = compEquiv($dat["totalMinsUndertime"]);

            $dat["totalTardy"] = $dat["totalTardy"]?$dat["totalTardy"]:"";
            $dat["totalMinsTardy"] = $dat["totalMinsTardy"]?$dat["totalMinsTardy"]:"";
            $dat["totalMinsUndertime"] = $dat["totalMinsUndertime"]?$dat["totalMinsUndertime"]:"";

            $a[] = $dat;
        }
        $this->summary = $a;
    }
}

function compEquiv($mins)
{
    $equiv = "";
    if (!$mins) return $equiv;
    $c = 0.002083333;
    $equiv = $c * intval($mins);
    return number_format($equiv, 3);
}
