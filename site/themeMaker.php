<?php
	require ('includes/functions.php');
	
	
if ($logged_in)
{
	
	$userId = getUserId ();
	
	if (isset($_POST['editThemeSubmit']))
	{
            $editTheme = isset($_POST["themeToEdit"]) ? $_POST["themeToEdit"] : "";
            $query = "SELECT * FROM themes WHERE theme_id = '".clean($editTheme)."'";
        }
        else
	{
            $query = "SELECT * FROM themes WHERE theme_id = '1'";
        }
        
        $result = mysqli_query($db, $query);

        while ($row = mysqli_fetch_assoc($result)) 
        {
                $theme_name = clean(isset($_REQUEST["theme_name"]) ? $_REQUEST["theme_name"] : $row['theme_name']);
                $user_id = clean(isset($_REQUEST["user_id"]) ? $_REQUEST["user_id"] : "");
                $background_color = clean(isset($_REQUEST["background_color"]) ? $_REQUEST["background_color"] : $row['background_color']);
                $background_img = clean(isset($_REQUEST["background_img"]) ? $_REQUEST["background_img"] : $row['background_img']);
                $nav_bar = clean(isset($_REQUEST["nav_bar"]) ? $_REQUEST["nav_bar"] : $row['nav_bar']);
                $nav_buttons = clean(isset($_REQUEST["nav_buttons"]) ? $_REQUEST["nav_buttons"] : $row['nav_buttons']);
                $nav_curve = clean(isset($_REQUEST["nav_curve"]) ? $_REQUEST["nav_curve"] : $row['nav_curve']);
                $nav_text = clean(isset($_REQUEST["nav_text"]) ? $_REQUEST["nav_text"] : $row['nav_text']);
                $nav_text_hover = clean(isset($_REQUEST["nav_text_hover"]) ? $_REQUEST["nav_text_hover"] : $row['nav_text_hover']);
                $banner_curve = clean(isset($_REQUEST["banner_curve"]) ? $_REQUEST["banner_curve"] : $row['banner_curve']);
                $text_color = clean(isset($_REQUEST["text_color"]) ? $_REQUEST["text_color"] : $row['text_color']);
                $link_color = clean(isset($_REQUEST["link_color"]) ? $_REQUEST["link_color"] : $row['link_color']);
                $link_hover_color = clean(isset($_REQUEST["link_hover_color"]) ? $_REQUEST["link_hover_color"] : $row['link_hover_color']);
                $box_color = clean(isset($_REQUEST["box_color"]) ? $_REQUEST["box_color"] : $row['box_color']);
                $footer_color = clean(isset($_REQUEST["footer_color"]) ? $_REQUEST["footer_color"] : $row['footer_color']);
        }
	
	$userId = getUserId ($db);
	
	if (isset($_POST['submit']))
	{
		
		$query = "INSERT INTO themes (`theme_name`, `user_id`, `background_color`, `background_img`, `nav_bar`, `nav_buttons`, `nav_curve`, `nav_text`, `nav_text_hover`, `banner_curve`, `text_color`, `link_color`, `link_hover_color`, `box_color`, `footer_color`) VALUES ('$theme_name','$userId','$background_color','$background_img','$nav_bar','$nav_buttons','$nav_curve','$nav_text','$nav_text_hover','$banner_curve','$text_color','$link_color','$link_hover_color','$box_color','$footer_color')";
		$result = mysqli_query($db, $query);
		$errors = mysqli_error($db);
	}
	?>


<!DOCTYPE html> 
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Theme Maker</title>
		<link rel="stylesheet" href="includes/styles/style.css" type="text/css">
		<link rel="stylesheet" href="includes/styles/navMenu.css">
		<script src="includes/jscolor/jscolor.js" type="text/javascript"></script>
		<style type="text/css">
			body{
				background-color: <?php echo $background_color; ?>;
				color: <?php echo $text_color; ?>;
			}

			.box{
				background-color: <?php echo $box_color; ?>;
				border-top:2px solid #000000;
				border-bottom:2px solid #000000;
			}
			.box a{ 
				color: <?php echo $link_color; ?>;
				text-decoration:underline;
			}
			.box a:hover{ 
				color: <?php echo $link_hover_color; ?>;
				text-decoration:underline;
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

			#footer {
				background-color: <?php echo $footer_color; ?>;
			}
		</style>
		
		<script type='text/javascript' src='includes/js/jquery-1.2.3.min.js'></script>
		<script type='text/javascript' src='includes/js/menu.js'></script>
		
	</head>
		<?php
			require("includes/header.php");
		?>
			
			
			<form method="post" action="<?php echo $filename; ?>">
				Select a theme to edit <select name="themeToEdit">
				<?php
					$userId = getUserId ($db);
					$query = "SELECT * FROM themes WHERE user_id IS NULL OR user_id = '".clean($userId)."'";
					$result = mysqli_query($db, $query);

					while ($row = mysqli_fetch_assoc($result)) 
					{
						if (isset($_POST['editThemeSubmit']))
						{
							if ($_POST['themeToEdit'] == $row['theme_id'])
							{
								echo "<option selected=\"selected\" value=\"" . $row['theme_id'] . "\">" . $row['theme_name'] . "</option>";
							}
							else
							{
								echo "<option value=\"" . $row['theme_id'] . "\">" . $row['theme_name'] . "</option>";
							}
						}
						else
						{
							echo "<option value=\"" . $row['theme_id'] . "\">" . $row['theme_name'] . "</option>";
						}
					}
					echo mysqli_error($db);
				?>
				</select>
				<input type="submit" value="Submit" name="editThemeSubmit"/>
			</form>
			
				or create your own from scratch
				<br>
			<a href="accountSettings.php">Back to Account Settings</a>
			
			<form method="post" action="<?php echo $filename; ?>">
				<table>
					<tr>
						<td>Theme Name</td>
						<td><input type="text" name="theme_name" id="theme_name" value="<?php echo $theme_name;?>"/></td>
					</tr>
					<tr>
						<td>Nav Bar</td>
						<td><input type="text" name="nav_bar" id="nav_bar" onchange="$('.topnav').css('background-color', '#'+this.color);" class="color {hash:true}" value="<?php echo $nav_bar;?>"/></td>
					</tr>
					<tr>
						<td>Background Color</td>
						<td><input type="text" name="background_color" id="background_color" onchange="$('body').css('background-color', '#'+this.color);" class="color {hash:true}" value="<?php echo $background_color;?>"/></td>
					</tr>
					<tr>
						<td>Nav Buttons</td>
						<td><input type="text" name="nav_buttons" id="nav_buttons" onchange="$('.topnav li').css('background-color', '#'+this.color);" class="color {hash:true}" value="<?php echo $nav_buttons;?>"/></td>
					</tr>
					<tr>
						<td>Nav Text</td>
						<td><input type="text" name="nav_text" id="nav_text" onchange="$('.topnav a').css('color', '#'+this.color);" class="color {hash:true}" value="<?php echo $nav_text;?>"/></td>
					</tr>
					<tr>
						<td>Nav Text Hover (Will not change automatically)</td>
						<td><input type="text" name="nav_text_hover" id="nav_text_hover" class="color {hash:true}" value="<?php echo $nav_text_hover;?>"/><input type="submit" value="TEST" name="test"/></td>
					</tr>
					<tr>
						<td>Text Color</td>
						<td><input type="text" name="text_color" id="text_color" onchange="$('body').css('color', '#'+this.color);" class="color {hash:true}" value="<?php echo $text_color;?>"/></td>
					</tr>
					<tr>
						<td>Link Color</td>
						<td><input type="text" name="link_color" id="link_color" onchange="$('.box a').css('color', '#'+this.color);" class="color {hash:true}" value="<?php echo $link_color;?>"/></td>
					</tr>
					<tr>
						<td>Link Hover (Will not change automatically)</td>
						<td><input type="text" name="link_hover_color" id="link_hover_color" class="color {hash:true}" value="<?php echo $link_hover_color;?>"/><input type="submit" value="TEST" name="test"/></td>
					</tr>
					<tr>
						<td>Box Color</td>
						<td><input type="text" name="box_color" id="box_color" onchange="$('.box').css('background-color', '#'+this.color);" class="color {hash:true}" value="<?php echo $box_color;?>"/></td>
					</tr>
					<tr>
						<td>Footer Color</td>
						<td><input type="text" name="footer_color" id="footer_color" onchange="$('#footer').css('background-color', '#'+this.color);" class="color {hash:true}" value="<?php echo $footer_color;?>"/></td>
					</tr>
					<tr>	
						<td>Nav Buttons Curve</td>
						<td>
							<input type="range" min="0" max="30" value="<?php echo $nav_curve; ?>" name="nav_curve" onchange="showValue(this.value)" />
							<span id="range">0</span>
							<script type="text/javascript">
							function showValue(newValue)
							{
								document.getElementById("range").innerHTML=newValue;
								var nav_curve;
								nav_curve = newValue;
								$('.topnav li').css('-webkit-border-radius', newValue + 'px');
							}
							</script>
						</td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" value="Save" name="submit"/></td>
					</tr>
				</table>
			</form>
			

		<p style="text-align: center;"><a href="#">Test Link</a> <a href="#">Test Link</a> <a href="#">Test Link</a> <a href="#">Test Link</a></p>
			
		<p style="text-align: center;">Donec condimentum, arcu quis iaculis porttitor, nisl risus fringilla dolor, non cursus lorem est in nulla. Cras rhoncus mattis nulla, nec sodales neque porta ut. Quisque ac elit at nulla vulputate dignissim. Sed in erat risus. Aliquam erat volutpat. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Praesent pellentesque sem tristique nunc cursus nec facilisis metus molestie. Donec sodales, enim eget volutpat vestibulum, ipsum arcu blandit neque, at pharetra augue leo eget urna. Nulla a quam quis massa varius convallis. Suspendisse quam lectus, molestie vitae vehicula a, vulputate ut ante. Aenean congue pretium ultrices. Etiam nec erat non sapien hendrerit gravida a et arcu. Phasellus egestas pellentesque velit eget sodales. Cras fringilla porta porta. Etiam ut diam nunc. Pellentesque feugiat nisi lectus.</p>
			
			
		</div>
		<div class="box" id="footer">
			&copy; Something
		</div>
	</body>
</html>

<?php
}
else
{
	require ('includes/notloggedin.php');
}
?>