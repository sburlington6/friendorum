<?php
	require ('includes/functions.php');
	
	$qerrors = array();
	$uerrors = array();
	
	$answer1 = isset($_POST["answer1"]) ? $_POST["answer1"] : "";
	$answer2 = isset($_POST["answer2"]) ? $_POST["answer2"] : "";
	$answer3 = isset($_POST["answer3"]) ? $_POST["answer3"] : "";
	
	$uname = isset($_POST["uname"]) ? $_POST["uname"] : "";
	
	$password_changed = false;
	
	if (isset($_POST['username_submit']))
	{
		$validname = false;
		$query = "SELECT * FROM user WHERE username = '".clean($uname)."'";
		$result = mysqli_query($db, $query);
		echo mysqli_error($db);
		while ($row = mysqli_fetch_assoc($result)) 
		{
			$validname = true;
		}
		if ($uname == "" OR !$validname)
		{
			$uerrors[] = 'Your must enter a valid username';
		}
	}
	
	if (empty($uerrors) AND (isset($_POST['submit']) OR isset($_POST['username_submit'])))
	{
		#get current questions
		$userId = lookUpUserId($uname);
		$query = "SELECT * FROM user WHERE user_id = '".clean($userId)."'";
		$result = mysqli_query($db, $query);
		echo mysqli_error($db);
		while ($row = mysqli_fetch_assoc($result)) 
		{
			$question1 = $row['question1'];
			$question2 = $row['question2'];
			$question3 = $row['question3'];
			$real_answer1 = $row['answer1'];
			$real_answer2 = $row['answer2'];
			$real_answer3 = $row['answer3'];
		}
	}
	
	if (isset($_POST['submit']))
	{
		if ($answer1 != $real_answer1)
		{
			$qerrors[] = 'Your Answer for Question 1 is Wrong';
		}
		if ($answer2 != $real_answer2)
		{
			$qerrors[] = 'Your Answer for Question 2 is Wrong';
		}
		if ($answer3 != $real_answer3)
		{
			$qerrors[] = 'Your Answer for Question 3 is Wrong';
		}
	}
	
	if (empty($qerrors) AND empty($qerrors) AND isset($_POST['submit']))
	{
		$newPass = makePass();
		$new_crypt_pass = crypt($newPass, makeSalt() );
		$updateQuery = "UPDATE  `user` SET  `password` =  '".clean($new_crypt_pass)."' WHERE  `user`.`user_id` = '".clean($userId)."'";
		$updateResult = mysqli_query($db, $updateQuery);
		$password_changed = true;
	}

?>
	<!DOCTYPE html> 
	<html>
		<head>
			<title>Password Reset</title>
			<meta charset="utf-8"/>
			<?php require ('includes/style.php'); ?>
		</head>
		
	  <?php 
		require("includes/headder.php");
	  
	  if (!empty($uerrors) OR !empty($qerrors))
	  {
		foreach($uerrors as $error)
		{
		  echo "<p class=\"error\">$error</p>";
		}
		foreach($qerrors as $error)
		{
		  echo "<p class=\"error\">$error</p>";
		}
	  }
	  if ($password_changed)
	  {
		echo "Your password has been successfully changed to: " . $newPass;
		echo "<br>You may now <a href=\"index.php\">Login</a>";
	  }
	  
		if (!isset($_POST['uname']) OR !empty($uerrors))
		{
	  ?>
			<h2>Enter Your Username</h2>
			
			<form method="post" action="<?php echo $filename; ?>">
			<p>Your Username: <input type="text" name="uname" value="<?php echo $uname; ?>"/></p>
			<p><input type="submit" name="username_submit" value="Submit"/></p>
			</form>
			
			<?php
		}
			if (empty($uerrors) AND isset($_POST['uname']) AND !$password_changed)
			{
			?>
				<h2><?php echo $uname ?> Password Reset</h2>
				<form method="post" action="<?php echo $filename; ?>">
				<input type="hidden" name="uname" value="<?php echo $uname;?>"/>
				<p>Question 1
				<?php
				$query = "SELECT * FROM security_questions WHERE question_id = '".clean($question1)."'";
				$result = mysqli_query($db, $query);

				while ($row = mysqli_fetch_assoc($result)) 
				{
						echo '<p>' . $row['question'] . '</p>';
				}
				?>
					<p>Answer 1: <input type="text" name="answer1" autocomplete="off" value="<?php echo $answer1; ?>"/></p>
					<p>Question 2
					<?php
						$query = "SELECT * FROM security_questions WHERE question_id = '".clean($question2)."'";
						$result = mysqli_query($db, $query);

						while ($row = mysqli_fetch_assoc($result)) 
						{
								echo '<p>' . $row['question'] . '</p>';
						}
					?>
					</select></p>
					<p>Answer 2: <input type="text" name="answer2" autocomplete="off" value="<?php echo $answer2; ?>"/></p>
					<p>Question 3
					<?php
						$query = "SELECT * FROM security_questions WHERE question_id = '".clean($question3)."'";
						$result = mysqli_query($db, $query);

						while ($row = mysqli_fetch_assoc($result)) 
						{
								echo '<p>' . $row['question'] . '</p>';
						}
					?>
					</select></p>
					<p>Answer 3: <input type="text" name="answer3" autocomplete="off" value="<?php echo $answer3; ?>"/></p>
				
				<p><input type="submit" name="submit" value="Reset Your Password"/></p>
				</form>
			<?php
			}
			require ('includes/close.php');
			require("includes/footer.php");
			?>
		</body>
	</html>