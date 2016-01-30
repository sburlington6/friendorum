<?php
if (!isset($_REQUEST["userId"]))
	{
		header( 'Location: index.php' ) ;
	}

	require ('includes/functions.php');
	
	if ($logged_in)
{

	$errors = array();
	$userId = isset($_REQUEST["userId"]) ? $_REQUEST["userId"] : "";
	$comment = isset($_POST["comment"]) ? $_POST["comment"] : "";
	$statusId = isset($_POST["statusId"]) ? $_POST["statusId"] : "";
	$personsUserName = getUserName();
	$checkId = lookUpUserId ($personsUserName);
	$name = lookUpName($userId);
	$friends = false;
	
	$query = "SELECT * FROM friends WHERE (user = ".clean($userId)." OR friend = ".clean($userId).") AND (user = ".clean($checkId)." OR friend = ".clean($checkId).")";
	$result = mysqli_query($db, $query);

	while ($row = mysqli_fetch_assoc($result)) 
	{
		$friends = true;
	}
	
	//start comment validation
	if (isset($_POST['commentSubmit']))
	{
		if($comment == "")
		{
			$errors[] = "Comment cannot be blank.";
		}
		else
		{
			if(strlen($comment) < 1 || strlen($comment) > 200)
			{
				$errors[] = "Comment must be between 1 and 200 characters.";
			}
		}
		
		if(empty($errors))
		{
			$userId = getUserId ();
			$queryInsert = "INSERT INTO comment (user_id, comment, status_id) VALUES ('".clean($userId)."', '".clean($comment)."', '".clean($statusId)."')";
			$result = mysqli_query($db, $queryInsert);
			
			$comment = "";

			if(!$result)
			{
				echo "MySQL error" . mysqli_error($db);
				exit();
			}
		}
	}
	//end comment validation
	
	if (isset($_GET['addFriend']))
	{
		//find current number of notifications user has
		$query = "SELECT * FROM `profile` WHERE `user_id` = ".clean($userId);
		$result = mysqli_query($db, $query);
		while ($row = mysqli_fetch_assoc($result)) 
		{
			$notifications = $row['notifications'];
			$profileID = $row['profile_id'];
		}
		
		//add one to that number
		$notifications = $notifications + 1;
		$query = "UPDATE  `profile` SET  `notifications` =  '".clean($notifications)."' WHERE `profile_id` = ".clean($profileID);
		$result = mysqli_query($db, $query);
		
		//add friendship to table
		$queryAdd = "INSERT INTO friends (user, friend) VALUES (".clean($checkId).", ".clean($userId).")";
		$resultAdd = mysqli_query($db, $queryAdd);
		header( "Location: profile.php?userId=$userId" ) ;
	}
	
	if ($userId == $checkId)
	{
		$yours = true;
	}
	else
	{
		$yours = false; 
	}
	
?>
<!doctype html>
<html>
	<head>
		<title>Profile</title>
		<meta charset="utf-8"/>
		<?php require ('includes/style.php'); ?>
	</head>
	
		<?php 
			require("includes/header.php");
		  
			$profile_pic = getProfilePic($userId,"medium");
			
			$query = "SELECT * FROM `albums` WHERE `user_id` = ".clean($userId)." AND `album_name` = 'Profile Pictures'";
			$result = mysqli_query($db, $query);
			while ($row = mysqli_fetch_assoc($result)) 
			{
				$profilePicId = $row['album_id'];
			}
			
			if (isset($profilePicId))
			{
				echo "<a href=\"gallery.php?albumIds=" . $profilePicId . "\"><img src=\"$profile_pic\" alt=\"profile picture\"/></a>";
			}
			else
			{
				echo "<img src=\"$profile_pic\" alt=\"profile picture\"/>";
			}
			
			echo "<h1 id=\"username\">" . $name . "</h1>";
			
			echo "<a href=\"info.php?userId=" . $userId . "\">Info</a>";
			
			echo " ";
			
			echo "<a href=\"albums.php?userId=" . $userId . "\">Albums</a>";
			
			echo " ";
			
			echo "<a href=\"friends.php?userId=" . $userId . "\">Friends</a>";
			
			echo " ";
			
			
			//echo "friends = " . $friends . "<br>";
			
			if (!$friends and !$yours)
			{
				echo 		"<form method=\"get\" action=\"$filename\">";
				echo 			"<input type=\"hidden\" name=\"userId\" value=\"" . $userId . "\"/>";
				echo 			"<input type=\"submit\" value=\"Add Friend\" name=\"addFriend\"/>";
				echo 		"</form>";
			}
			
			
			//require ('friends.php');
		?>
		<table>
		<tr>
			<th>User</th>
			<th>Status</th>
			<th>Date</th>
		</tr>
		<?php
		$query = "SELECT * FROM status WHERE user_id = '".clean($userId)."' ORDER BY `date` DESC ";
		$result = mysqli_query($db, $query);

		while ($row = mysqli_fetch_assoc($result)) 
			{
				echo"<tr>";
				echo "<td>";
				echo 	"<a href=\"profile.php?userId=" . $row["user_id"] . "\">" . lookUpUserName($row["user_id"]) . "</a>" ;
				if (yours(lookUpUserName($row["user_id"])))
				{
					echo "<form method=\"post\" action=\"".$filename."\">";
					echo 	"<input type=\"hidden\" name=\"statusId\" value=\"" . $row['status_id'] . "\"/>";
					echo 	"<input type=\"hidden\" name=\"userId\" value=\"" . $userId . "\"/>";
					echo 	"<input type=\"submit\" value=\"Remove Status\" name=\"removeStatus\"/>";
					echo "</form>";
				}
				echo "</td>";
				echo "<td>";
				echo $row['status'];
				
				echo "<form action=\"$filename\" method=\"post\">";
				echo "	<input type=\"hidden\" name=\"statusId\" value=\"".$row['status_id']."\"/>";
				echo "<input type=\"hidden\" name=\"userId\" value=\"" . $userId . "\"/>";
				echo "	<input type=\"submit\" value=\"Comment\" name=\"newComment\"/>";
				echo "</form>";
				
				
				if (isset($_POST['newComment']) AND $_POST['statusId'] == $row['status_id'])
				{
				?>
				<form action="<?php echo $filename;?>" method="post">
					<input type="hidden" name="statusId" value="<?php echo $row['status_id'];?>"/>
					Comment:<input type="text" name="comment" value="<?php echo $comment; ?>"/>
					<input type="hidden" name="userId" value=" <?php echo $userId; ?> "/>
					<input type="submit" value="Submit" name="commentSubmit"/>
				</form>	
				<a href="<?php echo $filename;?>">Cancel</a>
				<?php
				}
				echo "</td>";
				echo "<td>" . convertTimestamp($row['date']) . "</td>";
				echo "</tr>";
				
				$innerquery = "SELECT * FROM comment WHERE status_id = '".clean($row['status_id'])."' ORDER BY `comment_date` DESC ";
				$innerresult = mysqli_query($db, $innerquery);
				if ($innerresult)
				{
					while ($innerrow = mysqli_fetch_assoc($innerresult)) 
					{
						echo '<tr>';
						echo 	'<td colspan = "3" class="comment">';
						echo 		'<a href="profile.php?userId='.$innerrow['user_id'].'" >' . lookUpUserName($innerrow['user_id']) . '</a>: ' . $innerrow['comment'];
						if (yours(lookUpUserName($innerrow["user_id"])) OR yours(lookUpUserName($row["user_id"])))
						{
							echo 	"<form method=\"post\" action=\"$filename\">";
							echo 		"<input type=\"hidden\" name=\"commentId\" value=\"" . $innerrow['comment_id'] . "\"/>";
							echo 		"<input type=\"submit\" value=\"Remove Comment\" name=\"removeComment\"/>";
							echo 	"</form>";
						}
						echo 	'</td>';
						echo '</tr>';
					}	
				}
			}
			echo "</table>";
		
			
		require("includes/close.php");
		require("includes/footer.php");
		?>
		
	</body>
</html>
<?PHP
} 
else
{
require ('includes/notloggedin.php');
} 
?>