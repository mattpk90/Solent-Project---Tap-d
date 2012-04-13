<!DOCTYPE html>
<html>
<head>
	<title>Store Deck</title>
	<link rel="stylesheet" type="text/css" href="main.css" />
	<link rel="stylesheet" type="text/css" href="jquery-ui-css.css" />
	<script type='text/javascript' src='jquery.js'></script>
	<script type='text/javascript' src='jquery-ui.js'></script>
	
	<script type='text/javascript'>	
	$(document).ready(onLoad);

	function onLoad()
	{
		for (var i = 0; i < localStorage.length; i++){
		    var card = localStorage.getItem(localStorage.key(i));
		    $("#scriptArea").append(card + "<br />");
		}
	}
	</script>
	<?php include "./functions.php"; ?>
</head>

<body>
	<div id="top">
	<div id="login"> <?php panel() ?> </div>
	<div id="nav">
		<ul>
			<li><a href='index.php'>Home</a></li>
			<li><a href='add_deck.php'>Deck Management</a></li>
			<li><a href='help.php'>Help</a></li>
		</ul>
	</div>
	<a class="logo" href="index.php"><div id="logoDiv"><img src="images/logo2.png" title="Home" alt="Tap'd"/></div></a>
	</div>
	<a href="script.php"><button>Paste Deck Script</button></a><br /><br />
	Copy this script to a text file and save it.<br />
	<textarea id="scriptArea" rows="30" cols="60"></textarea>

	
</body>
</html>