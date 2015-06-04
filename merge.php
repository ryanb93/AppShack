<?php 
include 'setup.php';
$username = $_SESSION['username'];

if ($username == "") {
	header('Location: login.php');
}

$currentUsername = $username;
$otherUsername = $_POST['otherUsername'];
$currentPassword = $_POST['currentPassword'];
$otherPassword = $_POST['otherPassword'];

//If this page has been sent a request to merge accounts.
if ($currentUsername != "" && $otherUsername != "" && $currentPassword != "" && $otherPassword != "") {

	// Does the other user exist?
	$getUser = "select * from users where username='".$otherUsername."'";
	$result = mysql_query($getUser);
	$count = mysql_num_rows($result);
	if ($count == 0) {
		echo "Other username does not exist.";
	}
	
	$currentPassword = hashPassword($currentPassword);
	$otherPassword = hashPassword($currentPassword);
	echo $otherPassword;
	// Does the other user exist?
	$getPassword = "select * from users where password='".$currentPassword."' and username='".$currentUsername."'";
		$result = mysql_query($getPassword);
	$count = mysql_num_rows($result);
	if ($count == 0) {
		echo "Invalid current password.";
	}
	
	// Does the other user exist?
	$getPassword = "select * from users where password='".$otherPassword."' and username='".$otherUsername."'";
	$result = mysql_query($getPassword);
	$count = mysql_num_rows($result);
	if ($count == 0) {
		echo "Invalid other password.";
	}
	
	//Get the ID of both users.
	$query = "select id from users where username='".$currentUsername."'";
	$result = mysql_query($query);
	$currentID = mysql_result($result, 0, "id");
	$query = "select id from users where username='".$otherUsername."'";
	$result = mysql_query($query);
	$otherID = mysql_result($result, 0, "id");
	
	//Change all the applications owned by the other developer to the current developer.
	mysql_query("UPDATE applications SET developerID='$currentID' WHERE developerID='$otherID'");

	//Delete other user.
	mysql_query("DELETE FROM users WHERE username='".$otherUsername."'");
		
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<title>Merge Accounts.</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<div id="container">
<h1>AppShack</h1>
		<div id="navigation">
			<ul>
				<li><a href="index.php">Home</a></li>
				<?php if (isset($username)) {?>
				<li ><a href="profile.php">User Profile</a></li>
				<li class="account"><a href="logout.php">Log out</a></li>
				<?php } else { ?>
				<li class="account"><a href="signup.php">Sign Up</a></li>
				<li class="account"><a href="login.php">Login</a></li>
				<?php }?>
			</ul>
		</div>
<div id="content-container">

<div id="registration" style="width: 600px">	
		<div class="form-title">Merge Accounts</div>
		<div class="form-sub-title">If you have released applications under two different accounts and wish to consolidate them into a single account then please use this function. Please note that the second account will be permanently deleted from the system.</div>
		
<form name="registrationForm" action="merge.php" method="post">
<table>
  <tbody>
  <tr>
    <td><label>Current Username:</label></td>
    <td><div><input disabled="disabled" name="currentUsername" type="text" value="<?php echo $username; ?>" class="signUpInput"/></div></td>
    <td><label>Other Username:</label></td>
    <td><div><input name="otherUsername" type="text" class="signUpInput"/></div></td>
  </tr>
  <tr>
    <td><label>Current Password:</label></td>
    <td><div><input name="currentPassword" type="password" class="signUpInput"/></div></td>
     <td><label>Other Password:</label></td>
    <td><div><input name="otherPassword" type="password" class="signUpInput"/></div></td>
  </tr>
    </tbody>
</table>
<input type="submit" class="signup" value="Merge Accounts" />

</form>
</div>
<div id="footer">
			<div id="footercontent">
						Copyright &#169; <a href="http://ryanburke.co.uk">Ryan Burke</a> 2012
			<br /><br />
			<a href="http://jigsaw.w3.org/css-validator/check/referer">
    <img style="border:0;width:88px;height:31px"
        src="http://jigsaw.w3.org/css-validator/images/vcss-blue"
        alt="Valid CSS!" /></a>
			<a href="http://validator.w3.org/check?uri=referer"><img
      src="http://www.w3.org/Icons/valid-xhtml10-blue" alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a>
			</div>
		</div>
</div>
</div>
</body>
</html>
