<?php

use PhpOffice\PhpSpreadsheet\Worksheet\Row;

require_once "_connect.db.php";
require_once "./libs/Pms.php";

if (isset($_POST["load"])) {
    $prr_id = $_POST["prr_id"];
    $type = $_POST["type"];
    $year = "SELECT * from prr where prr_id='$prr_id'";
    $year = $mysqli->query($year);
    $year = $year->fetch_assoc();

    $period = $year['period'];
    $year = $year['year'];

    # fetch data from spms_performancereviewstatus
    $fetch_data_online_pms = fetch_data_online_pms($mysqli, $period, $year, $type);
    # update prrlist from the fetched data
    // $test = [];
    foreach ($fetch_data_online_pms as $value) {
        $employees_id = $value["employees_id"];
        $date_submitted = $value["date_submitted"];
        $date_appraised = $value["date_appraised"];
        $numerical = $value["numerical"];
        $adjectival = $value["adjectival"];
        $comments = $mysqli->real_escape_string($value["comments"]);
        $stages = $value["stages"];
        // "employees_id": "31018",
        // "date_submitted": "2022-08-05",
        // "date_appraised": "2022-09-06",
        // "numerical": 4.58,
        // "adjectival": "O",
        // "comments": "Needs training on detection of Tilapia Lake Virus",
        // "stages": "W",
        // "department_id": "4"
        $sql = "SELECT * FROM `prrlist` WHERE `prr_id`='$prr_id' AND `employees_id`='$employees_id'";
        $res = $mysqli->query($sql);
        $row = $res->fetch_assoc();

        if (!$row) {
            $mysqli->query("INSERT INTO `prrlist`(`prr_id`, `employees_id`, `date_submitted`, `appraisal_type`, `date_appraised`, `numerical`, `adjectival`, `remarks`, `comments`, `stages`) VALUES ('$prr_id','$employees_id', '$date_submitted', 'Semestral', '$date_appraised', '$numerical', '$adjectival', '', '$comments', '$stages')");
            continue;
        }

        // $row["date_submitted"];
        // $row["date_appraised"];
        // $row["stages"];
        // if prrlist already have existing datesub or date_appraised skip update 

        $sql = "";

        if (!$row["date_submitted"] && !$row["date_appraised"] && ($row["stages"] == "C")) {
            $sql = "UPDATE `prrlist` SET `date_submitted`='$date_submitted',`date_appraised`='$date_appraised',`numerical`='$numerical',`adjectival`='$adjectival',`comments`='$comments',`stages`='$stages' WHERE `prr_id`='$prr_id' AND `employees_id`='$employees_id'";
        } elseif ($row["date_submitted"] && !$row["date_appraised"] && ($row["stages"] == "C")) {
            $sql = "UPDATE `prrlist` SET `date_appraised`='$date_appraised',`numerical`='$numerical',`adjectival`='$adjectival',`comments`='$comments',`stages`='$stages' WHERE `prr_id`='$prr_id' AND `employees_id`='$employees_id'";
        } elseif ($row["date_submitted"] && $row["date_appraised"] && ($row["stages"] == "C")) {
            $sql = "UPDATE `prrlist` SET `numerical`='$numerical',`adjectival`='$adjectival',`comments`='$comments',`stages`='$stages' WHERE `prr_id`='$prr_id' AND `employees_id`='$employees_id'";
        } elseif ($row["date_submitted"] && $row["date_appraised"] && ($row["stages"] != "C")) {
            $sql = "UPDATE `prrlist` SET `numerical`='$numerical',`adjectival`='$adjectival',`comments`='$comments' WHERE `prr_id`='$prr_id' AND `employees_id`='$employees_id'";
        }

        if (!$row["date_appraised"] || $row["date_appraised"] == "0000-00-00") {
            if (!$date_appraised) {
                $date_appraised = "0000-00-00";
            }
            $sql_dates = "UPDATE `prrlist` SET `date_appraised`='$date_appraised' WHERE `prr_id`='$prr_id' AND `employees_id`='$employees_id'";
            $mysqli->query($sql_dates);
        }

        if (!$row["date_submitted"] || $row["date_submitted"] == "0000-00-00") {
            if (!$date_submitted) {
                $date_submitted = "0000-00-00";
            }
            $sql_dates = "UPDATE `prrlist` SET `date_submitted`='$date_submitted' WHERE `prr_id`='$prr_id' AND `employees_id`='$employees_id'";
            $mysqli->query($sql_dates);
        }


        // $test[] = $sql;

        if (!$sql) {
            continue;
        } else $mysqli->query($sql);
    }


    # perform check from online pms
    # get list of `employee_id` from `spms_performancereviewstatus` that are casual and active
    # SELECT * FROM `spms_performancereviewstatus` LEFT JOIN `employees` ON `spms_performancereviewstatus`.`employees_id` = `employees`.`employees_id` WHERE `employees`.`status` = 'ACTIVE' AND `employees`.`employmentStatus` = 'CASUAL' AND `spms_performancereviewstatus`.`period_id` = '2';
    # get row data: `date_submitted`, `date_appraised`, `numerical`, `adjectival` and `comments`
    # get `stages`
    # get `prr_id` using `period` and `year`
    # using `prr_id` and `employee_id` check if personnel has entry in `prrlist`
    # if none insert row
    # if existing always update row 

    $data = get_employees($mysqli, $prr_id);
    echo json_encode($data);
    // echo json_encode($test);

    /*
        to make changes on spms_performancereviewstatus for records earlier than 2022
    */
    // update_spms_performancereviewstatus($mysqli, 2);
} elseif (isset($_POST["get_emps"])) {
    echo json_encode(emp($mysqli));
} elseif (isset($_POST["get_ova_rates"])) {
    $prr_id = $_POST["prr_id"];
    echo json_encode(Ov_rates($mysqli, $prr_id));
}


