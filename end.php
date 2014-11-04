<?php
	session_start();
	setcookie("loggedin", 0, time()-100);
	$_SESSION['loggedIn'] = false;
	//$_SERVER["PHP_SELF"];
?>