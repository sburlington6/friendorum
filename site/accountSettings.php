<?php
	require ('includes/functions.php');
	
	if ($logged_in)
{
	$userId = getUserId ();
	$password_changed = false;
	$errors = array();
	
	$question1 = isset($_POST["question1"]) ? $_POST["question1"] : "";
	$question2 = isset($_POST["question2"]) ? $_POST["question2"] : "";
	$question3 = isset($_POST["question3"]) ? $_POST["question3"] : "";
	$answer1 = isset($_POST["answer1"]) ? $_POST["answer1"] : "";
	$answer2 = isset($_POST["answer2"]) ? $_POST["answer2"] : "";
	$answer3 = isset($_POST["answer3"]) ? $_POST["answer3"] : "";
	
	$uname = isset($_POST["uname"]) ? $_POST["uname"] : "";
	
	if (isset($_POST['change_questions']))
	{
		
		if(strlen($answer1) < 2 || strlen($answer1) > 50)
		{
			$errors[] = "Answer 1 must be between 2 and 50 characters.";
		}
		
		if(strlen($answer2) < 2 || strlen($answer2) > 50)
		{
			$errors[] = "Answer 2 must be between 2 and 50 characters.";
		}
		
		if(strlen($answer3) < 2 || strlen($answer3) > 50)
		{
			$errors[] = "Answer 3 must be between 2 and 50 characters.";
		}
		
		if($question1 == "" OR $question1 == "0")
		{
			$errors[] = "You must select a Question for Question 1.";
		}
		
		if($question2 == "" OR $question2 == "0")
		{
			$errors[] = "You must select a Question for Question 2.";
		}
		
		if($question3 == "" OR $question3 == "0")
		{
			$errors[] = "You must select a Question for Question 3.";
		}
		
		if($question1 == $question2 OR $question2 == $question3 OR $question1 == $question3)
		{
			$errors[] = "You can not select the same security question more than once.";
		}
	
		$query = "SELECT * FROM user WHERE user_id = 'clean($userId)'";
		$result = mysqli_query($db, $query);
		while ($row = mysqli_fetch_assoc($result)) 
		{
			$crypt_pass = crypt($_POST['current_password'], $row["password"]);
			if($row["password"] != $crypt_pass)
			{
				$errors[] = 'that was not your current password';
			}
		}
		if (empty($errors))
		{
			$queryInsert = "UPDATE  `user` SET  `question1` =  'clean($question1)',`answer1` = 'clean($answer1)',`answer2` = 'clean($answer2)',`answer3` = 'clean($answer3)',`question2` =  'clean($question2)',`question3` =  'clean($question3)' WHERE  `user`.`user_id` = 'clean($userId)'"; //create the user
			$result = mysqli_query($db, $queryInsert);
			echo 'there were no errrors!';
			header( "Location: accountSettings.php" ) ;
		}
	}
	
	if (isset($_POST['change_password']))
	{
		$query = "SELECT * FROM user WHERE user_id = 'clean($userId)'";
		$result = mysqli_query($db, $query);
		while ($row = mysqli_fetch_assoc($result)) 
		{
			$crypt_pass = crypt($_POST['current_password'], $row["password"]);
			if($row["password"] != $crypt_pass)
			{
				$errors[] = 'that was not your current password';
			}
			if($_POST['new_password_check'] != $_POST['new_password'])
			{
				$errors[] = 'the passwords did not match';
			}
			if (strlen($_POST['new_password']) < 8 || strlen($_POST['new_password']) > 50)
			{
				$errors[] = "Password must be between 8 and 50 characters.";
			}
			if (empty($errors))
			{
				$new_crypt_pass = crypt($_POST['new_password'], makeSalt() );
				$updateQuery = "UPDATE  `user` SET  `password` =  'clean($new_crypt_pass)' WHERE  `user`.`user_id` = 'clean($userId)'";
				$updateResult = mysqli_query($db, $updateQuery);
				$password_changed = true;
			}
		}
	}
	
	if (isset($_POST['change_username']))
	{
		$query = "SELECT * FROM user WHERE user_id = 'clean($userId)'";
		$result = mysqli_query($db, $query);
		while ($row = mysqli_fetch_assoc($result)) 
		{
			$crypt_pass = crypt($_POST['current_password'], $row["password"]);
			if($row["password"] != $crypt_pass)
			{
				$errors[] = 'that was not your current password';
			}
		}
		if(strlen($uname) < 6 || strlen($uname) > 12)
		{
			$errors[] = "Username must be between 6 and 12 characters.";
		}
		if (empty($errors))
		{
			$updateQuery = "UPDATE  `user` SET  `username` =  'clean($uname)' WHERE  `user`.`user_id` = 'clean($userId)'";
			$updateResult = mysqli_query($db, $updateQuery);
			if (!$updateResult)
			{
				echo 'password update errors';
				echo mysqli_error($db);
			}
			$_SESSION['user_name'] = $uname ;
		}
	}
	
	#get current questions
	$query = "SELECT * FROM user WHERE user_id = 'clean($userId)'";
	$result = mysqli_query($db, $query);
	while ($row = mysqli_fetch_assoc($result)) 
	{
		$question1 = $row['question1'];
		$question2 = $row['question2'];
		$question3 = $row['question3'];
	}
	


?>
	<!DOCTYPE html> 
	<html>
		<head>
			<title>Account Settings</title>
			<meta charset="utf-8"/>
			<?php require ('includes/style.php'); ?>
		</head>
		
	  <?php 
		require("includes/header.php");
	  
			if (!empty($errors))
			{
				foreach($errors as $error)
				{
					echo "<p class=\"error\">$error</p>";
				}
			}
	  ?>
			
			<h2>Change Site Themes</h2>
			<?php  
			require ('includes/themeChanger.php');
			?>
			
			<h2>Change Your Password</h2>
			
			<?php
			if ($password_changed)
			{
				echo "Your password was changed successfully";
			}
			?>
			
			<form method="post" action="<?php echo $filename; ?>">
				<table>
					<tr>
						<td>Current Password: </td>
						<td><input type="password" name="current_password" /></td>
					</tr>
					<tr>
						<td>New Password: </td>
						<td><input type="password" name="new_password" /></td>
					</tr>
					<tr>
						<td>Confirm New Password: </td>
						<td><input type="password" name="new_password_check" /></td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" value="Change Password" name="change_password" /></td>
					</tr>
				</table>
			</form>
			
			<h2>Change Your Security Questions</h2>
			
			<form action="<?php echo $filename; ?>" method="post">
				<table>
					<tr>
						<td>Question 1: </td>
						<td>
							<select name="question1">
							<?php
								echo "<option value=\"0\">Select a Security Question</option>";
								
								$query = "SELECT * FROM security_questions";
								$result = mysqli_query($db, $query);

								while ($row = mysqli_fetch_assoc($result)) 
								{
									if ($question1 == $row['question_id'])
									{
										echo "<option selected=\"selected\" value=\"" . $row['question_id'] . "\">" . $row['question'] . "</option>";
									}
									else
									{
										echo "<option value=\"" . $row['question_id'] . "\">" . $row['question'] . "</option>";
									}
								}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Answer 1: </td>
						<td><input type="text" name="answer1" autocomplete="off" value="<?php echo $answer1; ?>"/></td>
					</tr>
					<tr>
						<td>Question 2: </td>
						<td>
							<select name="question2">
							<?php
								echo "<option value=\"0\">Select a Security Question</option>";
								
								$query = "SELECT * FROM security_questions";
								$result = mysqli_query($db, $query);

								while ($row = mysqli_fetch_assoc($result)) 
								{
									if ($question2 == $row['question_id'])
									{
										echo "<option selected=\"selected\" value=\"" . $row['question_id'] . "\">" . $row['question'] . "</option>";
									}
									else
									{
										echo "<option value=\"" . $row['question_id'] . "\">" . $row['question'] . "</option>";
									}
								}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Answer 2: </td>
						<td><input type="text" name="answer2" autocomplete="off" value="<?php echo $answer2; ?>"/></td>
					</tr>
					<tr>
						<td>Question 3: </td>
						<td>
							<select name="question3">
							<?php
								echo "<option value=\"0\">Select a Security Question</option>";
								
								$query = "SELECT * FROM security_questions";
								$result = mysqli_query($db, $query);

								while ($row = mysqli_fetch_assoc($result)) 
								{
									if ($question3 == $row['question_id'])
									{
										echo "<option selected=\"selected\" value=\"" . $row['question_id'] . "\">" . $row['question'] . "</option>";
									}
									else
									{
										echo "<option value=\"" . $row['question_id'] . "\">" . $row['question'] . "</option>";
									}
								}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Answer 3: </td>
						<td><input type="text" name="answer3" autocomplete="off" value="<?php echo $answer3; ?>"/></td>
					</tr>
					<tr>
						<td>Current Password: </td>
						<td><input type="password" name="current_password" /></td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" name="change_questions" value="Change Your Security Questions"/></td>
					</tr>
				</table>
			</form>
			
			<h2>Change Your Username</h2>
			
			<?php echo "Current Username: " . getUserName() . "<br>";?>
			
			<form action="<?php echo $filename; ?>" method="post">
				<table>
					<tr>
						<td>New Username: </td>
						<td><input type="text" name="uname" value="<?php echo $uname; ?>"/></td>
					</tr>
					<tr>
						<td>Current Password: </td>
						<td><input type="password" name="current_password" /></td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" name="change_username" value="Change Your Username"/></td>
					</tr>
				</table>
			</form>
			
			<br>
			<table>
				<tr>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="2"></td>
				</tr>
			</table>
			
			<?php
			
			require ('includes/close.php');
			require("includes/footer.php");
			?>
		</body>
	</html>
<?PHP
	}
	else
	{
		//header( "Location: index.php" ) ;
	}
	
?>