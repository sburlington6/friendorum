<?php
	if (isLoggedIn())
	{
		if ($filename == 'profile.php' OR $filename == 'albums.php' OR $filename == 'friends.php' OR $filename == 'info.php')
		{
			$query = "SELECT * FROM profile WHERE user_id = ".clean($userId);
			$result = mysqli_query($db, $query);
			while ($row = mysqli_fetch_assoc($result)) 
			{
				$theme = $row['profile_theme_id'];
			}
		}
		elseif ($filename == 'gallery.php')
		{
			$query = "SELECT * FROM albums WHERE album_id = ".clean($_GET['albumIds']);
			$result = mysqli_query($db, $query);
			while ($row = mysqli_fetch_assoc($result)) 
			{
				$user = $row['user_id'];
			}
			$query = "SELECT * FROM profile WHERE user_id = ".clean($user);
			$result = mysqli_query($db, $query);
			while ($row = mysqli_fetch_assoc($result)) 
			{
				$theme = $row['profile_theme_id'];
			}
		}
		elseif($filename == 'photo.php')
		{
			$query = "SELECT * FROM images WHERE image_id = ".clean($_REQUEST['photoId']);
			$result = mysqli_query($db, $query);
			while ($row = mysqli_fetch_assoc($result)) 
			{
				$user = $row['user_id'];
			}
			$query = "SELECT * FROM profile WHERE user_id = ".clean($user);
			$result = mysqli_query($db, $query);
			while ($row = mysqli_fetch_assoc($result)) 
			{
				$theme = $row['profile_theme_id'];
			}
		}
		elseif ($filename == 'accountSettings.php' OR $filename == 'profileedit.php')
		{
			$id = getUserId();
			$query = "SELECT * FROM profile WHERE user_id = ".clean($id);
			$result = mysqli_query($db, $query);
			if (!$result)
			{
				echo mysqli_error($db);
			}
			while ($row = mysqli_fetch_assoc($result)) 
			{
				$theme = $row['profile_theme_id'];
			}
		}
		else
		{
			$id = getUserId();
			$query = "SELECT * FROM profile WHERE user_id = ".clean($id);
			$result = mysqli_query($db, $query);
			if (!$result)
			{
				echo mysqli_error($db);
			}
			while ($row = mysqli_fetch_assoc($result)) 
			{
				$theme = $row['site_theme_id'];
			}
		}
	}
	else
	{
		$theme = '1';
	}
	
	$query = "SELECT * FROM themes WHERE theme_id = ".clean($theme);
	$result = mysqli_query($db, $query);

	while ($row = mysqli_fetch_assoc($result)) 
	{
		$background_color = $row['background_color'];
		$background_img = isset($row['background_img']) ? $row['background_img'] : "$background_color";
		$nav_bar = $row['nav_bar'];
		$nav_buttons = $row['nav_buttons'];
		$nav_curve = $row['nav_curve'];
		$nav_text = $row['nav_text'];
		$nav_text_hover = $row['nav_text_hover'];
		$defaultBanner = "images/logos/default.png"; #not in database
		$banner_color = $row['banner_color'];
		$banner_curve = $row['banner_curve'];
		$text_color = $row['text_color'];
		$link_color = $row['link_color'];
		$link_hover_color = $row['link_hover_color'];
		$box_color = $row['box_color'];
		$footer_color = $row['footer_color'];
	}

?>
<script type='text/javascript' src='includes/js/jquery-1.2.3.min.js'></script>
<script type='text/javascript' src='includes/js/menu.js'></script>
<script type='text/javascript' src='includes/js/charCount.js'></script>
<script type='text/javascript' src='includes/js/updateClock.js'></script>

<link rel="stylesheet" href="includes/styles/style.css">

<style>
body{
	background-color: <?php echo $background_color; ?>;
	color: <?php echo $text_color; ?>;
}

.box{
	background-color: <?php echo $box_color; ?>;
}
.box a:link{ 
	color: <?php echo $link_color; ?>;
}
.box a:visited{ 
	color: <?php echo $link_color; ?>;
}
.box a:hover{ 
	color: <?php echo $link_hover_color; ?>;
}

.topnav{
	background-color: <?php echo $nav_bar; ?>; 
}
.topnav li{
	background-color: <?php echo $nav_buttons; ?>; 
	
	-moz-border-radius: <?php echo $nav_curve; ?>px;
	-khtml-border-radius: <?php echo $nav_curve; ?>px;
	-webkit-border-radius: <?php echo $nav_curve; ?>px;  
}
.topnav li a{
	color: <?php echo $nav_text; ?>;
}
.topnav li a:hover{
	color: <?php echo $nav_text_hover; ?>;
}
.subnav{
	background-color: <?php echo $nav_buttons; ?>; 
}
.subnav{
	background-color: <?php echo $nav_bar; ?>; 
}
.subnav a{
	color: <?php echo $nav_text; ?>;
	background-color: <?php echo $nav_buttons; ?>; 
}
.subnav a{
	color: <?php echo $nav_text_hover; ?>;
}

#logo{
	background-color: <?php echo $banner_color; ?>;
}

#footer {
	color: <?php echo $text_color; ?>;
	background-color: <?php echo $footer_color; ?>;
}
</style>