<?php

require_once "_connect.db.php";
require_once "./libs/models/Employee.php";


if (isset($_POST["get_period_label"])) {
    $period_label = "";
    if ($_POST["period"] == 21) {
        $period_label = "July - December 2021";
    } else {
        $period_label = "January - June 2022";
    }
    echo $period_label;
} elseif (isset($_POST["get_list"])) {
    $emp = new Employee();
    $period = $_POST["period"];
    # July - Dec 2021 (21)
    # 17,18 (Perm, Casual)
    # Jan - June 2022 (22)
    # 19, 20 (Perm, Casual)

    $periods = "";
    if ($period == 21) {
        $periods = "(17,18)";
    } else {
        $periods = "(19,20)";
    }

    $sql = "SELECT * FROM `prrlist` LEFT JOIN `employees` ON `prrlist`.`employees_id` = `employees`.`employees_id` WHERE `prrlist`.`prr_id` IN $periods ORDER BY `employees`.`lastName` ASC";

    $res = $mysqli->query($sql);
    $data = [];
    while ($row = $res->fetch_assoc()) {
        $data[] = [
            "employees_id" => $row["employees_id"],
            "name" => $emp->get_full_name_upper($row["employees_id"]),
            "rating" => $row["numerical"],
        ];
    }
    echo json_encode($data);
}
