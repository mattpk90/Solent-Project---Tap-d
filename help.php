<!DOCTYPE html>
<html>
<head>
	<title>Help</title>
	<link rel="stylesheet" type="text/css" href="main.css" />
	<link rel="stylesheet" type="text/css" href="jquery-ui-css.css" />
	<script type='text/javascript' src='jquery.js'></script>
	<script type='text/javascript' src='jquery-ui.js'></script>
	<?php include "./functions.php"; ?>
</head>

<body>
	<div id="top">
	<div id="login"> <?php panel() ?> </div>
	<div id="nav">
		<ul>
			<li><a href='index.php'>Home</a></li>
			<li><a href='add_deck.php'>Deck Management</a></li>
		</ul>
	</div>
	<a class="logo" href="index.php"><div id="logoDiv"><img src="images/logo2.png" title="Home" alt="Tap'd"/></div></a>
	</div>
	<br /><br />
	Add your cards one by one through the deck management page. You can speed up the process by dragging <br />
	and dropping the list objects on the right hand side of the page, over the Duplicate area, to copy the details <br />
	of that card to a new card. You can also remove cards the same way with the Remove area.
	<br /><br />

	If you are a member, and logged in, you will see a button to generate a deck script. <br />
	This will provide you with text which you can copy and save somewhere. This script can be used <br />
	to generate your deck again in the future.
	<br />
	To generate your deck, click the Paste Deck Script button, and copy and paste the text into <br />
	the text area, and press the button. This will load your deck back into your browser so you <br />
	can play again, without having to add all your cards again.


	
</body>
</html>