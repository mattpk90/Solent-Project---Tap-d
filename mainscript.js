/*
Todo/ideas:
Dimensions of cards- 0.7:1

css3 page transitions? single file different divs for pages- maintain state of game

stopimmediatepropagation: stops all following functions with same name from calling
add a token card to the field- specify text and can duplicate
draw seven cards for hand
mulligan
send card to top/bottom
flip card

use associative array for library, graveyard etc instead of normal one?
*/
$(document).ready(onLoad);

var libraryArray = [];
var graveyardArray = [];
var exiledArray = [];
var activeCard;

//return a card object from localstorage
function fetchCard(id){
	var getCardString = localStorage.getItem(id);
	var card = JSON.parse(getCardString);
	return card;
}

//set card to either land, spell or creature
function outputCardType(id, l){
	var card = fetchCard(id);

	if(l == "c")
	{
		if(card.type == "Land")
		{
			return "<div class='cardName'>" + card.name + "</div><div class='cardType'>" +
							card.type + "</div>";			
		}
		else if(card.type == "Instant" || card.type == "Sorcery" || 
					card.type == "Enchantment" || card.type == "Artifact")
		{
			return "<div class='cardName'>" + card.name + 
			   "</div><div class='cardCost'>" + card.cost + 
			    "</div><br /><div class='cardType'>" + card.type + 
			    "</div><br /><div class='cardText'>" + card.text + "</div>";
		}
		else if(card.type == "Creature")
		{
			return "<div class='cardName'>" + card.name + "</div><div class='cardCost'>" + card.cost + 
			      	"</div><br /><div class='cardType'>" + card.type + "&nbsp; - &nbsp;" + card.subtype + "</div><br /><div class='cardText'>" 
			      	+ card.text + "</div><br /><div class='cardStats'><div class='cardPower'>" 
			      	+ card.power + "</div>/<div class='cardToughness'>" + card.toughness + "</div></div>";
		}
	}
	else if(l == "i")
	{
		if(card.type == "Land")
		{
			return "<div class='infoCardName'>" + card.name + "</div><div class='infoCardType'>" +
							card.type + "</div>";			
		}
		else if(card.type == "Instant" || card.type == "Sorcery" || 
					card.type == "Enchantment" || card.type == "Artifact")
		{
			return "<div class='infoCardName'>" + card.name + 
			   "</div><div class='infoCardCost'>" + card.cost + 
			    "</div><div class='infoCardType'>" + card.type + 
			    "</div><br /><div class='infoCardText'>" + card.text + "</div>";
		}
		else if(card.type == "Creature")
		{
			return "<div class='infoCardName'>" + card.name + "</div><div class='infoCardCost'>" + card.cost + 
			      	"</div><div class='infoCardType'>" + card.type + "&nbsp; - &nbsp;" + card.subtype + 
			      	"</div><br /><div class='infoCardText'>" + card.text + 
			      	"</div><br /><div class='infoCardStats'><div class='infoCardPower'>" 
			      	+ card.power + "</div>/<div class='infoCardToughness'>" + card.toughness + "</div></div>";
		}
	}
}

shuffle = function(v){
	    for(var j, x, i = v.length; i; j = parseInt(Math.random() * i), x = v[--i], v[i] = v[j], v[j] = x);
	    return v;
	};

