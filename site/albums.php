<?php
require ('includes/functions.php');

$yourId = getUserId ();
$userId = isset($_REQUEST["userId"]) ? $_REQUEST["userId"] : "$yourId";
$userName = lookUpUserName($userId);
$albumName = array();
$albumIds = array();
$taimages = false;

if (isset($_POST['removeAlbum']))
{
	//code for removing albums
	$query = "SELECT * FROM images WHERE album_id = ".clean($_POST['albumId']);
	$result = mysqli_query($db, $query);
	if (mysqli_num_rows($result) > 0)
	{
		$taimages = true;
	}
	else
	{
		$query = "DELETE FROM albums WHERE album_id = ".clean($_POST['albumId']);
		$result = mysqli_query($db, $query);
		header( "Location: albums.php?userId=$userId" ) ;
	}
}



$query = "SELECT * FROM albums WHERE user_id = ".clean($userId);
$result = mysqli_query($db, $query);
while ($row = mysqli_fetch_assoc($result)) 
{
	$albumName[] = $row['album_name'];
	$albumIds[] = $row['album_id'];
}
echo mysqli_error($db);

$cols = 4; 													#Number of columns to display 

$colCtr = 0; 												#controlling the number of colums 


require("includes/upload.process.php");
?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Albums</title>
		<?php require ('includes/style.php'); ?>
	</head>
	
		<?php
			require("includes/headder.php");
			
			if ($taimages)
			{
				echo "There are images in that album. You can not remove it until all the images are deleted";
			}
			
			if (!empty($albumIds))
			{
				if (count($albumIds) > 0)
				{
					echo "<h1>" . $userName . "'s Albums</h1>";
					
					if (yours ($userName))
					{
						echo "<form method=\"post\" action=\"$filename\">";
						echo 	"<input type=\"hidden\" name=\"userId\" value=\"" . $userId . "\"/>";
						echo 	"<input type=\"submit\" value=\"Add a Picture\" name=\"uploadPic\"/>";
						echo "</form>";
						if (isset($_POST['uploadPic']) OR !empty($imageError))
						{
							echo '<div class="dark">';
							echo	'<div class="uploadForm">';
										require("includes/upload.form.php");
							echo	'</div>';
							echo '</div>';
						}
					}
					
					for($i=0;$i<count($albumIds);$i++) 
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
						
						
						$rows = 0;
						$query = "SELECT * FROM images WHERE album_id = ".clean($albumIds[$i])." ORDER BY  `images`.`image_id` DESC LIMIT 0 , 1";
						$result = mysqli_query($db, $query);
						while ($row = mysqli_fetch_assoc($result)) 
						{
							echo '<a href="gallery.php?albumIds=' . $albumIds[$i] . '"><img src="' . $row['medium'] . '" alt="user image"/><br>' . $albumName[$i] . '</a>';
							$rows++;
						}
						if ($rows == "0")
						{
							echo '<a href="gallery.php?albumIds=' . $albumIds[$i] . '">' . $albumName[$i] . '</a>';
						}
						
						
						
						
						//echo '<a href="gallery.php?albumIds=' . $albumIds[$i] . '"><img src="' . $imagesMedium[$i] . '" alt="user image"/></a>';
						
						if (yours ($userName))
						{
								echo "<form method=\"post\" action=\"$filename\">";
								echo 	"<input type=\"hidden\" name=\"userId\" value=\"" . $userId . "\"/>";
								echo 	"<input type=\"hidden\" name=\"albumId\" value=\"" . $albumIds[$i] . "\"/>";
								echo 	"<input type=\"submit\" value=\"Remove Album\" name=\"removeAlbum\"/>";
								echo "</form>";
						}
						
						echo '</td>'; 
						$colCtr++; 
					}
					echo '</tr></table>' . "\r\n"; 
				}
			}
			else
			{
				echo "<p>$userName has no albums</p>";
			}
			require("includes/footer.php");
		?>
	</body>
</html>
