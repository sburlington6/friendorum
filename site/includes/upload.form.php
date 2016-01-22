<?php
// set a max file size for the html upload form
$max_file_size = "2147483648"; // size in bytes

$currentFile = $_SERVER["PHP_SELF"];
$parts = Explode('/', $currentFile);
$filename = $parts[count($parts) - 1];

if (!empty($imageError))
{
	foreach($imageError as $bigError)
	{
	  echo "<p class=\"error\">$bigError</p>";
	}
}
?>
		<form id="Upload" action="<?php echo $filename; ?>" enctype="multipart/form-data" method="post">
			<?php
			if ($filename != "profileedit.php")
			{
			?>
				<p><a href="albums.php?userId=<?php echo $userId; ?>" alt="cancel">Cancel</a></p>
				<p>
					<label for="existing">Existing Album:</label>
					<select name="albumId" id="albumId">
					
					<?php
					$query = "SELECT * FROM `albums` WHERE `user_id` = '$userId'";
					$result = mysqli_query($db, $query);
					
					if ($albumId > 0)
					{
						echo '<option value="0">Existing Album: </option>';
						while ($row = mysqli_fetch_assoc($result)) 
						{
							if ($albumId == $row['album_id'])
							{
								echo '<option value="' . $row['album_id'] . '" selected ="selected">' . $row['album_name'] . '</option>';
							}
							else
							{
								echo '<option value="' . $row['album_id'] . '">' . $row['album_name'] . '</option>';
							}
						}
					}
					else
					{
						echo '<option value="0" selected ="selected">Existing Album: </option>';
						while ($row = mysqli_fetch_assoc($result)) 
						{
							echo '<option value="' . $row['album_id'] . '">' . $row['album_name'] . '</option>';
						}
					}	
						?>
						
					</select>
				</p>
				<p>
					<label for="new">New Album:</label> 
					<input type="text" name="newAlbum" value="<?php echo $newAlbumName; ?>"/>
				</p>
			<?php
			}
			?>
			<p>
				<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>">
				<input type="hidden" name="userId" value="<?php echo $userId; ?>">
			</p>
			<p><input id="file" type="file" name="file"></p>		
			<p>
				<label for="caption">Caption</label>
				<input type="text" name="caption" id="caption" value="<?php echo $caption; ?>"/>
			</p>
			<p><input id="upload" type="submit" name="upload" value="Upload Image"></p>
		</form>