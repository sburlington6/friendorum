<?php
/*
* Forum Functions ------------------------------
*/


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
/*
 * gets the userId of the user that uploaded an image
 */
function getuploaderId($id)
{
	global $db;
	$query = "SELECT * FROM `images` WHERE `image_id` = ".clean($id);
	$result = mysqli_query($db, $query);
	while ($row = mysqli_fetch_assoc($result)) 
	{
		return $row['user_id'];
	}
	return false;
}