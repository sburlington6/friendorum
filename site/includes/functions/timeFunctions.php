<?php

/*
* Time Functions ------------------------------
*/
function nicetime($date)
{
    if(empty($date)) {
        return "No date provided";
    }
    
    $periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths         = array("60","60","24","7","4.35","12","10");
    
    $now             = time();
    $unix_date         = strtotime($date);
    
       // check validity of date
    if(empty($unix_date)) {    
        return "Bad date";
    }

    // is it future date or past date
    if($now >= $unix_date) {    
        $difference     = $now - $unix_date;
        $tense         = "ago";
        
    } else {
        $difference     = $unix_date - $now;
        $tense         = "from now";
    }
    
    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
        $difference /= $lengths[$j];
    }
    
    $difference = round($difference);
    
    if($difference != 1) {
        $periods[$j].= "s";
    }
    
    return "$difference $periods[$j] {$tense}";
}

//$date = "2012-07-04 17:45";
//echo  '<br/><br/><br/>'.nicetime($date); // 2 days ago

function time_elapsed_A($secs)
{
	$secs = time() - $secs;
    $bit = array(
        'y' => $secs / 31556926 % 12,
        'w' => $secs / 604800 % 52,
        'd' => $secs / 86400 % 7,
        'h' => $secs / 3600 % 24,
        'm' => $secs / 60 % 60,
        's' => $secs % 60
        );
        
    foreach($bit as $k => $v)
        if($v > 0)$ret[] = $v . $k;
        
    return join(' ', $ret).' ago';
    }


function convertTimestamp($timeStamp,$break = 'no')			// converts a timestamp to something more readable
{
	$year = substr($timeStamp, 0, 4);
	$month = substr($timeStamp, 5, 2);
	$day = substr($timeStamp, 8, 2);
	$hour = substr($timeStamp, 11, 2);
	$minSec = substr($timeStamp, 13, 6);
	$amORpm = "AM";
	
	switch ($month)
	{
		case 01:
		$month = "January";
		break;
		case 02:
		$month = "February";
		break;
		case 03:
		$month = "March";
		break;
		case 04:
		$month = "April";
		break;
		case 05:
		$month = "May";
		break;
		case 06:
		$month = "June";
		break;
		case 07:
		$month = "July";
		break;
		case 08:
		$month = "August";
		break;
		case 09:
		$month = "September";
		break;
		case 10:
		$month = "October";
		break;
		case 11:
		$month = "November";
		break;
		case 12:
		$month = "December";
		break;
	}
	
	switch ($hour)
	{
		case 00:
		$hour = "12";
		$amORpm = "AM";
		break;
		case 13:
		$hour = "01";
		$amORpm = "PM";
		break;
		case 14:
		$hour = "02";
		$amORpm = "PM";
		break;
		case 15:
		$hour = "03";
		$amORpm = "PM";
		break;
		case 16:
		$hour = "04";
		$amORpm = "PM";
		break;
		case 17:
		$hour = "05";
		$amORpm = "PM";
		break;
		case 18:
		$hour = "06";
		$amORpm = "PM";
		break;
		case 19:
		$hour = "07";
		$amORpm = "PM";
		break;
		case 20:
		$hour = "08";
		$amORpm = "PM";
		break;
		case 21:
		$hour = "09";
		$amORpm = "PM";
		break;
		case 22:
		$hour = "10";
		$amORpm = "PM";
		break;
		case 23:
		$hour = "11";
		$amORpm = "PM";
		break;
		case 24:
		$hour = "12";
		$amORpm = "PM";
		break;
	}
	
	$date = $month . " " . $day . ", " . $year . " " .  $hour . $minSec . $amORpm;
	$dateB = $month . " " . $day . ", " . $year . "<br/>" .  $hour . $minSec . $amORpm;
	
	if ($break == 'yes')
	{
		return $dateB;
	}
	else
	{
		return $date;
	}
}
?>