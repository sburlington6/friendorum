<?php	
//BASIC INFO
	$genderEdit = clean(isset($_POST['genderEdit']) ? $_POST['genderEdit'] : "");
	$ageEdit = clean(isset($_POST['ageEdit']) ? $_POST['ageEdit'] : "");
	$ethnicityEdit = clean(isset($_POST['ethnicityEdit']) ? $_POST['ethnicityEdit'] : "");
	$bdayEdit = clean(isset($_POST['bdayEdit']) ? $_POST['bdayEdit'] : "");
	$bmonthEdit = clean(isset($_POST['bmonthEdit']) ? $_POST['bmonthEdit'] : "");
	$byearEdit = clean(isset($_POST['byearEdit']) ? $_POST['byearEdit'] : "");
	$locationEdit = clean(isset($_POST['locationEdit']) ? $_POST['locationEdit'] : "");
	
	if (isset($_POST["basicSubmit"]))
	{	
		if(empty($errors))
		{
			$query = "UPDATE profile SET "; 
			$query .= "`gender`=\"$genderEdit\", ";
			$query .= "`age` = \"$ageEdit\", ";
			$query .= "`ethnicity` = \"$ethnicityEdit\", ";
			$query .= "`bday` = \"$bdayEdit\", ";
			$query .= "`bmonth` = \"$bmonthEdit\", ";
			$query .= "`byear` = \"$byearEdit\", ";
			$query .= "`location`=\"$locationEdit\" ";
			$query .= " WHERE `user_id` = '$userId'";
			$result = mysqli_query($db, $query);
			if (!$result)
			{
				echo "<br>MYSQL Update Error: ".mysqli_error($db)."<br>";
			}
		}
	}
	
//CONTACT INFO
	$addressEdit = clean(isset($_POST['addressEdit']) ? $_POST['addressEdit'] : "");
	$phoneEdit = clean(isset($_POST['phoneEdit']) ? $_POST['phoneEdit'] : "");
	$emailEdit = clean(isset($_POST['emailEdit']) ? $_POST['emailEdit'] : "");
	$chatEdit = clean(isset($_POST['chatEdit']) ? $_POST['chatEdit'] : "");
	
	if (isset($_POST["contactSubmit"]))
	{	
		if(empty($errors))
		{
			$query = "UPDATE profile SET "; 
			$query .= "`address`=\"$addressEdit\", ";
			$query .= "`phone`=\"$phoneEdit\", ";
			$query .= "`email`=\"$emailEdit\", ";
			$query .= "`chat`=\"$chatEdit\" ";
			$query .= " WHERE `user_id` = '$userId'";
			$result = mysqli_query($db, $query);
			if (!$result)
			{
				echo "<br>MYSQL Update Error: ".mysqli_error($db)."<br>";
			}
		}
	}
	
//EDUCATION
	$collegeEdit= clean(isset($_POST['collegeEdit']) ? $_POST['collegeEdit'] : "");
	$majorEdit= clean(isset($_POST['majorEdit']) ? $_POST['majorEdit'] : "");
	$highSchoolEdit= clean(isset($_POST['highSchoolEdit']) ? $_POST['highSchoolEdit'] : "");
	$languagesEdit= clean(isset($_POST['languagesEdit']) ? $_POST['languagesEdit'] : "");
	
	if (isset($_POST["eduSubmit"]))
	{	
		if(empty($errors))
		{
			$query = "UPDATE profile SET "; 
			$query .= "`college`=\"$collegeEdit\", ";
			$query .= "`major`=\"$majorEdit\", ";
			$query .= "`high_school`=\"$highSchoolEdit\", ";
			$query .= "`languages`=\"$languagesEdit\" ";
			$query .= " WHERE `user_id` = '$userId'";
			$result = mysqli_query($db, $query);
			if (!$result)
			{
				echo "<br>MYSQL Update Error: ".mysqli_error($db)."<br>";
			}
		}
	}
	