function onLoad() {
	
	//populate the library
	if(localStorage.length == 0)
	{
		$(".libraryPlaceholder").hide();
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

	//randomise library on page load
	shuffle(libraryArray);

	//count the number of cards in zones
	$("#libCounter").html(libraryArray.length);
	$("#graveyardCounter").html(graveyardArray.length);
	$("#exiledCounter").html(exiledArray.length);

	//graveyard and exiled hidden by default as game starts with them empty
	$(".graveyardPlaceholder").hide();
	$(".exiledPlaceholder").hide();

	//hide card buttons
	$("#buttonsDiv").hide();

	//$("#sortable").sortable();
	//$("#sortable").disableSelection();

	$('#searchDialog').dialog({autoOpen: false, width: 300,
		close: function(event, ui) { $("#dialogInner").html(""); }
	});

	$(".card").draggable({ cursor: 'move', snap: true, snapTolerance: 5, stack: ".card", delay: 10,
		stop: function(event, ui){
			$('body').css('cursor','default');}})
	.click(function(){
		var id = $(this).attr("id");
		if($(this).hasClass("cardTapped"))
			{ $(this).removeClass("cardTapped"); }
		else{ $(this).addClass("cardTapped"); }
	});

	$(".cardInfoBox").click(function(event){
		event.stopImmediatePropagation();
		var id = $(this).parent().attr("id");
		$("#cardinfo").removeClass();
		$("#cardinfo").addClass(id);
		$("#cardinfo").html(outputCardType(id, "i"));
		$("#buttonsDiv").show();
		if($(this).parent().hasClass("selected")){
			$(".selected").removeClass("selected");
		}else{
			$(".selected").removeClass("selected");
			$(this).parent().addClass("selected");
			$("#cardinfo").html("");
			$("#cardinfo").removeClass();
			$("#buttonsDiv").hide();
		}
		activeCard = id;
	});

	$(".libraryPlaceholder").draggable({ cursor: 'move', revert: 'invalid', helper: "clone",
		start: function(event, ui){ $('#libCounter').html(libraryArray.length-1); },
		stop: function(event, ui){ $('body').css('cursor','default') }
	});	

	$(".graveyardPlaceholder").draggable({ cursor: 'move', helper: "clone",
		stop: function(event, ui){
			$('body').css('cursor','default');},
		start: function(event, ui) { 
			if(graveyardArray.length == 1) 
			{
				$("#graveyardCounter").html("0");
				$(".graveyardPlaceholder").hide();

				ui.helper.html(outputCardType(graveyardArray[0], "c")).append("<div class='cardInfoBox'></div>");
				ui.helper.show();
			}
			else if(graveyardArray.length >= 2) //replaces placeholder with card below it in array
			{
				$("#graveyardCounter").html(graveyardArray.length-1);

				$(".graveyardPlaceholder").html(outputCardType(graveyardArray[1], "c"))
					.append("<div class='cardInfoBox'></div>");
				$(".graveyardPlaceholder").removeClass(graveyardArray[0]);
				$(".graveyardPlaceholder").addClass(graveyardArray[1]);				

				ui.helper.html(outputCardType(graveyardArray[0], "c")).append("<div class='cardInfoBox'></div>");
				ui.helper.show();
				
				$(".cardInfoBox").click(function(event){
					event.stopImmediatePropagation();
					$("#cardinfo").html(outputCardType(graveyardArray[0], "c"));
				});
				
			}
		}
	});	

	$(".exiledPlaceholder").draggable({ cursor: 'move',
		helper: "clone",
		stop: function(event, ui){ $('body').css('cursor','default')}, 
		start: function(event, ui) { 
			if(exiledArray.length == 1) 
			{
				$("#exiledPlaceholder").html("0");
				$(".exiledPlaceholder").hide();

				ui.helper.html(outputCardType(exiledArray[0], "c")).append("<div class='cardInfoBox'></div>");
				ui.helper.show();						
			}
			else if(exiledArray.length >= 2) 
			{
				$("#exiledCounter").html(exiledArray.length-1);

				$(".exiledPlaceholder").html(outputCardType(exiledArray[1], "c"))
					.append("<div class='cardInfoBox'></div>");
				$(".exiledPlaceholder").removeClass(exiledArray[0]);
				$(".exiledPlaceholder").addClass(exiledArray[1]);	

				ui.helper.html(outputCardType(exiledArray[0], "c")).append("<div class='cardInfoBox'></div>");
				ui.helper.show();
				
				$(".cardInfoBox").click(function(event){
					event.stopImmediatePropagation();
					$("#cardinfo").html(outputCardType(exiledArray[0], "i"));
				});
				
			}
		}
	});	

	$("#container").droppable({
		tolerance: 'pointer',
		accept: function(d){
			if((d.hasClass("libraryPlaceholder"))||(d.hasClass("graveyardPlaceholder"))
				||(d.hasClass("exiledPlaceholder")))
			{ return true; }
		},		
		drop: function(event, ui) {
			if(ui.draggable.hasClass("libraryPlaceholder"))
			{
				var cardID = libraryArray[0];
				var card = fetchCard(cardID);
				libraryArray.splice(0,1);
			
				var newDiv = $(ui.helper).clone(false)
					.removeClass()
			      	.addClass('card')
			      	.addClass('ui-draggable')		      
			      	.attr('id', cardID)
			      	.html(outputCardType(cardID, "c"))
			      	.append("<div class='cardInfoBox'></div>");
			    if(libraryArray.length == 0){ $(".libraryPlaceholder").hide(); }
			    $("#container").append(newDiv);		   
			    $("#libCounter").html(libraryArray.length);
			    
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
		    }
		    else if (ui.draggable.hasClass("graveyardPlaceholder"))   
		    {
		    	var cardID = graveyardArray[0];
		    	var card = fetchCard(cardID);
				graveyardArray.splice(0,1);

				var newDiv = $(ui.helper).clone(false)
				  	.removeClass()
			      	.addClass('card')
			     	.addClass('ui-draggable')
			    	.attr('id', cardID)
			    	.html(outputCardType(cardID, "c"))
			    	.append("<div class='cardInfoBox'></div>");
			    if(graveyardArray.length == 0){ 
			    	$(".graveyardPlaceholder").removeClass(cardID);
			    }
			    else if(graveyardArray.length >= 2){
			    	$(".graveyardPlaceholder").addClass(graveyardArray[0]);
			    }
			    $("#container").append(newDiv);
			    $(".graveyardPlaceholder").removeClass("selected");
			    $("#graveyardCounter").html(graveyardArray.length);		
			    $("#cardinfo").html("");
			    $("#cardinfo").removeClass();
			    $("#buttonsDiv").hide();					

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
		    }
		    else if (ui.draggable.hasClass("exiledPlaceholder"))   
		    {
		    	var cardID = exiledArray[0];
		    	var card = fetchCard(cardID);
				exiledArray.splice(0,1);

				var newDiv = $(ui.helper).clone(false)
					.removeClass()
			      	.addClass('card')
			      	.addClass('ui-draggable')		      
			      	.attr('id', cardID)
			      	.html(outputCardType(cardID, "c"))
			      	.append("<div class='cardInfoBox'></div>");
			    if(exiledArray.length == 0){ 
			    	$(".exiledPlaceholder").hide();
			    	$(".exiledPlaceholder").removeClass(cardID); 
			    }
			    else if(exiledArray.length > 1){
			    	$(".exiledPlaceholder").addClass(exiledArray[0]);
			    }
			    $("#container").append(newDiv);
			    $(".exiledPlaceholder").removeClass("selected");
			    $("#exiledCounter").html(exiledArray.length);
			    $("#cardinfo").html("");
			    $("#cardinfo").removeClass();
			    $("#buttonsDiv").hide();		    			

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
		    }

		    $(".cardInfoBox").click(function(event){
				event.stopImmediatePropagation();			
				if($(this).parent().hasClass("selected")){
					$(".selected").removeClass("selected");
					$("#cardinfo").html("");
					$("#cardinfo").removeClass();
					$("#buttonsDiv").hide();
					activeCard = null;
				}else{
					var id = $(this).parent().attr("id");
					$("#cardinfo").removeClass();
					$("#cardinfo").addClass(id);
					$("#cardinfo").html(outputCardType(id, "i"));
					$("#buttonsDiv").show();
					$(".selected").removeClass("selected");
					$(this).parent().addClass("selected");	
					activeCard = id;		
				}			
			});

		    $("#library").css('border-color', '#d6d3c0');
		    $("#hand").css('border-color', '#d6d3c0');
		    $("#graveyard").css('border-color', '#d6d3c0');
		    $("#battlefield").css('border-color', '#d6d3c0');
		    $("#exile").css('border-color', '#d6d3c0');
		    $('body').css('cursor','default');
		}
	});

	$("#library").droppable({
		tolerance: 'pointer',
		accept: '.card, .graveyardPlaceholder, .exiledPlaceholder',
		over: function(event, ui){
			$("#library").css('border-color', 'yellow');
		},
		out: function(event, ui){
			$("#library").css('border-color', '#d6d3c0');
		},
		drop: function(event, ui){
			$("#library").css('border-color', '#d6d3c0');				
				$(".libraryPlaceholder").show();
				var cardID = ui.draggable.attr("id");
				ui.draggable.remove();			
				libraryArray.unshift(cardID);
				$('body').css('cursor','default');
				$("#libCounter").html(libraryArray.length);
				if(cardID == activeCard){
					$("#cardinfo").removeClass();
					$("#cardinfo").html("");
					$("#buttonsDiv").hide();
				}			
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
		accept: '.card',
		over: function(event, ui){
			$("#graveyard").css('border-color', 'yellow');
		},
		out: function(event, ui){
			$("#graveyard").css('border-color', '#d6d3c0');
		},
		drop: function(event, ui){
			$("#graveyard").css('border-color', '#d6d3c0');	
			$(".graveyardPlaceholder").show();
			if(graveyardArray.length >= 1){
				$(".graveyardPlaceholder").removeClass(graveyardArray[0]);
			}
			var cardID = ui.draggable.attr("id");
			ui.draggable.remove();				
			graveyardArray.unshift(cardID);
			$(".graveyardPlaceholder").addClass(cardID);
			$("#graveyardCounter").html(graveyardArray.length);
			$("#buttonsDiv").hide();
			$("#cardinfo").html("");
			$("#cardinfo").removeClass();
			$(".selected").removeClass("selected");

			$(".graveyardPlaceholder")
				.addClass(cardID)
				.html(outputCardType(cardID, "c"))
				.append("<div class='cardInfoBox'></div>");
			
			$(".cardInfoBox").click(function(event){
				event.stopImmediatePropagation();			
				if($(this).parent().hasClass("selected")){
					$(".selected").removeClass("selected");
					$("#cardinfo").html("");
					$("#cardinfo").removeClass();
					$("#buttonsDiv").hide();
					activeCard = null;
				}else{
					var id = graveyardArray[0];
					$("#cardinfo").removeClass();
					$("#cardinfo").addClass(id);
					$("#cardinfo").html(outputCardType(id, "i"));
					$("#buttonsDiv").show();
					$(".selected").removeClass("selected");
					$(".graveyardPlaceholder").addClass("selected");
					activeCard = id;		
				}			
			});
			$('body').css('cursor','default');
		}
	});

	$("#exile").droppable({
		tolerance: 'pointer',
		accept: '.card',
		over: function(event, ui){
			$("#exile").css('border-color', 'yellow');
		},
		out: function(event, ui){
			$("#exile").css('border-color', '#d6d3c0');
		},
		drop: function(event, ui){
			$("#exile").css('border-color', '#d6d3c0');		
			$(".exiledPlaceholder").show();		
			if(exiledArray.length >= 1){
				$(".exiledPlaceholder").removeClass(exiledArray[0]);
			}
			var cardID = ui.draggable.attr("id");
			ui.draggable.remove();				
			exiledArray.unshift(cardID);
			$(".exiledPlaceholder").addClass(cardID);
			$("#exiledCounter").html(exiledArray.length);
			$("#buttonsDiv").hide();
			$("#cardinfo").html("");
			$("#cardinfo").removeClass();
			$(".selected").removeClass("selected");

			$(".exiledPlaceholder")
				.addClass(cardID)
				.html(outputCardType(cardID, "c"))
				.append("<div class='cardInfoBox'></div>");
			
			$(".cardInfoBox").click(function(event){
				event.stopImmediatePropagation();			
				if($(this).parent().hasClass("selected")){
					$(".selected").removeClass("selected");
					$("#cardinfo").html("");
					$("#cardinfo").removeClass();
					$("#buttonsDiv").hide();
					activeCard = null;
				}else{
					var id = exiledArray[0];
					$("#cardinfo").removeClass();
					$("#cardinfo").addClass(id);
					$("#cardinfo").html(outputCardType(id, "i"));
					$("#buttonsDiv").show();
					$(".selected").removeClass("selected");
					$(".exiledPlaceholder").addClass("selected");	
					activeCard = id;		
				}			
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

function sendToLib(l){
	$(".libraryPlaceholder").show();
	var id = $("#cardinfo").attr('class');
	if($("#"+id).hasClass("card")){
		$("#"+id).remove();
	}
	else if($(".graveyardPlaceholder").hasClass(id)){
		if(graveyardArray.length==1){ 
			$(".graveyardPlaceholder").hide();
		}
		else if(graveyardArray.length >= 2){
			$(".graveyardPlaceholder").show();
			$(".graveyardPlaceholder").html(outputCardType(graveyardArray[1], "c")).append("<div class='cardInfoBox'></div>");
			$(".graveyardPlaceholder").addClass(graveyardArray[1]);
			
			$(".cardInfoBox").click(function(event){
				event.stopImmediatePropagation();
				var id = graveyardArray[0];
				$("#cardinfo").addClass(id);
				$("#cardinfo").html(outputCardType(id, "i"));
				$("#buttonsDiv").show();
			});
		}
		graveyardArray.splice(0,1);
		$("#graveyardCounter").html(graveyardArray.length);
		$(".graveyardPlaceholder").removeClass(id);
	}
	else if($(".exiledPlaceholder").hasClass(id)){
		if(exiledArray.length == 1){
			$(".exiledPlaceholder").hide();
		}
		else if(exiledArray.length > 1){
			$(".exiledPlaceholder").show();
			$(".exiledPlaceholder").html(outputCardType(exiledArray[1], "c")).append("<div class='cardInfoBox'></div>");
			$(".exiledPlaceholder").addClass(exiledArray[1]);
			
			$(".cardInfoBox").click(function(event){
				event.stopImmediatePropagation();
				var id = exiledArray[0];
				$("#cardinfo").addClass(id);
				$("#cardinfo").html(outputCardType(id, "i"));
				$("#buttonsDiv").show();
			});
		}
		exiledArray.splice(0,1);
		$("#exiledCounter").html(exiledArray.length);
		$(".exiledPlaceholder").removeClass(id);
	}

	if(l == "f") libraryArray.unshift(id);
	else if(l == "b") libraryArray.push(id);
	$("#libCounter").html(libraryArray.length);
	$("#cardinfo").html("");
	$("#cardinfo").removeClass();
	$("#buttonsDiv").hide();
	$(".selected").removeClass("selected");
	activeCard = null;
}


function modStats(t)
{
	var id = $("#cardinfo").attr("class");

	if(t == "pu"){
		var p = $("#"+id).find('.cardPower').html();
		$("#"+id).find('.cardPower').html(++p);
	}
	else if(t == "pd"){
		var p = $("#"+id).find('.cardPower').html();
		$("#"+id).find('.cardPower').html(--p);
	}
	else if(t == "tu"){
		var t = $("#"+id).find('.cardToughness').html();
		$("#"+id).find('.cardToughness').html(++t);
	}
	else if(t == "td"){
		var t = $("#"+id).find('.cardToughness').html();
		$("#"+id).find('.cardToughness').html(--t);
	}
}

function turnCard(a)
{
	var id = $("#cardinfo").attr("class");

	if(a == "u")
	{
		$("#"+id).removeClass("faceDown");
		$("#"+id).html(outputCardType(id, "c")).append("<div class='cardInfoBox'></div>");
		$(".cardInfoBox").click(function(event){
			event.stopImmediatePropagation();			
			if($(this).parent().hasClass("selected")){
				$(".selected").removeClass("selected");
				$("#cardinfo").html("");
				$("#cardinfo").removeClass();
				$("#buttonsDiv").hide();
				activeCard = null;
			}else{
				var id = $(this).parent().attr("id");
				$("#cardinfo").removeClass();
				$("#cardinfo").addClass(id);
				$("#cardinfo").html(outputCardType(id, "i"));
				$("#buttonsDiv").show();
				$(".selected").removeClass("selected");
				$(this).parent().addClass("selected");	
				activeCard = id;		
			}			
		});

}
	else if(a == "d")
	{
		$("#"+id).addClass("faceDown");
		$("#"+id).html("<div class='backDesign'></div>").append("<div class='cardInfoBox'></div>");
		$(".cardInfoBox").click(function(event){
			event.stopImmediatePropagation();			
			if($(this).parent().hasClass("selected")){
				$(".selected").removeClass("selected");
				$("#cardinfo").html("");
				$("#cardinfo").removeClass();
				$("#buttonsDiv").hide();
				activeCard = null;
			}else{
				var id = $(this).parent().attr("id");
				$("#cardinfo").removeClass();
				$("#cardinfo").addClass(id);
				$("#cardinfo").html(outputCardType(id, "i"));
				$("#buttonsDiv").show();
				$(".selected").removeClass("selected");
				$(this).parent().addClass("selected");	
				activeCard = id;		
			}			
		});
	}
}

function shuffleLib()
{
	shuffle(libraryArray);
	alert("Shuffle Complete.")
}

function searchLib()
{
	if($("#searchDialog").is(":visible")){
		$("#searchDialog").dialog('close');
	}
	else
	{
		for(var i=0; i < libraryArray.length; i++)
		{
			var card = fetchCard(libraryArray[i]);
			$("#dialogInner").append("<tr><td>" + card.name +
				"&nbsp;</td><td><button onclick='removeLib(" + libraryArray[i] + ", " + i + ")'>Remove</button></td</tr>");
		}
		$("#searchDialog").dialog('open');
	}
}

function removeLib(id, pos)
{
	libraryArray.splice(pos, 1);
	if(libraryArray.length == 0){ $(".libraryPlaceholder").hide(); }

    var t = outputCardType(id,"c");
	$("#stage").append("<div class='card ui-draggable' id="+id+">" + t + "</div>");
	$("#"+id).append("<div class='cardInfoBox'></div>");

	$("#"+id).draggable({ cursor: 'move', snap: true, snapTolerance: 5, 
    	stack: ".card", delay: 50, containment: 'window',
		stop: function(event, ui){
			$('body').css('cursor','default');}})
	.click(function(){
		if($(this).hasClass("cardTapped"))
		{
			$(this).removeClass("cardTapped");
		}else{
			$(this).addClass("cardTapped");
		}
	});

	$(".cardInfoBox").click(function(event){
		event.stopImmediatePropagation();			
		if($(this).parent().hasClass("selected")){
			$(".selected").removeClass("selected");
			$("#cardinfo").html("");
			$("#cardinfo").removeClass();
			$("#buttonsDiv").hide();
			activeCard = null;
		}else{
			var id = $(this).parent().attr("id");
			$("#cardinfo").removeClass();
			$("#cardinfo").addClass(id);
			$("#cardinfo").html(outputCardType(id, "i"));
			$("#buttonsDiv").show();
			$(".selected").removeClass("selected");
			$(this).parent().addClass("selected");	
			activeCard = id;		
		}			
	});

	$("#libCounter").html(libraryArray.length);
	$("#searchDialog").dialog('close');
	$("#dialogInner").html("");
}

function untap(){
	$(".cardTapped").removeClass("cardTapped");
}


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