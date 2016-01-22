<?php
	require ('includes/functions.php');
	
	$search = isset($_GET["search"]) ? $_GET["search"] : "";
	
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

	
if ($logged_in)
{
?>
<!doctype html>
<html>
	<head>
		<title>Users</title>
		<meta charset="utf-8"/>
		<?php require ('includes/style.php'); ?>
	</head>
	
	  <?php 
		require("includes/headder.php");

	  
	  ?>
		<h1>Registered Users</h1>
		
		<form method="get" action="<?php echo $filename; ?>">
			<table>
				<tr>
					<td>Username:</td>
				</tr>
				<tr>
					<td>
						<input class="swap" id="s" type="text" name="search"/>
					</td>
				</tr>
				<tr>
					<td>Gender:</td>
				</tr>
				<tr>
					<td>
						<select name="genderEdit">
							<option value="">Gender</option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
							<option value="Other">Other</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Age:</td>
				</tr>
				<tr>
					<td>
						<select name="ageFrom">
							<option value=""></option>
						<?php
						for ($i=13;$i<=100;$i++)
						{
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
						?>
							<option value="100+">100+</option>
						</select>
						to
						<select name="ageTo">
							<option value=""></option>
						<?php
						for ($i=13;$i<=100;$i++)
						{
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
						?>
							<option value="100+">100+</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Location:</td>
				</tr>
				<tr>
					<td>
						<input type="text" name="location"/>
					</td>
				</tr>
				<tr>
					<td>
						<input type="submit" name="searchSubmit"/>
					</td>
				</tr>
			</table>
		</form>
		
		<script src="http://jqueryjs.googlecode.com/files/jquery-1.3.js" type="text/javascript"></script>
		<script>
			<!--
			$("#s")
			.val("Search...")
			.css("color", "#ccc")
			.focus(function(){
				$(this).css("color", "black");
				if ($(this).val() == "Search...") {
					$(this).val("");
				}
			})
			.blur(function(){
				$(this).css("color", "#ccc");
				if ($(this).val() == "") {
					$(this).val("Search...");
				}
			});
			-->
		</script>
		<?php
		
		if (isset($_GET['searchSubmit']))
		{
			//echo "<a href=\"users.php\">Back</a>";
			if ($taResults)
			{
				
				?>
				<table>
					<tr>
						<th>Pic</th>
						<th>Users Profiles</th>
						<th>Number of Posts</th>
						<th>Date Joined</th>
						<th>Last Login</th>
						<th>Last Logout</th>
					</tr>
				<?php
				
				$query = "SELECT * FROM user ORDER BY user_date DESC";
				$result = mysqli_query($db, $query);

				while ($row = mysqli_fetch_assoc($result)) 
					{
						foreach ($results as $value)
						{
							if ($value == $row['user_id'])
							{
								$profile_pic = getProfilePic($row['user_id'],"small");
								echo "<tr>";
								echo 	"<td><img alt=\"" . lookUpUserName($row['user_id']) . "'s profile pic\" src=\"$profile_pic\"/></td>";
								echo 	"<td><a href=\"profile.php?userId=" . $row['user_id'] . "\">" . $row['username'] . " (" . lookUpName($row['user_id']) . ") " . "</a></td>";
								echo 	"<td>" . getNumberOfPosts($row['user_id']) . "</td><td>" . convertTimestamp($row['user_date']) . "</td>";
								echo 	"<td>" . convertTimestamp($row['last_log_in']) . "</td>";
								echo 	"<td>" . convertTimestamp($row['last_log_out']) . "</td>";
								echo "</tr>";
							}
						}
					}
				require ('includes/close.php');
				
				echo "</table>";
			}
			else
			{
				echo "There are no registered users with that name";
			}
		}
		else
		{
			?>
			<table>
				<tr>
					<?php
			$sort= isset($_GET["sort"]) ? $_GET["sort"] : "";
			$order = isset($_GET["order"]) ? $_GET["order"] : "";
					if ($sort == 'name' AND $order == 'ASC')
					{
						echo '<th colspan="2"><a href="users.php?sort=name&order=DESC">Users Profiles</a></th>';
					}
					elseif ($sort == 'name' AND $order == 'DESC')
					{
						echo '<th colspan="2"><a href="users.php?sort=name&order=ASC">Users Profiles</a></th>';
					}
					else
					{
						echo '<th colspan="2"><a href="users.php?sort=name&order=DESC">Users Profiles</a></th>';
					}
					
					echo '<th>Number of Posts<br>(forum)</th>';
					
					if ($sort == 'joined' AND $order == 'ASC')
					{
						echo '<th><a href="users.php?sort=joined&order=DESC">Date Joined</a></th>';
					}
					elseif ($sort == 'joined' AND $order == 'DESC')
					{
						echo '<th><a href="users.php?sort=joined&order=ASC">Date Joined</a></th>';
					}
					else
					{
						echo '<th><a href="users.php?sort=joined&order=DESC">Date Joined</a></th>';
					}
					//echo '<th>Date Joined</th>';
					echo '<th>Last Login</th>';
					echo '<th>Last Logout</th>';
					?>
				</tr>
			<?php
			if ($sort == 'name')
			{
				if ($order == 'DESC')
				{
					$query = "SELECT * FROM user ORDER BY username DESC";
				}
				elseif ($order == 'ASC')
				{
					$query = "SELECT * FROM user ORDER BY username ASC";
				}
			}
			elseif ($sort == 'joined')
			{
				if ($order == 'DESC')
				{
					$query = "SELECT * FROM user ORDER BY user_date DESC";
				}
				elseif ($order == 'ASC')
				{
					$query = "SELECT * FROM user ORDER BY user_date ASC";
				}
			}
			else
			{
				$query = "SELECT * FROM user ORDER BY user_date DESC";
			}
			
			$result = mysqli_query($db, $query);

			while ($row = mysqli_fetch_assoc($result)) 
				{
					$profile_pic = getProfilePic($row['user_id'],"small");
					echo "<tr>";
					echo 	"<td><img alt=\"" . lookUpUserName($row['user_id']) . "'s profile pic\" src=\"$profile_pic\"/></td>";
					echo 	"<td><a href=\"profile.php?userId=" . $row['user_id'] . "\">" . $row['username'] . " (" . lookUpName($row['user_id']) . ") " . "</a></td>";
					echo 	"<td>" . getNumberOfPosts($row['user_id']) . "</td>";
					echo 	"<td>" . convertTimestamp($row['user_date']) . "</td>";
					echo 	"<td>" . convertTimestamp($row['last_log_in']) . "</td>";
					echo 	"<td>" . convertTimestamp($row['last_log_out']) . "</td>";
					echo "</tr>";
				}
			require ('includes/close.php');
			
			echo "</table>";
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