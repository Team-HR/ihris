<?php

class PcrTableClass
{
    private $trHead;
    private $trBody;
    private $trFoot;
    private $hideCol;
    private $budgetView;
    private $accountableView;
    private $dat;
    function __construct($h)
    {
        $this->hideCol = $h;
    }
    public function formType($type)
    {
        if ($type == 2) {
            $this->budgetView     = 'display:none';
        } else if ($type == 1) {
            $this->budgetView = 'display:none';
            $this->accountableView = 'display:none';
        }
    }
    public function set_body($data)
    {
        $this->trBody .= $data;
        $this->load();
    }
    public function set_head($data)
    {
        $this->trHead = $data;
        $this->load();
    }
    public function set_foot($data)
    {
        $this->trFoot = $data;
        $this->load();
    }
    private function load()
    {
        $col = "";
        if (!$this->hideCol) {
            $col = "<th rowspan='2' class='noprint' ><i class='ui cog icon'></th>";
        }
        $table = "
		$this->trHead
		<table border='1px' style='border-collapse:collapse;width:98%;margin:auto;'>
		<tr style='background:#00c4ff36;font-size:14px'>
		<th rowspan='2' style='padding:20px'>MFO / PAP</th>
		<th rowspan='2'>Success Indicator</th>
		<th rowspan='2' style='$this->budgetView'>Alloted Budget<br>for 2021 (whole<br>year)</th>
		<th  rowspan='2' style='$this->accountableView'>Individual/s or <br> Division Accountable</th>
		<th rowspan='2'>Actual Accomplishments</th>
		<th colspan='4' style='width:40px'>Rating Matrix</th>
		<th rowspan='2'>Remarks</th>
		<th rowspan='2' class='noprint' ><i class='ui blue folder icon'></i></th>
		$col
		</tr>
		<tr style='font-size:12px;background:#00c4ff36;font-size:14px'>
		<th>Q</th>
		<th>E</th>
		<th>T</th>
		<th>A</th>
		</tr>
		<tbody style='font-size:14px'>
		$this->trBody
		</tbody>
		</table>
		$this->trFoot
		";
        $this->dat = $table;
    }
    public function _get()
    {
        return $this->dat;
    }
}