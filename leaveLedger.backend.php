<?php
require_once "_connect.db.php";


if (isset($_POST['getRows'])) {
    $rows = [];
    $employee_id = $_POST['employee_id'];
    $year = 2023;


    for ($i = 0; $i < 12; $i++) {
        $month = $i + 1;
        $period = strtotime("$year-$month");
        $rows[] = mb_convert_case(date('M Y', $period), MB_CASE_UPPER);

        $equivalentDayPerMin = 0.0020833;

        // $rows[] =  [
        //     "period" => mb_convert_case(date('M Y', $period), MB_CASE_UPPER),
        //     "vl_earned" => 1.25,
        //     "vl_balance" => null,
        //     "sl_earned" => 1.25,
        //     "sl_balance" => null,
        // ];

        $sql = "SELECT *, DAY(`dtr_date`) AS `day` FROM `dtrmanagement` WHERE `emp_id` = '$employee_id' AND year(`dtr_date`) = '$year' AND MONTH(`dtr_date`) = '$month';";
        $res = $mysqli->query($sql);

        while ($row = $res->fetch_assoc()) {
            $row["totalTardy"] = intval($row["amTardy"]) + intval($row["pmTardy"]);
            $row["totalTardyEquivalentDay"] = number_format($row["totalTardy"] * $equivalentDayPerMin, 3);
            $row["totalUnder"] = intval($row["amUnder"]) + intval($row["pmUnder"]);
            $row["totalUnderEquivalentDay"] = number_format($row["totalUnder"] * $equivalentDayPerMin, 3);

            $rows[] = [
                "dtr_id" => $row["dtr_id"],
                "day" => $row["day"],
                "totalTardy" => $row["totalTardy"],
                "totalTardyEquivalentDay" => $row["totalTardyEquivalentDay"],
                "totalUnder" => $row["totalUnder"],
                "totalUnderEquivalentDay" => $row["totalUnderEquivalentDay"],
                "other" => $row["other"]
            ];

            // $rows[] = $row;
        }
    }


    // testing
    $sql = "SELECT * FROM `dtr` WHERE `empID` = '000394' AND YEAR(`attendDate`) = '2024' AND MONTH(`attendDate`) = '6' ORDER BY `attendDate` ASC";
    $res = $mysqli3->query($sql);
    $data = [];
    while ($row = $res->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
}
