<?php
require_once 'Model.php';
class Auth extends Model
{
    private $session = array();
    public $full_name = "";
    public $employee_id = 0;
    public $is_hr = false;

    function __construct()
    {   
        if (!$_SESSION) return null;
        $this->session = $_SESSION;
        $session = $this->session;
        $this->employee_id = $session["employee_id"];
        $this->full_name = $session["full_name"];
        $this->is_hr = in_array("HR",$session["roles"]);
        parent::__construct();
    }

    public function get_auth()
    {   
        return $this->session;
    }

}
