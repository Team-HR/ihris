<?php
require_once "Controller.php";

class CalendarController extends Controller
{
	private $employee_id = null;
	private $events = [];

	function __construct()
	{
		parent::__construct();
	}

	public function set_employee_id($employee_id)
	{
		if (!$employee_id) return null;
		$this->employee_id = $employee_id;
	}

	public function get_all_events()
	{
		$employee_id = $this->employee_id;
		if (!$employee_id) return null;
		$this->get_onlyme_events();
		$this->get_mydepartment_events();
		$this->get_everyone_events();
		return $this->events;
	}

	private function get_onlyme_events()
	{
		$employee_id = $this->employee_id;
		$sql = "SELECT * FROM `calendar` WHERE `employee_id` = '$employee_id' AND `privacy` = 'onlyme'";
		$this->get_events_query($sql);
	}

	private function get_mydepartment_events()
	{
		$employee_id = $this->employee_id;
		$department_id = null;
		// get department_id start
		$sql = "SELECT `department_id` FROM `employees` WHERE `employees_id` = '$employee_id'";
		$result = $this->mysqli->query($sql);
		if ($row = $result->fetch_assoc()) {
			$department_id = $row['department_id'];
		}
		// get department_id end
		if (!$department_id) return null;

		$sql = "SELECT * FROM `calendar` WHERE `department_id` = '$department_id' AND `privacy` = 'mydepartment'";
		$this->get_events_query($sql);

	}

	private function get_everyone_events()
	{
		$sql = "SELECT * FROM `calendar` WHERE `privacy` = 'everyone' AND `is_confirmed` = '1'";
		$this->get_events_query($sql);
	}

	private function get_events_query($sql)
	{
		if (!$sql) return null;
		$result = $this->mysqli->query($sql);
		while ($row = $result->fetch_assoc()) {
			$id = $row["id"];
			$allDay = $row["allDay"] == 1 ? true : false;
			$start_date = $row["start_date"];
			$end_date = $row["end_date"];
			$start_time = $row["start_time"];
			$end_time = $row["end_time"];
			$title = $row["title"];
			$privacy = $row["privacy"];
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

			$this->events[] = [
				"id" => $id,
				"title" => $title,
				"allDay" => $allDay,
				"start" =>  $start,
				"end" =>  $end,
				"employee_id" => $row["employee_id"],
				"privacy" => $privacy,
				"color" => $color,
				"url" => " "
			];
		}
	}


}
