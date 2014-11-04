<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>仕事</title>

<link href="../css/reset.css" rel="stylesheet" type="text/css" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />

</head>
<body>
	<div id="header-container">
		<div id="header">
			<h1>Hello there.</h1>
		</div>
		<div id="navbar">
			<ul>
				<a href="../"><li>Main</li></a>
				<a href="../dev"><li>Dev</li></a>
				<a href="http://twitch.tv/sullyjhf/"><li>Stream</li></a>
				<a href=""><li>Work</li></a>
			</ul>
		</div>
	</div>
	<div id="container">
	
		<div id="start">
			<?php
				$quotes = array(
				"Frankly, my dear, I don't give a damn.",
				"I'm going to make him an offer he can't refuse.",
				"Toto, I've a feeling we're not in Kansas anymore.",
				"Go ahead, make my day.",
				"May the Force be with you.",
				"You talkin' to me?",
				"Fasten your seatbelts. It's going to be a bumpy night.",
				"E.T. phone home.",
				"Bond. James Bond.",
				"There's no place like home.",
				"After all, tomorrow is another day!",
				"You're gonna need a bigger boat.",
				"My Momma always said life was like a box of chocolates. You never know what you're gonna get.",
				"I see dead people.",
				"Houston, we have a problem.",
				"It's alive! It's alive!",
				"Keep your friends close, but your enemies closer.",
				"Well, here's another nice mess you've gotten me into!",
				"Take your stinking paws off me, you damned dirty ape.",
				"Here's Johnny!",
				"Hasta la vista, baby.",
				"A martini. Shaken, not stirred.",
				"I feel the need—the need for speed!",
				"My precious.",
				"Haha, what a story Mark.",
				"You can say that again!"
				);
				
				$length = count($quotes);
				$rand = rand(0, $length-1);
				echo "<p>\"".$quotes[$rand]."\"</p>";
			?>
		</div>
		<div id="left">
			<h1>This is some of my work.</h1>
			<br />
			<div class="content">
				<a href="http://antoniahockton.co.uk/"><img src="../images/hockton_thumb.jpg" alt="Hockton Sculpture"/></a>
				<p>This was the first site I ever made, the whole page is built up of just images, using rollovers for the buttons and such. Obviously it isn't the best but for a first I think it's reasonable. I learned a lot in the process of making this, and even more since then, working on new projects. Looking back over this code makes me cringe and I should probably go back and rewrite this soon.</p>
				<div class="clear"></div>
			</div>
			<div class="content">
				<a href="http://tobiasfordsculpture.com/"><img src="../images/tobiassculpture_thumb.jpg" alt="Tobias Ford Sculpture"/></a>
				<p>Worked on this for quite a while only to find out that it didn't look right on pretty much all browsers bar chrome (and maybe firefox). This is where I learned that all other browsers are bad and need to be catered for, however rewriting this was a ton of fun and I learned loads. I am actually currently rewriting it again with database support and a contents management system for my Computing A Level.</p>
				<div class="clear"></div>
			</div>
			</div>
	</div>
	<div id="footer-container">
		<div id="footer">
			<div id="left">
				<a href="mailto:sullyjhf@hotmail.co.uk">sullyjhf@hotmail.co.uk</a>
			</div>
			<div id="right">
				haha.
			</div>
		</div>
	</div>
</body>
</html>