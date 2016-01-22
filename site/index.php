<?php
require("includes/functions.php");

$registered = isset($_GET['registered']) ? $_GET['registered'] : "false";

if ($logged_in)
{
//start status validation
	$errors = array();
	$taerrors = false;
	$text = isset($_POST["text"]) ? $_POST["text"] : "";
	$comment = isset($_POST["comment"]) ? $_POST["comment"] : "";
	$statusId = isset($_POST["statusId"]) ? $_POST["statusId"] : "";
        
	if (isset($_POST["statusSubmit"]))
	{
		if($text == "")
		{
			$errors[] = "Status cannot be blank.";
		}
		else
		{
			if(strlen($text) < 1 || strlen($text) > 200)
			{
				$errors[] = "Status must be between 1 and 200 characters.";
			}
		}
		
		$userId = getUserId ();
		
		if(empty($errors))
		{
			$queryInsert = "INSERT INTO status (user_id, status) VALUES ('$userId', '$text')";
			$result = mysqli_query($db, $queryInsert);
			
			$text = "";

			if(!$result)
			{
				echo "MySQL error" . mysqli_error($db);
				exit();
			}
		}
	}
	//end status validation
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
	
	if (isset($_POST['removeStatus']))
	{
		$statusToRemove = $_POST['statusId'];
		$query = "DELETE FROM `status` WHERE `status_id` = ".clean($statusToRemove);
		$result = mysqli_query($db, $query);
	}
	if (isset($_POST['removeComment']))
	{
		$commentToRemove = $_POST['commentId'];
		$query = "DELETE FROM `comment` WHERE `comment_id` = ".clean($commentToRemove);
		$result = mysqli_query($db, $query);
		header( "Location: index.php" ) ;
	}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Welcome</title>
	<?php require ('includes/style.php'); ?>
	<link rel="stylesheet" href="includes/styles/status.css">
  </head>
  
	  <?php 
		require("includes/headder.php");
	  ?>
	<div class="login">
		Welcome <h3><?PHP echo getName(); ?></h3>
	</div>
	<?php
	
	if (!empty($errors))
	{
		foreach($errors as $error)
		{
			echo "<p class=\"error\">$error</p>";
		}
	}
	
	
	?>
	<form action="<?php echo $filename; ?>" method="post">
		<table>
			<tr>
				<td>
					<textarea rows="4" cols="50" name="text" class="word_count" id="status"><?php echo $text; ?></textarea>
					<br/>
					<span class="counter"></span>
				</td>
				<td>
					<input type="submit" value="Submit" name="statusSubmit"/>
				</td>
			</tr>
		</table>
	</form>
	
	<div id="statuses">
	<?php
//status start
		$query = "SELECT * FROM status ORDER BY `date` DESC ";
		$result = mysqli_query($db, $query);

		while ($row = mysqli_fetch_assoc($result)) 
			{
				$userId = getUserId ();
				if (friends($userId , $row['user_id']))
				{
				echo '<div class="fullStatus">';
				echo"<div class='status'>";
				
				echo '<table class="statusT"><tr>';
					echo 	"<td style='width: 155px; text-align: center;'>";
					echo  "<a href=\"profile.php?userId=" . $row["user_id"] . "\">" .getProfilePic($row['user_id'],'medium','yes') . "</a></td>" ;
					
					
				echo '<td style="vertical-align: top;"><table><tr><td>';
					echo 	"<a href=\"profile.php?userId=" . $row["user_id"] . "\">" . lookUpName($row["user_id"]) . "</a> " ;

					date_default_timezone_set('America/New_York');
					echo "<span style='font-size: 70%;'>" . nicetime($row['date']). "</span>";
					
					//remove status form
					if (yours(lookUpUserName($row["user_id"]))) //if its your status
					{
						echo "<form method=\"post\" action=\"$filename\" class='button' style='float: right;'>";
						echo 	"<input type=\"hidden\" name=\"statusId\" value=\"" . $row['status_id'] . "\"/>";
						echo 	"<input type=\"submit\" value=\"Remove Status\" name=\"removeStatus\"/>";
						echo "</form>";
					}
					//end remove status form
					
					echo '</td></tr><tr><td>';
					
					echo $row['status'];
					
					echo '</td></tr><tr><td>';
					
					?>
					
					<form action="<?php echo $filename;?>" method="post" class='button'>
						<input type="hidden" name="statusId" value="<?php echo $row['status_id'];?>"/>
						<input type="submit" value="Comment" name="newComment"/>
					</form>	
					
					<?php
					if (isset($_POST['newComment']) AND $_POST['statusId'] == $row['status_id'])
					{
						?>
						<form action="<?php echo $filename;?>" method="post">
							<input type="hidden" name="statusId" value="<?php echo $row['status_id'];?>"/>
							Comment:<input type="text" name="comment" value="<?php echo $comment; ?>"/>
							<input type="submit" value="Submit" name="commentSubmit"/>
						</form>	
						<a href="<?php echo $filename;?>">Cancel</a>
						<?php
					}
					
				echo '</td></tr></table>';
				echo '</td></tr></table>';
				echo "</div>";
					
					$innerquery = "SELECT * FROM comment WHERE status_id = '".clean($row['status_id'])."' ORDER BY `comment_date` DESC ";
					$innerresult = mysqli_query($db, $innerquery);
					if ($innerresult AND mysqli_num_rows ($innerresult) > 0)
					{
							echo '<div class="comment">';
							echo '<table>';
						while ($innerrow = mysqli_fetch_assoc($innerresult)) 
						{
							echo '<tr><td>';
							echo 	'<a href="profile.php?userId='.$innerrow['user_id'].'">' . getProfilePic($innerrow['user_id'],'small','yes') . '</a> ';
							echo '</td><td>';
							echo 	'<a href="profile.php?userId='.$innerrow['user_id'].'">' . lookUpName($innerrow['user_id']) . '</a>: ' . $innerrow['comment'];
							echo " <span style='font-size: 70%;'>" . nicetime($innerrow['comment_date']). "</span>";
							if (yours(lookUpUserName($innerrow["user_id"])) OR yours(lookUpUserName($row["user_id"])))
							{
							echo '</td><td>';
								echo 	"<form method=\"post\" action=\"$filename\" class=\"remove\" style='float: right;'>";
                                                                echo 		"<input type=\"hidden\" name=\"commentId\" value=\"" . $innerrow['comment_id'] . "\"/>";
								echo 		"<input type=\"submit\" value=\"Remove Comment\" name=\"removeComment\"/>";
								echo 	"</form>";
							}
							echo '</td></tr>';
						}	
							echo '</table>';
							echo '</div>';
					}
					echo '</div>';
				}
			}
//status end
			?>	
			</div>
<?PHP
} 
else
{
?>
	<!DOCTYPE html>
	<html>
	  <head>
		<meta charset="utf-8" />
		<title>Login</title>
		<?php require ('includes/style.php'); ?>
	  </head>
	  
	  <?php 
		require("includes/headder.php");
	  
	if ($registered == "true")
	{
		echo "You are registered and may now log in";
	}
	
	  ?>
	  
		<div id="logo">
			<img src="images/logos/logo.png" width="845" height="126" alt="Logo" />
		</div>
		<div class="login">
			<form method="post" action="<?php echo $filename; ?>" id="login">
			  
				Username or Email:
				<input type="text" size="14" name="login_user_name" />
				Password:
				<input type="password" size="14" name="login_password" />
				<input type="submit" value="Login" name="login" />
			  
			</form>
                    <br/>
			<a href="passwordReset.php">Forgot Your Password?</a>
			<a href="register.php">Register</a>
		</div>
		
<?PHP
}
if ($login_error AND !$guest) 
{
  echo '    <div id="login-error"><b>Login failed!</b> User name or password was incorrect.<br /></div>';
}
if ($guest)
{
    echo '<div id="alpha" style="text-align: center; width: 700px; margin: auto;"><p>Friendorum.com is currently in the testing phase and can only allow a few accounts to be used at this time. Once the site goes into beta we will be able to allow more users access. For now you are registered and will be notified when you are granted access. Thank you for showing interest in Friendorum.com</p></div>';
}
  
	require("includes/close.php");
	require("includes/footer.php");
	?>
	</body>
</html>