<?php

require_once "_connect.db.php";

if (isset($_POST["load"])) {
    $prr_id = $_POST["prr_id"];
    // $type = $_POST["type"];
    // $year = "SELECT * from prr where prr_id='$prr_id'";
    // $year = $mysqli->query($year);
    // $year = $year->fetch_assoc();
    // $year = $year['year'];
    $data = get_employees($mysqli, $prr_id);
    echo json_encode($data);
} elseif (isset($_POST["get_emps"])) {
    echo json_encode(emp($mysqli));
} elseif (isset($_POST["get_ova_rates"])) {
    $prr_id = $_POST["prr_id"];
    echo json_encode(Ov_rates($mysqli, $prr_id));
}

function get_employees($mysqli, $prr_id)
{
    $data = array();
    $year = "SELECT * from prr where prr_id='$prr_id'";
    $year = $mysqli->query($year);
    $year = $year->fetch_assoc();
    $year = $year['year'];
    $csid = substr($year, -2) . "001";
    $sql1 = "SELECT * from prrlist right join employees on prrlist.employees_id=employees.employees_id where prr_id='$prr_id' ORDER BY `gender` ASC, `lastName` ASC";
    $result1 = $mysqli->query($sql1);
    $i = 0;
    $tr = "";

    # get period_id with prr_id
    $sql = "SELECT * FROM prr WHERE `prr_id` = '$prr_id'";
    $res = $mysqli->query($sql);
    $prr = $res->fetch_assoc();
    $month_mfo = $prr["period"];
    $year_mfo = $prr["year"];
    $sql = "SELECT * FROM `spms_mfo_period` WHERE `month_mfo` = '$month_mfo' AND `year_mfo` = '$year_mfo'";
    $res = $mysqli->query($sql);
    $period = $res->fetch_assoc();
    $period_id = $period["mfoperiod_id"];


    while ($row = $result1->fetch_assoc()) {
        # get date_submitted and date_appraised from spms_performancereviewstatus
        $sql = "SELECT * FROM `spms_performancereviewstatus` WHERE period_id = '$period_id' AND employees_id = '$row[employees_id]'";
        $res = $mysqli->query($sql);

        $date_submitted = format_date_ymd($row["date_submitted"]);
        $date_appraised = format_date_ymd($row["date_appraised"]);


        if ($status = $res->fetch_assoc()) {
            if ($date_submitted == "0000-00-00") {
                $date_submitted = format_date_ymd($status["dateAccomplished"]);
            }
            if ($date_appraised == "0000-00-00") {
                $date_appraised = format_date_ymd($status["panelApproved"]);
            }
        }

        // $date_appraised = isset($row["date_appraised"]) && $row["certify"] ? $date_appraised : "";

        if (!$row['date_appraised'] || $row['date_appraised'] == "0000-00-00") {
            $date_appraised = isset($status["certify"]) && $status["certify"] != "" ? format_date_ymd($status["certify"]) : "0000-00-00"; //"date_submitted: $date_submitted  date_appraised: $row[date_appraised]";
        } else {
            $date_appraised = $row["date_appraised"];
        }


        if ($date_submitted != "0000-00-00") {
            $row["date_submitted"] =  $date_submitted;
            $row["date_submitted_view"] =  format_date_mdy($date_submitted);
        } else {
            $row["date_submitted"] = "";
            $row["date_submitted_view"] = "";
        }


        if ($date_appraised != "0000-00-00") {
            $row["date_appraised"] =  $date_appraised;
            $row["date_appraised_view"] =  format_date_mdy($date_appraised);
        } else {
            $row["date_appraised"] = "";
            $row["date_appraised_view"] = "";
        }



        $row["csid"] = $csid++;
        $row["middleName"] = $row["middleName"] ? $row["middleName"][0] : "";
        $row["gender"] = $row["gender"] ? $row["gender"][0] : "";


        // $final_numerical_rating = isset($status["final_numerical_rating"]) ? $status["final_numerical_rating"] : "";
        $final_numerical_rating = $row["numerical"];

        $row["numerical"] = $final_numerical_rating != 0 ? $final_numerical_rating : "";

        $final_adjectival_rating = "";
        if ($final_numerical_rating <= 5 && $final_numerical_rating > 4) {
            $final_adjectival_rating = "O";
        } elseif ($final_numerical_rating <= 4 && $final_numerical_rating > 3) {
            $final_adjectival_rating = "VS";
        } elseif ($final_numerical_rating <= 3 && $final_numerical_rating > 2) {
            $final_adjectival_rating = "S";
        } elseif ($final_numerical_rating <= 2 && $final_numerical_rating > 1) {
            $final_adjectival_rating = "U";
        }

        $row["adjectival"] = $final_adjectival_rating;

        $row['appraisal_type'] = 'Semestral';
        if ($row['stages'] == 'C') {
            # set color state based on date_submitted and date_appraised
            if ($date_submitted != "0000-00-00" && $date_appraised != "0000-00-00") {
                $state = "W";
            } elseif ($date_submitted != "0000-00-00" && $date_appraised == "0000-00-00") {
                $state = "Y";
            } else {
                $state = "C";
                $row['appraisal_type'] = '';
            }
            $row["stages"] = $state;
        }
        $data[] = $row;
    }

    return $data;
}

