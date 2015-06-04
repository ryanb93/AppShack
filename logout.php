<?php
setcookie("username", "false", time()+86400);
setcookie("hash", "false", time()+86400);
setcookie("retain", "false", time()+86400);
session_start ();
session_destroy ();
header ( "Location:index.php" );
?>