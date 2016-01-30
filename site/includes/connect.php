<?PHP
//setup information
$dbhost = 'localhost';
$dbuser = 'friendorum';
$dbpass = 'password';
$dbname = 'friendorum';

//open database
$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if(mysqli_connect_errno())
{
	echo "Connection failed: " . mysqli_connect_error();
	exit();
}