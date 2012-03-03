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
				var getID = $(ui.helper).attr("id");
				var getCardValues = localStorage.getItem(getID);

				var values = getCardValues.split(";");
				var name = values[0];
				var cost = values[1];
				var type = values[2];
				var text = values[3];
				var power = values[4];
				var toughness = values[5];

				$("#cardView").html(name + " " + cost + "<br />" + type + "<br />" + text + 
										"<br />" + power+"/"+toughness);
			}
		});

		$("#deckCounter").html(localStorage.length);

		if(localStorage.length > 0)
		{
			for(var i=0; i < localStorage.length; i++)
			{
				cardKey = localStorage.key(i);
				var getCardValues = localStorage.getItem(cardKey);
				var values = getCardValues.split(";");
				var nameA = values[0];
				var costA = values[1];
				var textA = values[2];
				var powerA = values[3];
				var toughnessA = values[4];

				$("#cardList").append("<li class='ui-state-default' id="+cardKey+">" + 
					nameA + "</li>");
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
			alert('Deck Cleared.');
			window.location.reload();
		}
		else
		{
			alert('Operation cancelled.');
		} 
	}	

	function addPlains()
	{
		var cardValues = [];		
		var nameVal = "Plains";
		var costVal, textVal, typeVal, powerVal, toughnessVal = "";
		
		cardValues.push(nameVal);
		cardValues.push(costVal);
		cardValues.push(typeVal);
		cardValues.push(textVal);
		cardValues.push(powerVal);
		cardValues.push(toughnessVal);

		var newDate = new Date();
		var cardID = newDate.getTime();	
		window.localStorage.setItem(cardID, cardValues.join(";"));	
		cardValues.length = 0;
		window.location.reload();
	}
	
	function addIsland()
	{
		var cardValues = [];			
		var nameVal = "Island";
		var costVal, textVal, typeVal, powerVal, toughnessVal = "";
		
		cardValues.push(nameVal);
		cardValues.push(costVal);
		cardValues.push(typeVal);
		cardValues.push(textVal);
		cardValues.push(powerVal);
		cardValues.push(toughnessVal);

		var newDate = new Date();
		var cardID = newDate.getTime();	
		localStorage.setItem(cardID, cardValues.join(";"));	
		cardValues.length = 0;
		window.location.reload();
	}
	
	function addMountain()
	{
		var cardValues = [];			
		var nameVal = "Mountain";
		var costVal, textVal, typeVal, powerVal, toughnessVal = "";
		
		cardValues.push(nameVal);
		cardValues.push(costVal);
		cardValues.push(typeVal);
		cardValues.push(textVal);
		cardValues.push(powerVal);
		cardValues.push(toughnessVal);

		var newDate = new Date();
		var cardID = newDate.getTime();
		localStorage.setItem(cardID, cardValues.join(";"));		
		cardValues.length = 0;
		window.location.reload();
	}
	
	function addForest()
	{
		var cardValues = [];			
		var nameVal = "Forest";
		var costVal, textVal, typeVal, powerVal, toughnessVal = "";
		
		cardValues.push(nameVal);
		cardValues.push(costVal);
		cardValues.push(typeVal);
		cardValues.push(textVal);
		cardValues.push(powerVal);
		cardValues.push(toughnessVal);

		var newDate = new Date();
		var cardID = newDate.getTime();
		localStorage.setItem(cardID, cardValues.join(";"));			
		cardValues.length = 0;
		window.location.reload();
	}
	
	function addSwamp()
	{
		var cardValues = [];			
		var nameVal = "Swamp";
		var costVal, textVal, typeVal, powerVal, toughnessVal = "";
		
		cardValues.push(nameVal);
		cardValues.push(costVal);
		cardValues.push(typeVal);
		cardValues.push(textVal);
		cardValues.push(powerVal);
		cardValues.push(toughnessVal);

		var newDate = new Date();
		var cardID = newDate.getTime();		
		localStorage.setItem(cardID, cardValues.join(";"));
		cardValues.length = 0;
		window.location.reload();
	}	


	function populateTest()
	{
		for(var i = 0; i < 60; i++)
		{
			var cardValues = [];		
			var newDate = new Date();		
			cardValues.push(i);
			cardValues.push(i);
			cardValues.push(i);
			cardValues.push(i);
			cardValues.push(i);
			cardValues.push(i);			
			localStorage.setItem(newDate.getTime(), cardValues.join(";"));
		}
		window.location.reload();
	}
	</script>
</head>

<body>
	<h3 class="deckTitle">Current Deck</h3><br />
	<div id="countDiv">Count: <div id="deckCounter"></div></div>
	<br />
	<ul id="cardList">
	</ul>

	<div id="leftSide">
	<a href="index.php"><button name="home" type="button"/>Home</button></a><br /><br />


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

	<table><tr><td><button onclick="addPlains()">Add Plains</button></td>
			<td><button onclick="addIsland()">Add Island</button></td>
			<td><button onclick="addMountain()">Add Mountain</button></td>
			<td><button onclick="addForest()">Add Forest</button></td>
			<td><button onclick="addSwamp()">Add Swamp</button></td></tr></table>

	<br />

	<button onclick="clearDeck()">Remove All Cards</button><br />
	<button onclick="populateTest()">Populate Test Deck</button>

	<br /><br /><br /><br />
	<div id="deckManagementTrash">Drag and drop to remove card.</div>
	<div id="cardView"></div>
	</div>


<script type='text/javascript'>	
	$("#addCard").submit(
		function(){
			var cardValues = [];		
			var newDate = new Date();

			var cardID = newDate.getTime();	
			var nameVal = $("#name").val();
			var costVal = $("#cost").val();
			var typeVal = $("#type").val();
			var textVal = $("#text").val();
			var powerVal = $("#power").val();
			var toughnessVal = $("#toughness").val();
			
			cardValues.push(nameVal);
			cardValues.push(costVal);
			cardValues.push(typeVal);
			cardValues.push(textVal);
			cardValues.push(powerVal);
			cardValues.push(toughnessVal);
			
			localStorage.setItem(cardID, cardValues.join(";"));
			cardValues.length = 0;		
		}
	);	
	</script>

</body>
</html>