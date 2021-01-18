<?php
require "../_connect.db.php";

if (isset($_POST["get_data"])) {
    $employee_id = $_POST["employee_id"];
    $sql = "SELECT * FROM `appointments` 
    LEFT JOIN `employees` ON `appointments`.`employee_id` = `employees`.`employees_id` 
    LEFT JOIN `plantillas` ON `appointments`.`plantilla_id` = `plantillas`.`id`
    LEFT JOIN `department` ON `plantillas`.`department_id` = `department`.`department_id`
    LEFT JOIN `positiontitles` ON `plantillas`.`position_id` = `positiontitles`.`position_id`
    WHERE `appointments`.`employee_id` = '$employee_id'";
    $result = $mysqli->query($sql);

while ($row = $result->fetch_assoc()) {
    if ($row) {
        $salary_sql = "SELECT
                        setup_salary_adjustments_setup.monthly_salary
                    FROM
                        setup_salary_adjustments_setup
                        LEFT JOIN
                        setup_salary_adjustments
                        ON 
                            setup_salary_adjustments_setup.parent_id = setup_salary_adjustments.id
                    WHERE
                        setup_salary_adjustments.`schedule` = $row[schedule] AND
                        setup_salary_adjustments_setup.step_no = $row[step] AND
                        setup_salary_adjustments_setup.salary_grade = $row[salaryGrade] AND
                        setup_salary_adjustments.active = 1";

        $res = $mysqli->query($salary_sql);
        $salary_data = $res->fetch_assoc();
        $row["monthly_salary"] = $salary_data["monthly_salary"];
    }
    $data[] = $row;
}
    
    // $data = $result->fetch_assoc();

    // if ($row) {
    //     $salary_sql = "SELECT
    //                     setup_salary_adjustments_setup.monthly_salary
    //                 FROM
    //                     setup_salary_adjustments_setup
    //                     LEFT JOIN
    //                     setup_salary_adjustments
    //                     ON 
    //                         setup_salary_adjustments_setup.parent_id = setup_salary_adjustments.id
    //                 WHERE
    //                     setup_salary_adjustments.`schedule` = $row[schedule] AND
    //                     setup_salary_adjustments_setup.step_no = $row[step] AND
    //                     setup_salary_adjustments_setup.salary_grade = $row[salaryGrade] AND
    //                     setup_salary_adjustments.active = 1";

    //     $result = $mysqli->query($salary_sql);
    //     $salary_data = $result->fetch_assoc();
    //     $row["monthly_salary"] = $salary_data["monthly_salary"];
    // }

    echo json_encode($data);
}
