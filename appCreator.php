<?php
include 'setup.php';

// username and password sent from form
$appName = $_POST ['appName'];
$appDescription = $_POST ['description'];
$platform = $_POST ['platform'];
$downloadURL = $_POST ['downloadURL'];
$username = $_SESSION['username'];
$icon = $_FILES["icon"];

// Data Validation, normal user should never see this due to javascript
// validation on client.
// But for security reasons we should not trust the client as js could be
// disabled, check again on server.
if ($appName == "" || $appDescription == "" || $platform == "" || $downloadURL == "") {
	//Redirect using javascript instead of headers.
	printf("<script>location.href='newapp.php?status=nullError'</script>");
	die();
}

// Protection from injection attacks.
$username = stripslashes ( $username );
$appName = stripslashes ( $appName );
$appDescription = stripslashes ( $appDescription );
$platform = stripslashes ( $platform );
$username = mysql_real_escape_string ( $username );
$appName = mysql_real_escape_string ( $appName );
$appDescription = mysql_real_escape_string ( $appDescription );
$platform = mysql_real_escape_string ( $platform );

//Make sure URL's are valid.
if(!filter_var($downloadURL, FILTER_VALIDATE_URL))
{
	printf("<script>location.href='newapp.php?status=invalidURL'</script>");
	die();
}

// Does the Application already exist in the database?
$getUser = "select * from applications where name='$appName'";
$result = mysql_query ( $getUser );
$count = mysql_num_rows ( $result );
if ($count >= 1) {
	printf("<script>location.href='newapp.php?status=appexists'</script>");
	die();
}

else {
	
	if ((($_FILES["icon"]["type"] == "image/png") //PNG
			|| ($_FILES["icon"]["type"] == "image/jpeg") //JPG
			|| ($_FILES["icon"]["type"] == "image/pjpeg"))
			&& ($_FILES["icon"]["size"] < 2097152 )) //No bigger than 2MB.
	{
	
	//Get the developer ID
	$getUserID = "select id from users where username='$username'";
	$result = mysql_query($getUserID);
	$developerID = mysql_result($result, 0, "id");
		
	$insert = "INSERT INTO  `rb00166`.`applications` ( `name`, `description`, `developerID`, `download`, `platform`)
	VALUES ('$appName', '$appDescription', '$developerID', '$downloadURL' , '$platform');";
	mysql_query ($insert) or die ( mysql_error () );
		
	$check = "SELECT * FROM applications WHERE name='$appName'";
	$result = mysql_query ($check);
	$applicationID = mysql_result($result, 0, "id");
		
      	mkdir("images/".$applicationID);
      	move_uploaded_file($_FILES["icon"]["tmp_name"], "images/".$applicationID."/" . $_FILES["icon"]["name"]);
      	mysql_query("UPDATE applications SET icon='images/".$applicationID."/".$_FILES['icon']['name']."' WHERE id='$applicationID'");
      	 
  } 
  //File is not an image or too big.
else
  {
		printf("<script>location.href='newapp.php?status=invalidImage'</script>");
		die();
  }

	//Create the corresponding review table.
	mysql_query("INSERT INTO `rb00166`.`reviews` (`applicationID`) VALUES ('$applicationID');");
	// Mysql_num_row is counting table row
	$count = mysql_num_rows ( $result );
	// If result matched $myusername and $mypassword, table row must be 1 row
	if ($count == 1) {
		// App created successfully.
		printf("<script>location.href='profile.php?id=".$developerID."&status=appCreated'</script>");
		
	} else {
		printf("<script>location.href='newapp.php?status=notCreated'</script>");
		
	}
}

