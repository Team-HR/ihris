<?php
require_once "Controller.php";

class Department extends Controller
{
	function __construct()
	{
		parent::__construct();
	}

	public function getData($id)
	{
		$mysqli = $this->mysqli;
		$sql = "SELECT * FROM `department` WHERE `department_id` = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = $result->fetch_assoc();
		$stmt->close();
		return $data;
	}

	public function get_departments()
	{

		$mysqli2 = $this->mysqli2;
		$data = [];
		$sql = "SELECT * FROM `departments` ORDER BY `department` ASC";
		$res = $mysqli2->query($sql);

		while ($row = $res->fetch_assoc()) {
			$data[] = [
				"department_id" => $row["id"],
				"department" => $row["department"]
			];
		}
		return $data;
	}

	public function getDepartment($id)
	{
		$mysqli = $this->mysqli;
		$department = "";
		$sql = "SELECT `department` FROM `department` WHERE `department_id` = ?";

		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("i", $id);
		$stmt->execute();

		$stmt->store_result();
		$stmt->bind_result($department);
		$stmt->fetch();

		$stmt->close();

		return $department;
	}
	public function getDepartmentData($id)
	{
		$mysqli = $this->mysqli;
		$department = "";
		$sql = "SELECT * FROM `department` WHERE `department_id` = '$id'";

		$res = $mysqli->query($sql);
		if ($row = $res->fetch_assoc()) {
			$department = $row;
		}
		return $department;
	}
}
