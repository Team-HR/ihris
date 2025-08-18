<?php
require "../_connect.db.php";

if (isset($_POST["get_data"])) {
    $employee_id = $_POST["employee_id"];
    $sql = "SELECT * FROM `appointments` 
    LEFT JOIN `employees` ON `appointments`.`employee_id` = `employees`.`employees_id` 
    LEFT JOIN `plantillas` ON `appointments`.`plantilla_id` = `plantillas`.`id`
    LEFT JOIN `department` ON `plantillas`.`department_id` = `department`.`department_id`
    LEFT JOIN `positiontitles` ON `plantillas`.`position_id` = `positiontitles`.`position_id`
    WHERE `appointments`.`employee_id` = '$employee_id' ORDER BY `appointments`.`date_of_appointment` DESC";
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
            $row["date_of_appointment"] = dateToString($row["date_of_appointment"]);
            $row["nature_of_appointment"] = formatToTitleCase($row["nature_of_appointment"]);
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
} else if (isset($_POST["saveOathOfOffice"])) {
    $oathOfOffice = $_POST["oathOfOffice"];

    $appointment_id = $oathOfOffice['appointment_id'] ?? null;
    $address = $oathOfOffice['address'] ?? null;
    $govId_type = $oathOfOffice['govId_type'] ?? null;
    $govId_no = $oathOfOffice['govId_no'] ?? null;
    $govId_issued_date = $oathOfOffice['govId_issued_date'] ?? null;
    $sworn_date = $oathOfOffice['sworn_date'] ?? null;
    $sworn_in = $oathOfOffice['sworn_in'] ?? null;
    $appointing_authority = $oathOfOffice['appointing_authority'] ?? null;

    // Prepare statement
    $stmt = $mysqli->prepare("
    UPDATE appointments
    SET
        address = ?,
        govId_type = ?,
        govId_no = ?,
        govId_issued_date = ?,
        sworn_date = ?,
        sworn_in = ?,
        appointing_authority = ?
    WHERE appointment_id = ?
");

    // Bind parameters (all strings except appointment_id which is integer)
    $stmt->bind_param("sssssssi", $address, $govId_type, $govId_no, $govId_issued_date, $sworn_date, $sworn_in, $appointing_authority, $appointment_id);

    // Execute
    $stmt->execute();

    // Check if successful
    if ($stmt->affected_rows > 0) {
        echo "Appointment updated successfully.";
    } else {
        echo "No changes made or appointment not found.";
    }

    // Close
    $stmt->close();
    $mysqli->close();
    // return;
}


function dateToString($date)
{
    if (!$date) return false;
    $date = date_create($date);
    return date_format($date, 'F d,Y');
}

function formatToTitleCase($str)
{
    if (!$str) return false;
    return mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
}
