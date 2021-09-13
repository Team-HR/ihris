<?php
require_once "_connect.db.php";
session_start();

// fetch events for view only
if (isset($_GET['fetch_events'])) {
    $employee_id = $_GET['employees_id'];
    $employee_id = $mysqli->real_escape_string($employee_id);
    $department_id = null;
    $data = [];
    // get department_id start
    $sql = "SELECT `department_id` FROM `employees` WHERE `employees_id` = '$employee_id'";
    $result = $mysqli->query($sql);
    if ($row = $result->fetch_assoc()) {
        $department_id = $row['department_id'];
    }
    // get department_id end

    // get events via employees_id start
    $sql = "SELECT * FROM `calendar` WHERE `employee_id` = '$employee_id'";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $allDay = $row["allDay"] == 1 ? true : false;
        $start_date = $row["start_date"];
        $end_date = $row["end_date"];
        $start_time = $row["start_time"];
        $end_time = $row["end_time"];
        $title = $row["title"];
        $privacy = $row["privacy"];
        // $description = $row["description"];
        $color = "";

        if ($privacy == 'onlyme') {
            $color = "green";
        } elseif ($privacy == 'mydepartment') {
            $color = "orange";
        } elseif ($privacy == 'everyone') {
            $color = "";
        }

        $start = $start_date;
        $end = $end_date;

        if ($allDay) {
            $end = new DateTime($end_date); // For today/now, don't pass an arg.
            $end->modify("+1 day");
            $end = $end->format("Y-m-d");
        } else {
            $start = $start_date . 'T' . $start_time;
            $end = $end_date . 'T' . $end_time;
        }

        $data[] = [
            "id" => $id,
            "title" => $title,
            "allDay" => $allDay,
            "start" =>  $start,
            "end" =>  $end,
            "color" => $color
        ];
    }
    // get events via employees_id end
    echo json_encode($data);
} elseif (isset($_POST["submit_create_event"])) {
    $employee_id = $_POST["employees_id"];
    $event = $_POST["event"];

    $title = $mysqli->real_escape_string($event["title"]);
    $description = $mysqli->real_escape_string($event["description"]);
    $allDay = $mysqli->real_escape_string($event["allDay"]);
    $start_date = $mysqli->real_escape_string($event["start_date"]);
    $end_date = $mysqli->real_escape_string($event["end_date"]);
    $start_time = $mysqli->real_escape_string($event["start_time"]);
    $end_time = $mysqli->real_escape_string($event["end_time"]);
    $privacy = $mysqli->real_escape_string($event["privacy"]);

    $allDay = $allDay ? 1 : 0;
    $department_id = null;
    // if privacy == department
    // get department_id start
    if ($privacy == 'mydepartment') {
        $sql = "SELECT `department_id` FROM `employees` WHERE `employees_id` = '$employee_id'";
        $result = $mysqli->query($sql);
        if ($row = $result->fetch_assoc()) {
            $department_id = $row['department_id'];
        }
    }
    // get department_id end

    $sql = "INSERT INTO `calendar` (`id`, `allDay`, `start_date`, `end_date`, `start_time`, `end_time`, `title`, `description`, `department_id`, `employee_id`, `privacy`, `created_at`, `updated_at`) VALUES (NULL, '$allDay', '$start_date', '$end_date', '$start_time', '$end_time', '$title', '$description', '$department_id', '$employee_id', '$privacy', current_timestamp(), current_timestamp())";
    $mysqli->query($sql);

    echo json_encode($event);
}
