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

	<div id="stage">
		<div id="battlefield"></div>

		<div id="info">
			<div id="topinfo">		
				<h3 class="infoheader">Card Information</h3>
				<div id="cardinfo" class=""></div>
			</div>
			
			<div id="cardcontrols">
				<h3 class="infoheader">Card Controls</h3>
				<div id="buttonsDiv">
					<button onclick="sendToLib('f')">Library Top</button> &nbsp; <button onclick="modStats('u')">+1/+1</button> &nbsp; <button onclick="turnCard('u')">Face Up</button><br />
					<button onclick="sendToLib('b')">Library Bottom</button> &nbsp; <button onclick="modStats('d')">-1/-1</button> <button onclick="turnCard('d')">Face Down</button>
				</div>
			</div>
		</div>

		<div id="hand">
			<!--
			<ul id="sortable">
			<li class="ui-state-default"><div class="inHand">card1</div></li>
			<li class="ui-state-default"><div class="inHand">card2</div></li>
			<li class="ui-state-default"><div class="inHand">card3</div></li>
			<li class="ui-state-default"><div class="inHand">card4</div></li>
			</ul> -->
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