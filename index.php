<?php 
	//ini_set('session.gc_maxlifetime', time()+60*60*24*365);
	//session_set_cookie_params(time()+60*60*24*365);
	session_start();
	require('access.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>チン子</title>
		<link href="http://sullivanford.co.uk/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">
		<link href="http://sullivanford.co.uk/favicon.ico" rel="icon" type="image/vnd.microsoft.icon">
		<link href="css/reset.css" rel="stylesheet" type="text/css" />
		<link href="style.css" rel="stylesheet" type="text/css" />
		<link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<div id="notFound" style="display:none;"><p>Tag(s) not found</p></div>
		<div id="noContent" style="display:none;"><p>No Content found, try another rating (keys 0-4)</p></div>
		<div id="content" style="width:100%;">
			<div id="gutter-sizer"></div>
			<?php require_once 'loadTaggedImages.php'; ?>
		</div>

		<script src="css/jquery-1.11.1.min.js"></script>
		<script src="css/masonry.pkgd.min.js"></script> 
		<script src="css/detectmobilebrowser.js"></script>
		<script src="main.js"></script>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-51676819-2', 'auto');
		  ga('send', 'pageview');

		</script>
	</body>
</html>