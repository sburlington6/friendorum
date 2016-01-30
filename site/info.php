<?php
require ('includes/functions.php');
require ('includes/selects/arrays.php');

$userId = isset($_REQUEST["userId"]) ? $_REQUEST["userId"] : getUserId();
$tab = isset($_REQUEST["tab"]) ? $_REQUEST["tab"] : "basic";

if ($userId == getUserId())
{
	$edit = isset($_REQUEST["edit"]) ? $_REQUEST["edit"] : "";
}
else
{
	$edit = 'no';
}



require ('includes/infoEdit.php');
?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Info</title>
		<?php require ('includes/style.php'); ?>
		<link rel="stylesheet" href="includes/styles/info.css">
	</head>
	
		<?php
		require("includes/header.php");
	
		if ($userId == getUserId())
		{
			echo "Your Info:";
		}
		else
		{
			echo lookUpUserName($userId) . "'s Info:";
		}
		
echo '<div id="container">';//container div
	echo '<div id="tabs">'; //tabs div
	
	$links = array('basic','contact','edu','more','favs','personal');
	$linkText = array('Basic','Contact','Education','More','Favorites','Personal');
	
	for ($i=0;$i<count($links);$i++)
	{
		if ($i==0)
		{
			if ($tab == $links[$i])
			{
				echo '<a style="margin-top: 0px;" class="selected" href="'.$filename.'?userId='.$userId.'&tab='.$links[$i].'">'.$linkText[$i].'</a>';
			}
			else
			{
				echo '<a style="margin-top: 0px;" href="'.$filename.'?userId='.$userId.'&tab='.$links[$i].'">'.$linkText[$i].'</a>';
			}
		}
		else
		{
			if ($tab == $links[$i])
			{
				echo '<a class="selected" href="'.$filename.'?userId='.$userId.'&tab='.$links[$i].'">'.$linkText[$i].'</a>';
			}
			else
			{
				echo '<a href="'.$filename.'?userId='.$userId.'&tab='.$links[$i].'">'.$linkText[$i].'</a>';
			}
		}
		
	}
	
	echo '</div>'; //end tabs div
	echo '<div id="info">'; //info div
		
		$query = "SELECT * FROM profile WHERE user_id ='".clean($userId)."'";
		$result = mysqli_query($db, $query);

		while ($row = mysqli_fetch_assoc($result)) 
		{
//basic info
	if ($tab == 'basic')
	{
		if ($edit == 'basic')
		{
			echo '<form method="post" action="'.$filename.'">';
			echo '<input type="hidden" name="userId" value="'.$userId.'"/>';
			echo '<input type="hidden" name="tab" value="'.$tab.'"/>';
			echo '<table class="info">';
			echo "<tr><th colspan=\"2\">Basic ";
			if ($userId == getUserId())
			{
				echo "<a class=\"edit\" name=\"basic\" href=\"$filename?userId=$userId&tab=$tab\">Cancel</a>";
			}
			echo '</th></tr>';
			?>
			<tr>
				<td class="labels">Gender:</td>
				<td>
					<select name="genderEdit">
						<option value="">Gender</option>
						<?php
							if ($row['gender'] == 'Male')
							{
								echo '<option value="Male" selected ="selected">Male</option>';
							}
							else
							{
								echo '<option value="Male">Male</option>';
							}
							if ($row['gender'] == 'Female')
							{
								echo '<option value="Female" selected ="selected">Female</option>';
							}
							else
							{
								echo '<option value="Female">Female</option>';
							}
							if ($row['gender'] == 'Other')
							{
								echo '<option value="Other" selected ="selected">Other</option>';
							}
							else
							{
								echo '<option value="Other">Other</option>';
							}
							if ($row['gender'] == 'Prefer Not To Answer')
							{
								echo '<option value="Prefer Not To Answer" selected ="selected">Prefer Not To Answer</option>';
							}
							else
							{
								echo '<option value="Prefer Not To Answer">Prefer Not To Answer</option>';
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="labels">Age:</td>
				<td><input type="text" name="ageEdit" value="<?php echo $row['age']; ?>"/></td>
			</tr>
			<tr>
				<td class="labels">Ethnicity:</td>
				<td><input type="text" name="ethnicityEdit" value="<?php echo $row['ethnicity']; ?>"/></td>
			</tr>
			<tr>
				<td class="labels">Birthdate: </td>
				<td>
				<input type="hidden" name="userId" value="<?php echo $userId; ?>"/>
					<select name="bmonthEdit" id="bmonth">
						<option value="">Month: </option>
						<?php
						for ($k=1;$k<=12;$k++)
						{
							if ($months[$k] == $row['bmonth'])
							{
								echo " <option value=\"" . $months[$k] . "\" selected = \"selected\">" . $months[$k] . "</option>";
							}
							else
							{
								echo " <option value=\"" . $months[$k] . "\" >" . $months[$k] . "</option>";
							}
						}
					?>
					</select>
					<select name="bdayEdit" id="bday">
						<option value="">Day:</option>
						<?php
							for ($i=1;$i<=31;$i++)
							{
								if ($i == $row['bday'])
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
					<select name="byearEdit" id="byear">
						<option value="">Year:</option>
						<?php	
							$year = date("Y");
							$ye = $year - 200;
							for ($j=date("Y");$j>=$ye;$j--)
							{
								if ($j == $row['byear'])
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
			<tr>
				<td class="labels">Current Location:</td>
				<td><input type="text" name="locationEdit" value="<?php echo $row['location']; ?>"/></td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" name="basicSubmit" value="Submit"/>
				</td>
			</tr>
			</table>
			</form>
			<?php
		}
		else
		{
			echo '<table class="info">';
			echo "<tr><th colspan=\"2\">Basic ";
			if ($userId == getUserId())
			{
				echo "<a class=\"edit\" name=\"basic\" href=\"$filename?userId=$userId&tab=$tab&edit=basic#basic\">Edit</a>";
			}
			echo "</th></tr>";
			echo "<tr><td class=\"labels\">Gender: </td><td>" . $row['gender'] . "</td></tr>";
			echo "<tr><td class=\"labels\">Age: </td><td>" . $row['age'] . "</td></tr>";
			echo "<tr><td class=\"labels\">Ethnicity: </td><td>" . $row['ethnicity'] . "</td></tr>";
			echo "<tr><td class=\"labels\">Birthdate: </td><td>" . $row['bmonth'] . " " . $row['bday'] . ", " . $row['byear'] . "</td></tr>";
			echo "<tr><td class=\"labels\">Current Location: </td><td>" . $row['location'] . "</td></tr>";
		}		
		echo "</table>";
	}
//end basic info

//contact info
	elseif ($tab == 'contact')
	{
		if ($edit == 'contact')
		{
			echo '<form method="post" action="'.$filename.'">';
			echo '<input type="hidden" name="userId" value="'.$userId.'"/>';
			echo '<input type="hidden" name="tab" value="'.$tab.'"/>';
			echo '<table class="info">';
			echo "<tr><th colspan=\"2\">Contact ";
			if ($userId == getUserId())
			{
				echo "<a class=\"edit\" name=\"contact\" href=\"$filename?userId=$userId&tab=$tab\">Cancel</a>";
			}
			echo "</th></tr>";
			?>
			<tr>
				<td class="labels">Address:</td>
				<td>
					<textarea rows="5" cols="50" name="addressEdit"><?php echo $row['address']; ?></textarea>
				</td>
			</tr>
			<tr>
				<td class="labels">Phone:</td>
				<td><input type="text" name="phoneEdit" value="<?php echo $row['phone']; ?>"/></td>
			</tr>
			<tr>
				<td class="labels">E-mail(s):</td>
				<td><input type="text" name="emailEdit" value="<?php echo $row['email']; ?>"/></td>
			</tr>
			<tr>
				<td class="labels">Chat:</td>
				<td>
					<textarea rows="5" cols="50" name="chatEdit"><?php echo $row['chat']; ?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" name="contactSubmit" value="Submit"/>
				</td>
			</tr>
			</table>
			</form>
			<?php
		}
		else
		{
			echo '<table class="info">';
			echo "<tr><th colspan=\"2\">Contact ";
			if ($userId == getUserId())
			{
				echo "<a class=\"edit\" name=\"contact\" href=\"$filename?userId=$userId&tab=$tab&edit=contact#contact\">Edit</a>";
			}
			echo "</th></tr>";
			echo "<tr><td class=\"labels\">Address: </td><td>" . $row['address'] . "</td></tr>";
			echo "<tr><td class=\"labels\">Phone: </td><td>" . $row['phone'] . "</td></tr>";
			echo "<tr><td class=\"labels\">E-mail(s): </td><td>" . $row['email'] . "</td></tr>";
			echo "<tr><td class=\"labels\">Chat: </td><td>" . $row['chat'] . "</td></tr>";
		}
		echo "</table>";
	}
//end contact info

//education
	elseif ($tab == 'edu')
	{
		if ($edit == 'edu')
		{
			echo '<form method="post" action="'.$filename.'">';
			echo '<input type="hidden" name="userId" value="'.$userId.'"/>';
			echo '<input type="hidden" name="tab" value="'.$tab.'"/>';
			echo '<table class="info">';
			echo "<tr><th colspan=\"2\">Education ";
			if ($userId == getUserId())
			{
				echo "<a class=\"edit\" name=\"edu\" href=\"$filename?userId=$userId&tab=$tab\">Cancel</a>";
			}
			echo "</th></tr>";
			?>
			<tr>
				<td>College: </td>
				<td>
					<textarea rows="4" cols="50" name="collegeEdit"><?php echo $row['college']; ?></textarea>
				</td>
			</tr>
			<tr>
				<td>Major/Minor: </td>
				<td>
					<textarea rows="4" cols="50" name="majorEdit"><?php echo $row['major']; ?></textarea>
				</td>
			</tr>
			<tr>
				<td>High School: </td>
				<td>
					<textarea rows="4" cols="50" name="highSchoolEdit"><?php echo $row['high_school']; ?></textarea>
				</td>
			</tr>
			<tr>
				<td>Languages: </td>
				<td>
					<textarea rows="5" cols="50" name="languagesEdit"><?php echo $row['languages']; ?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" name="eduSubmit" value="Submit"/>
				</td>
			</tr>
			</table>
			</form>
			<?php
		}
		else
		{
			echo '<table class="info">';
			echo "<tr><th colspan=\"2\">Education ";
			if ($userId == getUserId())
			{
				echo "<a class=\"edit\" name=\"edu\" href=\"$filename?userId=$userId&tab=$tab&edit=edu#edu\">Edit</a>";
			}
			echo "</th></tr>";
			echo "<tr><td class=\"labels\">College: </td><td>" . $row['college'] . "</td></tr>";
			echo "<tr><td class=\"labels\">Major: </td><td>" . $row['major'] . "</td></tr>";
			echo "<tr><td class=\"labels\">High School: </td><td>" . $row['high_school'] . "</td></tr>";
			echo "<tr><td class=\"labels\">Languages: </td><td>" . $row['languages'] . "</td></tr>";
		}
		echo "</table>";
	}
//end education

//more info
	elseif ($tab == 'more')
	{
		if ($edit == 'more')
		{
			echo '<form method="post" action="'.$filename.'">';
			echo '<input type="hidden" name="userId" value="'.$userId.'"/>';
			echo '<input type="hidden" name="tab" value="'.$tab.'"/>';
			echo '<table class="info">';
			echo "<tr><th colspan=\"2\">More ";
			if ($userId == getUserId())
			{
				echo "<a class=\"edit\" name=\"more\" href=\"$filename?userId=$userId&tab=$tab\">Cancel</a>";
			}
			echo "</th></tr>";
			?>
			<tr>
				<td>About Me: </td>
				<td>
					<textarea rows="5" cols="50" name="aboutEdit"><?php echo $row['about']; ?></textarea>
				</td>
			</tr>
			<tr>
				<td>Political View: </td>
				<td>
					<select name="politicalEdit" id="political">
						<?php
						for ($k=0;$k<count($political);$k++)
						{
							if ($political[$k] == $row['political_view'])
							{
								echo " <option value=\"" . $political[$k] . "\" selected = \"selected\">" . $political[$k] . "</option>";
							}
							else
							{
								echo " <option value=\"" . $political[$k] . "\" >" . $political[$k] . "</option>";
							}
						}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Religion: </td>
				<td>
					<select name="religionEdit" id="religion">
						<?php
						for ($k=0;$k<count($religion);$k++)
						{
							if ($religion[$k] == $row['political_view'])
							{
								echo " <option value=\"" . $religion[$k] . "\" selected = \"selected\">" . $religion[$k] . "</option>";
							}
							else
							{
								echo " <option value=\"" . $religion[$k] . "\" >" . $religion[$k] . "</option>";
							}
						}
					?>
					</select>
				</td>
			</tr>
			
			<tr>
				<td>Interests: </td>
				<td>
					<textarea rows="5" cols="50" name="interestsEdit"><?php echo $row['interests']; ?></textarea>
				</td>
			</tr>
			<tr>
				<td>Website(s): </td>
				<td>
					<textarea rows="5" cols="50" name="websiteEdit"><?php echo $row['website']; ?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" name="moreSubmit" value="Submit"/>
				</td>
			</tr>
			</table>
			</form>
			<?php
		}
		else
		{
			echo '<table class="info">';
			echo "<tr><th colspan=\"2\">More ";
			if ($userId == getUserId())
			{
				echo "<a class=\"edit\" name=\"more\" href=\"$filename?userId=$userId&tab=$tab&edit=more#more\">Edit</a>";
			}
			echo "</th></tr>";
			echo "<tr><td class=\"labels\">About Me: </td><td>" . $row['about'] . "</td></tr>";
			echo "<tr><td class=\"labels\">Political View: </td><td>" . $row['political_view'] . "</td></tr>";
			echo "<tr><td class=\"labels\">Religion: </td><td>" . $row['religion'] . "</td></tr>";
			echo "<tr><td class=\"labels\">Interests: </td><td>" . $row['interests'] . "</td></tr>";
			echo "<tr><td class=\"labels\">Web Site: </td><td>" . $row['website'] . "</td></tr>";
		}
		echo "</table>";
	}
//end more info

//favorites
	if ($tab == 'favs')
	{
		if ($edit == 'favs')
		{
			echo '<form method="post" action="'.$filename.'">';
			echo '<input type="hidden" name="userId" value="'.$userId.'"/>';
			echo '<input type="hidden" name="tab" value="'.$tab.'"/>';
			echo '<table class="info">';
			echo "<tr><th colspan=\"2\">Favorites ";
			if ($userId == getUserId())
			{
				echo "<a class=\"edit\" name=\"favs\" href=\"$filename?userId=$userId&tab=$tab\">Cancel</a>";
			}
			echo "</th></tr>";
			?>
			<tr>
				<td>Sports: </td>
				<td>
					<textarea rows="5" cols="50" name="sportsEdit"><?php echo $row['sports']; ?></textarea>
				</td>
			</tr>
			<tr>
				<td>Activities: </td>
				<td>
					<textarea rows="5" cols="50" name="activitiesEdit"><?php echo $row['activities']; ?></textarea>
				</td>
			</tr>
			<tr>
				<td>Games: </td>
				<td>
					<textarea rows="5" cols="50" name="gamesEdit"><?php echo $row['games']; ?></textarea>
				</td>
			</tr>
			<tr>
				<td>Movies: </td>
				<td>
					<textarea rows="5" cols="50" name="moviesEdit"><?php echo $row['movies']; ?></textarea>
				</td>
			</tr>
			<tr>
				<td>TV Shows: </td>
				<td>
					<textarea rows="5" cols="50" name="tvEdit"><?php echo $row['tv_shows']; ?></textarea>
				</td>
			</tr>
			<tr>
				<td>Restaurants: </td>
				<td>
					<textarea rows="5" cols="50" name="restEdit"><?php echo $row['restaurants']; ?></textarea>
				</td>
			</tr>
			<tr>
				<td>Food: </td>
				<td>
					<textarea rows="5" cols="50" name="foodEdit"><?php echo $row['food']; ?></textarea>
				</td>
			</tr>
			<tr>
				<td>Things I Can't Live Without: </td>
				<td>
					<textarea rows="5" cols="50" name="TICLWedit"><?php echo $row['c_l_w']; ?></textarea>
				</td>
			</tr>
			<tr>
				<td>Places to go: </td>
				<td>
					<textarea rows="5" cols="50" name="PTGedit"><?php echo $row['p_t_g']; ?></textarea>
				</td>
			</tr>
			<tr>
				<td>Quote(s): </td>
				<td>
					<textarea rows="5" cols="50" name="quoteEdit"><?php echo $row['quote']; ?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" name="favsSubmit" value="Submit"/>
				</td>
			</tr>
			</table>
			</form>
			<?php
		}
		else
		{
			echo '<table class="info">';
			echo "<tr><th colspan=\"2\">Favorites ";
			if ($userId == getUserId())
			{
				echo "<a class=\"edit\" name=\"favs\" href=\"$filename?userId=$userId&tab=$tab&edit=favs#favs\">Edit</a>";
			}
			echo "</th></tr>";
			echo "<tr><td class=\"labels\">Sports: </td><td>" . $row['sports'] . "</td></tr>";
			echo "<tr><td class=\"labels\">Activities: </td><td>" . $row['activities'] . "</td></tr>";
			echo "<tr><td class=\"labels\">Games: </td><td>" . $row['games'] . "</td></tr>";
			echo "<tr><td class=\"labels\">Movies: </td><td>" . $row['movies'] . "</td></tr>";
			echo "<tr><td class=\"labels\">TV Shows: </td><td>" . $row['tv_shows'] . "</td></tr>";
			echo "<tr><td class=\"labels\">Restaurants: </td><td>" . $row['restaurants'] . "</td></tr>";
			echo "<tr><td class=\"labels\">Food: </td><td>" . $row['food'] . "</td></tr>";
			echo "<tr><td class=\"labels\">Things I Can't Live Without: </td><td>" . $row['c_l_w'] . "</td></tr>";
			echo "<tr><td class=\"labels\">Places to go: </td><td>" . $row['p_t_g'] . "</td></tr>";
			echo "<tr><td class=\"labels\">Quote(s): </td><td>" . $row['quote'] . "</td></tr>";
		}
		echo "</table>";
	}
//end favorites

//personal
	elseif ($tab == 'personal')
	{
		if ($edit == 'personal')
		{
			echo '<form method="post" action="'.$filename.'">';
			echo '<input type="hidden" name="userId" value="'.$userId.'"/>';
			echo '<input type="hidden" name="tab" value="'.$tab.'"/>';
			echo '<table class="info">';
			echo "<tr><th colspan=\"2\">Personal ";
			if ($userId == getUserId())
			{
				echo "<a class=\"edit\" name=\"personal\" href=\"$filename?userId=$userId&tab=$tab\">Cancel</a>";
			}
			echo "</th></tr>";
			?>
			<tr>
				<td>Height:</td>
				<td><input type="text" name="heightEdit" value="<?php echo $row['height']; ?>"/></td>
			</tr>
			<tr>
				<td>Smoke?</td>
				<td><input type="text" name="smokeEdit" value="<?php echo $row['smoke']; ?>"/></td>
			</tr>
			<tr>
				<td>Drink?</td>
				<td><input type="text" name="drinkEdit" value="<?php echo $row['drink']; ?>"/></td>
			</tr>
			<tr>
				<td>Interested In:</td>
				<td><input type="text" name="interestedInEdit" value="<?php echo $row['interested_in']; ?>"/></td>
			</tr>
			<tr>
				<td>Relationship Status:</td>
				<td><input type="text" name="relationshipEdit" value="<?php echo $row['relationship']; ?>"/></td>
			</tr>
			<tr>
				<td>Looking For:</td>
				<td><input type="text" name="lookingEdit" value="<?php echo $row['l_f']; ?>"/></td>
			</tr>
			<tr>
				<td>Children?</td>
				<td><input type="text" name="childrenEdit" value="<?php echo $row['children']; ?>"/></td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" name="personalSubmit" value="Submit"/>
				</td>
			</tr>
			</table>
			</form>
			<?php
		}
		else
		{
			echo '<table class="info">';
			echo "<tr><th colspan=\"2\">Personal ";
			if ($userId == getUserId())
			{
				echo "<a class=\"edit\" name=\"personal\" href=\"$filename?userId=$userId&tab=$tab&edit=personal#personal\">Edit</a>";
			}
			echo "</th></tr>";
			echo "<tr><td class=\"labels\">Height: </td><td>" . $row['height'] . "</td></tr>";
			echo "<tr><td class=\"labels\">Smoke? </td><td>" . $row['smoke'] . "</td></tr>";
			echo "<tr><td class=\"labels\">Drink? </td><td>" . $row['drink'] . "</td></tr>";
			echo "<tr><td class=\"labels\">Interested In: </td><td>" . $row['interested_in'] . "</td></tr>";
			echo "<tr><td class=\"labels\">Relationship Status: </td><td>" . $row['relationship'] . "</td></tr>";
			echo "<tr><td class=\"labels\">Looking For: </td><td>" . $row['l_f'] . "</td></tr>";
			echo "<tr><td class=\"labels\">Children? </td><td>" . $row['children'] . "</td></tr>";
		}
		echo "</table>";
	}
//end personal

		}
		if (!$result)
		{
			echo "there are mysql errors";
		}
	echo '</div>'; //end info div
echo '</div>'; //end container div
		
		require ('includes/close.php');
		require("includes/footer.php");
	?>
	</body>
</html>