<?php
	require ('includes/functions.php');
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
	?>
		<h1>Changelog</h1>
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
			?>
		</table>
			
		<?php
		require("includes/close.php");
		require("includes/footer.php");
		?>
	</body>
</html>