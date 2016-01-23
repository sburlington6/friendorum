<?php
/*
* Validate Functions ------------------------------
*/

function validEmail($validate)
{
	$validEmailExpr = '/^[a-z0-9\-.]+@[a-z0-9\-]+\.[a-z0-9\-.]+$/i';
	if(preg_match($validEmailExpr, $validate) != 0)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}


?>