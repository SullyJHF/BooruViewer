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
		<div id="dark" style="display:none;"></div>
		<div id="help" style="display:none;">
			<div class="close">x</div>
			<h2>Help:</h2><br>
			<ul>
				<li>This site is designed for viewing images from your favourite booru sites.</li>
				<li>This popup will only show when you first visit the site, but you can access it again in the future with the 'H' key if you so wish.</li>
				<li>To load more images you can scroll to the bottom of the page  or press 'L'</li>
				<li>Press 'O' for options</li>
				<li class="sub">Rating - How safe for work you want the images to be</li>
				<li class="sub">Tags - The tags you want to return results for, separated by spaces</li>
				<li class="sub">Search - Refreshes the page, loading images with the selected options (Safe is default if nothing is selected)</li>
				<li class="sub">Load More - Loads more images in the background</li>
				<li class="sub">Clear - Clears the form</li>
				<li class="sub">Log Out - Logs you off the page</li>
			</ul>
		</div>
		<div id="options" style="display:none;">
			<div id="tagForm">
				<form onSubmit="return false;">
					<div class="close">x</div>
					<div class="space"></div>
					<div class="rightOut">
						<input id="logOut" type="button" name="logout" value="Log out" />
					</div>
					<div class="rightLoad">
						<input id="loadMore" type="button" name="load" value="Load More" />
					</div>
					<h2>Rating:</h2><br>
					<input id="s" type="checkbox" name="s" value="safe" /> Safe<br>
					<input id="q" type="checkbox" name="q" value="questionable" /> Questionable<br>
					<input id="x" type="checkbox" name="x" value="explicit" /> Explicit<br><br>
					<h2>Tags:</h2><small> Remember the tags are very specific</small><br><br>
					<input id="inputTags" type="text" name="tags" /> <br><br>
					<input id="formSubmit" type="submit" name="submit" value="Search" />
					<input type="reset" name="reset" value="Clear" />
					<input id="formGutter" style="display:none;" type="text" name="formGutter" readonly="">
				</form>
			</div>
		</div>
		<div id="notFound" style="display:none;"><p>Tag(s) not found</p></div>
		<div id="noContent" style="display:none;"><p>No Content found, try another rating (press 'o' for options)</p></div>
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