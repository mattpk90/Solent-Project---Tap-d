<!--
Created by Matt Kennedy, 2011-2012.
Property of Matt Kennedy and Southampton Solent University.

Trash icon property of "The Noun Project" http://thenounproject.com/

To do:
when adding card, item in list glows (yellow?) for a few seconds to show where it is
ability to duplicate a card
-->

<!DOCTYPE html>
<html>
<head>
	<title>Add Deck</title>
	<link rel="stylesheet" type="text/css" href="main.css" />
	<link rel="stylesheet" type="text/css" href="jquery-ui-css.css" />
	<script type='text/javascript' src='jquery.js'></script>
	<script type='text/javascript' src='jquery-ui.js'></script>
	
	<script type='text/javascript'>	
	var count = 0;
	$(document).ready(onLoad);

	function onLoad() {

		function fetchCard(id){
			var getCardString = localStorage.getItem(id);
			var card = JSON.parse(getCardString);
			return card;
		}

		$("#cardList").sortable();
		$("#cardList").disableSelection();

		$("#deckManagementTrash").droppable({
			over: function(event, ui){
				$("#deckManagementTrash").css("backgroundColor", "#565656");
			},
			out: function(event, ui){
				$("#deckManagementTrash").css("backgroundColor", "#151515");
			},
			drop: function(event, ui){
				var cardID = $(ui.helper).attr("id");
				localStorage.removeItem(cardID);
				alert("Card Removed.");
				window.location.reload();
			}
		});

		$("#duplicateCard").droppable({
			over: function(event, ui){
				$("#duplicateCard").css("backgroundColor", "#565656");
			},
			out: function(event, ui){
				$("#duplicateCard").css("backgroundColor", "#151515");
			},
			drop: function(event, ui){
				var card = fetchCard($(ui.helper).attr("id"));
				var newDate = new Date();
				var cardID = newDate.getTime();

				localStorage.setItem(cardID, JSON.stringify(card));
				alert("Card duplicated.");
				window.location.reload();
			}
		});

		
		$("#cardView").droppable({
			drop: function(event, ui){
				var id = $(ui.helper).attr("id");
				var card = fetchCard(id);

				if(card.type == "Land") //land card
				{
					$("#cardView").html("<div class='infoCardName'>" + card.name + "</div><div class='infoCardType'>" +
						card.type + "</div>");
				}
				else if(card.type == "Instant" || card.type == "Sorcery" || 
					card.type == "Enchantment" || card.type == "Artifact") //spell card
				{
					$("#cardView").html("<div class='infoCardName'>" + card.name + "</div><div class='infoCardCost'>" + card.cost + 
				      	"</div><br /><div class='infoCardType'>" + card.type + "</div><br /><div class='infoCardText'>" 
				      		+ card.text + "</div>");
				}
				else if(card.type == "Creature") //creature card
				{
					$("#cardView").html("<div class='infoCardName'>" + card.name + "</div><div class='infoCardCost'>" + card.cost + 
				      	"</div><br /><div class='cinfoCardType'>" + card.type + "&nbsp; - &nbsp;" + card.subtype + "</div><br /><div class='infoCardText'>" 
				      		+ card.text + "</div><br /><div class='infoCardStats'><div class='infoCardPower'>" 
				      		+ card.power + "</div>/<div class='infoCardToughness'>" + card.toughness + "</div></div>");
				}
			}
		});

		$("#deckCounter").html(localStorage.length);

		if(localStorage.length > 0)
		{
			for(var i=0; i < localStorage.length; i++)
			{
				var id = localStorage.key(i);
				var card = fetchCard(id);

				$("#cardList").append("<li class='ui-state-default' id="+id+">" + 
					card.name + "</li>");
			}
		}
		else
		{
			$("#cardList").append("No cards added yet.");
		}
	}

	function clearDeck()
	{
		if(confirm('Are you sure?'))
		{
			localStorage.clear();
			window.location.reload();
		}
		else
		{
		} 
	}	


	function addLandCard(l){
		var newDate = new Date();
		var cardID = newDate.getTime();
		if(l == "p")
		{		
			var plains = { 'name': "Plains", 'type': "Land" };
			localStorage.setItem(cardID, JSON.stringify(plains));
			window.location.reload();
		}
		else if(l == "i")
		{
			var island = { 'name': "Island", 'type': "Land" };
			localStorage.setItem(cardID, JSON.stringify(island));
			window.location.reload();
		}
		else if(l == "m")
		{
			var mountain = { 'name': "Mountain", 'type': "Land" };
			localStorage.setItem(cardID, JSON.stringify(mountain));
			window.location.reload();
		}
		else if(l == "f")
		{
			var forest = { 'name': "Forest", 'type': "Land" };
			localStorage.setItem(cardID, JSON.stringify(forest));
			window.location.reload();
		}
		else if(l == "s")
		{
			var swamp = { 'name': "Swamp", 'type': "Land" };
			localStorage.setItem(cardID, JSON.stringify(swamp));
			window.location.reload();
		}
	}

	function addPreset(p){
		var newDate = new Date();
		var cardID = newDate.getTime();
		if(p == "c")
		{		
			var card = {
				'name': 'Cancel',
				'cost': '1UU',
				'type': 'Instant',
				'text': 'Counter target spell.'
			};

			localStorage.setItem(cardID, JSON.stringify(card));
			window.location.reload();
		}
		else if(p == "g")
		{
			var card = {
				'name': 'Gemhide Sliver',
				'cost': '1G',
				'type': 'Creature',
				'subtype': 'Sliver',
				'text': 'All slivers have Tap: add one mana of any colour to your mana pool.',
				'power': '1',
				'toughness': '1'
			};
			localStorage.setItem(cardID, JSON.stringify(card));
			window.location.reload();
		}
		else if(p == "s")
		{
			var card = {
				'name': 'Shifting Sliver',
				'cost': '3U',
				'type': 'Creature',
				'subtype': 'Sliver',
				'text': 'Slivers are unblockable except by slivers.',
				'power': '2',
				'toughness': '2'
			};
			localStorage.setItem(cardID, JSON.stringify(card));
			window.location.reload();
		}
		else if(p == "cs")
		{
			var card = {
				'name': 'Crystalline Sliver',
				'cost': 'UW',
				'type': 'Creature',
				'subtype': 'Sliver',
				'text': 'All slivers have shroud.',
				'power': '2',
				'toughness': '2'
			};
			localStorage.setItem(cardID, JSON.stringify(card));
			window.location.reload();
		}
		else if(p == "m")
		{
			var card = {
				'name': 'Mox Opal',
				'cost': '0',
				'type': 'Artifact',
				'text': 'Metalcraft. Tap: Add one mana of any colour to your manapool.'
			};
			localStorage.setItem(cardID, JSON.stringify(card));
			window.location.reload();
		}
	}

	function populateTest()
	{
		for(var i=0; i < 60; i++)
		{
			var newDate = new Date();
			var card = {
				'name': i,
				'cost': i,
				'type': i,
				'text': i,
				'power': i,
				'toughness': i};	
			localStorage.setItem("" + i + newDate.getTime(), JSON.stringify(card));
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
			<li><a href='help.php'>Help</a></li>
		</ul>
	</div>
	<a class="logo" href="index.php"><div id="logoDiv"><img src="images/logo2.png" title="Home" alt="Tap'd"/></div></a>
	</div>
	<h3 class="deckTitle">Current Deck</h3><br />
	<div id="countDiv">Count: <div id="deckCounter"></div></div>
	<br />
	<ul id="cardList">
	</ul>

	<div id="leftSide">
	<form id="addCard">
	<table>
	<tr>	<td>Card Name:</td> <td><input type="text" id="name" /></td>			</tr>
	<tr>	<td>Mana Cost:</td> <td><input type="text" id="cost" /></td>			</tr>
	<tr>	<td>Type:</td> <td><select id="type">
									<option value="Land">Land</option>
									<option value="Instant">Instant</option>
									<option value="Sorcery">Sorcery</option>
									<option value="Enchantment">Enchantment</option>
									<option value="Artifact">Artifact</option>
									<option value="Creature">Creature</option>
								</select>&nbsp;&nbsp;
			Subtype:&nbsp;<input type="text" id="subtype" /></td>
	</tr>
	<tr>	<td>Text:</td> <td><textarea id="text" rows="3" cols="30"> </textarea></td>		</tr>
	<tr>	<td>Power:</td> <td><input type="text" id="power" size="5"/>&nbsp;&nbsp;
			Toughness:&nbsp;<input type="text" id="toughness" size="5"/></td>		</tr>
	<tr>	<td><button id="addSingleCard" type="submit"/>Add Card</button></td>	</tr>
	</table>
	</form>

	<br />

	<table><tr><td><button onclick="addLandCard('p')">Add Plains</button></td>
			<td><button onclick="addLandCard('i')">Add Island</button></td>
			<td><button onclick="addLandCard('m')">Add Mountain</button></td>
			<td><button onclick="addLandCard('f')">Add Forest</button></td>
			<td><button onclick="addLandCard('s')">Add Swamp</button></td></tr>
	</table>

	<table>
			<tr><td><button onclick="addPreset('c')">Add Cancel</button></td>
			<td><button onclick="addPreset('g')">Add Gemhide Sliver</button></td>
			<td><button onclick="addPreset('s')">Add Shifting Sliver</button></td>
			<td><button onclick="addPreset('cs')">Add Crystalline Sliver</button></td>
			<td><button onclick="addPreset('m')">Add Mox Opal</button></td></tr>
	</table>

	<br />

	<button onclick="clearDeck()">Remove All Cards</button><br />
	<button onclick="populateTest()">Populate Test Deck</button>
	<?php
	if(isset($_COOKIE['id']))
	{
		echo "<a href='deck_to_db.php'><button name='decktodb' type='button'>
			Generate Deck Script
		</button></a>
		<a href='script.php'><button>
			Paste Deck Script
		</button></a>
		<a href='sampleScript.php'><button name='decktodb' type='button'>
			Sample Deck Script
		</button></a><br />
		";
	}
	?>
	

	<br />
	<div id="deckManagementTrash">Drag and drop to remove card.</div>
	<div id="duplicateCard">Drag and drop to clone card.</div>
	<div id="cardView">Drag and drop to view card details.</div>
	</div>


<script type='text/javascript'>	
	$("#addCard").submit(
		function(){
			var newDate = new Date();
			var cardID = newDate.getTime();	

			var nameVal = $("#name").val();
			var costVal = $("#cost").val();
			var typeVal = $("#type").val();
			var subTypeVal = $("#subtype").val();
			var textVal = $("#text").val();
			var powerVal = $("#power").val();
			var toughnessVal = $("#toughness").val();
			
			var card = {
				'name': nameVal,
				'cost': costVal,
				'type': typeVal,
				'subtype': subTypeVal,
				'text': textVal,
				'power': powerVal,
				'toughness': toughnessVal
			};
			
			localStorage.setItem(cardID, JSON.stringify(card));		
		}
	);	
	</script>

</body>
</html>