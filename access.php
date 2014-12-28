<?php
	//setcookie("loggedin", 0, time()-60*60*24*365);
	//ini_set('session.gc_maxlifetime', 60*60*24*365);
	//session_set_cookie_params(60*60*24*365);
	session_start();
	$password = 'aa7726d6c335ea11d6aeb7579a5a2195ab85d511';
	
	/*if($_SESSION['loggedIn'] != true && $_COOKIE['loggedin'] == 1){
		$_SESSION['loggedIn'] = true;
	}*/
	
	if (/*!isset($_SESSION['loggedIn']) || */!isset($_COOKIE['loggedin'])) {
		//$_SESSION['loggedIn'] = false;
		setcookie("loggedin", 0, time()-100);
	}
	
	if (isset($_POST['password'])) {
		if (sha1($_POST['password']) == $password) {
			//$_SESSION['loggedIn'] = true;
			setcookie("loggedin", 1, time()+60*60*24*365);
			header('Location: ' . '/');
		} else {
			die ('Incorrect password');
		}
	} 
	
	if (/*!$_SESSION['loggedIn'] || */!isset($_COOKIE['loggedin'])): 
	//print_r($_COOKIE);
	//print_r($_SESSION);
?>
	
	<html>
	<head>
		<title>Login</title>
		<link href="http://sullivanford.co.uk/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">
		<link href="http://sullivanford.co.uk/favicon.ico" rel="icon" type="image/vnd.microsoft.icon">
		<link href="css/reset.css" rel="stylesheet" type="text/css" />
		<link href="style.css" rel="stylesheet" type="text/css" />
		<link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
		<script src="css/jquery-1.11.1.min.js"></script>
	</head>
	  <body style="height:100%;">
	  	<div style="position:fixed; width:174px; height:90px; top:50%; left:50%; margin-left:-87px; margin-top:-45px;">
			<form method="post">
			 	<p style="text-align:center;">
			 		Secrets:
			 	</p>
			  	<br />
			  	<input style="text-align:center;" type="password" name="password">
			  	<br />
			  	<br />
			  	<p style="text-align:center;">
			  		<input type="submit" name="submit" value="Login">
				</p>
			</form>
		</div>
	  </body>
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-51676819-2', 'auto');
			ga('send', 'pageview');
		</script>
	</html>
	
<?php
	exit();
	endif;
?>