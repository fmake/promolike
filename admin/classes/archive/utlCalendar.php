<?

class utlCalendar
{
    public $monthNames = array(
								'Январь', 'Февраль', 'Март', 'Апрель',   'Май',     'Июнь',
								'Июль',   'Август',  'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'
							   );

    public $daysInMonth = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

	public $D = null;
	public $M = null;
	public $Y = null;

    function __construct($d = null, $m = null, $y = null)
    {
		$this->D = ($d)?	$d	:	date("d");
		$this->M = ($m)?	$m	:	date("n");
		$this->Y = ($y)?	$y	:	date("Y");
    }

	function getFirstDay()
	{
		return date("w", mktime(12, 0, 0, $this->M, 1, $this->Y)) - 1;	// First day in month
	}

    function getDaysInMonth()
    {   
        $d = $this->daysInMonth[$this->M - 1];
   
        if ($this->M == 2)
        {        
            if ($this->Y%4 == 0)
            {
                if ($this->Y%100 == 0)
                {
                    if ($this->Y%400 == 0)
                    {
                        $d = 28;
                    }
                }
                else
                {
                    $d = 29;
                }
            }
        }
    
        return $d;
    }

	function getViewMonth($d = null, $m = null, $y = null)
	{
		$s = "";

		$d = ($d)?	$d	:	date("d");
		$m = ($m)?	$m	:	date("n");
		$y = ($y)?	$y	:	date("Y");

		$days_in_month = $this->getDaysInMonth($m, $y);		// Count days in month

		$first = date("w", mktime(12, 0, 0, $m, 1, $y));	// First day in month

		$monthName = $this->monthNames[$m - 1];				// Month Name
		
		$next = $this->getNext($m, $y);						// Get next month & year

		$prev = $this->getPrev($m, $y);						// Get prev month & year

		$header = $monthName." ".$y;

    	$s .= "<div class='calendar'>";

    	$s .= "<div class='mounth'>";
    	$s .= "<a href='/{$modul}/$d-{$next['month']}-{$next['year']}/' title='{$this->monthNames[$next['month'] - 1]} {$next['year']}'><img src='/images/arrright.gif' alt='{$this->monthNames[$next['month'] - 1]} {$next['year']}' width='34' height='22' align='right' /></a>";
    	$s .= "<a href='/{$modul}/$d-{$prev['month']}-{$prev['year']}/' title='{$this->monthNames[$prev['month'] - 1]} {$prev['year']}'><img src='/images/arrleft.gif' alt='{$this->monthNames[$prev['month'] - 1]} {$prev['year']}' width='34' height='22' align='left' /></a>";
    	$s .= "{$header}"; 
    	$s .= "</div>";

    	$s .= "<ul class='week'>";
    	$s .= "<li>" . $this->dayNames[($this->startDay)%7] .   "</li>";
    	$s .= "<li>" . $this->dayNames[($this->startDay+1)%7] .   "</li>";
    	$s .= "<li>" . $this->dayNames[($this->startDay+2)%7] .   "</li>";
    	$s .= "<li>" . $this->dayNames[($this->startDay+3)%7] .   "</li>";
    	$s .= "<li>" . $this->dayNames[($this->startDay+4)%7] .   "</li>";
    	$s .= "<li>" . $this->dayNames[($this->startDay+5)%7] .   "</li>";
    	$s .= "<li>" . $this->dayNames[($this->startDay+6)%7] .   "</li>";
    	$s .= "</ul>";
    	
    	$day = $this->startDay + 1 - $first;

    	while ($day > 1)
    	{
    	    $day -= 7;
    	}

		$s .= "<ul class='day'>";
    	
    	while ($day <= $days_in_month)
    	{
    	    for ($i = 0; $i < 7; $i++)
    	    {
    	        $s .= "<li>";       
    	        if ($day > 0 && $day <= $days_in_month)
    	        {
					if($i == 5 OR $i == 6 OR in_array($day, $nodays))
						$s .= $day;
					else
						$s .= "<a href='/{$modul}/{$day}-{$m}-{$y}/' ".(($day == $d)? "class='act'" : "").">$day</a>";
    	        }
    	        else
    	        {
    	            $s .= "&nbsp;";
    	        }
      	        $s .= "</li>";       
        	    $day++;
    	    }
    	}

    	$s .= "</ul></div>";
    	
    	return $s;
		
	}
}

?>
