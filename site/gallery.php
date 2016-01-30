<?php
require ('includes/functions.php');

$yourId = getUserId();
$albumIds = isset($_REQUEST["albumIds"]) ? $_REQUEST["albumIds"] : "";

$query = "SELECT * FROM images WHERE album_id = ".clean($albumIds);
$result = mysqli_query($db, $query);
while ($row = mysqli_fetch_assoc($result)) 
{
	$imagesMedium[] = $row['medium'];
	$imagesBig[] = $row['big'];
	$imageId[] = $row['image_id'];
	$caption[] = $row['caption'];
}

$query = "SELECT * FROM albums WHERE album_id = ".clean($albumIds);
$result = mysqli_query($db, $query);
while ($row = mysqli_fetch_assoc($result)) 
{
	$albumName = $row['album_name'];
	$userId = $row['user_id'];
}

$userName = lookUpUserName($userId);

if (isset($_POST['removePicture']))
{
	$pictureToRemove = $_POST['imageId'];
	

	$query = "SELECT * FROM images WHERE image_id = ".clean($pictureToRemove);
	$sresult = mysqli_query($db, $query);
	while ($row = mysqli_fetch_assoc($sresult)) 
	{
		$big = $row['big'];
		$medium = $row['medium'];
		$small = $row['small'];
		unlink("$big");
		unlink("$medium");
		unlink("$small");
	}
	
	$query = "DELETE FROM `images` WHERE `images`.`image_id` = ".clean($pictureToRemove);
	$remresult = mysqli_query($db, $query);
	
	header( "Location: gallery.php?albumIds=$albumIds" ) ;
}
if (isset($_POST['profilePicture']))
{
	$newPic = $_POST['imageId'];
	$query = "UPDATE  `profile` SET  `image_id` = ".clean($newPic)." WHERE  `profile`.`user_id` = ".clean($yourId);
	$result = mysqli_query($db, $query);
	header( "Location: gallery.php?albumIds=$albumIds" ) ;
}



echo mysqli_error($db);

$cols = 4; 													#Number of columns to display 

$colCtr = 0; 												#controlling the number of colums 


?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Gallery</title>
		<?php require ('includes/style.php'); ?>
	</head>
	
		<?php
			require("includes/header.php");
			echo '<a href="albums.php?userId=' . $userId . '">Back to Albums</a>';
			if (isset($imagesMedium) AND count($imagesMedium) > 0)
			{
				//need album name below
				echo "<h1> $userName - $albumName</h1>";
				
				for($i=0;$i<count($imagesMedium);$i++) 
				{ 
					if ($colCtr == 0)										#if its the first row
					{
						if($colCtr %$cols == 0) 
						{
							echo '<table class="gallery"><tr>'; 
						}
					}
					else
					{
						if($colCtr %$cols == 0) 							
						{
							echo '</tr></table><table class="gallery"><tr>'; 
						}
					}
					echo '<td>';
					echo '<a href="photo.php?photoId=' . $imageId[$i] . '"><img src="' . $imagesMedium[$i] . '" alt="user image"/></a>';
					
					if ($caption[$i] != "")
					{
						echo '<p class="caption">' . $caption[$i] . '</p>';
					}
					
					if (yours ($userName))
					{
						if ($imageId[$i] != getProfilePicId($userId))
						{
							echo "<form method=\"post\" action=\"$filename\">";
							echo 	"<input type=\"hidden\" name=\"albumIds\" value=\"" . $albumIds . "\"/>";
							echo 	"<input type=\"hidden\" name=\"imageId\" value=\"" . $imageId[$i] . "\"/>";
							echo 	"<input type=\"submit\" value=\"Remove Picture\" name=\"removePicture\"/>";
							echo "</form>";
							
							echo "<form method=\"post\" action=\"$filename\">";
							echo 	"<input type=\"hidden\" name=\"albumIds\" value=\"" . $albumIds . "\"/>";
							echo 	"<input type=\"hidden\" name=\"imageId\" value=\"" . $imageId[$i] . "\"/>";
							echo 	"<input type=\"submit\" value=\"Make Profile Picture\" name=\"profilePicture\"/>";
							echo "</form>";
						}
						else
						{
							echo "<br>This is your current profile picture";
						}
					}
					
					echo '</td>'; 
					$colCtr++; 
				}
				echo '</tr></table>' . "\r\n"; 
			}
			else
			{
				echo "<p>There are no images in this album</p>";
			}
			require("includes/footer.php");
		?>
	</body>
</html>
