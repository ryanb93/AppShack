<?php
include "setup.php";

$search = $_GET['search'];
$search = strtoupper($search);
$search = strip_tags($search);
$search = trim($search);
$username = $_SESSION ["username"];
// Get the top 25 rated applications
$data = ("SELECT * FROM applications WHERE `name` LIKE '%$search%' OR `description` LIKE '%$search%' OR `platform` LIKE '%$search%' LIMIT 25 ");
$result = mysql_query ( $data );
$num = mysql_num_rows ( $result );

$status = $_GET['status'];
?>

<!--Set titles-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<title>Welcome to AppShack by Ryan Burke</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
	<div id="container">
	<?php 
if ($status == "newUser") { ?>
	<div id="errorBox" style="visibility:visible">
	Account created successfully.
	</div>
<?}
?>
		<h1>AppShack</h1>
		<div id="navigation">
			<ul>
				<li class="active"><a href="index.php">Home</a></li>
				<?php if (isset($username)) {?>
				<li ><a href="profile.php">User Profile</a></li>
				<li class="account"><a href="logout.php">Log out</a></li>
				<?php } else { ?>
				<li class="account"><a href="signup.php">Sign Up</a></li>
				<li class="account"><a href="login.php">Login</a></li>
				<?php }?>
			</ul>
		</div>
		<br /><br />
		<h3>Search</h3>
		<div id="searchbar">
		<form action="index.php"  method="get" >
		<!-- Because im using XHTML I can't use the nice 'placeholder' attribute provided by HTML5. So we have a little javascript hack to do the same. -->
		<input name="search" type="text" class="signUpInput"
			value="Search by Name, Description or Platform"
			onfocus="this.value=''; this.style.color = 'black';"
			onblur='this.style.color = "grey"'
			style="width: 300px; color:grey;"/>
		<input type="submit" class="signup" value="Search" />
		</form>
		</div>
<div id="content-container">
				<div id="dwrap">
			<?php
$i = 0;
while ( $i < $num ) {
	$id = mysql_result($result,$i,"id");
	$name = mysql_result($result,$i,"name");
	$platform = mysql_result($result,$i,"platform");
	
	$developer = mysql_result($result,$i, "developerID");
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
		</div>
		
<div id="footer">
			<div id="footercontent">
							Shujun you can log in using Username: <b>ryan</b> Password: <b>tests</b> to access the rest of the site, or create a new user :).
			<br />
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
