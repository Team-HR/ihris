<?php

require_once "_connect.db.php";

if (isset($_POST["load"])) {
    $prr_id = $_POST["prr_id"];
    $type = $_POST["type"];
    $year = "SELECT * from prr where prr_id='$prr_id'";
    $year = $mysqli->query($year);
    $year = $year->fetch_assoc();
    $year = $year['year'];
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
