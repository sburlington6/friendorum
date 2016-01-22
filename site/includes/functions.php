<?PHP
session_start();

$guest = false;

require("includes/connect.php");

$currentFile = $_SERVER["PHP_SELF"];
$parts = Explode('/', $currentFile);
$filename = $parts[count($parts) - 1];

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
		$validEmailExpr = '/^[a-z0-9\-.]+@[a-z0-9\-]+\.[a-z0-9\-.]+$/i';
		if(preg_match($validEmailExpr, $_REQUEST['login_user_name']) != 0)
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

/* creates a random salt for sha-512 password encryption*/
function makeSalt() 
{
	static $seed = "./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	$algo = '$6$';
	$strength = 'rounds=5000';
	$salt = '$';
	for ($i = 0; $i < 16; $i++) {
		$salt .= substr($seed, mt_rand(0, 63), 1);
	}
	$salt .= '$';
	return $algo . $strength . $salt;
}

/* creates a random password*/
function makePass() 
{
	$pass = "";
	static $options = "./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	for ($i = 0; $i < 30; $i++) {
		$pass .= substr($options, mt_rand(0, 63), 1);
	}
	return $pass;
}

/**
 * Check the user name and password.
 * return true if the username and password are correct.
 */
 
function checkCredentials($username, $password)
{
	global $db;
        global $guest;
	$validEmailExpr = '/^[a-z0-9\-.]+@[a-z0-9\-]+\.[a-z0-9\-.]+$/i';
	if(preg_match($validEmailExpr, $username) != 0)
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

/**
 * return the username from the session
 */
function getUserName()
{
  return $_SESSION['user_name'];
}

function getUserId ()					//returns the user_id of the user stored in the session
{
	return $_SESSION['user_id'];
}

function getRole ()
{
	global $db;
	$query = "SELECT * FROM user WHERE user_id = ".clean($_SESSION['user_id']);
	$result = mysqli_query($db, $query);

	while ($row = mysqli_fetch_assoc($result)) 
	{
		$role = $row['role'];
	}
	return $role;
}

function getName()
{
	global $db;
	$query = "SELECT * FROM user WHERE user_id = ".clean($_SESSION['user_id']);
	$result = mysqli_query($db, $query);

	while ($row = mysqli_fetch_assoc($result)) 
	{
		$name = $row['first_name'] . " " . $row['last_name'];
	}
	return $name;
}

function lookUpName($id)
{
	global $db;
	$query = "SELECT * FROM user WHERE user_id = ".clean($id);
	$result = mysqli_query($db, $query);

	while ($row = mysqli_fetch_assoc($result)) 
	{
		$name = $row['first_name'] . " " . $row['last_name'];
	}
	return $name;
}

function yours ($testname)				//pass a name and tells you if the id is yours or not
{
	$name = $_SESSION['user_name'];
	if ($testname == $name)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function yoursId ($id)					//pass a username get the user id	
{
	global $db;
	$query = "SELECT * FROM user WHERE user_id = ".clean($id);
	$result = mysqli_query($db, $query);

	while ($row = mysqli_fetch_assoc($result)) 
	{
		if ($id == $row['user_id'])
		{
			return true;
		}
	}
	return false;
}

function lookUpUserId ($uname)					//pass a username get the user id	
{
	global $db;
	$query = "SELECT * FROM user WHERE username = '".clean($uname)."'";
	$result = mysqli_query($db, $query);

	while ($row = mysqli_fetch_assoc($result)) 
	{
		$userId = $row['user_id'] ;
	}
	return $userId;
}

function lookUpUserName($id)			//pass a user id get the username
{
	global $db;
	$query = "SELECT * FROM user WHERE user_id = ".clean($id);
	$result = mysqli_query($db, $query);

	while ($row = mysqli_fetch_assoc($result)) 
	{
		$name = $row['username'] ;
	}
	return $name;
}

function getProfilePic($id,$size,$img = 'no')			//pass a user id get their profile pic $size must be either small, medium, or big
{
	global $db;
	$query = "SELECT * FROM profile WHERE user_id = ".clean($id);
	$result = mysqli_query($db, $query);

	while ($row = mysqli_fetch_assoc($result)) 
	{
		$pic_id = $row['image_id'] ;
	}
	
	$query = "SELECT * FROM images WHERE image_id = ".clean($pic_id);
	$result = mysqli_query($db, $query);

	while ($row = mysqli_fetch_assoc($result)) 
	{
		$image = $row["$size"] ;
	}
	if ($img == 'yes')
	{
		return '<img src="'.$image.'" alt="profile pic"/>';
	}
	else
	{
		return $image;
	}
}

function getProfilePicId($id)			//pass a user id get their profile pic id
{
	global $db;
	$query = "SELECT * FROM profile WHERE user_id = ".clean($id);
	$result = mysqli_query($db, $query);

	while ($row = mysqli_fetch_assoc($result)) 
	{
		$pic_id = $row['image_id'] ;
	}
	return $pic_id;
}

function getUserSig($id)			//pass a user id get their signature
{
	global $db;
	$query = "SELECT * FROM profile WHERE user_id = ".clean($id);
	$result = mysqli_query($db, $query);

	while ($row = mysqli_fetch_assoc($result)) 
	{
		$sig = $row['user_sig'] ;
	}
	return $sig;
}

function getNumberOfPosts($id)			//pass a user id get the number of posts they have made
{
	global $db;
	
	$query = "SELECT * FROM post WHERE user_id = ".clean($id);
	$result = mysqli_query($db, $query);
	
	return mysqli_num_rows($result);
}

function getNumberOfNotifications($userId) //find current number of notifications user has
{
	global $db;
	$query = "SELECT * FROM `profile` WHERE `user_id` = ".clean($userId);
	$result = mysqli_query($db, $query);
	while ($row = mysqli_fetch_assoc($result)) 
	{
		$notifications = $row['notifications'];
	}
	return $notifications;
}

function getNumberOfPostsThread($id)			//pass a thread id get the number of posts in it
{
	global $db;
	$numPosts = 0;
	$query = "SELECT * FROM post WHERE thread_id = ".clean($id);
	$result = mysqli_query($db, $query);
	
	while ($row = mysqli_fetch_assoc($result)) 
	{
		$numPosts = $numPosts +1 ;
	}
	return $numPosts;
}

function getLastPosterId($id)			//pass a thread id get the id of the last person to post to it
{	
	global $db;
	$query = "SELECT * FROM  post WHERE thread_id = '".clean($id)."' ORDER BY post_date DESC LIMIT 1";
	$result = mysqli_query($db, $query);
	
	while ($row = mysqli_fetch_assoc($result)) 
	{
		$user = $row['user_id'];
	}
	if (isset($user))
	{
		return $user;
	}
	else
	{
		return "There are no posts";
	}
}

function friends($id1 , $id2) //pass two user ids find out if they are friends
{
	global $db;
	
	$query = "SELECT * FROM friends WHERE (user = ".clean($id1)." OR friend = ".clean($id1).") AND (user = ".clean($id2)." OR friend = ".clean($id2).")";
	$result = mysqli_query($db, $query);

	while ($row = mysqli_fetch_assoc($result)) 
	{
		return true;
	}
	if (!$result)
	{
		return false;
	}
}

function getuploaderId($id)  //pass an image id get the id of the person that uploaded that image
{
	global $db;
	$query = "SELECT * FROM `images` WHERE `image_id` = ".clean($id);
	$result = mysqli_query($db, $query);
	while ($row = mysqli_fetch_assoc($result)) 
	{
		return $row['user_id'];
	}
}


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

//---------------------TIME-----------------------------
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