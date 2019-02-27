<?php

namespace Ifgiovanni\Holidays;

use DateTime;
use DateInterval;

use Illuminate\Database\Eloquent\Model;
use Ifgiovanni\Holidays\ElSalvador;

class Holiday extends Model
{
	protected $pais = "";
    protected $holidays = [];
	protected $weekend = [];

   	protected function getData($pais){
   		(env('HOLYDAYS_SATURDAY', false)) ? ($this->weekend = array('Sun' => '','Sat' => '')) : ($this->weekend = array('Sun' => ''));
   		($pais == "env") ? ($this->pais = env('HOLYDAYS_COUNTRY','')) : ($this->pais = $pais);
   		switch ($this->pais){
			case 'SV':
				$this->holidays = ElSalvador::getHolidays();
				break;
			default:
				$this->holidays = [];
				break;
		}
   	}

   	protected function getWorkingDays($days, $pais = "env", $startDate = "now"){
   		$this->getData($pais);
   		if($startDate == "now") $startDate = DateTime::createFromFormat('m-d', date('Y-m-d'));
	    $date       = new DateTime($startDate); 
	    $nextDay    = clone $date;
	    $i          = 0;
	    $nextDates  = array();
	 
	    while ($i < $days) {
	        $nextDay->add(new DateInterval('P1D'));
	        if (in_array($nextDay->format('m-d'), $this->holidays)) continue;
	        if (isset($this->weekend[$nextDay->format('D')])) continue;
	        $nextDates[] = $nextDay->format('Y-m-d');
	        $i++;
	    }
	    return $nextDates;
	}

	protected function getAWorkingDay($days, $pais = "env", $startDate = "now"){
		$this->getData($pais);
   		if($startDate == "now") $startDate = DateTime::createFromFormat('m-d', date('Y-m-d'));
	    $date       = new DateTime($startDate); 
	    $nextDay    = clone $date;
	    $i          = 0;
	    $nextDate   = new DateTime($startDate);
	    while ($i < $days) {
	        $nextDay->add(new DateInterval('P1D'));
	        if (in_array($nextDay->format('m-d'), $this->holidays)) continue;
	        if (isset($this->weekend[$nextDay->format('D')])) continue;
	        $nextDate = $nextDay->format('Y-m-d');
	        $i++;
	    }
	    return $nextDate;
	}

}