function fetch_data_online_pms($mysqli, $period, $year, $type)
{

    $data = [];
    if (!$period || !$year || !$type) return false;
    # get period id
    $sql = "SELECT `mfoperiod_id` FROM `spms_mfo_period` WHERE `month_mfo` = '$period' AND `year_mfo` = '$year';";
    $res = $mysqli->query($sql);
    # mfoperiod_id
    $period_id = $res->fetch_assoc()["mfoperiod_id"];

    if (!$period_id) return false;


    $pms = new Pms();
    $pms->set_period_id($period_id);

    $sql = "SELECT * FROM `spms_performancereviewstatus` LEFT JOIN `employees` ON `spms_performancereviewstatus`.`employees_id` = `employees`.`employees_id` WHERE `employees`.`status` = 'ACTIVE' AND `employees`.`employmentStatus` = '$type' AND `spms_performancereviewstatus`.`period_id` = '$period_id' ORDER BY `employees`.`lastName` ASC";

    $res = $mysqli->query($sql);

    // $csid = substr($year, -2) . "001";


    while ($row = $res->fetch_assoc()) {

        $employee_id = $row["employees_id"];
        $department_id = $row["department_id"];

        $datum = [
            "employees_id" => $employee_id,
            "date_submitted" => format_date_ymd($row["dateAccomplished"]),
            "date_appraised" => format_date_ymd($row["panelApproved"]),
            "numerical" => [],
            "adjectival" => "",
            "comments" => "",
            "stages" => "C",
            // "period_id" => $period_id,
            "department_id" => $department_id,
        ];

        $data[] = $datum;
    }

    if (count($data) < 1) return false;

    foreach ($data as $key => $pcr) {
        $employee_id = $pcr["employees_id"];
        $department_id = $pcr["department_id"];
        $pms->set_employee_id($employee_id);
        $pms->set_department_id($department_id);
        $data[$key]["numerical"] = $pms->get_final_numerical_rating();
        $data[$key]["adjectival"] = $pms->get_final_adjectival_rating();
        $data[$key]["comments"] = $pms->get_comments_and_recommendations();
        // C !dateAccomplished
        // Y !panelApproved
        // W  panelApproved && dateAccomplished
        if (!$pcr["date_submitted"]) {
            $data[$key]["stages"] = "C";
        } elseif ($pcr["date_submitted"] && !$pcr["date_appraised"]) {
            $data[$key]["stages"] = "Y";
        } elseif ($pcr["date_submitted"] && $pcr["date_appraised"]) {
            $data[$key]["stages"] = "W";
        }
    }

    # get row data: `date_submitted`, `date_appraised`, `numerical`, `adjectival` and `comments`

    return $data;
}

