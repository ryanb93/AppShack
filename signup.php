<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<title>Create a new AppShack account</title>
<!-- Validation script. Not for security but more for user experience and to reduce server load. -->
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript">
//When the document is ready.
$(document).ready(function(){
	//When the submit button is pressed.
	$('#registrationForm').submit(function(e) {	
		//Create an ajax request.
		$.ajax({
			type: "POST",
			url: "accountCreator.php",
			data: $('#registrationForm').serialize(),
			dataType: "json",
			success: function(msg) {
				//If the account was created successfully.
				if(parseInt(msg.status)==1)
				{
					window.location=msg.text;
				}
				//If there was an error.
				else if(parseInt(msg.status)==0)
				{
					//Set the visibility of the error box to visible.
					$('#errorBox').css('visibility','visible');
					//Set the text of the error box.
					$('#errorBox').html(msg.text);
				}		
			}
		});
		//jquery method to stop the button from working (so we dont get people spam clicking).
		e.preventDefault();		
	});
});
</script>
</head>

<body>
<div id="container">
<h1>AppShack</h1>

		<div id="navigation">
			<ul>
				<li><a href="index.php">Home</a></li>
				<?php if (isset($username)) { ?>
				<li><a href="profile.php">User Profile</a></li>
				<li class="account"><a href="logout.php"> Log out</a></li>
				<?php } else { ?>
				<li class="account active"><a href="signup.php">Sign Up</a></li>
				<li class="account"><a href="login.php">Login</a></li>
				<?php }?>
			</ul>
		</div>
<div id="content-container">
<div id="registration">

<div class="form-title">Welcome to AppShack</div>
<div class="form-sub-title">Share, publish and review apps!</div>

<form id="registrationForm" action="accountCreator.php" method="post">

<table>
  <tbody>
  <tr>
    <td><label>First Name:</label></td>
    <td><div><input name="firstname" id="firstname" type="text" class="signUpInput"/></div></td>
  </tr>
  <tr>
    <td><label>Last Name:</label></td>
    <td><div><input name="lastname" id="lastname" type="text" class="signUpInput"/></div></td>
  </tr>
    <tr>
    <td><label>User Name:</label></td>
    <td><div><input name="username" id="username" type="text" class="signUpInput"/></div></td>
  </tr>
  <tr>
    <td><label>Your Email:</label></td>
    <td><div><input name="email" id="email" type="text" class="signUpInput"/></div></td>
  </tr>
  <tr>
    <td><label>Password:</label></td>
    <td><div><input name="password" id="password" type="password" class="signUpInput"/></div></td>
  </tr>
    <tr>
    <td><label>Confirm Password:</label></td>
    <td><div><input name="confirmpass" id="confirmpass" type="password" class="signUpInput" /></div></td>
  </tr> 
  <tr>
  <td></td> 
  <td><input type="submit" class="signup" value="Sign Up" /></td>
  </tr>
  </tbody>
</table>
</form>
<div id="errorBox">
&nbsp;
</div>

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



