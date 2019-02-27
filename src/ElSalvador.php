<?php

namespace Ifgiovanni\Holidays;

use DateTime;
use DateInterval;

use Illuminate\Database\Eloquent\Model;

class ElSalvador extends Model
{
	
   	protected function getHolidays(){
   		return $this->holidays;
   	}

    protected $holidays = [];

	public function __construct() {
		$this->holidays["New Year's Eve"] = '01-01';
		$this->holidays["Holy Thursday"] = $this->getEasterDay(3);
       	$this->holidays["Holy Friday"] = $this->getEasterDay(2);
       	$this->holidays["Holy Saturday"] = $this->getEasterDay(1);
	    $this->holidays["Labor Day"] = '05-01';
	    $this->holidays["Mothers Day"] = '05-10';
	    $this->holidays["Father's Day"] = '06-17';
	    $this->holidays["Independence Day"] = '09-15';
	    $this->holidays["Day of the Dead"] = '11-02';
	    $this->holidays["Christmas Day"] = '12-24';
   	}

	protected function getEasterDay($day){
		$fecha = explode('-', $this->Easter(date("Y")));
		return date("m-d", mktime(0,0,0,$fecha[1],$fecha[0]-$day,$fecha[2]));
	}

	private function Easter($anno){
	    $M = 24;
	    $N = 5;

	    $a = $anno % 19;
	    $b = $anno % 4;
	    $c = $anno % 7;
	    $d = (19*$a + $M) % 30;
	    $e = (2*$b+4*$c+6*$d + $N) % 7;

	    if ( $d + $e < 10 ) {
	        $dia = $d + $e + 22;
	        $mes = 3; 
	        }
	    else {
	        $dia = $d + $e - 9;
	        $mes = 4; 
	        }
	    if ( $dia == 26  and $mes == 4 ) { 
	        $dia = 19;
	        }
	    if ( $dia == 25 and $mes == 4 and $d==28 and $e == 6 and $a >10 ) { 
	        $dia = 18;
	        }
	    $ret = $dia.'-'.$mes.'-'.$anno;
		return ($ret);
	}

}
