<!--
Created by Matt Kennedy, 2011-2012.
Property of Matt Kennedy and Southampton Solent University.

Todo/ideas:
Dimensions of cards- 0.7:1

css3 page transitions? single file different divs for pages- maintain state of game

drag over library, layover on card with 'add to library'
stopimmediatepropagation: stops all following functions with same name from calling
add a token card to the field- specify text and can duplicate
draw seven cards for hand
mulligan
send card to top/bottom
flip card
-->

<!DOCTYPE html>
<html>
<head>
	<title>Tap'd</title>
	<link rel="stylesheet" type="text/css" href="main.css" />
	<script type='text/javascript' src='jquery.js'></script>
	<script type='text/javascript' src='jquery-ui.js'></script>
	
	<script type='text/javascript'>
	$(document).ready(onLoad);

	function onLoad() {
		var libraryArray = [];
		var tappedArray = [];

		var clickStart, clickStop, diff;
		var clickTime = 100;

		if(localStorage.length == 0)
		{
			$(".cardback").hide();
		}
		else
		{
			for(var i=0; i < localStorage.length; i++)
			{
				var j = localStorage.key(i);
				libraryArray.push(j);
				j++;
			}
		}

		shuffle = function(v){
		    for(var j, x, i = v.length; i; j = parseInt(Math.random() * i), x = v[--i], v[i] = v[j], v[j] = x);
		    return v;
		};

		shuffle(libraryArray);

		function fetchCard(id){
			var getCardValues = localStorage.getItem(id);
			var values = getCardValues.split(";");
			return {
				'name': values[0],
				'cost': values[1],
				'type': values[2],
				'text': values[3],
				'power': values[4],
				'toughness': values[5]
			};
		}

		var graveyardArray = [];
		var exiledArray = [];
		$("#libCounter").html(libraryArray.length);
		$("#graveyardCounter").html(graveyardArray.length);
		$("#exiledCounter").html(exiledArray.length);

		$(".graveyardPlaceholder").hide();
		$(".exiledPlaceholder").hide();

		$(".card").draggable({ cursor: 'move', snap: true, snapTolerance: 5, stack: ".card", delay: 50,
			stop: function(event, ui){
				$('body').css('cursor','default');}})
		.click(function(){
			var id = $(this).attr("id");
			if($(this).hasClass("cardTapped"))
			{
				$(this).removeClass("cardTapped");
			}else{
			$(this).addClass("cardTapped");
			}
		});

		$(".cardInfoBox").click(function(event){
			event.stopImmediatePropagation();
			var cardIDInfo = $(this).parent().attr("id");
			var cardDataInfo = fetchCard(cardIDInfo);
			$("#cardinfo").html(cardDataInfo.name + " " + cardDataInfo.cost + "<br />" + cardDataInfo.type + 
				"<br />" + cardDataInfo.text + "<br />" + cardDataInfo.power+"/"+cardDataInfo.toughness);
		});

		$(".cardback").draggable({ cursor: 'move', revert: 'invalid',
			helper: "clone",
			start: function(event, ui){ $('#libCounter').html(libraryArray.length-1); },
			stop: function(event, ui){ $('body').css('cursor','default') }
		});	

		$(".graveyardPlaceholder").draggable({ cursor: 'move',
			helper: "clone",
			stop: function(event, ui){
				$('body').css('cursor','default');},
			start: function(event, ui) { 
				if(graveyardArray.length == 1) 
				{
					$("#graveyardCounter").html("0");
					var cardID = $(graveyardArray).get(0);
					var cardData = fetchCard(cardID);

					$(".graveyardPlaceholder").hide();
					if(cardData.cost == "")
					{
						ui.helper.html("<div class='cardName'>" + cardData.name + "</div>")
						 	.append("<div class='cardInfoBox'></div>");			    
					}
					else if(cardData.power == "")
					{
				    	ui.helper.html("<div class='cardName'>" + cardData.name + 
				    	 	"</div><div class='cardCost'>" + cardData.cost + 
				      	"</div><br /><div class='cardType'>" + cardData.type + 
				      	"</div><br /><div class='cardText'>" + cardData.text + "</div>")
				      .append("<div class='cardInfoBox'></div>");	    
					}
					else
					{
				      ui.helper.html("<div class='cardName'>" + cardData.name + 
				      	"</div><div class='cardCost'>" + cardData.cost + 
				      	"</div><br /><div class='cardType'>" + cardData.type + 
				      	"</div><br /><div class='cardText'>" +
				      	cardData.text + "</div><br /><div class='cardStats'>" +
				      	cardData.power + "/" + cardData.toughness + "</div>")
				      .append("<div class='cardInfoBox'></div>");		    
					}

					$(".cardInfoBox").click(function(event){
						event.stopImmediatePropagation();
						var cardIDInfo = $(this).parent().attr("id");
						var cardDataInfo = fetchCard(cardIDInfo);
						$("#cardinfo").html(cardDataInfo.name + " " + cardDataInfo.cost + "<br />" + cardDataInfo.type + 
							"<br />" + cardDataInfo.text + "<br />" + cardDataInfo.power+"/"+cardDataInfo.toughness);
					});
					ui.helper.show();					
				}
				else if(graveyardArray.length >= 2) 
				{
					$("#graveyardCounter").html(graveyardArray.length-1);
					var cardID = $(graveyardArray).get(0);
					var cardData = fetchCard(cardID);
					
					var cardID_1 = $(graveyardArray).get(1);
					var cardData_1 = fetchCard(cardID_1);

					var gLand = $(".graveyardPlaceholder").html("<div class='cardName'>" + cardData_1.name + "</div>")
						 	.append("<div class='cardInfoBox'></div>");

					var gSpell = $(".graveyardPlaceholder").html("<div class='cardName'>" + cardData_1.name + 
					    	 	"</div><div class='cardCost'>" + cardData_1.cost + 
					      	"</div><br /><div class='cardType'>" + cardData_1.type + 
					      	"</div><br /><div class='cardText'>" + cardData_1.text + "</div>")
					    	.append("<div class='cardInfoBox'></div>"); 

					var gCreature = $(".graveyardPlaceholder").html("<div class='cardName'>" + cardData_1.name + 
					      	"</div><div class='cardCost'>" + cardData_1.cost + 
					      	"</div><br /><div class='cardType'>" + cardData_1.type + 
					      	"</div><br /><div class='cardText'>" +
					      	cardData_1.text + "</div><br /><div class='cardStats'>" +
					      	cardData_1.power + "/" + cardData_1.toughness + "</div>")
					    	.append("<div class='cardInfoBox'></div>");


					if(cardData.cost == "")
					{
						ui.helper.html("<div class='cardName'>" + cardData.name + "</div>")
						 	.append("<div class='cardInfoBox'></div>");

						if(cardData_1.cost == "")
						{
							gLand;
						}
						else if(cardData_1.power == "")
						{
							gSpell;
						}
						else
						{
							gCreature;
						}					    
					}
					else if(cardData.power == "")
					{
				    	ui.helper.html("<div class='cardName'>" + cardData.name + 
				    	 	"</div><div class='cardCost'>" + cardData.cost + 
				      	"</div><br /><div class='cardType'>" + cardData.type + 
				      	"</div><br /><div class='cardText'>" + cardData.text + "</div>")
				    	.append("<div class='cardInfoBox'></div>");

				    	if(cardData_1.cost == "")
						{
							gLand;
						}
						else if(cardData_1.power == "")
						{
							gSpell;
						}
						else
						{
							gCreature;
						}
					}
					else
					{
				      ui.helper.html("<div class='cardName'>" + cardData.name + 
				      	"</div><div class='cardCost'>" + cardData.cost + 
				      	"</div><br /><div class='cardType'>" + cardData.type + 
				      	"</div><br /><div class='cardText'>" +
				      	cardData.text + "</div><br /><div class='cardStats'>" +
				      	cardData.power + "/" + cardData.toughness + "</div>")
				      .append("<div class='cardInfoBox'></div>");

				    	if(cardData_1.cost == "")
						{
							gLand;
						}
						else if(cardData_1.power == "")
						{
							gSpell; 
						}
						else
						{
							gCreature;
						}    
					}
					$(".cardInfoBox").click(function(event){
						event.stopImmediatePropagation();
						var cardIDInfo = $(graveyardArray).get(0);
						var cardDataInfo = fetchCard(cardIDInfo);
						$("#cardinfo").html(cardDataInfo.name + " " + cardDataInfo.cost + "<br />" + cardDataInfo.type + 
							"<br />" + cardDataInfo.text + "<br />" + cardDataInfo.power+"/"+cardDataInfo.toughness);
					});
					ui.helper.show();
				}
			}
		});	

		$(".exiledPlaceholder").draggable({ cursor: 'move',
			helper: "clone",
			stop: function(event, ui){ $('body').css('cursor','default')}, 
			start: function(event, ui) { 
				if(exiledArray.length == 1) 
				{
					$("#exiledCounter").html("0");
					var cardID = $(exiledArray).get(0);
					var cardData = fetchCard(cardID);

					$(".exiledPlaceholder").hide();
					if(cardData.cost == "")
					{
						ui.helper.html("<div class='cardName'>" + cardData.name + "</div>")
						 	.append("<div class='cardInfoBox'></div>");			    
					}
					else if(cardData.power == "")
					{
				    	ui.helper.html("<div class='cardName'>" + cardData.name + 
				    	 	"</div><div class='cardCost'>" + cardData.cost + 
				      	"</div><br /><div class='cardType'>" + cardData.type + 
				      	"</div><br /><div class='cardText'>" + cardData.text + "</div>")
				      .append("<div class='cardInfoBox'></div>");	    
					}
					else
					{
				      ui.helper.html("<div class='cardName'>" + cardData.name + 
				      	"</div><div class='cardCost'>" + cardData.cost + 
				      	"</div><br /><div class='cardType'>" + cardData.type + 
				      	"</div><br /><div class='cardText'>" +
				      	cardData.text + "</div><br /><div class='cardStats'>" +
				      	cardData.power + "/" + cardData.toughness + "</div>")
				      .append("<div class='cardInfoBox'></div>");		    
					}

					$(".cardInfoBox").click(function(event){
						event.stopImmediatePropagation();
						var cardIDInfo = $(this).parent().attr("id");
						var cardDataInfo = fetchCard(cardIDInfo);
						$("#cardinfo").html(cardDataInfo.name + " " + cardDataInfo.cost + "<br />" + cardDataInfo.type + 
							"<br />" + cardDataInfo.text + "<br />" + cardDataInfo.power+"/"+cardDataInfo.toughness);
					});
					ui.helper.show();					
				}
				else if(exiledArray.length >= 2) 
				{
					$("#exiledPlaceholder").html(exiledArray.length-1);
					var cardID = $(exiledArray).get(0);
					var cardData = fetchCard(cardID);
					
					var cardID_1 = $(exiledArray).get(1);
					var cardData_1 = fetchCard(cardID_1);

					var gLand = $(".exiledPlaceholder").html("<div class='cardName'>" + cardData_1.name + "</div>")
						 	.append("<div class='cardInfoBox'></div>");

					var gSpell = $(".exiledPlaceholder").html("<div class='cardName'>" + cardData_1.name + 
					    	 	"</div><div class='cardCost'>" + cardData_1.cost + 
					      	"</div><br /><div class='cardType'>" + cardData_1.type + 
					      	"</div><br /><div class='cardText'>" + cardData_1.text + "</div>")
					    	.append("<div class='cardInfoBox'></div>"); 

					var gCreature = $(".exiledPlaceholder").html("<div class='cardName'>" + cardData_1.name + 
					      	"</div><div class='cardCost'>" + cardData_1.cost + 
					      	"</div><br /><div class='cardType'>" + cardData_1.type + 
					      	"</div><br /><div class='cardText'>" +
					      	cardData_1.text + "</div><br /><div class='cardStats'>" +
					      	cardData_1.power + "/" + cardData_1.toughness + "</div>")
					    	.append("<div class='cardInfoBox'></div>");


					if(cardData.cost == "")
					{
						ui.helper.html("<div class='cardName'>" + cardData.name + "</div>")
						 	.append("<div class='cardInfoBox'></div>");

						if(cardData_1.cost == "")
						{
							gLand;
						}
						else if(cardData_1.power == "")
						{
							gSpell;
						}
						else
						{
							gCreature;
						}					    
					}
					else if(cardData.power == "")
					{
				    	ui.helper.html("<div class='cardName'>" + cardData.name + 
				    	 	"</div><div class='cardCost'>" + cardData.cost + 
				      	"</div><br /><div class='cardType'>" + cardData.type + 
				      	"</div><br /><div class='cardText'>" + cardData.text + "</div>")
				    	.append("<div class='cardInfoBox'></div>");

				    	if(cardData_1.cost == "")
						{
							gLand;
						}
						else if(cardData_1.power == "")
						{
							gSpell;
						}
						else
						{
							gCreature;
						}
					}
					else
					{
				      ui.helper.html("<div class='cardName'>" + cardData.name + 
				      	"</div><div class='cardCost'>" + cardData.cost + 
				      	"</div><br /><div class='cardType'>" + cardData.type + 
				      	"</div><br /><div class='cardText'>" +
				      	cardData.text + "</div><br /><div class='cardStats'>" +
				      	cardData.power + "/" + cardData.toughness + "</div>")
				      .append("<div class='cardInfoBox'></div>");

				    	if(cardData_1.cost == "")
						{
							gLand;
						}
						else if(cardData_1.power == "")
						{
							gSpell; 
						}
						else
						{
							gCreature;
						}    
					}
					$(".cardInfoBox").click(function(event){
						event.stopImmediatePropagation();
						var cardIDInfo = $(exiledArray).get(0);
						var cardDataInfo = fetchCard(cardIDInfo);
						$("#cardinfo").html(cardDataInfo.name + " " + cardDataInfo.cost + "<br />" + cardDataInfo.type + 
							"<br />" + cardDataInfo.text + "<br />" + cardDataInfo.power+"/"+cardDataInfo.toughness);
					});
					ui.helper.show();
				}
			}
		});	

			
			
		$("#container").droppable({
			tolerance: 'pointer',
			accept: function(d){
				if((d.hasClass("cardback"))||(d.hasClass("graveyardPlaceholder"))
					||(d.hasClass("exiledPlaceholder")))
				{ return true; }
			},		
			drop: function(event, ui) {
				if(ui.draggable.hasClass("cardback"))
				{
					var cardID = $(libraryArray).get(0);
					var cardData = fetchCard(cardID);
					libraryArray.splice(0,1);

					if(cardData.cost == "")
					{
						var newDiv = $(ui.helper).clone(false)
				      .addClass('card')
				      .addClass('ui-draggable')
				      .removeClass('ui-draggable-dragging')
				      .removeClass('cardback')
				      .attr('id', cardID)
				      .html("<div class='cardName'>" + cardData.name + "</div>")
				      .append("<div class='cardInfoBox'></div>");
				      	if(libraryArray.length == 0) { $(".cardback").hide(); }
				    	$("#container").append(newDiv);
				    	$("#libCounter").html(libraryArray.length);			    
					}
					else if(cardData.power == "")
					{
						var newDiv = $(ui.helper).clone(false)
				      .addClass('card')
				      .addClass('ui-draggable')
				      .removeClass('ui-draggable-dragging')
				      .removeClass('cardback')
				      .attr('id', cardID)
				      .html("<div class='cardName'>" + cardData.name + "</div><div class='cardCost'>" + cardData.cost + 
				      	"</div><br /><div class='cardType'>" + cardData.type + "</div><br /><div class='cardText'>" 
				      		+ cardData.text + "</div>")
				      .append("<div class='cardInfoBox'></div>");
				      	if(libraryArray.length == 0) { $(".cardback").hide(); }
				    	$("#container").append(newDiv);
				    	$("#libCounter").html(libraryArray.length);			    
					}
					else
					{
						var newDiv = $(ui.helper).clone(false)
				      .addClass('card')
				      .addClass('ui-draggable')
				      .removeClass('ui-draggable-dragging')
				      .removeClass('cardback')
				      .attr('id', cardID)
				      .html("<div class='cardName'>" + cardData.name + "</div><div class='cardCost'>" + cardData.cost + 
				      	"</div><br /><div class='cardType'>" + cardData.type + "</div><br /><div class='cardText'>" 
				      		+ cardData.text + "</div><br /><div class='cardStats'>" 
				      		+ cardData.power + "/" + cardData.toughness + "</div>")
				      .append("<div class='cardInfoBox'></div>");
				      	if(libraryArray.length == 0) { $(".cardback").hide(); }
				   		$("#container").append(newDiv);
				    	$("#libCounter").html(libraryArray.length);			    
					}				

				    $(".cardInfoBox").click(function(event){
						event.stopImmediatePropagation();
						var cardID = $(this).parent().attr("id");
						var cardData = fetchCard(cardID);
						$("#cardinfo").html(cardData.name + " " + cardData.cost + "<br />" + cardData.type + 
							"<br />" + cardData.text + "<br />" + cardData.power+"/"+cardData.toughness);
					});

				    $("#"+cardID).draggable({ cursor: 'move', snap: true, snapTolerance: 5, 
				    	stack: ".card", delay: 50, containment: 'window',
						stop: function(event, ui){
							$('body').css('cursor','default');}})
					.click(function(){
						var id = $(this).attr("id");
						if($(this).hasClass("cardTapped"))
						{
							$(this).removeClass("cardTapped");
						}else{
						$(this).addClass("cardTapped");
						}
					});

				    $("#library").css('border-color', '#d6d3c0');
				    $("#hand").css('border-color', '#d6d3c0');
				    $("#graveyard").css('border-color', '#d6d3c0');
				    $("#battlefield").css('border-color', '#d6d3c0');
				    $("#exile").css('border-color', '#d6d3c0');
				    $('body').css('cursor','default');	
			    }
			    else if (ui.draggable.hasClass("graveyardPlaceholder"))   
			    {
			    	var cardID = $(graveyardArray).get(0);
			    	var cardData = fetchCard(cardID);
					graveyardArray.splice(0,1);

				    if(cardData.cost == "")
					{
						var newDiv = $(ui.helper).clone(false)
				      .addClass('card')
				      .addClass('ui-draggable')
				      .removeClass('ui-draggable-dragging')
				      .removeClass('graveyardPlaceholder')
				      .attr('id', cardID)
				      .html("<div class='cardName'>" + cardData.name + "</div>")
				      .append("<div class='cardInfoBox'></div>");
				      	if(graveyardArray.length == 0) { $(".graveyardPlaceholder").hide(); }
				    	$("#container").append(newDiv);
				    	$("#graveyardCounter").html(graveyardArray.length);			    
					}
					else if(cardData.power == "")
					{
						var newDiv = $(ui.helper).clone(false)
				      .addClass('card')
				      .addClass('ui-draggable')
				      .removeClass('ui-draggable-dragging')
				      .removeClass('graveyardPlaceholder')
				      .attr('id', cardID)
				      .html("<div class='cardName'>" + cardData.name + "</div><div class='cardCost'>" + cardData.cost + 
				      	"</div><br /><div class='cardType'>" + cardData.type + "</div><br /><div class='cardText'>" 
				      		+ cardData.text + "</div>")
				      .append("<div class='cardInfoBox'></div>");
				      	if(graveyardArray.length == 0) { $(".graveyardPlaceholder").hide(); }
				    	$("#container").append(newDiv);
				    	$("#graveyardCounter").html(graveyardArray.length);			    
					}
					else
					{
						var newDiv = $(ui.helper).clone(false)
				      .addClass('card')
				      .addClass('ui-draggable')
				      .removeClass('ui-draggable-dragging')
				      .removeClass('graveyardPlaceholder')
				      .attr('id', cardID)
				      .html("<div class='cardName'>" + cardData.name + "</div><div class='cardCost'>" + cardData.cost + 
				      	"</div><br /><div class='cardType'>" + cardData.type + "</div><br /><div class='cardText'>" 
				      		+ cardData.text + "</div><br /><div class='cardStats'>" 
				      		+ cardData.power + "/" + cardData.toughness + "</div>")
				      .append("<div class='cardInfoBox'></div>");
				      	if(graveyardArray.length == 0) { $(".graveyardPlaceholder").hide(); }
				   		$("#container").append(newDiv);
				    	$("#graveyardCounter").html(graveyardArray.length);			    
					}
					

				    $(".cardInfoBox").click(function(event){
						event.stopImmediatePropagation();
						var cardID = $(this).parent().attr("id");
						var cardData = fetchCard(cardID);
						$("#cardinfo").html(cardData.name + " " + cardData.cost + "<br />" + cardData.type + 
							"<br />" + cardData.text + "<br />" + cardData.power+"/"+cardData.toughness);
					});

				    $("#"+cardID).draggable({ cursor: 'move', snap: true, snapTolerance: 5, 
				    	stack: ".card", delay: 50, containment: 'window',
						stop: function(event, ui){
							$('body').css('cursor','default');}})
					.click(function(){
						var id = $(this).attr("id");
						if($(this).hasClass("cardTapped"))
						{
							$(this).removeClass("cardTapped");
						}else{
						$(this).addClass("cardTapped");
						}
					});

				    $("#library").css('border-color', '#d6d3c0');
				    $("#hand").css('border-color', '#d6d3c0');
				    $("#graveyard").css('border-color', '#d6d3c0');
				    $("#battlefield").css('border-color', '#d6d3c0');
				    $("#exile").css('border-color', '#d6d3c0');
				    $('body').css('cursor','default');
			    }
			    else if (ui.draggable.hasClass("exiledPlaceholder"))   
			    {	    	
			    	var cardID = $(exiledArray).get(0);
			    	var cardData = fetchCard(cardID);
					exiledArray.splice(0,1);

				    if(cardData.cost == "")
					{
						var newDiv = $(ui.helper).clone(false)
				      .addClass('card')
				      .addClass('ui-draggable')
				      .removeClass('ui-draggable-dragging')
				      .removeClass('exiledPlaceholder')
				      .attr('id', cardID)
				      .html("<div class='cardName'>" + cardData.name + "</div>")
				      .append("<div class='cardInfoBox'></div>");
				      	if(exiledArray.length == 0) { $(".exiledPlaceholder").hide(); }
				    	$("#container").append(newDiv);
				    	$("#exiledCounter").html(exiledArray.length);			    
					}
					else if(cardData.power == "")
					{
						var newDiv = $(ui.helper).clone(false)
				      .addClass('card')
				      .addClass('ui-draggable')
				      .removeClass('ui-draggable-dragging')
				      .removeClass('exiledPlaceholder')
				      .attr('id', cardID)
				      .html("<div class='cardName'>" + cardData.name + "</div><div class='cardCost'>" + cardData.cost + 
				      	"</div><br /><div class='cardType'>" + cardData.type + "</div><br /><div class='cardText'>" 
				      		+ cardData.text + "</div>")
				      .append("<div class='cardInfoBox'></div>");
				      	if(exiledArray.length == 0) { $(".exiledPlaceholder").hide(); }
				    	$("#container").append(newDiv);
				    	$("#exiledCounter").html(exiledArray.length);			    
					}
					else
					{
						var newDiv = $(ui.helper).clone(false)
				      .addClass('card')
				      .addClass('ui-draggable')
				      .removeClass('ui-draggable-dragging')
				      .removeClass('exiledPlaceholder')
				      .attr('id', cardID)
				      .html("<div class='cardName'>" + cardData.name + "</div><div class='cardCost'>" + cardData.cost + 
				      	"</div><br /><div class='cardType'>" + cardData.type + "</div><br /><div class='cardText'>" 
				      		+ cardData.text + "</div><br /><div class='cardStats'>" 
				      		+ cardData.power + "/" + cardData.toughness + "</div>")
				      .append("<div class='cardInfoBox'></div>");
				      	if(exiledArray.length == 0) { $(".exiledPlaceholder").hide(); }
				   		$("#container").append(newDiv);
				    	$("#exiledCounter").html(exiledArray.length);			    
					}
					

				    $(".cardInfoBox").click(function(event){
						event.stopImmediatePropagation();
						var cardID = $(this).parent().attr("id");
						var cardData = fetchCard(cardID);
						$("#cardinfo").html(cardData.name + " " + cardData.cost + "<br />" + cardData.type + 
							"<br />" + cardData.text + "<br />" + cardData.power+"/"+cardData.toughness);
					});

				    $("#"+cardID).draggable({ cursor: 'move', snap: true, snapTolerance: 5, 
				    	stack: ".card", delay: 50, containment: 'window',
						stop: function(event, ui){
							$('body').css('cursor','default');}})
					.click(function(){
						var id = $(this).attr("id");
						if($(this).hasClass("cardTapped"))
						{
							$(this).removeClass("cardTapped");
						}else{
						$(this).addClass("cardTapped");
						}
					});

				    $("#library").css('border-color', '#d6d3c0');
				    $("#hand").css('border-color', '#d6d3c0');
				    $("#graveyard").css('border-color', '#d6d3c0');
				    $("#battlefield").css('border-color', '#d6d3c0');
				    $("#exile").css('border-color', '#d6d3c0');
				    $('body').css('cursor','default');
			    }
			}
		});

		$("#library").droppable({
			tolerance: 'pointer',
			over: function(event, ui){
				$("#library").css('border-color', 'yellow');
			},
			out: function(event, ui){
				$("#library").css('border-color', '#d6d3c0');
			},
			drop: function(event, ui){
				$("#library").css('border-color', '#d6d3c0');				
					$(".cardback").show();
					var cardID = ui.draggable.attr("id");
					ui.draggable.remove();			
					libraryArray.unshift(cardID);
					$('body').css('cursor','default');
					$("#libCounter").html(libraryArray.length);							
			}
		});	

		$("#battlefield").droppable({
			tolerance: 'pointer',
			over: function(event, ui){
				$("#battlefield").css('border-color', 'yellow');
			},
			out: function(event, ui){
				$("#battlefield").css('border-color', '#d6d3c0');
			}
			,
			drop: function(event, ui){
				$("#battlefield").css('border-color', '#d6d3c0');
			}
		});

		$("#graveyard").droppable({
			tolerance: 'pointer',
			over: function(event, ui){
				$("#graveyard").css('border-color', 'yellow');
			},
			out: function(event, ui){
				$("#graveyard").css('border-color', '#d6d3c0');
			},
			drop: function(event, ui){
				$("#graveyard").css('border-color', '#d6d3c0');			
				var cardID = ui.draggable.attr("id");
				var cardData = fetchCard(cardID);
				ui.draggable.remove();
				if(graveyardArray.length == 0) { $(".graveyardPlaceholder").show(); }			
				graveyardArray.unshift(cardID);
				$("#graveyardCounter").html(graveyardArray.length);

				if(cardData.cost == "")
				{
					$(".graveyardPlaceholder")
					.html("<div class='cardName'>" + cardData.name + "</div>")
					.append("<div class='cardInfoBox'></div>");	
				}
				else if(cardData.power == "")
				{
					$(".graveyardPlaceholder").html("<div class='cardName'>" + cardData.name + 
						"</div><div class='cardCost'>" + cardData.cost + 
				      	"</div><br /><div class='cardType'>" + cardData.type + "</div><br /><div class='cardText'>" 
				      		+ cardData.text + "</div>")
					.append("<div class='cardInfoBox'></div>");
				}
				else
				{
					$(".graveyardPlaceholder").html("<div class='cardName'>" + cardData.name + 
						"</div><div class='cardCost'>" + cardData.cost + 
				      	"</div><br /><div class='cardType'>" + cardData.type + "</div><br /><div class='cardText'>" 
				      		+ cardData.text + "</div><br /><div class='cardStats'>" 
				      		+ cardData.power + "/" + cardData.toughness + "</div>")
					.append("<div class='cardInfoBox'></div>");
				}				

				$(".cardInfoBox").click(function(event){
					event.stopImmediatePropagation();
					var cardIDInfo = $(graveyardArray).get(0);
					var cardDataInfo = fetchCard(cardIDInfo);
					$("#cardinfo").html(cardDataInfo.name + " " + cardDataInfo.cost + "<br />" + cardDataInfo.type + 
						"<br />" + cardDataInfo.text + "<br />" + cardDataInfo.power+"/"+cardDataInfo.toughness);
				});

				$('body').css('cursor','default');
			}
		});

		$("#exile").droppable({
			tolerance: 'pointer',
			over: function(event, ui){
				$("#exile").css('border-color', 'yellow');
			},
			out: function(event, ui){
				$("#exile").css('border-color', '#d6d3c0');
			},
			drop: function(event, ui){
				$("#exile").css('border-color', '#d6d3c0');
				var cardID = ui.draggable.attr("id");
				var cardData = fetchCard(cardID);
				ui.draggable.remove();
				if(exiledArray.length == 0) { $(".exiledPlaceholder").show(); }			
				exiledArray.unshift(cardID);
				$("#exiledCounter").html(exiledArray.length);

				if(cardData.cost == "")
				{
					$(".exiledPlaceholder")
					.html("<div class='cardName'>" + cardData.name + "</div>")
					.append("<div class='cardInfoBox'></div>");	
				}
				else if(cardData.power == "")
				{
					$(".exiledPlaceholder").html("<div class='cardName'>" + cardData.name + 
						"</div><div class='cardCost'>" + cardData.cost + 
				      	"</div><br /><div class='cardType'>" + cardData.type + "</div><br /><div class='cardText'>" 
				      		+ cardData.text + "</div>")
					.append("<div class='cardInfoBox'></div>");
				}
				else
				{
					$(".exiledPlaceholder").html("<div class='cardName'>" + cardData.name + 
						"</div><div class='cardCost'>" + cardData.cost + 
				      	"</div><br /><div class='cardType'>" + cardData.type + "</div><br /><div class='cardText'>" 
				      		+ cardData.text + "</div><br /><div class='cardStats'>" 
				      		+ cardData.power + "/" + cardData.toughness + "</div>")
					.append("<div class='cardInfoBox'></div>");
				}				

				$(".cardInfoBox").click(function(event){
					event.stopImmediatePropagation();
					var cardIDInfo = $(exiledArray).get(0);
					var cardDataInfo = fetchCard(cardIDInfo);
					$("#cardinfo").html(cardDataInfo.name + " " + cardDataInfo.cost + "<br />" + cardDataInfo.type + 
						"<br />" + cardDataInfo.text + "<br />" + cardDataInfo.power+"/"+cardDataInfo.toughness);
				});
				$('body').css('cursor','default');
			}
		});

		$("#hand").droppable({
			tolerance: 'pointer',
			over: function(event, ui){
				$("#hand").css('border-color', 'yellow');
			},
			out: function(event, ui){
				$("#hand").css('border-color', '#d6d3c0');
			},
			drop: function(event, ui){
				$("#hand").css('border-color', '#d6d3c0');
			}
		});
	};

	function validate()
	{
		var e = document.forms["loginform"]["email"].value;
		var p = document.forms["loginform"]["password"].value;
		if(e == "" || p == "")
		{
			alert("You must enter an email and password.");
			return false;
		}
		return true;
	}
	</script>
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
			<div id="cardinfo"></div>
		</div>
		
		<div id="cardcontrols">
			<h3 class="infoheader">Card Controls</h3>

		</div>
	</div>
	
	<div id="bottomContainer">
		<div id="hand">
		</div>

		<div id="library">Library<br />
			<p id="libCounter"></p>		
			<div class="cardback"><div class="backDesign"></div></div>	
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