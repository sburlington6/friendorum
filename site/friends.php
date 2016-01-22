<?php
require ('includes/functions.php');

$userId = isset($_REQUEST["userId"]) ? $_REQUEST["userId"] : "";
$personsUserName = getUserName();
$checkId = lookUpUserId ($personsUserName);
$name = lookUpUserName($userId);
$yours = false;
if ($userId == $checkId)
{
	$yours = true;
}
else
{
	$yours = false; 
}


	if (isset($_POST['accepted']))
	{
		$user = getUserId ();
		$friend = $_POST['friend'];
		
		$query = "UPDATE friends SET pending = 0 WHERE user = ".clean($friend)." AND friend = ".clean($user); //create their profile
		$result = mysqli_query($db, $query);
		
		header( "Location: friends.php?userId=$userId" ) ;
	
		//find current number of notifications user has
		$notifications = getNumberOfNotifications($user);
		echo $notifications . "<br>";
		if ($notifications >= 1)
		{
			//subtract one from that number
			$notifications = $notifications - 1;
			echo "before " . $notifications . "<br>";
			$queryminus = "UPDATE  `profile` SET  `notifications` = '".clean($notifications)."' WHERE `user_id` = ".clean($user);
			$result = mysqli_query($db, $queryminus);
			
			echo "after " . $notifications . "<br>";
			echo "new number" . getNumberOfNotifications($user) . "<br>";
			unset($reply);
		}
	}
	elseif (isset($_POST['denied']))
	{	
		$user = getUserId ();
		$friend = $_POST['friend'];
	
		$query = "DELETE FROM friends WHERE user = ".clean($friend)." AND friend = ".clean($user); 
		$result = mysqli_query($db, $query);
		header( "Location: friends.php?userId=$userId" ) ;
	
		//find current number of notifications user has
		$notifications = getNumberOfNotifications($user);
		echo $notifications . "<br>";
		if ($notifications >= 1)
		{
			//subtract one from that number
			$notifications = $notifications - 1;
			echo "before " . $notifications . "<br>";
			$queryminus = "UPDATE  `profile` SET  `notifications` = '".clean($notifications)."' WHERE `user_id` = ".clean($user);
			$result = mysqli_query($db, $queryminus);
			
			echo "after " . $notifications . "<br>";
			echo "new number" . getNumberOfNotifications($user) . "<br>";
			unset($reply);
		}
	}
		
		
	
	if (isset($_POST['removeFriendship']))
	{
		$user = getUserId ();
		$friend = $_POST['Rfriend'];
		
		
		$delquery = "DELETE FROM friends WHERE (user = ".clean($user)." OR friend = ".clean($user).") AND (user = ".clean($friend)." OR friend = ".clean($friend).")";
		$result = mysqli_query($db, $delquery);
		if ($result)
		{
			//echo "friend deleted";
		}
		if (!$result)
		{
			//echo "friend not deleted";
		}
		
		
		header( "Location: friends.php?userId=$user" ) ;
		
	}
	
	
	?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Gallery</title>
		<?php require ('includes/style.php'); ?>
	</head>
	
		<?php
			require("includes/headder.php");
	
	//$userId = $_REQUEST['userId'];
		
	echo lookUpUserName($userId) . "'s friend list:";

	$query = "SELECT * FROM friends WHERE user = ".clean($userId)." OR friend = ".clean($userId);
	$result = mysqli_query($db, $query);

	?>
	<table>
		<tr>
			<th>Friend</th>
			<th>Accept</th>
			<th>Remove Friend</th>
		</tr>
	<?php
	$confirm = false;
	
	
	while ($row = mysqli_fetch_assoc($result)) 
		{
			if ($row['user'] == $userId)
			{
				$friendId = $row['friend'];
			}
			elseif ($row['friend'] == $userId)
			{
				$friendId = $row['user'];
				$confirm = true;
			}
			$friend_profile_pic = getProfilePic($friendId,"small");
			$friendName = lookUpUserName($friendId);
			if ($yours)
			{
				if ($confirm and $row['pending'] == 1)
				{
					echo "<tr>";
					echo 	"<td><a href=\"profile.php?userId=$friendId\"><img src=\"$friend_profile_pic\" alt=\"friend profile picture\"/> $friendName</a></td>";
					echo 	"<td>";
					echo 		"<form method=\"post\" action=\"$filename\">";
					echo 			"<input type=\"hidden\" name=\"friend\" value=\"" . $friendId . "\"/>";
					echo 			"<input type=\"hidden\" name=\"userId\" value=\"" . $userId . "\"/>";
					echo 			"<input type=\"submit\" value=\"Accept\" name=\"accepted\"/>";
					echo 			"<input type=\"submit\" value=\"Deny\" name=\"denied\"/>";
					echo 		"</form>";
					echo 	"</td>";
					echo 	"<td></td>";
					echo "</tr>";
				}
				else
				{
					echo "<tr>";
					echo 	"<td><a href=\"profile.php?userId=$friendId\"><img src=\"$friend_profile_pic\" alt=\"friend profile picture\"/> $friendName</a></td>";
					echo 	"<td>Friendship Accepted</td>";
					echo 	"<td>";
					echo 		"<form method=\"post\" action=\"$filename\">";
					echo 			"<input type=\"hidden\" name=\"userId\" value=\"" . $userId . "\"/>";
					echo 			"<input type=\"hidden\" name=\"Rfriend\" value=\"" . $friendId . "\"/>";
					echo 			"<input type=\"submit\" value=\"Remove Friendship\" name=\"removeFriendship\"/>";
					echo 		"</form>";
					echo 	"</td>";
					echo "</tr>";
				}
			}
			else
			{
				echo "<tr>";
				echo	"<td><a href=\"profile.php?userId=$friendId\"><img src=\"$friend_profile_pic\" alt=\"friend profile picture\"/> $friendName</a></td>";
				if ($row['pending'] == 1)
				{
					echo	"<td>friendship pending</td>";
				}
				else
				{
					echo 	"<td>Friendship Accepted</td>";
				}
				echo	"<td></td>";
				echo "</tr>";
			}
		}
		
		
		echo "</table>";
require("includes/footer.php");
		?>
	</body>
</html>