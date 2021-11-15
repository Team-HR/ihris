<?php
require_once 'Controller.php';
class PcrFinalNumericalRatingController extends Controller
{

    private $employee_id = 0;
    private $period_id = 0;

    public $total_weighted_average_core = 0;
    public $total_weighted_average_support = 0;
    public $final_numerical_rating = 0;

    function __construct()
    {
        parent::__construct();
    }

    // public function set_period_id($period_id)
    // {
    //     if (!$period_id || $period_id == 0) return false;
    //     $this->period_id = $period_id;
    // }

    public function get_final_numerical_rating($employee_id = null, $period_id = null)
    {
        if ($employee_id || $period_id) {
            $this->employee_id = $employee_id;
            $this->period_id = $period_id;
        }

        if (!$this->employee_id || !$this->period_id) return false;

        $core_functions = [];
        $sql = "
                SELECT `spms_corefucndata`.*, `spms_matrixindicators`.`mi_id`,`spms_matrixindicators`.`cf_ID`, `spms_corefunctions`.`cf_ID`  FROM `spms_corefucndata` 
                LEFT JOIN `spms_matrixindicators`
                ON `spms_corefucndata`.`p_id` = `spms_matrixindicators`.`mi_id`
                LEFT JOIN `spms_corefunctions`
                ON `spms_matrixindicators`.`cf_ID` = `spms_corefunctions`.`cf_ID`
                WHERE `empId` = ?
                AND `spms_corefunctions`.`cf_ID` IS NOT NULL
                ORDER BY `spms_corefucndata`.`cfd_id` ASC;
            ";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $this->employee_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $core_function = [
                "cfd_id" => $row["cfd_id"],
                "p_id" => $row["p_id"],
                "Q" => $row["Q"],
                "E" => $row["E"],
                "T" => $row["T"],
                "disable" => $row["disable"],
                "actualAcc" => $row["actualAcc"],
                "percent" => $row["percent"],
                "weighted_average" => $this->compute_weighted_average($row["Q"], $row["E"], $row["T"], $row["percent"], $row["disable"])
            ];
            $core_functions[] = $core_function;
        }

        // remove item with duplicate p_id (mi_id) start
            $p_ids = [];
            $filtered_core_functions = [];
            foreach ($core_functions as $index => $core_function) {
                $p_id = $core_function['p_id'];
                if (in_array($p_id, $p_ids)) {
                    unset($core_functions[$index]);
                } else {
                    $p_ids[] = $p_id;
                }
            }
            $core_functions = array_values($core_functions);
        // remove item with duplicate p_id (mi_id) end

        // return $core_functions;

        $total_weighted_average_core = 0;

        foreach ($core_functions as $value) {
            $total_weighted_average_core += $value["weighted_average"] ? $value["weighted_average"] : 0;
        }

        $sql = "SELECT * FROM `spms_supportfunctiondata` WHERE `emp_id` = ? AND `period_id` = ? ORDER BY `spms_supportfunctiondata`.`parent_id` ASC";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("ii", $this->employee_id, $this->period_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $support_functions = [];

        while ($row = $result->fetch_assoc()) {
            $support_function = [
                "parent_id" => $row["parent_id"],
                "Q" => $row["Q"],
                "E" => $row["E"],
                "T" => $row["T"],
                "percent" => $row["percent"],
                "weighted_average" => $this->compute_weighted_average($row["Q"], $row["E"], $row["T"], $row["percent"], 0)
            ];
            $support_functions[] = $support_function;
        }

        $total_weighted_average_support = 0;

        foreach ($support_functions as $value) {
            $total_weighted_average_support += $value["weighted_average"];
        }

        $total_weighted_average_core = $total_weighted_average_core; // number_format($total_weighted_average_core, "2", ".", ""); // debatable to either 1 decimal places or 2?
        $total_weighted_average_support = $total_weighted_average_support; // number_format($total_weighted_average_support, "2", ".", "");
        $final_numerical_rating = $total_weighted_average_core + $total_weighted_average_support;
        $final_numerical_rating = $final_numerical_rating; //number_format($final_numerical_rating, "2", ".", "");

        $this->total_weighted_average_core = $total_weighted_average_core;
        $this->total_weighted_average_support = $total_weighted_average_support;
        $this->final_numerical_rating = $final_numerical_rating;

        // return $final_numerical_rating;
        return [
            "core" => $this->total_weighted_average_core,
            "support" => $this->total_weighted_average_support,
            "final" => $this->final_numerical_rating
        ];
    }

    private function compute_weighted_average($q, $e, $t, $percent, $disable)
    {
        if ($disable || $disable == 1) return 0;

        $arr = [];
        $q ? array_push($arr, $q) : null;
        $e ? array_push($arr, $e) : null;
        $t ? array_push($arr, $t) : null;

        $sum = 0;
        foreach ($arr as $value) {
            $sum += $value;
        }

        $count = count($arr);
        if (!$count) return 0;
        $ave = $sum / $count;
        $weighted_average = $ave * floatval($percent) / 100;
        // return $weighted_average;
        return number_format(intval($weighted_average * 100) / 100, "2", ".", "");
    }
}
