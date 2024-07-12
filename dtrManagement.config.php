<?php
require_once "_connect.db.php";


if (isset($_POST['getRows'])) {
    $rows = [];
    $employee_id = $_POST['employee_id'];
    $monthYear = $period =  $_POST['monthYear'];
    $monthYear = explode("-", $monthYear);

    $year = intval($monthYear[0]);
    $month = intval($monthYear[1]);

    $dtrNo = "";
    $sql = "SELECT * FROM `employees_card_number` WHERE `employees_id` = '$employee_id'";
    $res = $mysqli->query($sql);

    if ($row = $res->fetch_assoc()) {
        $dtrNo = $row["dtrno"];
    }

    // $month = 6;
    // $year = 2024;
    $rows = [];

    $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    $timesTardy = 0;
    $totalTardy = 0;
    $totalUndertime = 0;


    // for DtrSummary vars start
    $halfDaysTardy = [];
    $halfDaysUndertime = [];
    $allRemarks = [];

    $dtr_issubmitted = false;

    $check_dtrissubmitted_qry = "SELECT * FROM `dtrsummary` WHERE `employee_id` = '$employee_id' AND `month` = '$period'";
    $check_dtrissubmitted_res = $mysqli->query($check_dtrissubmitted_qry);

    if ($check_dtrissubmitted_row = $check_dtrissubmitted_res->fetch_assoc()) {
        $dtr_issubmitted = $check_dtrissubmitted_row["submitted"] == 1 ? true : false;
    }

    $url = "http://192.168.50.51:8084/getDtrsFromHRIS_v2.php?dtrNo=$dtrNo&year=$year&month=$month";
    $dtrs = file_get_contents($url);
    $dtrs = json_decode($dtrs, true);
    $dtrs = count($dtrs) > 0 ? $dtrs : [];

    for ($i = 1; $i <= $days; $i++) {

        $tardyAm = 0;
        $tardyPm = 0;
        $undertimeAm = 0;
        $underTimePm = 0;
        $other = "";
        $isConfirmed = false;

        $amIn = '';
        $amOut = '';
        $pmIn = '';
        $pmOut = '';

        $month = str_pad($month, 2, "0", STR_PAD_LEFT);
        $i = str_pad($i, 2, "0", STR_PAD_LEFT);

        $dtr_date = "$year-$month-$i";

        // $sql = "SELECT * FROM `dtr` WHERE `empID` = '$dtrNo' AND YEAR(`attendDate`) = '$year' AND MONTH(`attendDate`) = '$month' AND DAY(`attendDate`) = '$i' ORDER BY `attendDate` ASC";
        // $res = $mysqli3->query($sql);
        $row = null;
        foreach ($dtrs as $key => $dtr) {
            if ($dtr['attendDate'] == $dtr_date) {
                $row = $dtr;
                break;
            }
        }
        //  if ($row = $res->fetch_assoc()) {
        if ($row) {

            $amIn = $row["amIn"];
            $amOut = $row["amOut"];
            $pmIn = $row["pmIn"];
            $pmOut = $row["pmOut"];



            $dtrmanagement_sql = "SELECT * FROM `dtrmanagement` WHERE `emp_id` = '$employee_id' AND `dtr_date` = '$dtr_date'";
            $dtrmanagement_res = $mysqli->query($dtrmanagement_sql);
            $dtrmanagement_row = "";
            if ($dtrmanagement_row = $dtrmanagement_res->fetch_assoc()) {
                $tardyAm = $dtrmanagement_row["amTardy"] ? intval($dtrmanagement_row["amTardy"]) : 0;
                $tardyPm = $dtrmanagement_row["pmTardy"] ? intval($dtrmanagement_row["pmTardy"]) : 0;
                $undertimeAm = $dtrmanagement_row["amUnder"] ? intval($dtrmanagement_row["amUnder"]) : 0;
                $underTimePm = $dtrmanagement_row["pmUnder"] ? intval($dtrmanagement_row["pmUnder"]) : 0;
                $other = $dtrmanagement_row["other"];
                $isConfirmed = true;
                if ($tardyAm > 0 || $tardyPm > 0) {
                    $timesTardy += 1;
                }
                $totalTardy += ($tardyAm + $tardyPm);
                $totalUndertime += ($undertimeAm + $underTimePm);
            } else {
                if ($row["amIn"] != '00:00:00' && $row["amOut"] != '00:00:00') {
                    $tardyAm = getMinutesDifference('08:00:00', $row["amIn"]);
                    $undertimeAm = getMinutesDifference($row["amOut"], '12:00:00');
                } else if ($row["amIn"] == '00:00:00' && $row["amOut"] == '00:00:00') {
                    $tardyAm = 240;
                }

                if ($row["pmIn"] != '00:00:00' && $row["pmOut"] != '00:00:00') {
                    $tardyPm = getMinutesDifference('13:00:00', $row["pmIn"]);
                    $underTimePm = getMinutesDifference($row["pmOut"], '17:00:00');
                } else if ($row["pmIn"] == '00:00:00' && $row["pmOut"] == '00:00:00') {
                    $underTimePm = 240;
                }
            }
        } else {

            $date = "$year-$month-$i";
            $date = new DateTime($date);
            $date = $date->format("Y-m-d");


            $dtrmanagement_sql = "SELECT * FROM `dtrmanagement` WHERE `emp_id` = '$employee_id' AND `dtr_date` = '$dtr_date'";
            $dtrmanagement_res = $mysqli->query($dtrmanagement_sql);
            $dtrmanagement_row = "";
            if ($dtrmanagement_row = $dtrmanagement_res->fetch_assoc()) {
                $tardyAm = $dtrmanagement_row["amTardy"] ? intval($dtrmanagement_row["amTardy"]) : 0;
                $tardyPm = $dtrmanagement_row["pmTardy"] ? intval($dtrmanagement_row["pmTardy"]) : 0;
                $undertimeAm = $dtrmanagement_row["amUnder"] ? intval($dtrmanagement_row["amUnder"]) : 0;
                $underTimePm = $dtrmanagement_row["pmUnder"] ? intval($dtrmanagement_row["pmUnder"]) : 0;
                $other = $dtrmanagement_row["other"];
                $isConfirmed = true;
                if ($tardyAm > 0 || $tardyPm > 0) {
                    $timesTardy += 1;
                }
                $totalTardy += ($tardyAm + $tardyPm);
                $totalUndertime += ($undertimeAm + $underTimePm);
            }

            // 
            //   
        }

        // for dtr summary start
        if ($tardyAm == 240) {
            $halfDaysTardy[] = str_pad(explode("-", $dtr_date)[2], 2, "0", STR_PAD_LEFT);
        }
        if ($underTimePm == 240) {
            $halfDaysUndertime[] = str_pad(explode("-", $dtr_date)[2], 2, "0", STR_PAD_LEFT);
        }

        if ($other) {
            $allRemarks[] = str_pad(explode("-", $dtr_date)[2], 2, "0", STR_PAD_LEFT) . "-" . $other;
        }

        // for dtr summary end

        $rows[] = [
            "attendDate" =>  $dtr_date,
            "day" => getNameOfDay($dtr_date),
            "amIn" => $amIn,
            "amOut" => $amOut,
            "pmIn" => $pmIn,
            "pmOut" => $pmOut,
            "tardyAm" => $tardyAm,
            "tardyPm" => $tardyPm,
            "undertimeAm" => $undertimeAm,
            "undertimePm" => $underTimePm,
            "tardies" => $tardyAm + $tardyPm,
            "undertimes" => $undertimeAm + $underTimePm,
            "other" => $other,
            "isConfirmed" => $isConfirmed
        ];
    }

    $data = [
        "employee" => $employee_id,
        "dtrno" => $dtrNo,
        "rows" => $rows,
        "period" => $period,
        "totalTardy" => $totalTardy,
        "timesTardy" => $timesTardy,
        "totalUndertime" => $totalUndertime,
        "halfDaysTardy" => $halfDaysTardy,
        "halfDaysUndertime" => $halfDaysUndertime,
        "allRemarks" => $allRemarks,
        "submitted" =>  $dtr_issubmitted
    ];


    // update DtrSumamry
    // updateDtrSummary($mysqli, $data);

    echo json_encode($data);
} elseif (isset($_POST["saveToDtrsummary"])) {
    $data = $_POST["data"];
    updateDtrSummary($mysqli, $data);
} elseif (isset($_POST["getEmployeesList"])) {
    $sql = "SELECT * FROM `employees` WHERE `status`='ACTIVE' ORDER BY `lastName` ASC";
    $data = [];

    $res = $mysqli->query($sql);

    while ($row = $res->fetch_assoc()) {
        $data[] = [
            "employees_id" => $row["employees_id"],
            "fullName" => $row["lastName"] . ", " . $row["firstName"] . "" . ($row["middleName"] ? " " . $row["middleName"][0] . "." : "") . ($row["extName"] ? " " . $row["extName"] : "")
        ];
    }

    echo json_encode($data);
} elseif (isset($_POST["saveActions"])) {
    $data = [];
    $selectedRow = $_POST["selectedRow"];

    // "attendDate":"2024-06-02",
    // "day":"SUN",
    // "tardyAm":"1",
    // "tardyPm":"1",
    // "undertimeAm":"1",
    // "undertimePm":"1",
    // "other":"1"

    $employee_id = $_POST['employee_id'];
    $attendDate = isset($selectedRow['attendDate']) ? $selectedRow['attendDate'] : '';
    $tardyAm = isset($selectedRow['tardyAm']) ? $selectedRow['tardyAm'] : '';
    $tardyPm = isset($selectedRow['tardyPm']) ? $selectedRow['tardyPm'] : '';
    $undertimeAm = isset($selectedRow['undertimeAm']) ? $selectedRow['undertimeAm'] : '';
    $undertimePm = isset($selectedRow['undertimePm']) ? $selectedRow['undertimePm'] : '';
    $other = isset($selectedRow['other']) ? $selectedRow['other'] : '';


    $check_qry = "SELECT * FROM `dtrmanagement` WHERE `dtr_date` = '$attendDate' AND `emp_id` = '$employee_id';";
    $res  = $mysqli->query($check_qry);

    if ($row = $res->fetch_assoc()) {
        $dtr_id = $row["dtr_id"];
        $update_qry = "UPDATE `dtrmanagement` SET `dtr_date`='$attendDate',`amTardy`='$tardyAm',`amUnder`='$undertimeAm',`emp_id`='$employee_id',`pmTardy`='$tardyPm',`pmUnder`='$undertimePm',`other`='$other' WHERE `dtr_id` = '$dtr_id'";
        $mysqli->query($update_qry);
        echo json_encode("updated!");
        exit;
    } else {
        $insert_qry = "INSERT INTO `dtrmanagement` (`dtr_id`, `dtr_date`, `amTardy`, `amUnder`, `emp_id`, `pmTardy`, `pmUnder`, `other`) VALUES (NULL, '$attendDate', '$tardyAm', '$undertimeAm', '$employee_id', '$tardyPm', '$undertimePm', '$other')";
        $mysqli->query($insert_qry);
        echo json_encode("inserted!");
        exit;
    }
    // echo json_encode($selectedRow);
} elseif (isset($_POST['dtrSubmitted'])) {
    $period = $_POST['period'];
    $emp_id = $_POST['emp_id'];
    $check = "SELECT * from dtrSummary where `month`='$period' and `employee_id`='$emp_id'";
    $check = $mysqli->query($check);
    $check = $check->fetch_assoc();
    if ($check) {
        $sql = "UPDATE `dtrSummary` SET `submitted` = 1 WHERE `dtrSummary_id` = '$check[dtrSummary_id]'";
    } else {
        $sql = "INSERT INTO `dtrSummary` (`dtrSummary_id`, `employee_id`, `month`, `submitted`) VALUES (NULL, '$emp_id', '$period','1')";
    }
    $sql = $mysqli->query($sql);

    echo json_encode(true);
} elseif (isset($_POST['dtrNotSubmitted'])) {
    $period = $_POST['period'];
    $emp_id = $_POST['emp_id'];
    $check = "SELECT * from dtrSummary where `month`='$period' and `employee_id`='$emp_id'";
    $check = $mysqli->query($check);
    $check = $check->fetch_assoc();
    if ($check) {
        $sql = "UPDATE `dtrSummary` SET `submitted` = '0' WHERE `dtrSummary_id` = '$check[dtrSummary_id]'";
    } else {
        $sql = "INSERT INTO `dtrSummary` (`dtrSummary_id`, `employee_id`, `month`, `submitted`) VALUES (NULL, '$emp_id', '$period','0')";
    }
    $sql = $mysqli->query($sql);
    echo json_encode(false);
}


