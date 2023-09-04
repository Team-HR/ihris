<?php

/**
 * 
 */
class DateCompactor
{
	
public function compactDates($arr){
	$compDates = array();
	if ($arr) {
		sort($arr);
	
	$temp = array();

foreach ($arr as $key => $value) {
		$next = next($arr);
		if ($this->isConsecutive($value, $next)){
			array_push($temp, $value);
		} else {
			if (count($arr)>1) {
				array_push($compDates, !current($temp) ? $value : current($temp).",".$value);
				$temp = array();
			} else {
				array_push($compDates,$value);
			}
		}

}
	$view = "";
	foreach ($compDates as $key => $value) {
		$view .= "* ";
		 if(!strpos($value, ",")){
			$a = explode(",", $this->formatDate($value));
			$view .= "$a[0] $a[1], $a[2]";
		 } else {
		 	$val = explode(",", $value);
			$a = explode(",", $this->formatDate($val[0]));
			$b = explode(",", $this->formatDate($val[1]));
	
			if ($a[0] === $b[0] && $a[2] === $b[2]) {
				$view .= "$a[0] $a[1] to $b[1], $a[2]";
			} elseif ($a[0] !== $b[0] && $a[2] === $b[2]) {
				$view .= "$a[0] $a[1] to $b[0] $b[1], $a[2]";
			} elseif ($a[0] === $b[0] && $a[2] !== $b[2]) {
				$view .= "$a[0] $a[1], $a[2] to $b[0] $b[1], $b[2]";
			} elseif ($a[0] !== $b[0] && $a[2] !== $b[2]) {
				$view .= "$a[0] $a[1], $a[2] to $b[0] $b[1], $b[2]";
			}
		 }
		 $view .= "<br>";

	}

	return $view;

	} else {
	 		return -1;
		}
	}

private function formatDate($numeric_date){
	 	$date = new DateTime($numeric_date);
	 	$strDate = $date->format('M,d,Y');
		return $strDate;
}

private function isConsecutive($date_1 , $date_2)
{

 	$a = strtotime($date_1);
 	$b = strtotime($date_2);
	$diff = abs($a-$b);

    if ($diff === 86400) {
    	return true;
    } else {
    	return false;
    }
}

// private function isConsecutive($date_1 , $date_2 , $differenceFormat = '%a' )
// {
//     $datetime1 = date_create($date_1);
//     $datetime2 = date_create($date_2);
//     $interval = date_diff($datetime1, $datetime2);
//     $diff = $interval->format($differenceFormat);
//     if ($diff === "1") {
//     	return true;
//     } else {
//     	return false;
//     }
// }

}