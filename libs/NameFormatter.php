<?php
class NameFormatter
{
	private $firstName;
	private $lastName;
	private $middleName;
	private $extName;
	private $exts = array('JR', 'SR');

	function __construct($firstName, $lastName, $middleName, $extName)
	
	{
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->middleName = $middleName;
		$this->extName = $extName;
	}

	public function getFullName()
	{

		$firstName = $this->firstName;
		$lastName = $this->lastName;

		if ($this->middleName == ".") {
			$middleName = "";
		} else {
			$middleName	= $this->middleName;
			$middleName = $this->middleName[0] . ".";
		}

		$extName	=	strtoupper($this->extName);
		$exts = $this->exts;

		if (in_array(substr($extName, 0, 2), $exts)) {
			$extName = " " . mb_convert_case($extName, MB_CASE_TITLE, "UTF-8");
		} else {
			$extName = " " . $extName;
		}

		$fullname =  mb_convert_case("$lastName, $firstName $middleName", MB_CASE_TITLE, "UTF-8") . $extName;

		return $fullname;
	}

	public function getFullNameStandardUpper()
	{

		$firstName = $this->firstName;
		$lastName = $this->lastName;

		if ($this->middleName == ".") {
			$middleName = "";
		} else {
			$middleName	= $this->middleName;
			$middleName = " " . $this->middleName[0] . ". ";
		}

		$extName	=	strtoupper($this->extName);
		$exts = $this->exts;

		if (in_array(substr($extName, 0, 2), $exts)) {
			$extName = " " . mb_convert_case($extName, MB_CASE_UPPER, "UTF-8");
		} else {
			$extName = " " . $extName;
		}

		$fullname =  mb_convert_case("$firstName$middleName$lastName", MB_CASE_UPPER, "UTF-8") . $extName;

		return $fullname;
	}

	public function getFullNameStandardTitle()
	{

		$firstName = $this->firstName;
		$lastName = $this->lastName;

		if ($this->middleName == ".") {
			$middleName = "";
		} else {
			$middleName	= $this->middleName;
			$middleName = " " . $this->middleName[0] . ". ";
		}

		$extName	=	strtoupper($this->extName);
		$exts = $this->exts;

		if (in_array(substr($extName, 0, 2), $exts)) {
			$extName = " " . mb_convert_case($extName, MB_CASE_TITLE, "UTF-8");
		} else {
			$extName = " " . $extName;
		}

		$fullname =  mb_convert_case("$firstName $middleName $lastName", MB_CASE_TITLE, "UTF-8") . $extName;

		return $fullname;
	}
}