function emp($mysqli)
{
    $sql = "SELECT * from employees";
    $res = $mysqli->query($sql);
    $data = [];
    while ($row = $res->fetch_assoc()) {
        $data[] = [
            "employees_id" => $row["employees_id"],
            "text" => $row["lastName"] . ", " . $row["firstName"]
        ];
    }
    return $data;
}


function Ov_rates($mysqli, $prr_id)
{
    $sql = "SELECT * from prrlist left join employees on prrlist.employees_id=employees.employees_id where prr_id='$prr_id'";
    $result = $mysqli->query($sql);
    $FO = 0;
    $FV = 0;
    $FS = 0;
    $FU = 0;
    $FP = 0;
    $FT = 0;
    $MO = 0;
    $MV = 0;
    $MS = 0;
    $MU = 0;
    $MP = 0;
    $MT = 0;

    $others_male = 0;
    $others_female = 0;
    $others_total = 0;

    while ($row = $result->fetch_assoc()) {
        if ($row['gender'] == "MALE") {
            if (isset($row["date_submitted"]) && $row["date_submitted"] != "0000-00-00" && $row["numerical"] != "0") {
                if ($row['adjectival'] == 'O') {
                    $MO++;
                } elseif ($row['adjectival'] == 'VS') {
                    $MV++;
                } elseif ($row['adjectival'] == 'S') {
                    $MS++;
                } elseif ($row['adjectival'] == 'US') {
                    $MU++;
                } else {
                    $MP++;
                }
            } else {
                $others_male++;
            }
        } elseif ($row['gender'] == "FEMALE") {
            if (isset($row["date_submitted"]) && $row["date_submitted"] != "0000-00-00" && $row["numerical"] != "0") {
                if ($row['adjectival'] == 'O') {
                    $FO++;
                } elseif ($row['adjectival'] == 'VS') {
                    $FV++;
                } elseif ($row['adjectival'] == 'S') {
                    $FS++;
                } elseif ($row['adjectival'] == 'US') {
                    $FU++;
                } else {
                    $FP++;
                }
            } else {
                $others_female++;
            }
        }
    }
    $FT = $FO + $FV + $FS + $FU + $FP;
    $MT = $MO + $MV + $MS + $MU + $MP;
    // $a = array(
    //     'F' => array('O' => $FO, 'V' => $FV, 'S' => $FS, 'U' => $FU, 'P' => $FP, 'T' => $FT),
    //     'M' => array('O' => $MO, 'V' => $MV, 'S' => $MS, 'U' => $MU, 'P' => $MP, 'T' => $MT)
    // );

    $arr = [
        [
            "row" => "OUTSTANDING",
            "female" => $FO,
            "male" => $MO,
            "total" => $FO + $MO,
            "percent" => round((($FO + $MO) / ($FT + $MT) * 100))
        ],
        [
            "row" => "VERY SATISFACTORY",
            "female" => $FV,
            "male" => $MV,
            "total" => $FV + $MV,
            "percent" => round((($FV + $MV) / ($FT + $MT) * 100))
        ],
        [
            "row" => "SATISFACTORY",
            "female" => $FS,
            "male" => $MS,
            "total" => $FS + $MS,
            "percent" => round((($FS + $MS) / ($FT + $MT) * 100))
        ],
        [
            "row" => "UNSATISFACTORY",
            "female" => $FU,
            "male" => $MU,
            "total" => $FU + $MU,
            "percent" => round((($FU + $MU) / ($FT + $MT) * 100))
        ],
        [
            "row" => "POOR",
            "female" => $FP,
            "male" => $MP,
            "total" => $FP + $MP,
            "percent" => round((($FP + $MP) / ($FT + $MT) * 100))
        ],
        [
            "row" => "TOTAL",
            "female" => $FT,
            "male" => $MT,
            "total" => $FT + $MT,
            "percent" => 100
        ],
        [
            "row" => "OTHERS (Not submitted/ Separated/ Inactive)",
            "female" => $others_female,
            "male" => $others_male,
            "total" => $others_female + $others_male
        ]
    ];
    return $arr;
}


function format_date_ymd($date)
{
    if (!$date || $date == "0000-00-00") return "0000-00-00";

    if ($date = date_create($date)) {
        $date =  date_format($date, "Y-m-d");
    } else {
        $date = "0000-00-00";
    }
    return $date;
}

function format_date_mdy($date)
{
    if (!$date || $date == "0000-00-00") return "";
    $date = explode('-', $date);
    if (count($date) == 3) {
        return "$date[1]/$date[2]/$date[0]";
    } else return "";
}