//MORE INFO
	$aboutEdit= clean(isset($_POST['aboutEdit']) ? $_POST['aboutEdit'] : "");
	$politicalEdit = clean(isset($_POST['politicalEdit']) ? $_POST['politicalEdit'] : "");
	$religionEdit = clean(isset($_POST['religionEdit']) ? $_POST['religionEdit'] : "");
	$interestsEdit = clean(isset($_POST['interestsEdit']) ? $_POST['interestsEdit'] : "");
	$websiteEdit= clean(isset($_POST['websiteEdit']) ? $_POST['websiteEdit'] : "");
	
	if (isset($_POST["moreSubmit"]))
	{	
		if(empty($errors))
		{
			$query = "UPDATE profile SET "; 
			$query .= "`about`=\"$aboutEdit\", ";
			$query .= "`political_view`=\"$politicalEdit\", ";
			$query .= "`religion`=\"$religionEdit\", ";
			$query .= "`interests` = \"$interestsEdit\", ";
			$query .= "`website`=\"$websiteEdit\" ";
			$query .= " WHERE `user_id` = '$userId'";
			$result = mysqli_query($db, $query);
			if (!$result)
			{
				echo "<br>MYSQL Update Error: ".mysqli_error($db)."<br>";
			}
		}
	}
	
//FAVORITES
	$sportsEdit = clean(isset($_POST['sportsEdit']) ? $_POST['sportsEdit'] : "");
	$activitiesEdit = clean(isset($_POST['activitiesEdit']) ? $_POST['activitiesEdit'] : "");
	$gamesEdit = clean(isset($_POST['gamesEdit']) ? $_POST['gamesEdit'] : "");
	$moviesEdit = clean(isset($_POST['moviesEdit']) ? $_POST['moviesEdit'] : "");
	$tvEdit = clean(isset($_POST['tvEdit']) ? $_POST['tvEdit'] : "");
	$restEdit = clean(isset($_POST['restEdit']) ? $_POST['restEdit'] : "");
	$foodEdit = clean(isset($_POST['foodEdit']) ? $_POST['foodEdit'] : "");
	$TICLWedit = clean(isset($_POST['TICLWedit']) ? $_POST['TICLWedit'] : "");
	$PTGedit = clean(isset($_POST['PTGedit']) ? $_POST['PTGedit'] : "");
	$quoteEdit = clean(isset($_POST['quoteEdit']) ? $_POST['quoteEdit'] : "");
	
	if (isset($_POST["favsSubmit"]))
	{	
		if(empty($errors))
		{
			$query = "UPDATE profile SET "; 
			$query .= "`sports`=\"$sportsEdit\", ";
			$query .= "`activities`=\"$activitiesEdit\", ";
			$query .= "`games`=\"$gamesEdit\", ";
			$query .= "`movies`=\"$moviesEdit\", ";
			$query .= "`tv_shows`=\"$tvEdit\", ";
			$query .= "`restaurants`=\"$restEdit\", ";
			$query .= "`food`=\"$foodEdit\", ";
			$query .= "`c_l_w`=\"$TICLWedit\", ";
			$query .= "`p_t_g`=\"$PTGedit\", ";
			$query .= "`quote`=\"$quoteEdit\" ";
			$query .= " WHERE `user_id` = '$userId'";
			$result = mysqli_query($db, $query);
			if (!$result)
			{
				echo "<br>MYSQL Update Error: ".mysqli_error($db)."<br>";
			}
		}
	}
	
//PERSONAL
	$heightEdit = clean(isset($_POST['heightEdit']) ? $_POST['heightEdit'] : "");
	$smokeEdit = clean(isset($_POST['smokeEdit']) ? $_POST['smokeEdit'] : "");
	$drinkEdit = clean(isset($_POST['drinkEdit']) ? $_POST['drinkEdit'] : "");
	$interestedInEdit = clean(isset($_POST['interestedInEdit']) ? $_POST['interestedInEdit'] : "");
	$relationshipEdit = clean(isset($_POST['relationshipEdit']) ? $_POST['relationshipEdit'] : "");
	$lookingEdit = clean(isset($_POST['lookingEdit']) ? $_POST['lookingEdit'] : "");
	$childrenEdit = clean(isset($_POST['childrenEdit']) ? $_POST['childrenEdit'] : "");
	
	if (isset($_POST["personalSubmit"]))
	{	
		if(empty($errors))
		{
			$query = "UPDATE profile SET "; 
			$query .= "`height`=\"$heightEdit\", ";
			$query .= "`smoke`=\"$smokeEdit\", ";
			$query .= "`drink`=\"$drinkEdit\", ";
			$query .= "`interested_in`=\"$interestedInEdit\", ";
			$query .= "`relationship`=\"$relationshipEdit\", ";
			$query .= "`l_f`=\"$lookingEdit\", ";
			$query .= "`children`=\"$childrenEdit\" ";
			$query .= " WHERE `user_id` = '$userId'";
			$result = mysqli_query($db, $query);
			if (!$result)
			{
				echo "<br>MYSQL Update Error: ".mysqli_error($db)."<br>";
			}
		}
	}