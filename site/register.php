<?php
	require ('includes/functions.php');
	require ('validation.php');
	
	if ($logged_in)
	{
	?>
		<!DOCTYPE html> 
		<html>
			<head>
				<meta charset="utf-8"/>
				<title>Register</title>
				<?php 
				require ('includes/style.php'); 
				?>
				
			</head>
			
				<?php 
					require("includes/headder.php");
				?>
				<h1>Register</h1>
				<p>You are already logged in. You have no need to register</p>
				<p>You can go <a href="index.php">Home</a> or <a href="<?php echo $filename; ?>?logout=TRUE">Logout</a>  </p>
				
				<?php
				require("includes/footer.php");
				?>
				
			</body>
		</html>
		
	<?php				  
	} 
	else
	{
		?>
		<!DOCTYPE html> 
		<html>
		   <head>
			<meta charset="utf-8"/>
			<title>Register</title>
			<?php 
			require ('includes/style.php');			
			?>
		  </head>
		  
			  <?php 
				require("includes/headder.php");
			  
				echo "<h1>Register</h1>";
			  
			  if (!empty($errors) AND isset($_POST['register']))
			  {
				echo "<p>There are errors:</p>";
				foreach($errors as $error)
				{
				  echo "<p class=\"error\">$error</p>";
				}
			  }
			  
			  
			  ?>
			
			<form action="register.php" method="post" name="userform">
				<table>
					<tr>
						<td>First Name: </td>
						<td><input type="text" name="fname" value="<?php echo $fname; ?>"/></td>
						<td>Last Name: </td>
						<td><input type="text" name="lname" value="<?php echo $lname; ?>"/></td>
					</tr>
					<tr>
						<td>Username: </td>
						<td><input type="text" name="uname" value="<?php echo $uname; ?>"/></td>
						<td>E-mail: </td>
						<td><input type="text" name="email" value="<?php echo $email; ?>"/></td>
					</tr>
					<tr>
						<td>Birth Date: </td>
						<td colspan="3">
							<select name="bmonth" id="bmonth">
								<option value="">Month: </option>
								<?php
								$months = array(
								'',
								'January',
								'February',
								'March',
								'April',
								'May',
								'June',
								'July',
								'August',
								'September',
								'October',
								'November',
								'December',
								);
								for ($k=1;$k<=12;$k++)
								{
										if ($k == $bmonth)
										{
											echo " <option value=\"" . $k . "\" selected = \"selected\">" . $months[$k] . "</option>";
										}
										else
										{
											echo " <option value=\"" . $k . "\" >" . $months[$k] . "</option>";
										}
									}
							?>
							</select>
							<select name="bday" id="bday">
								<option value="">Day:</option>
								<?php
									for ($i=1;$i<=31;$i++)
									{
										if ($i == $bday)
										{
											echo " <option value=\"" . $i . "\" selected = \"selected\">" . $i . "</option>";
										}
										else
										{
											echo " <option value=\"" . $i . "\" >" . $i . "</option>";
										}
									}
								?>
							</select>
							<select name="byear" id="byear">
								<option value="">Year:</option>
								<?php	
									$year = date("Y");
									$ye = $year - 200;
									for ($j=date("Y");$j>=$ye;$j--)
									{
										if ($j == $byear)
										{
											echo "<option value=\"" . "$j" . "\" selected = \"selected\">" . $j . "</option>";
										}
										else
										{
											echo "<option value=\"" . "$j" . "\" >" . $j . "</option>";
										}
									}
								?>
							</select>
						</td>
					</tr>
				</table>
				<table>
					<tr>
						<td>Question 1: </td>
						<td><select name="question1">
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
						</select></td>
					</tr>
					<tr>
						<td>Answer 1: </td>
						<td><input type="text" name="answer1" autocomplete="off" value="<?php echo $answer1; ?>"/></td>
					</tr>
					<tr>
						<td>Question 2: </td>
						<td><select name="question2">
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
						</select></td>
					</tr>
					<tr>
						<td>Answer 2: </td>
						<td><input type="text" name="answer2" autocomplete="off" value="<?php echo $answer2; ?>"/></td>
					</tr>
					<tr>
						<td>Question 3: </td>
						<td><select name="question3">
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
						</select></td>
					</tr>
					<tr>
						<td>Answer 3: </td>
						<td><input type="text" name="answer3" autocomplete="off" value="<?php echo $answer3; ?>"/></td>
					</tr>
				</table>
				
				
				<table>
					<tr>
						<td>Password:</td>
						<td><input type="password" name="pass1"/></td>
					</tr>
					<tr>
						<td>Confirm Password:</td>
						<td><input type="password" name="pass2"/></td>
					</tr>
				</table>
			  
				<table>
					<tr>
						<th colspan="6">Profile Pic</th>
					</tr>
					<tr>
					
					<?php
						$query = "SELECT * FROM `images` WHERE `user_id` is null";
						$result = mysqli_query($db, $query);
						if(!$result)
						{
							echo mysqli_error($db);
						}
						$trow = 1;
						while ($row = mysqli_fetch_assoc($result)) 
						{
							if ($profile_pic == $row['medium'])
							{
								echo '<td><input type="radio" name="profile_pic" id="' . $row['medium'] . '" value="' . $row['image_id'] . '" checked/></td>';
								echo '<td><label for="' . $row['medium'] . '"><img src="' . $row['medium'] . '" alt="profile pic option ' . $row['medium'] . '"/></label></td>';
							}
							else
							{	
							echo '<td><input type="radio" name="profile_pic" id="' . $row['medium'] . '" value="' . $row['image_id'] . '" /></td>';
							echo '<td><label for="' . $row['medium'] . '"><img src="' . $row['medium'] . '" alt="profile pic option ' . $row['medium'] . '"/></label></td>';
							}
							if ($trow % 3 == 0)
							{
								echo '</tr>';
								echo '</table>';
								echo '<table>';
								echo '<tr>';
							}
							$trow++;
						}
						require ('includes/close.php');
					?>
					</tr>
				</table>
			  
			  <p><input type="submit" name="register" value="Register"/></p>
			</form>
			<?php			
			require("includes/footer.php");
			?>
		  </body>
		</html>
	<?php
}	
?>