function update_spms_performancereviewstatus($mysqli, $period_id)
{
    if (!$period_id) return false;
    $sql = "SELECT * FROM prrlist WHERE prr_id = 20;";
    $data = [];
    $res = $mysqli->query($sql);
    while ($row = $res->fetch_assoc()) {

        $row = [
            "employees_id" => $row["employees_id"],
            "date_submitted" => format_date($row["date_submitted"]),
            "date_appraised" => format_date($row["date_appraised"]),
        ];
        $data[] = $row;
    }

    $queries = [];
    foreach ($data as $key => $value) {

        $employees_id = $value["employees_id"];

        if (!$employees_id) continue;

        $dateAccomplished = $value["date_submitted"];
        $panelApproved = $value["date_appraised"];

        if (!$panelApproved && !$dateAccomplished) continue;

        if ($panelApproved) {
            $panelApproved = "`panelApproved`= '$panelApproved'";
        } else {
            $panelApproved = "";
        }

        if ($dateAccomplished) {
            $dateAccomplished = "`dateAccomplished`= '$dateAccomplished'";
        } else {
            $dateAccomplished = "";
        }

        $inputs = "";
        if ($panelApproved && $dateAccomplished) {
            $inputs = "$panelApproved , $dateAccomplished";
        } elseif ($panelApproved && !$dateAccomplished) {
            $inputs = "$panelApproved";
        } elseif (!$panelApproved && $dateAccomplished) {
            $inputs = "$dateAccomplished";
        }

        $sql = "UPDATE `spms_performancereviewstatus` SET $inputs WHERE `employees_id` = '$employees_id' AND `period_id` = '$period_id'";
        // $mysqli->query($sql);
        // $queries[] = $sql;
    }

    // return $queries;
}
function format_date($date)
{
    if (!$date || $date == "0000-00-00") return "";
    $date = date_create($date);
    return date_format($date, "m/d/y");
}

function format_date_ymd($date)
{
    if (!$date || $date == "0000-00-00") return "0000-00-00";
    $date = date_create($date);
    return date_format($date, "Y-m-d");
}
# perform check from online pms
# get list of `employee_id` from `spms_performancereviewstatus` that are casual and active
# SELECT * FROM `spms_performancereviewstatus` LEFT JOIN `employees` ON `spms_performancereviewstatus`.`employees_id` = `employees`.`employees_id` WHERE `employees`.`status` = 'ACTIVE' AND `employees`.`employmentStatus` = 'CASUAL' AND `spms_performancereviewstatus`.`period_id` = '2';

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
    while ($row = $result1->fetch_assoc()) {
        $row["csid"] = $csid++;
        $row["middleName"] = $row["middleName"] ? $row["middleName"][0] : "";
        $row["gender"] = $row["gender"] ? $row["gender"][0] : "";
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
    while ($row = $result->fetch_assoc()) {
        $employees_id = $row["employees_id"];
        $sql1 = "SELECT * from prrlist where prr_id='$_POST[prr_id]' AND employees_id='$employees_id'";
        $result2 = $mysqli->query($sql1);
        $row2 = $result2->fetch_assoc();
        if ($row['gender'] == "MALE") {
            if ($row2['adjectival'] == 'O') {
                $MO++;
            } elseif ($row2['adjectival'] == 'VS') {
                $MV++;
            } elseif ($row2['adjectival'] == 'S') {
                $MS++;
            } elseif ($row2['adjectival'] == 'US') {
                $MU++;
            } else {
                $MP++;
            }
        } elseif ($row['gender'] == "FEMALE") {
            if ($row2['adjectival'] == 'O') {
                $FO++;
            } elseif ($row2['adjectival'] == 'VS') {
                $FV++;
            } elseif ($row2['adjectival'] == 'S') {
                $FS++;
            } elseif ($row2['adjectival'] == 'US') {
                $FU++;
            } else {
                $FP++;
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
            "total" => $FO + $MO
        ],
        [
            "row" => "VERY SATISFACTORY",
            "female" => $FV,
            "male" => $MV,
            "total" => $FV + $MV
        ],
        [
            "row" => "SATISFACTORY",
            "female" => $FS,
            "male" => $MS,
            "total" => $FS + $MS
        ],
        [
            "row" => "UNSATISFACTORY",
            "female" => $FU,
            "male" => $MU,
            "total" => $FU + $MU
        ],
        [
            "row" => "POOR",
            "female" => $FP,
            "male" => $MP,
            "total" => $FP + $MP
        ],
        [
            "row" => "TOTAL",
            "female" => $FT,
            "male" => $MT,
            "total" => $FT + $MT
        ],
    ];
    return $arr;
}
