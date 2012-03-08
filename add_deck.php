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

		$("#cardView").droppable({
			drop: function(event, ui){
				var id = $(ui.helper).attr("id");
				var card = fetchCard(id);

				if(typeof card.cost == "undefined") //land card
				{
					$("#cardView").html("<div class='cardName'>" + card.name + "</div>");
				}
				else if(typeof card.power == "undefined") //spell card
				{
					$("#cardView").html("<div class='cardName'>" + card.name + "</div><div class='cardCost'>" + card.cost + 
				      	"</div><br /><div class='cardType'>" + card.type + "</div><br /><div class='cardText'>" 
				      		+ card.text + "</div>");
				}
				else //creature card
				{
					$("#cardView").html("<div class='cardName'>" + card.name + "</div><div class='cardCost'>" + card.cost + 
				      	"</div><br /><div class='cardType'>" + card.type + "</div><br /><div class='cardText'>" 
				      		+ card.text + "</div><br /><div class='cardStats'>" 
				      		+ card.power + "/" + card.toughness + "</div>");
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
			var plains = { 'name': "Plains" };
			localStorage.setItem(cardID, JSON.stringify(plains));
			window.location.reload();
		}
		else if(l == "i")
		{
			var island = { 'name': "Island" };
			localStorage.setItem(cardID, JSON.stringify(island));
			window.location.reload();
		}
		else if(l == "m")
		{
			var mountain = { 'name': "Mountain" };
			localStorage.setItem(cardID, JSON.stringify(mountain));
			window.location.reload();
		}
		else if(l == "f")
		{
			var forest = { 'name': "Forest" };
			localStorage.setItem(cardID, JSON.stringify(forest));
			window.location.reload();
		}
		else if(l == "s")
		{
			var swamp = { 'name': "Swamp" };
			localStorage.setItem(cardID, JSON.stringify(swamp));
			window.location.reload();
		}
	}

	function populateTest()
	{
		for(var i = 1; i <= 60; i++)
		{			
			var newDate = new Date();
			if(i%4 == 0)
			{
				var card = {
					'name': i,
					'cost': i,
					'type': i,
					'text': i,
					'power': i,
					'toughness': i
				};		
			}
			else if(i%5 == 0)
			{
				var card = {
					'name': i,
					'cost': i,
					'type': i,
					'text': i
				};
			}
			else if(i%2 == 0)
			{
				var card = { 'name': i };
			}
			localStorage.setItem(newDate.getTime(), JSON.stringify(card));
		}
		window.location.reload();
	}
	</script>

	<?php include "./functions.php"; ?>
</head>

<body>
	<div id="login"> <?php panel() ?> </div>
	<a href="index.php"><div id="logoDiv"></div></a>
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
	<tr>	<td>Type:</td> <td><input type="text" id="type" /></td>					</tr>
	<tr>	<td>Text:</td> <td><input type="text" id="text" /></td>					</tr>
	<tr>	<td>Power:</td> <td><input type="text" id="power" />&nbsp;&nbsp;</td>
			<td>Toughness:</td> <td><input type="text" id="toughness" /></td>		</tr>
	<tr>	<td><button id="addSingleCard" type="submit"/>Add Card</button></td>	</tr>
	</table>
	</form>

	<br />

	<table><tr><td><button onclick="addLandCard('p')">Add Plains</button></td>
			<td><button onclick="addLandCard('i')">Add Island</button></td>
			<td><button onclick="addLandCard('m')">Add Mountain</button></td>
			<td><button onclick="addLandCard('f')">Add Forest</button></td>
			<td><button onclick="addLandCard('s')">Add Swamp</button></td></tr></table>

	<br />

	<button onclick="clearDeck()">Remove All Cards</button><br />
	<button onclick="populateTest()">Populate Test Deck</button>
	<?php
	if(isset($_COOKIE['id']))
	{
		echo "<a href='deck_to_db.php'><button name='decktodb' type='button'>
			Store Deck in Database
		</button></a>";
	}
	?>
	

	<br /><br /><br /><br />
	<div id="deckManagementTrash">Drag and drop to remove card.</div>
	<div id="cardView"></div>
	</div>


<script type='text/javascript'>	
	$("#addCard").submit(
		function(){
			var newDate = new Date();
			var cardID = newDate.getTime();	

			var nameVal = $("#name").val();
			var costVal = $("#cost").val();
			var typeVal = $("#type").val();
			var textVal = $("#text").val();
			var powerVal = $("#power").val();
			var toughnessVal = $("#toughness").val();
			
			var card = {
				'name': nameVal,
				'cost': costVal,
				'type': typeVal,
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