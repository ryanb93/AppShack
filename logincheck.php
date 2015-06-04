<?php
include 'setup.php';

// username and password sent from form
$username = $_POST ['username'];
$password = $_POST ['password'];
$retain = $_POST ['retain'];

// Protection from injection attacks.
$username = stripslashes ( $username );
$password = stripslashes ( $password );
$username = mysql_real_escape_string ( $username );
$password = mysql_real_escape_string ( $password );

// Create hashed password.
$password = hashPassword($password);

//Does the password and username exist in the database?
$sql = "SELECT * FROM users WHERE username='$username' and password='$password'";
$result = mysql_query ( $sql );
// Mysql_num_row is counting table row
$count = mysql_num_rows ( $result );

if ($count == 1) {
// Register $myusername and redirect to file
	$_SESSION ["username"] = $username;
	
	if($retain == "true") {
	setcookie("retain", "true", time()+86400);
	//If the user has chosen to stay logged in then set a cookie.
	setcookie("username", $username, time()+86400);
	//Generate an MD5 hash using a random number.
	$hash = md5(rand(10,10000));
	//Store this hash as a cookie.
	setcookie("hash", $hash, time()+86400);
	//Store this hash in the databse.
	mysql_query("UPDATE users SET hash='$hash' WHERE username='$username'");
	header ( "location:index.php" );
	}
	else {
		setcookie("retain", "false", time()+86400);
		header ( "location:index.php" );
	}
	
	
} else {
	header ("location:login.php?status=invalid");
}
?>