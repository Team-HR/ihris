<?php
require_once "Controller.php";

class Pms extends Controller
{
    private $period_id;
    private $employee_id;
    private $department_id; // based on spms_performancereviewstatus
    private $final_numerical_rating;

    function __construct()
    {
        parent::__construct();
    }

    public function set_period_id($period_id)
    {
        $this->period_id = $period_id;
    }

    public function set_employee_id($employee_id)
    {
        $this->employee_id = $employee_id;
    }

    public function set_department_id($department_id)
    {
        $this->department_id = $department_id;
    }

    public function get_numerical_rating()
    {
        $core_function_rating = $this->get_core_function_rating();
        $strategic_function_rating = $this->get_strategic_function_rating();
        $support_function_rating = $this->get_support_function_rating();
        $this->final_numerical_rating = $strategic_function_rating + $core_function_rating + $support_function_rating;
        return $this->final_numerical_rating;
    }

    public function get_adjectival_rating()
    {
        if (!$this->final_numerical_rating) {
            $this->get_numerical_rating();
        }

        $final_numerical_rating = $this->final_numerical_rating;

        $adjectival = "";

        if ($final_numerical_rating <= 5 && $final_numerical_rating > 4) {
            $adjectival = "O";
        } elseif ($final_numerical_rating <= 4 && $final_numerical_rating > 3) {
            $adjectival = "VS";
        } elseif ($final_numerical_rating <= 3 && $final_numerical_rating > 2) {
            $adjectival = "S";
        } elseif ($final_numerical_rating <= 2 && $final_numerical_rating > 1) {
            $adjectival = "U";
        }

        return $adjectival;
    }



    # SELECT * FROM `spms_supportfunctiondata` where `period_id` = '2' AND `emp_id` = '9';

    public function get_support_function_rating()
    {
        $support_function_rating = 0;
        $data = [];
        $sql = "SELECT * FROM `spms_supportfunctiondata` where `period_id` = '$this->period_id' AND `emp_id` = '$this->employee_id'";
        $res = $this->mysqli->query($sql);
        while ($row = $res->fetch_assoc()) {
            $datum = [
                "q" => isset($row["Q"]) ? intval($row["Q"]) : 0,
                "e" => isset($row["E"]) ? intval($row["E"]) : 0,
                "t" => isset($row["T"]) ? intval($row["T"]) : 0,
                "percent" => isset($row["percent"]) ? intval($row["percent"]) : 0,
            ];
            $data[] = $datum;
        }
        if (count($data) < 1) return 0;
        foreach ($data as $key => $val) {
            $num = 0;
            if ($val["q"]) {
                $num += 1;
            }
            if ($val["e"]) {
                $num += 1;
            }
            if ($val["t"]) {
                $num += 1;
            }
            if ($num == 0) {
                continue;
            }
            $support_function_rating += ($val["q"] + $val["e"] + $val["t"]) / $num * $val["percent"] / 100;
        }
        $total_core_function = floatval(number_format($support_function_rating, 2));
        return $total_core_function;
    }

    public function get_strategic_function_rating()
    {
        $strategic_function_rating = 0;
        $sql = "SELECT * FROM `spms_strategicfuncdata` WHERE `period_id` = '$this->period_id' AND `emp_id` = '$this->employee_id' LIMIT 1";
        $res = $this->mysqli->query($sql);
        while ($row = $res->fetch_assoc()) {
            $strategic_function_rating = $row["average"];
        }

        if (!$strategic_function_rating) return 0;
        $strategic_function_rating = floatval(number_format(floatval($strategic_function_rating) * 20 / 100, 2));

        return $strategic_function_rating;
    }

    public function get_core_function_rating()
    {
        if (!$this->period_id || !$this->department_id || !$this->employee_id) return false;
        $period_id = $this->period_id;
        $department_id = $this->department_id;
        $employee_id = $this->employee_id;

        $sql = "SELECT * FROM `spms_corefucndata` where empId = '$employee_id' AND `p_id` IN (SELECT `mi_id` FROM `spms_matrixindicators` LEFT JOIN `spms_corefunctions` ON `spms_matrixindicators`.`cf_ID` = `spms_corefunctions`.`cf_ID` WHERE `spms_corefunctions`.`mfo_periodId` = '$period_id' AND spms_corefunctions.dep_id = '$department_id')";
        $res = $this->mysqli->query($sql);
        $data = [];
        while ($row = $res->fetch_assoc()) {
            $datum = [
                "q" => isset($row["Q"]) ? intval($row["Q"]) : 0,
                "e" => isset($row["E"]) ? intval($row["E"]) : 0,
                "t" => isset($row["T"]) ? intval($row["T"]) : 0,
                "disable" => $row["disable"],
                "percent" => isset($row["percent"]) ? intval($row["percent"]) : 0,
            ];
            $data[] = $datum;
        }

        $total_core_function = 0;
        foreach ($data as $key => $val) {
            if ($val["disable"] == 0) {
                $num = 0;
                if ($val["q"]) {
                    $num += 1;
                }
                if ($val["e"]) {
                    $num += 1;
                }
                if ($val["t"]) {
                    $num += 1;
                }
                $total_core_function += ($val["q"] + $val["e"] + $val["t"]) / $num * $val["percent"] / 100;
            }
        }
        $total_core_function = floatval(number_format($total_core_function, 2,));
        return $total_core_function;
    }
}
