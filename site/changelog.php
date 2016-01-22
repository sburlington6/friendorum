<?php
	require ('includes/functions.php');
	$change = isset($_POST["change"]) ? $_POST["change"] : "";

	
	$errors=array();
	if (isset($_POST['submit']))
	{
		if (strlen($change) < 2)
		{
			$errors[] = "The change must be more than two characters.";
		}
		if (empty($errors))
		{
			$query = "INSERT INTO changelog (`change`) VALUES ('".clean($change)."')";
			$result = mysqli_query($db, $query);
			if (!$result)
			{
				echo mysqli_error($db);
			}
			$change = '';
		}
	}
?>
<!doctype html>
<html>
	<head>
		<title>Changelog</title>
		<meta charset="utf-8"/>
		<?php require ('includes/style.php'); ?>
	</head>
	
	  <?php 
		require("includes/headder.php");
	  
		echo '<h1>Changelog</h1>';
		
		
		if (!empty($errors))
			  {
				foreach($errors as $error)
				{
				  echo "<p class=\"error\">$error</p>";
				}
			  }
		if ($logged_in AND getRole() == 'owner')
		{
		?>
			<form action="<?php echo $filename; ?>" method="post">
				<table>
					<tr>
						<td>Change: <textarea rows="10" cols="50" name="change" onKeyPress="return checkSubmit(event)"><?php echo $change; ?></textarea></td>
					</tr>
					<tr>
						<td><input type="submit" value="Submit" name="submit" /></td>
					</tr>
				</table>
			</form>
			
			<script>
			<!--
			function checkSubmit(e)
			{
			   if(e && e.keyCode == 13)
			   {
				  document.forms[0].submit();
			   }
			}
			-->
			</script>
		<?php
		}
		?>
			<table>
				<tr>
					<th>Change</th>
					<th>Date</th>
				</tr>
			<?php
			
			$query = "SELECT * FROM changelog ORDER BY date DESC ";
			$result = mysqli_query($db, $query);

			while ($row = mysqli_fetch_assoc($result)) 
				{
					echo "<tr>";
					echo 	"<td>" . $row['change'] . "</td>";
					echo 	"<td>" . convertTimestamp($row['date']) . "</td>";
					echo "</tr>";
				}
			
			echo "</table>";
			?>
			<div id="rss">
				<a href="http://www.gettingsocial.tk/feed.php"><img src="images/rss.gif" alt="rss" height="34" width="34"/></a>
			</div>	
			<?php
			require("includes/close.php");
			require("includes/footer.php");
		?>
	</body>
</html>