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
				<li><a href='help.php'>Help</a></li>
			</ul>
		</div>
		<a class="logo" href="index.php"><div id="logoDiv"><img src="images/logo2.png" title="Home" alt="Tap'd"/></div></a>
	</div>

	<div id="stage">
		<div id="searchDialog"><div id="dialogInner"></div></div>
		<div id="tokenDialog"><div id="tokenDialogInner"></div></div>
 		<div id="battlefield"></div>

		<div id="info">
			<div id="topinfo">		
				<h3 class="infoheader">Card Information</h3>
				<div id="cardinfo" class=""></div>
			</div>
			
			<div id="cardcontrols">
				<h3 class="infoheader">Card Controls</h3>
				<div id="buttonsDiv">
					<table>
						<tr><td><button onclick="sendToLib('f')">Library Top</button></td> <td><button onclick="sendToLib('b')">Library Bottom</button></td></tr>
						<tr><td><button onclick="turnCard('u')">Face Up</button></td> <td><button onclick="turnCard('d')">Face Down</button><td></tr>
						<tr><td><button onclick="modStats('pu')">+1</button><button onclick="modStats('tu')">+1</button></td>
						<td><button onclick="modStats('pd')">-1</button><button onclick="modStats('td')">-1</button></td></tr>
					</table>
				</div>
			</div>
		</div>

		<div id="hand">
			<button onclick="shuffleLib()">Shuffle Library</button>
			<button onclick="searchLib()">Search Library</button>
			<button onclick="untap()">Untap All</button>&nbsp;&nbsp;&nbsp;
			Hit Points:<select id="hp"></select>&nbsp;&nbsp;
			Poison Counters:<select id="poison"></select> 
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