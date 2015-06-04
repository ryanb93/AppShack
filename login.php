<?php 
session_start();
if ($_SESSION['username'] != "") {
	header('Location: index.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<title>Login to your AppShack account.</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<div id="container">
<?php 
$status = $_GET ['status'];

switch($status) {
	case ("invalid") :
		echo '<div id="errorBox" style="visibility:visible">
	Invalid username or password.</div>';
		break;
	
	case ("authfail") :
		echo '	<div id="errorBox" style="visibility:visible">
	Authorisation has failed. Please log in again.</div>';
		break;
}
?>
<h1>AppShack</h1>
		<div id="navigation">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li class="account"><a href="signup.php">Sign Up</a></li>
				<li class="account active"><a href="login.php">Login</a></li>
			</ul>
		</div>
<div id="content-container">

<div id="registration">	
		<div class="form-title">Login</div>

<form name="registrationForm" action="logincheck.php" method="post">
<table>
  <tbody>
  <tr>
    <td><label>Username:</label></td>
    <td><div><input name="username" type="text" class="signUpInput"/></div></td>
  </tr>
  <tr>
    <td><label>Password:</label></td>
    <td><div><input name="password" type="password" class="signUpInput"/></div></td>
  </tr>
    <tr>
    <td><label>Stay logged in?</label></td>
    <td><div><input name="retain" type="checkbox" value="true"/></div></td>
  </tr>
  <tr>
  <td></td><td><input type="submit" class="signup" value="Login" /></td>
  </tr>
  </tbody>
</table>
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
