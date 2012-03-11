<!--
Created by Matt Kennedy, 2012.
Property of Matt Kennedy and Southampton Solent University.
-->

<!DOCTYPE html>
<html>
<head>
	<title>Tap'd</title>
	<link rel="stylesheet" type="text/css" href="main.css" />
	<script type='text/javascript' src='jquery.js'></script>
	<script type='text/javascript' src='jquery-ui.js'></script>
	<script type='text/javascript' src='mainscript.js'></script>

	<?php include "./functions.php"; ?>
</head>


<body>
<div id="container">
	<div id="login"> <?php panel() ?> </div>
	<a class="deckManageButton" href='add_deck.php'><button name='addcard' type='button'>Deck Management</button></a>
	<a href="index.php"><div id="logoDiv"></div></a>

	<div id="battlefield"></div>

	<div id="info">
		<div id="topinfo">		
			<h3 class="infoheader">Card Information</h3>
			<div id="cardinfo" class=""></div>
		</div>
		
		<div id="cardcontrols">
			<h3 class="infoheader">Card Controls</h3>
			<div id="buttonsDiv">
				<button onclick="sendToLib('f')">Top of Library</button> &nbsp; <button>+1/+1</button> &nbsp; <button>Face Up</button><br />
				<button onclick="sendToLib('b')">Bottom of Library</button> &nbsp; <button>-1/-1</button> <button>Face Down</button>
			</div>
		</div>
	</div>
	
	<div id="bottomContainer">
		<div id="hand">
		</div>

		<div id="library">Library<br />
			<p id="libCounter"></p>
			<div class="libraryPlaceholder"><div class="backDesign"></div></div>	
		</div>

		<div id="graveyard">Graveyard <br />
			<p id="graveyardCounter"></p>	
			<div class="graveyardPlaceholder"></div>
		</div>
		<div id="exile">Exiled <br />
			<p id="exiledCounter"></p>	
			<div class="exiledPlaceholder"></div>
		</div>
	</div>
</div>
</body>
</html>