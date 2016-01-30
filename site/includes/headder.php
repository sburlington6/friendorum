<body onload="updateClock(); setInterval('updateClock()', 1000 )">
<a name="top"></a>
<nav>
	<ul class="topnav">  
		<li id="headerLogo"><a href="index.php"><img id="smallLogo" src="images/logos/smallLogo.png" width="250" height="30" alt="Logo" /></a></li>
		<?php	
		if (isset($_SESSION['user_name']))
		{
		?>
		<li><a href="users.php">Users</a></li>  
		<li>
			<a href="profile.php?userId=<?php echo getUserId(); ?>" title="Profile"><?php echo $_SESSION['user_name']; ?></a>
			<div class="subnav">
				<table>
					<tr>
						<td style="vertical-align: top;">
							<a href="info.php?userId=<?php echo getUserId(); ?>" title="Info">Info</a>
						</td>
					</tr>
					<tr>
						<td>
							<a href="friends.php?userId=<?php echo getUserId(); ?>" title="Profile">Friends</a>
						</td>
					</tr>
					<tr>
						<td>
							<a href="albums.php?userId=<?php echo getUserId(); ?>" title="Profile">Albums</a>
						</td>
					</tr>
					<tr>
						<td><a href="accountSettings.php" title="Account Settings">Account&nbsp;Settings</a></td>
					</tr>
				</table>
			</div>
		</li>
		<li class="right" style="float: right;"><a href="index.php?logout=TRUE">Logout</a></li>
		<li class="right" style="float: right;"><a href="discuss.php">Discussions</a></li>  
		<?php
		}
		else
		{
			echo '<li class="right" style="float: right;"><a href="register.php">Register</a></li>';
		}
		?>
	</ul>
</nav>




<?php
	if (isLoggedIn())
	{
		if(getNumberOfNotifications(getUserId ()) > 0)
		{
			echo '<div id="notifications">';
			if(getNumberOfNotifications(getUserId ()) == 1)
			{
				echo 'You have ' . getNumberOfNotifications(getUserId ()) . ' friend request';
			}
			else
			{
				echo 'You have ' . getNumberOfNotifications(getUserId ()) . ' friend requests';
			}
			echo '</div>';
		}
	}
?>

	<div class="box" id="wrapper">