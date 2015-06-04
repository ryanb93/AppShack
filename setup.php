<?php
session_start();
$host = "localhost";
$databaseUsername = "root";
$databasePassword = "";
$databaseName = "rb00166";

// Connect to server.
mysql_connect ( "$host", "$databaseUsername", "$databasePassword" ) or die ( "Server error." );
mysql_select_db ( "$databaseName" ) or die ( "Database error." );

$username = $_COOKIE['username'];
$hash = $_COOKIE['hash'];
$retain = $_COOKIE['retain'];

if($retain == "true") {

	//Check these against those stored in the database.
	$auth = "SELECT * FROM users WHERE username='$username' AND hash='$hash'";
	$count = mysql_num_rows(mysql_query($auth));
	
	//If this authorisation was successful.
	if($count == 1) {

		$_SESSION ["username"] = $username;
			
		setcookie("username", $username, time()+86400);
		//Generate an MD5 hash using a random number.
		$hash = md5(rand(10,10000));
		//Store this hash as a cookie.
		setcookie("hash", $hash, time()+86400);
				//Store this hash in the databse.
		mysql_query("UPDATE users SET hash='$hash' WHERE username='$username'");
	}
	else {
		//Authorisation does not match, get user to reauthenticate using password.
		printf("<script>location.href='login.php?status=authfail'</script>");
		
	}
}

function hashPassword($password) {
	$salt = sha1(md5($password));
	$password = md5($salt.$password);
	return $password;
}