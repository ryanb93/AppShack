<?php 
session_start();
$username = $_SESSION['username'];
$error = $_GET ['error'];
if ($username == "") {
	header('Location: login.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<title>Submit a new application.</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script type="text/javascript" src="js/appValidator.js"></script>
</head>
<body>
<?php
switch ($_GET['status']) {
	case 'nullError' :
		echo '<div class="alert">All fields must be completed.</div>';
		break;

	case 'invalidURL' :
		echo '<div class="alert">One of your URL\'s is not valid.</div>';
		break;

	case 'appexists' :
		echo '<div class="alert">An application with the same name already exists.</div>';
		break;
		
		case 'notCreated' :
			echo '<div class="alert">Application error. Contact Admin.</div>';
			break;

			case 'invalidImage' :
				echo '<div class="alert">Invalid image. It must be under 2MB and a PNG or JPG.</div>';
				break;
			
}
?>
<div id="container">
<h1>AppShack</h1>
		<div id="navigation">
			<ul>
				<li><a href="index.php">Home</a></li>
				<?php if (isset($username)) { ?>
				<li><a href="profile.php">User Profile</a></li>
				<li class="account"><a href="logout.php"> Log out</a></li>
				<?php } else { ?>
				<li class="account"><a href="signup.php">Sign Up</a></li>
				<li class="account active"><a href="login.php">Login</a></li>
				<?php }?>
			</ul>
		</div>
	
			<div id="content-container">
		
	<div id="registration">	
		<div class="form-title">Submit new Application</div>

<form name="registrationForm" action="appCreator.php" method="post" enctype="multipart/form-data">
<table>
  <tbody>
  <tr>
    <td><label>Appliction Name:</label></td>
    <td><div><input name="appName" type="text" class="signUpInput"/></div></td>
  </tr>
  <tr>
    <td><label>Application Description:</label></td>
    <td><div><textarea name="description" cols="1" rows="3" class="signUpInput"></textarea></div></td>
  </tr>
    <tr>
    <td><label>Platform:</label></td>
    <td><div> 
		 	<select name="platform" class="signUpInput">
		 	<option value="windows">Windows</option>
		 	<option value="mac">Mac</option>
		 	<option value="linux">Linux</option>
		 	<option value="ios">iOS</option>
		 	<option value="android">Android</option>
		 	</select></div></td>
  </tr>
  <tr>
    <td><label>Direct Download URL:</label></td>
    <td><div><input name="downloadURL" type="text" class="signUpInput"/></div></td>
  </tr>
  <tr>
    <td><label>Icon:</label></td>
    <td><div><input type="file" name="icon" id="icon"/> </div></td>
  </tr>
  <tr>
  <td></td><td><input type="submit" class="signup" value="Submit" /></td>
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
		</div>	</div>
</body>
</html>