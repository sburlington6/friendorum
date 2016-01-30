<?php
require("includes/functions.php");

if ($logged_in)
{
	//start new thread validation
	$errors = array();
	$taerrors = false;
	$name= isset($_POST["name"]) ? $_POST["name"] : "";
	$topic = isset($_POST["topic"]) ? $_POST["topic"] : "";
	$desc = isset($_POST["desc"]) ? $_POST["desc"] : "";
	$text = isset($_POST["text"]) ? $_POST["text"] : "";
	$added = false;

	if (isset($_POST["submit"]))
	{
		if($name == "")
		{
			$errors[] = "Thread name cannot be blank.";
		}
		
		if($topic == "")
		{
			$errors[] = "Topic name cannot be blank.";
		}
		
		if($desc == "")
		{
			$errors[] = "Description cannot be blank.";
		}
		
		if($text == "")
		{
			$errors[] = "Text cannot be blank.";
		}
		
		if(strlen($name) < 2 || strlen($name) > 50)
		{
			$errors[] = "Thread name must be between 2 and 50 characters.";
		}
		
		if(strlen($topic) < 2 || strlen($topic) > 50)
		{
			$errors[] = "Topic must be between 2 and 50 characters.";
		}
		
		if(strlen($desc) < 2)
		{
			$errors[] = "Description must be at least 2 characters";
		}
		
		if(strlen($text) < 2)
		{
			$errors[] = "Text must be at least 2 characters";
		}
		
		$query = "SELECT thread_name FROM thread";
		$result = mysqli_query($db, $query);

		while ($row = mysqli_fetch_assoc($result)) 
			{
				if ($name == $row["thread_name"])
				{
					$errors[] = "That thread already exists.";
				}
			
			}
		
		$userId = getUserId ();
		
		
		if(empty($errors))
		{
			$queryInsert = "INSERT INTO thread (thread_id, user_id, topic, thread_name, thread_date, description, thread_text) VALUES (NULL, 'clean($userId)', 'clean($topic)', 'clean($name)', CURRENT_TIMESTAMP, 'clean($desc)', 'clean($text)')";
			$result = mysqli_query($db, $queryInsert);
			
			$name = "";
			$topic = "";
			$desc = "";
			$text = "";
			
			$added = true;

			if(!$result)
			{
				echo "MySQL error" . mysqli_error($db);
				exit();
			}
			$taerrors = false; 
		}
		else
		{
			$taerrors = true; //if there are errors 
		}
	}
	//end new thread validation
	
	
	
	if (isset($_POST['removeThread']))
	{
		$threadToRemove = $_POST['threadId'];
		$query = "DELETE FROM `thread` WHERE `thread`.`thread_id` = clean($threadToRemove)";
		$result = mysqli_query($db, $query);
	}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Welcome</title>
	<?php require ('includes/style.php'); ?>
  </head>
  
	  <?php 
		require("includes/header.php");
	  ?>
	<div id="login">
		Welcome <h3><?PHP echo getUserName(); ?></h3>!
	</div>
	<?php
	if (isset($_GET['newThread']))
	{
		require("includes/newthread.php");
	}
	
	if ($added)
	{
		echo "Thread added";
	}
	
	if ($taerrors)
	{
		foreach($errors as $error)
		{
			echo "<p class=\"error\">$error</p>";
		}
		require_once("includes/newthread.php");
	}
	
	if (!isset($_GET['newThread']))
	{
	?>
	<form method="get" action="<?php echo $filename; ?>">
		<input type="submit" value="Create a New Thread" name="newThread"/>
	</form>
	<?php
	}
	?>
	
	
	
	<table>
		<tr>
			<th>Thread</th>
			<th>Topic</th>
			<th>Number of Posts</th>
			<th>Statred By</th>
			<th>Description</th>
			<th>Last Poster</th>
			<th>Date Created</th>
		</tr>
		
	
	<?php
		$query = "SELECT * FROM thread ORDER BY `thread_date` DESC ";
		$result = mysqli_query($db, $query);

		while ($row = mysqli_fetch_assoc($result)) 
			{
				if (getLastPosterId($row["thread_id"]) == 0)
				{
					$lastPost = "There are no posts in this thread";
				}
				else
				{
					$lastPost = lookUpUserName(getLastPosterId($row["thread_id"]));
				}
				
				echo"<tr>";
				echo"<td><a href=\"thread.php?threadId=" . $row["thread_id"] . "\">" . $row["thread_name"] . "</a></td>";
				echo"<td>" . $row["topic"] . "</td>";
				echo"<td>" . getNumberOfPostsThread($row["thread_id"]) . "</td>";
				echo"<td>";
				echo 	"<a href=\"profile.php?userId=" . $row["user_id"] . "\">" . lookUpUserName($row["user_id"]) . "</a>" ;
				if (yours (lookUpUserName($row["user_id"])))
				{
					echo "<form method=\"post\" action=\"$filename\">";
					echo 	"<input type=\"hidden\" name=\"threadId\" value=\"" . $row['thread_id'] . "\"/>";
					echo 	"<input type=\"submit\" value=\"Remove Thread\" name=\"removeThread\"/>";
					echo "</form>";
				}
				echo "</td>";
				echo"<td>" . $row["description"] . "</td>";
				echo"<td>" . $lastPost . "</td>";
				echo"<td>" . convertTimestamp($row["thread_date"]) . "</td>";
				echo"</tr>";
			}
			?>	
	</table>
	
<?PHP

	require("includes/close.php");
	require("includes/footer.php");
} 
else
{
	require("includes/notloggedin.php");
}
?> 
	
	