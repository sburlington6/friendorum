<?php

	require ('includes/functions.php');
	
	
	if ($logged_in)
{
	$errors = array();
			
	$threadId = isset($_REQUEST["threadId"]) ? $_REQUEST["threadId"] : "";	
	$subject = isset($_POST["subject"]) ? $_POST["subject"] : "";
	$comment = isset($_POST["comment"]) ? $_POST["comment"] : "";
	$userId = getUserId ();
	
	if ($threadId == "")
	{
		header( "Location: index.php" ) ;
	}
	
	$query = "SELECT * FROM thread WHERE thread_id ='".clean($threadId)."'";
	$result = mysqli_query($db, $query);

	while ($row = mysqli_fetch_assoc($result)) 
	{
		$threadName = $row["thread_name"];
		$description = $row["description"];
		$text = $row["thread_text"];
	}	
			
	$taerrors = false;		
	
	if (isset($_POST["submit"]))
	{
		$posted = true;
		
		if($subject == "")
		{
			$errors[] = "subject name cannot be blank.";
		}
		
		if($comment == "" OR $comment == "Comment")
		{
			$errors[] = "comment cannot be blank.";
		}
		
		if(strlen($subject) < 2 || strlen($subject) > 50)
		{
			$errors[] = "subject name must be between 2 and 50 characters.";
		}
		
		if(strlen($comment) < 2)
		{
			$errors[] = "Comment must be at least 2 characters";
		}
		
		$checkQuery = "SELECT * FROM post WHERE thread_id ='".clean($threadId)."' AND subject ='".clean($subject)."' AND comment = '".clean($comment)."'";
		$checkResult = mysqli_query($db, $checkQuery);

		if ($checkResult)
		{
			while ($checkRow = mysqli_fetch_assoc($checkResult)) 
			{
				$errors[] = "That comment already exists!";
				$subject = "";
				$comment = "";
			}
		}
	
		if(empty($errors))
		{
			$queryInsert = "INSERT INTO post (thread_id, user_id, subject, comment) VALUES ('".clean($threadId)."', '".clean($userId)."', '".clean($subject)."', '".clean($comment)."')";
			$result = mysqli_query($db, $queryInsert);

			unset ($_POST['comment']);
			
			$subject = "";
			$comment = "";
			
		}
		else
		{
			$taerrors = true;
		}
	}
	
	if (isset($_POST['removecomment']))
	{
		$postToRemove = $_POST['commentId'];
		$query = "DELETE FROM `post` WHERE `post`.`post_id` = ".clean($postToRemove);
		$result = mysqli_query($db, $query);
		header( "Location: thread.php?threadId=$threadId" ) ;
	}
	if (isset($_POST['editsubmit']))
	{
		$subjectEdit = $_POST['subjectEdit'];
		$commentEdit = $_POST['commentEdit'];
		$threadIdedit = $_POST['threadIdedit'];
		$query = "UPDATE `post` SET `subject` =  '".clean($subjectEdit)."',`comment` =  '".clean($commentEdit)."' WHERE `post_id` = ".clean($threadIdedit);
		$result = mysqli_query($db, $query);
		echo mysqli_error($db);
	}
	

?>
<!doctype html>
<html>
	<head>
		<title><?php echo $threadName;?></title>
		<meta charset="utf-8"/>
		<?php require ('includes/style.php'); ?>
	</head>
	
	  <?php 
		require("includes/headder.php");
	  ?>
		<h1><?php echo $threadName . " - " . $description;?></h1>
		<p><?php echo $text;?></p>
		<?php
		if ($taerrors)
		{
			echo "<p>There are errors:</p>";
			foreach($errors as $error)
			{
			  echo "<p class=\"error\">$error</p>";
			}
		}
		?>
		<table>
			<tr>
				<th>Posted by</th>
				<th>Subject</th>
				<th>Comment</th>
				<th>Date</th>
			</tr>
		<?php
		$query = "SELECT * FROM post WHERE thread_id ='".clean($threadId)."' ORDER BY post_date DESC";
		$result = mysqli_query($db, $query);

		while ($row = mysqli_fetch_assoc($result)) 
		{
			echo"<tr>";
			
			$id = $row["user_id"];
			$userName = lookUpUserName($id);
			
				echo"<td>";
				echo 	"<a href=\"profile.php?userId=" . $row["user_id"] . "\">" . $userName . "</a><br>";
				if (yours ($userName))
				{
					echo "<form method=\"post\" action=\"$filename\">";
					echo 	"<input type=\"hidden\" name=\"threadId\" value=\"" . $threadId . "\"/>";
					echo 	"<input type=\"hidden\" name=\"commentId\" value=\"" . $row['post_id'] . "\"/>";
					echo 	"<input type=\"submit\" value=\"Remove Comment\" name=\"removecomment\"/>";
					echo 	"<input type=\"submit\" value=\"edit Comment\" name=\"editcomment\"/>";
					echo "</form>";
				}
				echo 	getUserSig($id);
				echo "</td>";
				echo"<td>" . $row["subject"] . "</td>";
				echo"<td>" . $row["comment"] . "</td>";
				echo"<td>" . convertTimestamp($row["post_date"]) . "</td>";
			echo"</tr>";
				if (isset($_POST['editcomment'])) // form to edit comments
				{
					if ($_POST['commentId'] == $row['post_id'])
					{
						?>
						<tr><td colspan='4'>
						
						<form action="thread.php" method="post">
							<input type="hidden" name="threadIdedit" value="<?php echo $row['post_id'];?>"/>
							<input type="hidden" name="threadId" value="<?php echo $threadId;?>"/>
							Subject:<input type="text" name="subjectEdit" value="<?php echo $row['subject']; ?>"/>
							Comment: <textarea rows="4" cols="50" name="commentEdit"><?php echo $row['comment']; ?></textarea>
							<input type="submit" value="Submit" name="editsubmit"/>
						</form>	
						
						</td>
					</tr>
				
					<?php	
					}
				}
		}
		require ('includes/close.php');
		
		echo '</table>';
		
		if (!isset($_POST['comment']))
		{
		?>
		
	
		<form action="thread.php" method="post">
			<input type="hidden" name="threadId" value="<?php echo $threadId;?>"/>
			<input type="submit" value="Comment" name="comment"/>
		</form>	
		<?php
		}
		if (isset($_POST['comment']))
		{
		require("includes/comment.php");
		}
		
			require("includes/footer.php");
		?>
	</body>
</html>
<?PHP
} 
else
{
require ('includes/notloggedin.php');
} 
?>