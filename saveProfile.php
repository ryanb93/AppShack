<?php
include 'setup.php';
$errorCode = "updated";

// username and password sent from form
$username = $_SESSION ['username'];
$oldpassword = $_POST ['oldpassword'];
$password = $_POST ['password'];
$passwordconfirm = $_POST ['passwordconfirm'];
$twitter = $_POST ['twitter'];
$facebook = $_POST ['facebook'];
$skype = $_POST ['skype'];
$account = $_POST ['account'];
$email = $_POST ['email'];

if ($username == "") {
	header('Location: login.php');
}

// Protection from injection attacks.
$oldpassword = stripslashes ( $oldpassword );
$password = stripslashes ( $password );
$passwordconfirm = stripslashes ( $passwordconfirm );
$twitter = stripslashes ( $twitter );
$facebook = stripslashes ( $facebook );
$email = stripslashes ( $email );
$skype = stripslashes ( $skype );
$oldpassword = mysql_real_escape_string ( $oldpassword );
$password = mysql_real_escape_string ( $password );
$passwordconfirm = mysql_real_escape_string ( $passwordconfirm );
$twitter = mysql_real_escape_string ( $twitter );
$facebook = mysql_real_escape_string ( $facebook );
$email = mysql_real_escape_string ( $email );
$skype = mysql_real_escape_string ( $skype );

//Save changes which dont have to be unique.
mysql_query("UPDATE users SET twitter='$twitter' WHERE username='$username'");
mysql_query("UPDATE users SET facebook='$facebook' WHERE username='$username'");
mysql_query("UPDATE users SET skype='$skype' WHERE username='$username'");
mysql_query("UPDATE users SET account='$account' WHERE username='$username'");

//Save email which must not belong to another user in the database.
$emailCheck = "SELECT * FROM users WHERE email='$email' AND username!='$username'";
$result = mysql_query ($emailCheck);
$emailFound = mysql_num_rows ($result);
if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $errorCode = "invalidemail";
else
{
	//If the email exists in the database.
	if ($emailFound >= 1) $errorCode = "emailexists";
	else {
		mysql_query("UPDATE users SET email='$email' WHERE username='$username'");
	}
}


//Save new password.
if ($oldpassword != null) {
//First we must check to make sure the user entered the correct old password.
$oldpassword = md5($oldpassword);
//Get users with the username and password entered.
$check = "SELECT * FROM users WHERE username='$username' AND password='$oldpassword'";
$result = mysql_query($check);
$count = mysql_num_rows($result);
//If it was the old password.
if($count == 1) {
	//Now we must check that the new password and confirmed password match.
	if($password == $passwordconfirm && ($password != null || $password != "")) { 
	$password = hashPassword($password);
	$passwordconfirm = hashPassword($passwordconfirm);
	mysql_query("UPDATE users SET password='$password' WHERE username='$username'");
	}
	else $errorCode = "passwordmatch";
}
//It was the incorrect old password.
else {
	$errorCode = "invalidpassword";
}
}

header("location:editprofile.php?status=".$errorCode);
