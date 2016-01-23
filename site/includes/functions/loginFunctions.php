<?php
/*
* Login Functions ------------------------------
*/

$guest = false;

$login_error = false;
if (isset($_REQUEST['login']))
{
  $login_error = !checkLogin();
}

checkLogout();
$logged_in = isLoggedIn();


/**
 * Check the user clicked the login button
 * return true if the login was successful.
 */
function checkLogin()
{
	global $db;
  if (isset($_REQUEST['login_user_name']) && isset($_REQUEST['login_password']))
  { 
    $isCorrectCred = checkCredentials($_REQUEST['login_user_name'], $_REQUEST['login_password']);
    if ($isCorrectCred)
    {
		if(validEmail($_REQUEST['login_user_name']))
		{
			$query = "SELECT * FROM user WHERE email = '".clean($_REQUEST['login_user_name'])."'";
			$result = mysqli_query($db, $query);

			while ($row = mysqli_fetch_assoc($result)) 
			{
                            
				$_SESSION['user_name'] = $row['username'] ;
				$_SESSION['user_id'] = $row['user_id'] ;
                        }
		}
		else
		{
			$query = "SELECT * FROM user WHERE username = '".clean($_REQUEST['login_user_name'])."'";
			$result = mysqli_query($db, $query);
			while ($row = mysqli_fetch_assoc($result)) 
			{
				$_SESSION['user_name'] = $row['username'];
				$_SESSION['user_id'] = $row['user_id'];
                        }
		}
		//update last login
		$user = $_SESSION['user_name'];
		
		$query = "UPDATE `user` SET  `last_log_in` = CURRENT_TIMESTAMP WHERE `username` = '".clean($user)."'";
		$result = mysqli_query($db, $query);
	  
		return true;
    }
    else 
    {
      return false;
    }
  }
}

/**
 * Check the user clicked the logout button.
 */
function checkLogout()
{
	global $db;
  if (isset($_REQUEST['logout']) && $_REQUEST['logout'] == TRUE)
  {
    if (isset($_SESSION['user_name']) AND isset($_SESSION['user_id']))
	{
		//update last log out
		$userID = $_SESSION['user_id'];
		
		$query = "UPDATE `user` SET  `last_log_out` = CURRENT_TIMESTAMP WHERE `user_id` = ".clean($userID);
		$result = mysqli_query($db, $query);
	
	
		unset($_SESSION['user_name']);
		unset($_SESSION['user_id']);
	}
  }
}

/**
 * Check the user name and password.
 * return true if the username and password are correct.
 */
function checkCredentials($username, $password)
{
	global $db,$guest;
	if(validEmail($username))
	{
		$query = "SELECT * FROM user WHERE email = '".clean($username)."'";
	}
	else
	{
		$query = "SELECT * FROM user WHERE username = '".clean($username)."'";
	}
	$result = mysqli_query($db, $query);
	if($result != false)
	{
		$row = mysqli_fetch_assoc($result);
		if($row)
		{
			$crypt_pass = crypt($password, $row["password"]);
			if($row["password"] == $crypt_pass)
			{
                            if ($row['role'] == 'guest')
                            {
                                $guest = true;
                                return false;
                               // return true;
                            }
                            else
                            {
                                $guest = false;
                                return true;
                            }
                        }
		}
	}
  return false;
}



/**
 * Check if the user is logged in.
 * return true if the user is logged in.
 */
function isLoggedIn()
{
  if(isset($_SESSION['user_name']) AND isset($_SESSION['user_id']))
  {
    return true;
  }
  return false;
}















?>