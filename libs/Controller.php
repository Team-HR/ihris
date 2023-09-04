<?php
class Controller
{
	protected $mysqli;
	protected $mysqli2;

	function __construct()
	{
		$dirs = explode(DIRECTORY_SEPARATOR, __DIR__);
		$config_file = "_connect.db.php"; //database configuration that serves as identifier for where the project folder (ihris/ihris_dev) is
		$file_location = "";
		foreach ($dirs as $dir) {
			if (file_exists($file_location . $config_file)) {
				$config_file = $file_location . $config_file;
				break;
			}
			$file_location .= $dir . DIRECTORY_SEPARATOR;
		}
		require $config_file;
		$this->mysqli = $mysqli;
		$this->mysqli2 = $mysqli2;

		// CLASS LOADER
		$arr = [];
		foreach (new DirectoryIterator(__DIR__) as $file) {
			if ($file->isFile()) {
				$include = __DIR__ . DIRECTORY_SEPARATOR . $file->getFilename();
				require_once $include;
			}
		}
	}
}
