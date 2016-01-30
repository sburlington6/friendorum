<?php

	if (isset($_POST["themesSubmit"]))
	{
		$profileTheme = isset($_POST["profileTheme"]) ? $_POST["profileTheme"] : "";
		$query = "UPDATE profile SET `profile_theme_id` = \"clean($profileTheme)\" WHERE `profile`.`user_id` = 'clean($userId)'";
		$result = mysqli_query($db, $query);
		if (!$result)
		{
			echo mysqli_error($db);
		}
	
		$siteTheme = isset($_POST["siteTheme"]) ? $_POST["siteTheme"] : "";
		$query = "UPDATE profile SET `site_theme_id` = \"clean($siteTheme)\" WHERE `profile`.`user_id` = 'clean($userId)'";
		$result = mysqli_query($db, $query);
		if (!$result)
		{
			echo mysqli_error($db);
		}
		
	header( "Location: $filename" ) ;
	}
	
	$userId = getUserId ();
	
	$query = "SELECT * FROM accountSettings WHERE user_id = '$userId'";
	$result = mysqli_query($db, $query);
	if ($result)
	{
		while ($row = mysqli_fetch_assoc($result)) 
		{
			$currentSiteTheme = $row['site_theme_id'];
			$currentProfileTheme = $row['profile_theme_id'];
		}
	}
	else
	{
		echo mysqli_error($db);
	}
	
	
	
?>

<form method="post" action="<?php echo $filename; ?>">
	<table>
		<tr>
			<td>Select The theme for the site: </td>
			<td>
				<select name="siteTheme">
				<?php
					
					
					$query = "SELECT * FROM themes WHERE user_id IS NULL OR user_id = 'clean($userId)'";
					$result = mysqli_query($db, $query);
					if (!$result)
					{
						echo mysqli_error($db);
					}

					while ($row = mysqli_fetch_assoc($result)) 
					{
						if ($currentSiteTheme == $row['theme_id'])
						{
							echo "<option selected=\"selected\" value=\"" . $row['theme_id'] . "\">" . $row['theme_name'] . "</option>";
						}
						else
						{
							echo "<option value=\"" . $row['theme_id'] . "\">" . $row['theme_name'] . "</option>";
						}
					}
					echo mysqli_error($db);
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Select The theme for your profile: </td>
			<td>
				<select name="profileTheme">
				<?php
					
					$query = "SELECT * FROM themes WHERE user_id IS NULL OR user_id = 'clean($userId)'";
					$result = mysqli_query($db, $query);
					while ($row = mysqli_fetch_assoc($result)) 
					{
						if ($currentProfileTheme == $row['theme_id'])
						{
							echo "<option selected=\"selected\" value=\"" . $row['theme_id'] . "\">" . $row['theme_name'] . "</option>";
						}
						else
						{
							echo "<option value=\"" . $row['theme_id'] . "\">" . $row['theme_name'] . "</option>";
						}
					}
					echo mysqli_error($db);
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2">or <a href="themeMaker.php">Create Your Own Theme</a></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" value="Submit" name="themesSubmit"/></td>
		</tr>
	</table>
</form>