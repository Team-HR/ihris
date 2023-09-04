<?php

class FormatDateTime
{

	public function formatDate($numeric_date){
	 	$date = new DateTime($numeric_date);
	 	$strDate = $date->format('F d, Y');
		return $strDate;
	}

}

	

