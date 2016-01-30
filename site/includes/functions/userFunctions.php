<?php
/*
* User Functions ------------------------------
*/


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


function friends($id1 , $id2) //pass two user ids find out if they are friends
{
	global $db;
	
	$query = "SELECT * FROM friends WHERE (user = ".clean($id1)." OR friend = ".clean($id1).") AND (user = ".clean($id2)." OR friend = ".clean($id2).")";
	$result = mysqli_query($db, $query);

	if (!$result)
	{
		return false;
	}
	else
	{
		//while ($row = mysqli_fetch_assoc($result)) {
			return true;
		//}
	}

}