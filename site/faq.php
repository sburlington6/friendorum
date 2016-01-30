<?php
	require ('includes/functions.php');
	
	$search = isset($_GET["search"]) ? $_GET["search"] : "Search";
	
if (isset($_GET['searchSubmit']))
{
	//$search = $_GET['search'];
	$results = array();
	$taResults = false;
	
	$query = "SELECT * FROM user";
	$result = mysqli_query($db, $query);

	while ($row = mysqli_fetch_assoc($result)) 
	{
		if ($search == "")
		{
			$search = "Search";
		}
		
		$searchLower = strtolower($search);
		$un = strtolower($row['username']);
		$pos = strpos($un,$searchLower);

		if($pos === false) 
		{
			// string needle NOT found in haystack
			
		}
		else 
		{
			// string needle found in haystack
			$taResults = true;
			$results[] = $row['user_id']; 
		}
	}
}

?>
<!doctype html>
<html>
	<head>
		<title>FAQ</title>
		<meta charset="utf-8"/>
		<?php require ('includes/style.php'); ?>
	</head>
	
	  <?php 
		require("includes/header.php");
	  ?>
		<h1>FAQ</h1>
			<table>
				<tr>
					<th>Type</th>
					<th>Question</th>
					<th>Answer</th>
					<th>Need Loign</th>
				</tr>
			<?php
			
			$query = "SELECT * FROM faq";
			$result = mysqli_query($db, $query);

			while ($row = mysqli_fetch_assoc($result)) 
				{
					echo "<tr>";
					echo 	"<td>" . $row['question_type'] . "</td>";
					echo 	"<td>" . $row['question'] . "</td>";
					echo 	"<td>" . $row['answer'] . "</td>";
					echo 	"<td>" . $row['need_login'] . "</td>";
					echo "</tr>";
				}
			require ('includes/close.php');
			
			echo "</table>";
			require("includes/footer.php");
		?>
	</body>
</html>