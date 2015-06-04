<?php
include 'setup.php';
$username = $_SESSION ["username"];
// ID recieved, pass through validation.
$id = $_GET ['id'];
$id = stripslashes ( $id );
$id = mysql_real_escape_string ( $id );
// Connect to database.
$sql = "SELECT * FROM applications WHERE id = '$id'";
$result = mysql_query ( $sql );
$num = mysql_num_rows ( $result );

// If there is an application with that ID.
if ($num != 0) {
	// Get
	$id = mysql_result ( $result, 0, "id" );
	$name = mysql_result ( $result, 0, "name" );
	$description = mysql_result ( $result, 0, "description" );
	$developerID = mysql_result ( $result, 0, "developerID" );
	$releasedate = mysql_result ( $result, 0, "releasedate" );
	$icon = mysql_result ( $result, 0, "icon" );
	$download = mysql_result ( $result, 0, "download" );
	$platform = mysql_result ( $result, 0, "platform" );
	?>
<!-- Start of HTML -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
<title>AppShack - <?php echo $name ?></title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script type="text/javascript">
//<![CDATA[ 
function submitReview()
{
	//Get values of the form.
	var rating = document.getElementById('rating').value;
	var comment = document.getElementById('comment').value;
	var appid = document.getElementById('appid').value;
//Create the request.
if (window.XMLHttpRequest) request = new XMLHttpRequest(); //New browsers.
else request = new ActiveXObject("Microsoft.XMLHTTP");	 //Old browsers.
//When the request state changes.
request.onreadystatechange = function() {
	//readystate 4 means request finished and response is ready. Status 200 means page was found.
  if (request.readyState==4 && request.status==200) {
	//Get the element and fill it what the request returned.
	  document.getElementById("reviewContainer").innerHTML = request.responseText;
  }
}
//Build the request, fill it with paramaters.
var parameters = "appid="+appid+"&comment="+comment+"&rating="+rating;
request.open("POST","submitReview.php",true);
//Need to send some headers first.
request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
request.setRequestHeader("Content-length", parameters.length);
request.setRequestHeader("Connection", "close");
//Send the request and wait for a response.
request.send(parameters);
}
//]]> 
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
				<li class="account"><a href="signup.php">Sign Up</a></li>
				<li class="account"><a href="login.php">Login</a></li>
				<?php }?>
			</ul>
		</div>
		<div id="content-container">
			<div id="sidebar">
				<h2>
					<?php echo $name?>
				</h2>
				<img src="<?php echo $icon;?>" height="100px;" width="100px;" alt="" />
				<br />
				<?php
	$sql = "SELECT username FROM users WHERE id='$developerID'";
	$result = mysql_query ( $sql );
	$developerName = mysql_result ( $result, 0, "username" );
	echo "Published by: <a href='profile.php?id=" . $developerID . "'>" . $developerName . " </a>";
	?>
				<br />
				<?php
	$releasedate = substr ( $releasedate, 0, 10 );
	echo "Released: " . $releasedate?>
				<br />
				<?php
	echo "Platform: " . $platform . "<br />"?>
				<?php
	// File size calculator using the built in server cURL function.
	$curl = curl_init ();
	// Accept headers.
	curl_setopt ( $curl, CURLOPT_HEADER, true );
	// Nobody
	curl_setopt ( $curl, CURLOPT_NOBODY, true );
	// Set the URL to check size of.
	curl_setopt ( $curl, CURLOPT_URL, $download );
	//
	curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, TRUE );
	// Get the header.
	$header = curl_exec ( $curl );
	// Get the size property from the header.
	$size = curl_getinfo ( $curl, CURLINFO_CONTENT_LENGTH_DOWNLOAD );
	// Depending on the filesize set the prefix and format.
	if ($size / 1024 < 1024)
		$size = number_format ( $size / 1024, 2 ) . ' KB';
	else {
		if ($size / 1048576 < 1024)
			$size = number_format ( $size / 1048576, 2 ) . ' MB';
		else if ($size / 1073741824 < 1024)
			$size = number_format ( $size / 1073741824, 2 ) . ' GB';
	}
	// If the size returned is 0 then link is dead.
	if ($size == 0)
		echo "Link Dead";
	else
		echo "Size: " . $size;
		
	// Get the current logged in users ID.
	if (isSet ( $username )) {
		$sql = "SELECT id FROM users WHERE username='$username'";
		$result = mysql_query ( $sql );
		$currentID = mysql_result ( $result, 0, "id" );
		
		}?> 
		
			</div>
			<div id="content">
				<?php echo $description; ?>
				<br /> <br /> <input type="button" value="Download"
					onclick="window.location.href='<?php echo $download ?>'" />
				<!-- Review Section -->
				<?php if(isSet($username)) { ?>
				<div id="registration">
					<div class="form-title">Submit a review</div>

						<table>
							<tbody>
								<tr>
									<td><label>Rating:</label></td>
									<td><div>
											<select id="rating" name="rating" class="signUpInput">
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
											</select>
										</div></td>
								</tr>
								<tr>
									<td><label>Comment:</label></td>
									<td><div>
											<textarea id="comment" name="comment" class="signUpInput"
												cols="2" rows="3"></textarea>
										</div></td>
								</tr>
								<tr>
									<td></td>
									<td><button type="button" class="signup"
											onclick="submitReview();">Submit</button></td>
								</tr>
								<tr>
									<td></td>
									<td><input id="appid" type="hidden" value="<?php echo $id?>;"
										name="appid" /></td>
								</tr>
							</tbody>
						</table>
				</div>
				<?php }
				else {
					echo "<br />";
					echo "<br />";
					echo "<a href='login.php'>Login</a> to post a review.<br />";
					echo "<br />";
				}
				?>
				<div id="reviewContainer">
					<h2>Reviews</h2>
					<?php
		// Get the review string from database.
		$check = "SELECT review FROM reviews WHERE applicationID='$id'";
		$result = mysql_query ( $check );
		$string = mysql_result ( $result, 0, "review" );
		// Create an XML element from the string.
		$reviews = new SimpleXMLElement ( $string );
		$xslDoc = new DOMDocument ();
		$xslDoc->load ( "xml/style.xsl" );
		$xmlDoc = new DOMDocument ();
		$xmlDoc->loadXML ( $string );
		// Make sure the XML is valid to its DTD. If it is not then we will show
		// an error.
		if ($xmlDoc->validate ()) {
			$proc = new XSLTProcessor ();
			$proc->importStylesheet ( $xslDoc );
			echo $proc->transformToXml ( $xmlDoc );
		} else {
			echo "Sorry, this XML file is broken.";
		}
		?>
					</div>
				<?php
	
}
	
	?>
			</div>
		</div>
		<div id="footer">
			<div id="footercontent">
				Copyright &#169; <a href="http://ryanburke.co.uk">Ryan Burke</a>
				2012 <br />
				<br /> <a href="http://jigsaw.w3.org/css-validator/check/referer"> <img
					style="border: 0; width: 88px; height: 31px"
					src="http://jigsaw.w3.org/css-validator/images/vcss-blue"
					alt="Valid CSS!" /></a> <a
					href="http://validator.w3.org/check?uri=referer"><img
					src="http://www.w3.org/Icons/valid-xhtml10-blue"
					alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a>
			</div>
		</div>
	</div>
</body>
</html>
