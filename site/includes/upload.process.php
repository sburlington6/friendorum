<?php
$newAlbumName = isset($_POST['newAlbum']) ? $_POST['newAlbum'] : "";
$caption = isset($_POST['caption']) ? $_POST['caption'] : "";
$albumId = isset($_POST['albumId']) ? $_POST['albumId'] : "";
$imageError = array();

if (isset($_POST['upload']))
{
	if (($albumId == "" OR $albumId == "0") AND $newAlbumName == "" AND $filename != 'profileedit.php')
	{
		$imageError[] = "You must select either Existing Album or New Album";
	}
		if (($albumId == "" OR $albumId == "0") AND (strlen($newAlbumName) < 1 OR strlen($newAlbumName) > 50))
		{
			$imageError[] = "You must choose an album name between 1 and 50 characters";
		}
	
	// get user id of current user
	$userFolder = "images/user_images/" . $userId;

	// make a note of the directory that will recieve the uploaded files
	$uploadsDirectory = $userFolder . '/';

	// name of the fieldname used for the file in the HTML form
	$fieldname = 'file';

	// possible PHP upload errors
	$fileErrors = array(1 => 'php.ini max file size exceeded', 
					2 => 'html form max file size exceeded', 
					3 => 'file upload was only partial', 
					4 => 'no file was attached');

	// check the upload form was actually submitted else print form
	isset($_POST['upload'])
		or $imageError[] = 'the upload form is neaded';

	// check for standard uploading errors
	($_FILES[$fieldname]['error'] == 0)
		or $imageError[] = $fileErrors[$_FILES[$fieldname]['error']];
		
	// check that the file we are working on really was an HTTP upload
	if (empty($imageError))
	{
		@is_uploaded_file($_FILES[$fieldname]['tmp_name'])
			or $imageError[] = 'not an HTTP upload';
	}
	// validation... since this is an image upload script we should run a check to make sure the upload is an image
	if (empty($imageError))
	{
		@getimagesize($_FILES[$fieldname]['tmp_name'])
			or $imageError[] = 'only image uploads are allowed';
	}
	
	function load($filename) 
	{
		$image_info = getimagesize($filename);
		$image_type = $image_info[2];
		if( $image_type == IMAGETYPE_JPEG ) 
		{
			$image = imagecreatefromjpeg($filename);
			return $image;
		} 
		elseif( $image_type == IMAGETYPE_GIF ) 
		{
			$image = imagecreatefromgif($filename);
			return $image;
		} 
		elseif( $image_type == IMAGETYPE_PNG ) 
		{
			$image = imagecreatefrompng($filename);
			return $image;
		}
		else
		{
			return false;
		}
	}

	function renames($size)
	{
		global $uploadsDirectory;
		global $uploadsDirectoryShort;
		global $fileName;
		$now = microtime(true);
		$sessionId = session_id();

		$newName = $uploadsDirectory.$now.'_'.$sessionId.'_'.$size.'_'.$fileName;
		return $newName;
	}

	function resize($image,$src,$size)
	{
		list($width,$height)=getimagesize($image);

		$newWidth=$size;
		$newHeight=($height/$width)*$newWidth;
		$newTmp=imagecreatetruecolor($newWidth,$newHeight);
		
		imagecopyresampled($newTmp,$src,0,0,0,0,$newWidth,$newHeight,$width,$height);
		return $newTmp;
	}

	function save($tmp,$name,$quality)
	{
		imagejpeg($tmp,$name,$quality);
	}

	if (empty($imageError))
	{
		$pic = $_FILES[$fieldname]['tmp_name'];
		$image = load($pic);

		$fileName = $_FILES[$fieldname]['name'];

		$big = resize($pic,$image,550);
		$medium = resize($pic,$image,150);
		$small = resize($pic,$image,25);

		$bigN = renames("big");
		$mediumN = renames("medium");
		$smallN = renames("small");

		$bigNLong = $_SERVER['DOCUMENT_ROOT'] . '/' . $bigN;
		$mediumNLong = $_SERVER['DOCUMENT_ROOT'] . '/' .  $mediumN;
		$smallNLong = $_SERVER['DOCUMENT_ROOT'] . '/' .  $smallN;

		save($big,$bigNLong,100);
		save($medium,$mediumNLong,100);
		save($small,$smallNLong,100);
			

		$userId = getUserId();	
		
		if ($filename == "profileedit.php")
		{
			$thisUserId = getUserId();
			//find the id of the users profile pictures album
			$query = "SELECT * FROM `albums` WHERE `album_name` = 'Profile Pictures' AND user_id = '".clean($thisUserId)."'";
			$result = mysqli_query($db, $query);
			while ($row = mysqli_fetch_assoc($result)) 
			{
				$thisAlbumId = $row['album_id'];
			}
			//insert the image into that album
			$queryInsert = "INSERT INTO images (album_id,user_id,caption,big,medium,small) VALUES ('".clean($thisAlbumId)."','".clean($thisUserId)."', '".clean($caption)."', '".clean($bigN)."', '".clean($mediumN)."', '".clean($smallN)."')";
			$result = mysqli_query($db, $queryInsert); 
			if (!$result)
			{
				echo mysql_error($db);
			}
			//find the id of the newly inserted image
			$query = "SELECT * FROM `images` WHERE user_id = '".clean($thisUserId)."' ORDER BY `image_id` DESC LIMIT 0 , 1";
			$result = mysqli_query($db, $query);
			while ($row = mysqli_fetch_assoc($result)) 
			{
				$newImageId = $row['image_id'];
			}
			//update users profile picture
			$query = "UPDATE `profile` SET `image_id` = ".clean($newImageId)." WHERE `user_id` = ".clean($thisUserId);
			$result = mysqli_query($db, $query);
			header( "Location: profileedit.php?userId=$userId" ) ;
		}
		else
		{
			if ($albumId > '0' AND $albumId != '')
			{
				//insert image into table with existing album
				$queryInsert = "INSERT INTO images (album_id,user_id,caption,big,medium,small) VALUES ('".clean($albumId)."','".clean($userId)."', '".clean($caption)."', '".clean($bigN)."', '".clean($mediumN)."', '".clean($smallN)."')";
				$result = mysqli_query($db, $queryInsert); 
				if (!$result)
				{
					echo mysql_error($db);
				}
				$caption = "";
			}
			elseif ($newAlbumName != '')
			{
				//create new album
				$queryInsert = "INSERT INTO albums (user_id,album_name) VALUES ('".clean($userId)."','".clean($newAlbumName)."')";
				$result = mysqli_query($db, $queryInsert); 
				if (!$result)
				{
					echo mysql_error($db);
				}
				//get its new id
				$query = "SELECT * FROM `albums` WHERE `album_name` = '".clean($newAlbumName)."'";
				$result = mysqli_query($db, $query);
				while ($row = mysqli_fetch_assoc($result)) 
				{
					$albumId = $row['album_id'];
				}
				if (!$result)
				{
					echo mysqli_error($db);
				}
				//insert image into table with new album
				$queryInsert = "INSERT INTO images (album_id,user_id,caption,big,medium,small) VALUES ('".clean($albumId)."','".clean($userId)."', '".clean($caption)."', '".clean($bigN)."', '".clean($mediumN)."', '".clean($smallN)."')";
				$result = mysqli_query($db, $queryInsert); 
				if (!$result)
				{
					echo mysqli_error($db);
				}
			}
			header("Location: " . $filename . "?userId={$_POST['userId']}");
		}
	}
	//header("Location: " . $page . "?sucess=true");
	//header("Refresh: $seconds; URL=\"$location\"");
}