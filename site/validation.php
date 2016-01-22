<?php
	$errors = array();
	
	$fname = clean(isset($_POST["fname"]) ? $_POST["fname"] : "");
	$lname = clean(isset($_POST["lname"]) ? $_POST["lname"] : "");
	$uname = clean(isset($_POST["uname"]) ? $_POST["uname"] : "");
	$email = clean(isset($_POST["email"]) ? $_POST["email"] : "");
	$bday = clean(isset($_POST["bday"]) ? $_POST["bday"] : "");
	$bmonth = clean(isset($_POST["bmonth"]) ? $_POST["bmonth"] : "");
	$byear = clean(isset($_POST["byear"]) ? $_POST["byear"] : "");
	$pass1 = clean(isset($_POST["pass1"]) ? $_POST["pass1"] : "");
	$pass2 = clean(isset($_POST["pass2"]) ? $_POST["pass2"] : "");
	$profile_pic = clean(isset($_POST["profile_pic"]) ? $_POST["profile_pic"] : "");
	$question1 = clean(isset($_POST["question1"]) ? $_POST["question1"] : "");
	$question2 = clean(isset($_POST["question2"]) ? $_POST["question2"] : "");
	$question3 = clean(isset($_POST["question3"]) ? $_POST["question3"] : "");
	$answer1 = clean(isset($_POST["answer1"]) ? $_POST["answer1"] : "");
	$answer2 = clean(isset($_POST["answer2"]) ? $_POST["answer2"] : "");
	$answer3 = clean(isset($_POST["answer3"]) ? $_POST["answer3"] : "");
	
	if(strlen($answer1) < 2 || strlen($answer1) > 50)
	{
		$errors[] = "Answer 1 must be between 2 and 50 characters.";
	}
	
	if(strlen($answer2) < 2 || strlen($answer2) > 50)
	{
		$errors[] = "Answer 2 must be between 2 and 50 characters.";
	}
	
	if(strlen($answer3) < 2 || strlen($answer3) > 50)
	{
		$errors[] = "Answer 3 must be between 2 and 50 characters.";
	}
	
	if($question1 == "" OR $question1 == "0")
	{
		$errors[] = "You must select a Question for Question 1.";
	}
	
	if($question2 == "" OR $question2 == "0")
	{
		$errors[] = "You must select a Question for Question 2.";
	}
	
	if($question3 == "" OR $question3 == "0")
	{
		$errors[] = "You must select a Question for Question 3.";
	}
	
	if($question1 == $question2 OR $question2 == $question3 OR $question1 == $question3)
	{
		$errors[] = "You can not select the same security question more than once.";
	}
	
	if($profile_pic == "")
	{
		$errors[] = "You must select a profile picture.";
	}
	if($fname == "")
	{
		$errors[] = "First name cannot be blank.";
	}
	if($lname == "")
	{
		$errors[] = "Last name cannot be blank.";
	}
	if($uname == "")
	{
		$errors[] = "Username cannot be blank.";
	}
	
	if(strlen($fname) < 2)
	{
		$errors[] = "First name must be more than 2 characters..";
	}
	
	if(strlen($lname) < 2)
	{
		$errors[] = "Last name must be more than 2 characters.";
	}
	
	if(strlen($uname) < 6 || strlen($uname) > 50)
	{
		$errors[] = "Username must be between 6 and 50 characters.";
	}
	
	$validUnameExpr = '/^[0-9a-z_]+$/i';
	if(preg_match($validUnameExpr, $uname) == 0)
	{
		$errors[] = "Username can only be letters numbers and underscores.";
	}
	
	if($email == "")
	{
		$errors[] = "E-mail cannot be blank.";
	}
	
	if($bday == "")
	{
		$errors[] = "You must select a valid birth day";
	}
	if($byear == "")
	{
		$errors[] = "You must select a valid birth year";
	}
	if($bmonth == "")
	{
		$errors[] = "You must select a valid birth month";
	}
	
	$validEmailExpr = '/^[a-z0-9\-.]+@[a-z0-9\-]+\.[a-z0-9\-.]+$/i';
	if(preg_match($validEmailExpr, $email) == 0)
	{
		$errors[] = "E-mail is in wrong format. Example format: name@domain.com.";
	}
	
	if ($pass1 != $pass2)
	{
		$errors[] = "The passwords did not match";
	}
	
	if(strlen($pass1) < 8 || strlen($pass1) > 50)
	{
		$errors[] = "Password must be between 8 and 50 characters.";
	}

	$query = "SELECT username FROM user";
	$result = mysqli_query($db, $query);

	while ($row = mysqli_fetch_assoc($result)) 
	{
		if (strtolower($uname) == strtolower($row["username"]))
		{
			$errors[] = "That username is already in use.";
		}
	
	}
	
	$query = "SELECT email FROM user";
	$result = mysqli_query($db, $query);

	while ($row = mysqli_fetch_assoc($result)) 
	{
		if (strtolower($email) == strtolower($row["email"]))
		{
			$errors[] = "That email address is already in use.";
		}
	
	}
	
	echo mysqli_error($db);
	

      if(empty($errors))
      {
     	$crypt_pass = crypt($pass1, makeSalt() );
		$queryInsert = "INSERT INTO user (username,email,password,first_name,last_name,question1,question2,question3,answer1,answer2,answer3) VALUES ('$uname', '$email','$crypt_pass','$fname','$lname','$question1','$question2','$question3','$answer1','$answer2','$answer3')"; //create the user
		$result = mysqli_query($db, $queryInsert);
		if(!$result)
		{
			echo "insert into user error<br>";
			echo mysqli_error($db);
			exit();
		}
		
		$userId = lookUpUserId ($uname);
		echo "the user id is $userId <br>";
		
		$queryInsert = "INSERT INTO profile (user_id,interests,image_id,bday,bmonth,byear) VALUES ('$userId','I am not very interesting', '$profile_pic','$bday','$bmonth','$byear')"; //create their profile
		$result = mysqli_query($db, $queryInsert);
		if(!$result)
		{
			echo "insert into profile error<br>";
			echo mysqli_error($db);
			exit();
		}
		
		$queryInsert = "INSERT INTO albums (user_id,album_name) VALUES ('$userId', 'Profile Pictures')"; //create profile photos album
		$result = mysqli_query($db, $queryInsert);
		
		if(!$result)
		{
			echo "MySQL errorz";
			exit();
		}
		
		mkdir("images/user_images/$userId", 0777); //make a folder for the users images to go in
		
		
		header( 'Location: index.php?registered=true' ) ; //redirect to index page
        //echo "<p>You are registered and may now login <a href=\"index.php\">login</a></p>";
      }
	  
	  
    ?>