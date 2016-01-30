<?php
require("includes/functions.php");


$photoId = $_REQUEST['photoId'];
$comment = isset($_POST["comment"]) ? $_POST["comment"] : "";

$photos=array();

if ($logged_in AND isset($_REQUEST['photoId']) AND $_REQUEST['photoId'] > 0)
{
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Image</title>
		<?php 
			$userId = getuploaderId($photoId);
			require ('includes/style.php'); 
		?>
	</head>
	
		<?php 
		require("includes/header.php");
		
		
		$query = "SELECT * FROM `images` WHERE `image_id` = ".clean($photoId)." AND `user_id` IS NOT NULL ";
		$result = mysqli_query($db, $query);
		if (mysqli_num_rows($result) > 0)
		{
			while ($row = mysqli_fetch_assoc($result)) 
			{
				echo '<a href="gallery.php?albumIds=' . $row['album_id'] . '">Back to Album</a>';
				
				//get all photos in the album
				$user = $row['user_id'];
				$album = $row['album_id'];
				$innerquery = "SELECT * FROM `images` WHERE `album_id` = ".$album;
				$innerresult = mysqli_query($db, $innerquery);
				while ($innerrow = mysqli_fetch_assoc($innerresult)) 
				{
					$photos[]=$innerrow['image_id'];
				}
				//left photo nav
				echo '<table id="photo">';
				echo '<tr>';
				echo '<td>';
				for($i=0;$i<count($photos);$i++)
				{
					if ($photos[$i] == $photoId)
					{
						if ($i == count($photos)-1 AND count($photos) > 1)
						{
							echo '<a href="photo.php?photoId='.$photos[0].'"><img src="images/buttons/skip2.png" alt="First" height="40" width="46"/></a>';
							echo ' ';
							echo '<a href="photo.php?photoId='.$photos[$i-1].'"><img src="images/buttons/rr.png" alt="Previous" height="40" width="46"/></a>';
						}
						elseif ($i == 0 AND count($photos) > 1)
						{
							echo '<img src="images/buttons/g_skip2.png" alt="First" height="40" width="46"/>';
							echo ' ';
							echo '<img src="images/buttons/g_rr.png" alt="Previous" height="40" width="46"/>';
						}
						elseif (count($photos) > 1)
						{
							echo '<a href="photo.php?photoId='.$photos[0].'"><img src="images/buttons/skip2.png" alt="First" height="40" width="46"/></a>';
							echo ' ';
							echo '<a href="photo.php?photoId='.$photos[$i-1].'"><img src="images/buttons/rr.png" alt="Previous" height="40" width="46"/></a>';
						}
						else
						{
							echo '<img src="images/buttons/g_skip2.png" alt="First" height="40" width="46"/>';
							echo ' ';
							echo '<img src="images/buttons/g_rr.png" alt="Previous" height="40" width="46"/>';
						}
					}
				}
				echo '</td>';
				echo '<td>';
				echo "<img src=\"" . $row['big'] . "\" alt=\"profile picture\" class=\"largeImage\"/>";
				if ($row['caption'] != "")
				{
					echo '<p class="caption">' . $row['caption'] . '</p>';
				}
				echo '</td>';
				echo '<td>';
				//right photo nav
				for($i=0;$i<count($photos);$i++)
				{
					if ($photos[$i] == $photoId)
					{
						if ($i == count($photos)-1 AND count($photos) > 1)
						{
							echo '<img src="images/buttons/g_ff.png" alt="Next" height="40" width="46"/>';
							echo ' ';
							echo '<img src="images/buttons/g_skip.png" alt="Last" height="40" width="46"/>';
						}
						elseif ($i == 0 AND count($photos) > 1)
						{
							echo '<a href="photo.php?photoId='.$photos[$i+1].'"><img src="images/buttons/ff.png" alt="Next" height="40" width="46"/></a>';
							echo ' ';
							echo '<a href="photo.php?photoId='.$photos[count($photos)-1].'"><img src="images/buttons/skip.png" alt="Last" height="40" width="46"/></a>';
						}
						elseif (count($photos) > 1)
						{
							echo '<a href="photo.php?photoId='.$photos[$i+1].'"><img src="images/buttons/ff.png" alt="Next" height="40" width="46"/></a>';
							echo ' ';
							echo '<a href="photo.php?photoId='.$photos[count($photos)-1].'"><img src="images/buttons/skip.png" alt="Last" height="40" width="46"/></a>';
						}
						else
						{
							echo '<img src="images/buttons/g_ff.png" alt="Next" height="40" width="46"/>';
							echo ' ';
							echo '<img src="images/buttons/g_skip.png" alt="Last" height="40" width="46"/>';
						}
					}
				}
				echo '</td>';
				echo '</tr>';
				echo '</table>';
			}
		}
		else
		{
			header( "Location: index.php" ) ;
		}
		
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
				$queryInsert = "INSERT INTO image_comments (user_id, comment, image_id) VALUES ('".clean($userId)."', '".clean($comment)."', '".clean($photoId)."')";
				$result = mysqli_query($db, $queryInsert);
				
				$comment = "";

				if(!$result)
				{
					echo "MySQL error" . mysqli_error($db);
					exit();
				}
				
				header( "Location: photo.php?photoId=$photoId" ) ;
			}
		}
		
		//start comments div
		echo '<div id="photoComments">';
		echo '<a name="comment"></a>';
		
		if (!empty($errors))
		{
			foreach($errors as $error)
			{
				echo "<p class=\"error\">$error</p>";
			}
		}
		
		if (!isset($_POST['newComment']) AND empty($errors))
		{
		?>
		<form action="<?php echo $filename;?>#comment" method="post">
			<input type="hidden" name="photoId" value="<?php echo $photoId;?>"/>
			<input type="submit" value="Comment" name="newComment"/>
		</form>
		<?php
		}
		if (isset($_POST['newComment']) OR !empty($errors))
		{
		?>
		<a href="photo.php?photoId=<?php echo $photoId;?>#comment" alt="">Cancel</a>
		<form action="<?php echo $filename;?>#comment" method="post">
			<input type="hidden" name="photoId" value="<?php echo $photoId;?>"/>
			Comment:<input type="text" name="comment" value="<?php echo $comment; ?>"/>
			<input type="submit" value="Submit" name="commentSubmit"/>
		</form>	
		<?php
		}
		
		
		$query = "SELECT * FROM image_comments WHERE image_id = '".clean($photoId)."' ORDER BY `date` ASC ";
		$result = mysqli_query($db, $query);
		
		if ($result)
		{
			
			while ($row = mysqli_fetch_assoc($result)) 
			{
				echo '<a href="profile.php?userId='.$row['user_id'].'" alt="'.lookUpUserName($row['user_id']).'s profile">' . lookUpUserName($row['user_id']) . '</a>: ' . $row['comment'];
				if (yours(lookUpUserName($row["user_id"])) or lookUpUserId($_SESSION["user_name"]) == $user)
				{
					echo 	"<form method=\"post\" action=\"$filename #comment\" class=\"remove\">";
					echo 		'<input type="hidden" name="photoId" value="'.$photoId.'"/>';
					echo 		"<input type=\"hidden\" name=\"commentId\" value=\"" . $row['comment_id'] . "\"/>";
					echo 		"<input type=\"submit\" value=\"Remove Comment\" name=\"removeComment\"/>";
					echo 	"</form>";
				}
				echo '<br>';
			}	
			if (mysqli_num_rows($result) == 0)
			{
				echo 'There are no comments on this photo yet.';
			}
		}
		echo '</div>';
		
		if (isset($_POST['removeComment']))
		{
			$commentToRemove = $_POST['commentId'];
			$query = "DELETE FROM `image_comments` WHERE `comment_id` = ".clean($commentToRemove);
			$result = mysqli_query($db, $query);
			header( "Location: photo.php?photoId=$photoId" ) ;
		}
		
		require("includes/close.php");
		require("includes/footer.php");
		?>
	</body>
</html>

<?php
}
else
{
	header( "Location: index.php" ) ;
}

?>