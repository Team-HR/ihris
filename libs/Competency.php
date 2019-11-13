<?php

class Competency
{
	private $competencies = array();
	private $competenciesMale = array();
	private $competenciesFemale = array();
	private $mysqli;

	function __construct(){

		require '_connect.db.php';
		require 'libs/NameFormatter.php';
		$this->mysqli = $mysqli;

		$this->competencies = $this->queryData("");
		$this->competenciesMale = $this->queryData("AND `employees`.`gender` = 'MALE'");
		$this->competenciesFemale = $this->queryData("AND `employees`.`gender` = 'FEMALE'");

	}


private function queryData($gender){

		$types = array(
			'Adaptability',
			'ContinousLearning',
			'Communication',
			'OrganizationalAwareness',
			'CreativeThinking',
			'NetworkingRelationshipBuilding',
			'ConflictManagement',
			'StewardshipofResources',
			'RiskManagement',
			'StressManagement',
			'Influence',
			'Initiative',
			'TeamLeadership',
			'ChangeLeadership',
			'ClientFocus',
			'Partnering',
			'DevelopingOthers',
			'PlanningandOrganizing',
			'DecisionMaking',
			'AnalyticalThinking',
			'ResultsOrientation',
			'Teamwork',
			'ValuesandEthics',
			'VisioningandStrategicDirection'
		);

		$competencies = array();

		foreach ($types as $index => $type) {
			$levels = array(
				1 => array(),
				2 => array(),
				3 => array(),
				4 => array(),
				5 => array()
			);

			foreach ($levels as $level => $ids) {

				$sql = "SELECT `competency`.`employees_id`,`employees`.`firstName`,`employees`.`lastName`,`employees`.`middleName`,`employees`.`extName`,`employees`.`gender` FROM `competency` LEFT JOIN `employees` ON `competency`.`employees_id` = `employees`.`employees_id` WHERE `competency`.`$type` = '$level' $gender ORDER BY `employees`.`lastName` ASC";

				$result = $this->mysqli->query($sql);
				while ($row = $result->fetch_assoc()) {
					$employees_id = $row["employees_id"];
					array_push($levels[$level], array('employees_id'=>$employees_id,'fullName'=>(new NameFormatter($row["firstName"],$row["lastName"],$row["middleName"],$row["extName"]))->getFullName()));
				}

			}

			$competencies[$index] = $levels;

		}

		return $competencies;
}


	public function getData($competency,$level){
		return $this->competencies[$competency][$level];
	}

	public function getDataMale($competency,$level){
		return $this->competenciesMale[$competency][$level];
	}

	public function getDataFemale($competency,$level){
		return $this->competenciesFemale[$competency][$level];
	}

}



?>
