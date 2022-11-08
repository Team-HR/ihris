<?php
require_once "Controller.php";

class Pms extends Controller
{
    private $period_id;
    private $employee_id;
    private $department_id; // based on spms_performancereviewstatus
    private $final_numerical_rating;
    private $adjectival_rating;

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

    public function get_final_numerical_rating()
    {
        $strategic_function_rating = 0;

        # check if employee is department head, if so exclude strategic function rating
        $sql = "SELECT `formType` FROM `spms_performancereviewstatus` WHERE `employees_id` = '$this->employee_id' AND `period_id` = '$this->period_id' LIMIT 1";
        $res = $this->mysqli->query($sql);
        if ($row = $res->fetch_assoc()) {
            if ($row["formType"] != "3") {
                $strategic_function_rating = $this->get_strategic_function_rating();
            }
        }

        $core_function_rating = $this->get_core_function_rating();
        $support_function_rating = $this->get_support_function_rating();
        $final_numerical_rating = $strategic_function_rating + $core_function_rating + $support_function_rating;
        $this->final_numerical_rating = floatval(number_format($final_numerical_rating, 2));
        return $this->final_numerical_rating;
    }

    public function get_final_adjectival_rating()
    {
        if (!$this->final_numerical_rating) {
            $this->get_final_numerical_rating();
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
        $this->adjectival_rating = $adjectival;
        return $adjectival;
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
        $total_core_function_average_rating = 0;
        if (!$this->period_id || !$this->department_id || !$this->employee_id) return false;
        $period_id = $this->period_id;
        $department_id = $this->department_id;
        $employee_id = $this->employee_id;

        $mi_ids = [];

        /*
        #
        #       START of filtered core function with distinct cf_count
        #       erroneous core function numerical rating computation caused by redundunt unused core function
        #       identifiable by the same cf_count. SOLUTION: only use the first cf_count disregard other same cf_count
        #
        */

        $cores = [];
        $sql = "SELECT * FROM `spms_corefunctions` WHERE `dep_id` = '$department_id' AND `mfo_periodId` = '$period_id'";
        $res = $this->mysqli->query($sql);
        while ($row = $res->fetch_assoc()) {
            $cf_count = $row["cf_count"];
            $exists = false;
            foreach ($cores as $core) {
                if ($core["cf_count"] == $cf_count) {
                    $exists = true;
                }
            }

            if (!$exists) {
                $cores[] =  [
                    "cf_ID" => $row["cf_ID"],
                    "cf_count" => $cf_count
                ];
            }
        }

        $filtered_cores = [];

        foreach ($cores as $core) {
            $filtered_cores[] = $core["cf_ID"];
        }

        $cf_IDs = implode(",", $filtered_cores);
        // return $cf_IDs;
        /*
        #
        #       END of filtered core function with distinct cf_count
        #       erroneous core function numerical rating computation caused by redundunt unused core function
        #       identifiable by the same cf_count. SOLUTION: only use the first cf_count disregard other same cf_count
        #
        */

        $sql = "SELECT * FROM `spms_matrixindicators` WHERE `mi_incharge` LIKE '%$employee_id%' AND `cf_ID` IN ($cf_IDs)";
        $res = $this->mysqli->query($sql);
        while ($row = $res->fetch_assoc()) {
            $mi_incharge = [];
            if (isset($row["mi_incharge"])) {
                $mi_incharge = explode(",", $row["mi_incharge"]);
            }
            if (in_array($employee_id, $mi_incharge)) {
                $mi_ids[] = $row["mi_id"];
                // $mi_ids[] = $row;
            }
        }

        // return $mi_ids;

        if (count($mi_ids) < 1) return 0;
        $spms_corefucndata = [];
        $mi_ids = implode(",", $mi_ids);

        $sql = "SELECT * FROM `spms_corefucndata` WHERE `empId` = '$employee_id' AND `p_id` IN ($mi_ids)";
        $res = $this->mysqli->query($sql);

        while ($row = $res->fetch_assoc()) {
            $spms_corefucndata[] = $row;
        }

        if (count($spms_corefucndata) < 1) return 0;
        $filtered_spms_corefucndata = [];
        foreach ($spms_corefucndata as $row) {
            $p_id = $row['p_id'];
            $exists = false;
            foreach ($filtered_spms_corefucndata as $value) {
                if ($value['p_id'] == $p_id) {
                    $exists = true;
                }
            }

            if (!$exists) {
                $filtered_spms_corefucndata[] = $row;
            }
        }

        // return $filtered_spms_corefucndata;

        $data = [];
        foreach ($filtered_spms_corefucndata as $row) {
            $datum = [
                "q" => isset($row["Q"]) ? intval($row["Q"]) : 0,
                "e" => isset($row["E"]) ? intval($row["E"]) : 0,
                "t" => isset($row["T"]) ? intval($row["T"]) : 0,
                "disable" => isset($row["disable"]) ? $row["disable"] : null,
                "percent" => isset($row["percent"]) ? intval($row["percent"]) : 0,
            ];
            $data[] = $datum;
        }

        foreach ($data as $val) {
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

                if ($num == 0) continue;

                $core_function_average_rating = ($val["q"] + $val["e"] + $val["t"]) / $num * $val["percent"] / 100;
                $total_core_function_average_rating += bcdiv($core_function_average_rating, 1, 2);
            }
        }

        return $total_core_function_average_rating; //number_format((float)$total_core_function_average_rating, 2, '.', '');
    }

    # SELECT * FROM `spms_supportfunctiondata` where `period_id` = '2' AND `emp_id` = '9';
    public function get_support_function_rating()
    {
        $support_function_rating = 0;
        $data = [];
        $sql = "SELECT * FROM `spms_supportfunctiondata` where `period_id` = '$this->period_id' AND `emp_id` = '$this->employee_id'";
        $res = $this->mysqli->query($sql);
        while ($row = $res->fetch_assoc()) {
            $parent_id = $row["parent_id"];
            $datum = [
                "parent_id" => $parent_id,
                "q" => isset($row["Q"]) ? intval($row["Q"]) : 0,
                "e" => isset($row["E"]) ? intval($row["E"]) : 0,
                "t" => isset($row["T"]) ? intval($row["T"]) : 0,
                "percent" => isset($row["percent"]) ? intval($row["percent"]) : 0,
            ];

            $exists = false;
            foreach ($data as $support_func) {
                if ($support_func["parent_id"] == $parent_id) {
                    $exists = true;
                }
            }

            if (!$exists) {
                $data[] = $datum;
            }
        }

        // return $this->get_status();
        // return $data;

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
        $support_function_rating = floatval(number_format($support_function_rating, 2));
        return $support_function_rating;
    }


    public function get_comments_and_recommendations()
    {
        if (!isset($this->period_id) || !isset($this->employee_id)) return false;
        $period_id = $this->period_id;
        $employee_id = $this->employee_id;

        $sql = "SELECT * FROM `spms_commentrec` WHERE `period_id` = '$period_id' AND `emp_id` = '$employee_id' LIMIT 1";
        $res = $this->mysqli->query($sql);

        $comments_and_recommendations = "";
        while ($row = $res->fetch_assoc()) {
            $comments_and_recommendations = $row["comment"];
        }
        return $comments_and_recommendations;
    }

    private function get_status()
    {
        $sql = "SELECT * FROM `spms_performancereviewstatus` WHERE `employees_id` = '$this->employee_id' AND `period_id` = '$this->period_id' LIMIT 1";
        $res = $this->mysqli->query($sql);
        $row = $res->fetch_assoc();
        return $row ? $row : null;
    }
}
