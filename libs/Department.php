<?php
// require 'libs/Database.php';

class Department
{
	private $mysqli;

	function __construct()
	{
		require $_SERVER["CONTEXT_DOCUMENT_ROOT"] . '/_connect.db.php';
		$this->mysqli = $mysqli;
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
		// require '_connect.db.php';
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
		// $mysqli->close();

		return $department;
	}
}
