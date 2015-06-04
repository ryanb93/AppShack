<?php
include 'setup.php';
//Set various variables.
$username = $_SESSION ["username"];
$rating = $_POST["rating"];
$comment = $_POST["comment"];
$id = $_POST["appid"];
$empty = false;
$posted = false;

if ($username == "") {
	header('Location: login.php');
}

if(isSet($rating)) {

	$rating = stripslashes ( $rating );
	$rating = mysql_real_escape_string ( $rating );
	$comment = stripslashes ( $comment );
	$comment = mysql_real_escape_string ( $comment );

	//Get the review string from database.
	$check = "SELECT review FROM reviews WHERE applicationID='$id'";
	$result = mysql_query($check);
	$string = mysql_result($result, 0, "review");
	//Create an XML element from the string.
	$reviews = new SimpleXMLElement($string);
	//Check to make sure this user hasnt already submitted a review.
	if ($reviews->review->username != null) {
		foreach ($reviews->review as $child) {
			if($child->username == $username) {
				$posted = true;
			}
		}
	} 
	if ($comment == "") $empty = true;

	if($empty != true && $posted != true) {
	
	//Add a new review.
	$review = $reviews->addChild('review');
	$review->addChild('username', $username);
	$review->addChild('rating', $rating);
	$review->addChild('comment', $comment);

	//Update the database with the added review.
	mysql_query("UPDATE reviews SET review='".$reviews->asXML()."' WHERE applicationID='$id'");

	}
	if ($empty == true) {
		echo '<div id="errorBox" style="visibility: visible">Sorry, the comment field was empty.</div>';
	}
	if ($posted == true) {
		echo '<div id="errorBox" style="visibility: visible">It looks like you have already posted a review for this application.</div><br/>';
	}
	
	echo '<h2> Reviews </h2>';
	
	//Get the review string from database.
	$check = "SELECT review FROM reviews WHERE applicationID='$id'";
	$result = mysql_query($check);
	$string = mysql_result($result, 0, "review");
	//Create an XML element from the string.
	$reviews = new SimpleXMLElement($string);
	$xslDoc = new DOMDocument();
	$xslDoc->load("xml/style.xsl");
	$xmlDoc = new DOMDocument();
	$xmlDoc->loadXML($string);
	//Make sure the XML is valid to its DTD. If it is not then we will show an error.
	if ($xmlDoc->validate()) {
		$proc = new XSLTProcessor();
		$proc->importStylesheet($xslDoc);
		echo $proc->transformToXml($xmlDoc);
	}
	else {
		echo '<div id="errorBox" style="visibility: visible">Sorry, this XML file is broken.</div><br/>';
	}
}