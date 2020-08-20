<?php
require_once 'Model.php';

class Department extends Model
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
}
