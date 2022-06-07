<?php
require_once "_connect.db.php";

if (isset($_POST["submit_form"])) {
    $employee_id = $_POST["employee_id"];
    $input = $_POST["input"];
    $current_password = $input["current_password"];
    $new_password = $input["new_password"];
    $new_password_confirm = $input["new_password_confirm"];

    // check if current password is equal to the db spms_accounts password
    $sql = "SELECT `password` FROM `spms_accounts` WHERE `employees_id` = '$employee_id'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $hash = $row["password"];

    $data = [
        "status" => null,
    ];

    // verify current password
    if (!password_verify($current_password, $hash)) {
        $data["status"] = "unauthorized";
        echo json_encode($data);
        return null;
    }

    // retype new password match
    if ($new_password !== $new_password_confirm) {
        $data["status"] = "mismatched";
        echo json_encode($data);
        return null;
    }

    // validate new password if empty
    $length = strlen($new_password) < 4;
    $empty = preg_match("/\\s/", $new_password);

    if ($length || $empty) {
        $data["status"] = "invalid";
        echo json_encode($data);
        return null;
    }

    $hash = password_hash($new_password, PASSWORD_DEFAULT);
    $sql = "UPDATE `spms_accounts` SET `password` = '$hash' WHERE `employees_id` = '$employee_id'";
    $mysqli->query($sql);

    echo json_encode($data);
}