function getNameOfDay($date)
{
    $date = new DateTime($date);
    return mb_convert_case($date->format('D'), MB_CASE_UPPER);
}

function getMinutesDifference($time1, $time2)
{
    // Create DateTime objects for both times
    $datetime1 = new DateTime($time1);
    $datetime2 = new DateTime($time2);

    // Calculate the difference between the two times
    $interval = $datetime1->diff($datetime2);

    // Convert the difference to total minutes
    $minutes = ($interval->h * 60) + $interval->i;

    // If the difference is negative, it means the first time is later in the day than the second
    if ($datetime1 > $datetime2) {
        $minutes = -$minutes;
    }

    return $minutes < 0 ? 0 : $minutes;
}

function updateDtrSummary($mysqli, $data)
{
    if (!$data['employee']) {
        return false;
    }
    $emp_id = $data['employee'];
    $period = $data['period'];

    $year = explode("-", $period);
    $year = $year[0];
    if ($year < 2020) {
        return false;
    }
    $totalTimesTardy = $data['timesTardy'];
    $totalMinsTardy = $data['totalTardy'];
    $totalMinUnderTime = $data['totalUndertime'];

    $halfDaysTardy = $data['halfDaysTardy'];
    if (count($halfDaysTardy)) {
        $halfDaysTardy = implode(",", $halfDaysTardy);
    } else $halfDaysTardy = "";

    $halfDaysUndertime = $data['halfDaysUndertime'];
    if (count($halfDaysUndertime)) {
        $halfDaysUndertime = implode(",", $halfDaysUndertime);
    } else $halfDaysUndertime = "";

    $remarksDtr = $data['allRemarks'];
    if (count($remarksDtr)) {
        $remarksDtr = implode(",", $remarksDtr);
    } else $remarksDtr = "";


    $check = "SELECT * FROM `dtrSummary` where `month`='$period' AND `employee_id`='$emp_id'";
    $check = $mysqli->query($check);
    $count = $check->num_rows;
    if ($count) {
        $datID = $check->fetch_assoc();
        $sql = "UPDATE `dtrSummary` SET 
                        `totalMinsTardy` = '$totalMinsTardy', 
                        `totalTardy` = '$totalTimesTardy', 
                        `totalMinsUndertime` = '$totalMinUnderTime',
                        `halfDaysTardy` = '$halfDaysTardy',
                        `halfDaysUndertime` = '$halfDaysUndertime',
                        `remarks` = '$remarksDtr'
                WHERE `dtrSummary`.`dtrSummary_id` ='$datID[dtrSummary_id]'";
    } else {
        $sql = "INSERT INTO `dtrSummary` (`dtrSummary_id`, `employee_id`, `month`, `totalMinsTardy`, `totalTardy`, `totalMinsUndertime`, `letterOfNotice`,`halfDaysTardy`,`halfDaysUndertime`,`remarks`,`submitted`) 
                            VALUES (NULL, '$emp_id', '$period', '$totalMinsTardy', '$totalTimesTardy', '$totalMinUnderTime', '0','$halfDaysTardy','$halfDaysUndertime','$remarksDtr','0')";
    }
    $sql = $mysqli->query($sql);
}
