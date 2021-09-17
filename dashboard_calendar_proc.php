<?php
require_once "_connect.db.php";
require_once "libs/CalendarController.php";
$calendar = new CalendarController;

session_start();

// fetch events for view only
if (isset($_GET['fetch_events'])) {
    $employee_id = $_GET['employees_id'];
    $calendar->set_employee_id($employee_id);
    $data = $calendar->get_all_events();
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

    $allDay = $allDay == "true" ? 1 : 0;
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
    $res = $mysqli->query($sql);
    echo json_encode($res);
}
