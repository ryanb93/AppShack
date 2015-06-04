<?php
include 'setup.php';
$tableName = "users";
$username = $_SESSION ["username"];
if ($username == "") {
	header('Location: login.php');
}
$status = $_GET ["status"];

$check = "SELECT * FROM users WHERE username='$username'";
$result = mysql_query($check);
$count = mysql_num_rows($result);

if($count == 0) {
	header("location:index.php");
}
else {
	$email = mysql_result($result, 0, "email");
	$twitter = mysql_result($result, 0, "twitter");
	$facebook = mysql_result($result, 0, "facebook");
	$skype = mysql_result($result, 0, "skype");
	$account = mysql_result($result, 0, "account");
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
<title>AppShack - Edit <?php echo $username ?>'s Profile </title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
	<div id="container">
<?php 
switch ($status) {
	case 'nullError' :
		echo '	<div id="errorBox" style="visibility:visible">
	Null Error</div>';
		break;

	case 'invalidpassword' :
		echo '	<div id="errorBox" style="visibility:visible">
	Incorrect old password.</div>';
		break;

	case 'passwordmatch' :
		echo '	<div id="errorBox" style="visibility:visible">
	New passwords do not match.</div>';
		break;

	case 'emailexists' :
		echo '	<div id="errorBox" style="visibility:visible">
	Email already registered by another account.</div>';
		break;
		
	case 'invalidemail' :
		echo '	<div id="errorBox" style="visibility:visible">
	Not a valid email address.</div>';
		break;		
	
	case 'updated' :
		echo '	<div id="errorBox" style="visibility:visible">
	Account changes saved.</div>';
		break;
} ?>
		<h1>AppShack</h1>
		<div id="navigation">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li class="active"><a href="profile.php">User Profile</a></li>
				<li class="account"><a href="logout.php"> Log out</a></li>
			</ul>
		</div>
		<div id="content-container">
		
	<div id="registration">	
		<div class="form-title">Edit Profile</div>

<form name="registrationForm" action="saveProfile.php"
				onsubmit="return validateForm();" method="post">
<table>
  <tbody>
  <tr>
    <td><label>Email:</label></td>
    <td><div><input name="email" value="<?php echo $email?>" type="text" class="signUpInput"/></div></td>
  </tr>
  <tr>
    <td><label>Twitter:</label></td>
    <td><div><input name="twitter" value="<?php echo $twitter?>" type="text" class="signUpInput"/></div></td>
  </tr>
    <tr>
    <td><label>Facebook:</label></td>
    <td><div><input name="facebook" value="<?php echo $facebook?>" type="text" class="signUpInput"/></div></td>
  </tr>
  <tr>
    <td><label>Skype:</label></td>
    <td><div><input name="skype" value="<?php echo $skype?>" type="text" class="signUpInput"/></div></td>
  </tr>
  <tr>
    <td><label>Account Type:</label></td>
    <td><div><select name="account" class="signUpInput">
				<?php 
				if ($account == "user") {
					echo '<option value="user" selected="selected">User</option>
					<option value="developer">Developer</option>';
				}
				else {
					echo '<option value="user">User</option>
					<option value="developer" selected="selected">Developer</option>';
				}
				?>
				</select></div></td>
  </tr>
    <tr>
    <td><label>Old Password:</label></td>
    <td><div><input name="oldpassword" type="password" class="signUpInput" /></div></td>
  </tr>  
      <tr>
    <td><label>New Password:</label></td>
    <td><div><input name="password" type="password" class="signUpInput" /></div></td>
  </tr> 
      <tr>
    <td><label>Confirm New Password:</label></td>
    <td><div><input name="passwordconfirm" type="password" class="signUpInput" /></div></td>
  </tr> 
  <tr>
  <td></td><td><input type="submit" class="signup" value="Save Profile" /></td>
  </tr>
  </tbody>
</table>
</form>
</div>
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
</body>
</html>