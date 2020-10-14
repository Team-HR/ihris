<?php
require_once "_connect.db.php";
    $sql = "SELECT `monthly_salary` FROM `setup_salary_adjustments_setup` ORDER BY monthly_salary ASC";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $rslt = $stmt->get_result();
    $data = array();
    while ($row = $rslt->fetch_assoc()) {
        $yearly_salary = $row["monthly_salary"] * 12;
        $data[] = array(
            "text" => number_format($yearly_salary, 2, ".", ","),
            "value" => $yearly_salary,
        );
    }
    echo json_encode($data);