<?php
/*
* Formatting Functions ------------------------------
*/

$currentFile = $_SERVER["PHP_SELF"];
$parts = Explode('/', $currentFile);
$filename = $parts[count($parts) - 1];


function clean($value)
{ 
global $db;
    $escaped = mysqli_real_escape_string($db,$value);
    $cleanValue = filter_var($escaped, FILTER_SANITIZE_SPECIAL_CHARS);
    
    return $cleanValue;
}

function changeNames($string)		//pass a string like user_id get a string like User Id	
{
	$patterns = array();
	$patterns[0] = '/_/';
	$replacements = array();
	$replacements[0] = ' ';
	$new = preg_replace($patterns, $replacements, $string);

	$lowerCase =  strtolower($new);

	$newWord = ucwords($lowerCase);
	return $newWord;
}



?>