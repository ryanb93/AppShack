<?php
// Start session
include 'setup.php';
$username = $_SESSION ["username"];
if($username == null) header ("location:login.php" );
$status = $_GET ["status"];
$id = $_GET ["id"];

$check = "SELECT * FROM users WHERE id='$id'";
$result = mysql_query($check);
$count = mysql_num_rows($result);

if($count == 0) {
	//Redirect to the logged in account.
	$getId = "SELECT * FROM users WHERE username='$username'";
	$idResult = mysql_query ($getId);
	$userid = mysql_result($idResult, 0, "id");
	header("location:profile.php?id=$userid");
}
else {
	$email = mysql_result($result, 0, "email");
	$twitter = mysql_result($result, 0, "twitter");
	$facebook = mysql_result($result, 0, "facebook");
	$skype = mysql_result($result, 0, "skype");
	$account = mysql_result($result, 0, "account");
	}

	//Make sure ID is an integer value.
	if (!filter_var($id, FILTER_VALIDATE_INT)) {
		echo '<div class="alert">Not a valid user ID.</div>';
		$id = null;
	}
	$check = "SELECT * FROM users WHERE id='$id' AND username='$username'";
	$result = mysql_query($check);
	$count = mysql_num_rows($result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<title>AppShack - <?php echo $username ?>'s Profile </title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
	<div id="container">
		<?php 
switch ($status) {
	case 'appCreated' :
		echo '<div id="errorBox" style="visibility:visible">Application was added successfully.</div>';
		break;
}
		?>
		<h1>AppShack</h1>
		
		<div id="navigation">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li class="active"><a href="profile.php">User Profile</a></li>
				<li class="account"><a href="logout.php"> Log out</a></li>
			</ul>
		</div>
		
		<div id="content-container">
		<div id="sidebar">
			<h2>Profile of <?php echo $username;?></h2> 
				<h3>Personal Details</h3>
				Email: <a href="MAILTO:<?php echo $email?>"><?php echo $email?></a> <br/>
				<?php if($twitter != "") {?>Twitter: <a href="http://twitter.com/<?php echo $twitter?>"><?php echo $twitter?></a><br/><?php }?>
				<?php if($facebook != "") {?>Facebook: <a href="http://facebook.com/<?php echo $facebook?>"><?php echo $facebook?></a><br/><?php }?>
				<?php if($skype != "") {?>Skype ID: <a href="skype:<?php echo $skype?>"><?php echo $skype?></a><br/><?php }?>
				
				Account Type: <?php echo $account; ?>
				<br/><br/>
				<?php if ($count != 0) { ?>
				<button type="button" onclick="window.location='editprofile.php'">Edit Profile</button> <br />
												<button type="button" onclick="window.location='merge.php'">Merge Accounts</button>
				
								<?php if($account == "developer") { ?> 
				<br />
				<button type="button" onclick="window.location='newapp.php'">Submit a new App</button> <br />
				
				<?php  } } ?>
				</div>
				<div id="content">
				<?php if($account == "developer") { ?> 
					<h3>Published Applications</h3>
							<div id="dwrap">
							<?php
			$sql = "SELECT * FROM applications WHERE developerID=$id";
			$result = mysql_query ( $sql );
			$num = mysql_num_rows ( $result );
$i = 0;
while ( $i < $num ) {
	$id = mysql_result($result,$i,"id");
	$name = mysql_result($result,$i,"name");
	$developer = mysql_result($result,$i, "developerID");
	$platform = mysql_result($result,$i, "platform");
	$icon = mysql_result($result,$i,"icon");
	$sql = 'SELECT username FROM users WHERE id="'.$developer.'"';
	$devresult = mysql_query ( $sql );
	$developer = mysql_result($devresult,0, "username");
	?>
			<div style="cursor: pointer;" onclick="window.location = 'app.php?id=<?php echo $id ?>'" >
			<table>
			<tr>
			<td>
			<img src="<?php echo $icon ?>" width="50px" height="50px" alt="icon" />
			</td>
			<td>
			<b><?php echo $name ?></b>
			<br /><?php echo $developer ?>
						<br /><?php echo $platform ?>	
			</td>
			</tr>
			</table>
			</div>
			<?php $i++; } ?>
		</div>
						 <?php } ?>

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