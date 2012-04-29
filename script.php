<!DOCTYPE html>
<html>
<head>
	<title>Paste Deck</title>
	<link rel="stylesheet" type="text/css" href="main.css" />
	<link rel="stylesheet" type="text/css" href="jquery-ui-css.css" />
	<script type='text/javascript' src='jquery.js'></script>
	<script type='text/javascript' src='jquery-ui.js'></script>
	
	<script type='text/javascript'>	
	//$(document).ready(onLoad);

	function deck()
	{
		localStorage.clear();

		var script = $("#scriptText").val();
		var substr = script.split('}');
		substr.pop();

		for(var i=0; i < substr.length; i++)
		{	
			substr[i] = substr[i]+"}";
		}

		for(var i=0; i < substr.length; i++)
		{
			var newDate = new Date();
			var cardID = newDate.getTime();			
			localStorage.setItem("1" + i + cardID, substr[i]);
		}
		window.location.reload();
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
	Paste your saved deck script here to load it into your browser.<br />
	<textarea id="scriptText" rows="30" cols="60"></textarea><br />
	<button onclick="deck()">Convert Script to Deck</button>

	
</body>
</html>