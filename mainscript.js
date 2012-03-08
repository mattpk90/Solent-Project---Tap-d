/*
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
*/
$(document).ready(onLoad);

function onLoad() {
	var libraryArray = [];
	var graveyardArray = [];
	var exiledArray = [];

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
	shuffle = function(v){
	    for(var j, x, i = v.length; i; j = parseInt(Math.random() * i), x = v[--i], v[i] = v[j], v[j] = x);
	    return v;
	};
	shuffle(libraryArray);

	//return a card object from localstorage
	function fetchCard(id){
		var getCardString = localStorage.getItem(id);
		var card = JSON.parse(getCardString);
		return card;
	}

	//set card to either land, spell or creature
	function outputCardType(id){
		var card = fetchCard(id);

		if(typeof card.cost == "undefined")
		{
			return "<div class='cardName'>" + card.name + "</div>";			
		}
		else if(card.power == "")
		{
			return "<div class='cardName'>" + card.name + 
			   "</div><div class='cardCost'>" + card.cost + 
			    "</div><br /><div class='cardType'>" + card.type + 
			    "</div><br /><div class='cardText'>" + card.text + "</div>";
		}
		else
		{
			return "<div class='cardName'>" + card.name + 
			    "</div><div class='cardCost'>" + card.cost + 
			   	"</div><br /><div class='cardType'>" + card.type + 
			    "</div><br /><div class='cardText'>" +
			    card.text + "</div><br /><div class='cardStats'>" +
			    card.power + "/" + card.toughness + "</div>";
		}
	}

	//count the number of cards in zones
	$("#libCounter").html(libraryArray.length);
	$("#graveyardCounter").html(graveyardArray.length);
	$("#exiledCounter").html(exiledArray.length);

	//graveyard and exiled hidden by default as game starts with them empty
	$(".graveyardPlaceholder").hide();
	$(".exiledPlaceholder").hide();

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
		$("#cardinfo").html(outputCardType(id));
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

				ui.helper.html(outputCardType(graveyardArray[0])).append("<div class='cardInfoBox'></div>");
				ui.helper.show();						
			}
			else if(graveyardArray.length >= 2) //replaces placeholder with card below it in array
			{
				$("#graveyardCounter").html(graveyardArray.length-1);

				$(".graveyardPlaceholder").html(outputCardType(graveyardArray[1]))
					.append("<div class='cardInfoBox'></div>");

				ui.helper.html(outputCardType(graveyardArray[0])).append("<div class='cardInfoBox'></div>");
				ui.helper.show();
				
				$(".cardInfoBox").click(function(event){
					event.stopImmediatePropagation();
					$("#cardinfo").html(outputCardType(graveyardArray[0]));
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

				ui.helper.html(outputCardType(exiledArray[0])).append("<div class='cardInfoBox'></div>");
				ui.helper.show();						
			}
			else if(exiledArray.length >= 2) 
			{
				$("#exiledCounter").html(exiledArray.length-1);

				$(".exiledPlaceholder").html(outputCardType(exiledArray[1]))
					.append("<div class='cardInfoBox'></div>");

				ui.helper.html(outputCardType(exiledArray[0])).append("<div class='cardInfoBox'></div>");
				ui.helper.show();
				
				$(".cardInfoBox").click(function(event){
					event.stopImmediatePropagation();
					$("#cardinfo").html(outputCardType(exiledArray[0]));
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
				var cardID = $(libraryArray).get(0);
				var card = fetchCard(cardID);
				libraryArray.splice(0,1);
			
				var newDiv = $(ui.helper).clone(false)
			      .addClass('card')
			      .addClass('ui-draggable')
			      .removeClass('ui-draggable-dragging')
			      .removeClass('libraryPlaceholder')
			      .attr('id', cardID)
			      .html(outputCardType(cardID))
			      .append("<div class='cardInfoBox'></div>");
			    if(libraryArray.length == 0) { $(".libraryPlaceholder").hide(); }
			    $("#container").append(newDiv);
			    $("#libCounter").html(libraryArray.length);

			    $(".cardInfoBox").click(function(event){
					event.stopImmediatePropagation();
					var cardID = $(this).parent().attr("id");
					$("#cardinfo").html(outputCardType(cardID));
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
		    }
		    else if (ui.draggable.hasClass("graveyardPlaceholder"))   
		    {
		    	var cardID = $(graveyardArray).get(0);
		    	var card = fetchCard(cardID);
				graveyardArray.splice(0,1);

				var newDiv = $(ui.helper).clone(false)
			      .addClass('card')
			      .addClass('ui-draggable')
			      .removeClass('ui-draggable-dragging')
			      .removeClass('graveyardPlaceholder')
			      .attr('id', cardID)
			      .html(outputCardType(cardID))
			      .append("<div class='cardInfoBox'></div>");
			    if(graveyardArray.length == 0) { $(".graveyardPlaceholder").hide(); }
			    $("#container").append(newDiv);
			    $("#graveyardCounter").html(graveyardArray.length);									

			    $(".cardInfoBox").click(function(event){
					event.stopImmediatePropagation();
					var cardID = $(this).parent().attr("id");
					$("#cardinfo").html(outputCardType(cardID));
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
		    }
		    else if (ui.draggable.hasClass("exiledPlaceholder"))   
		    {	    	
		    	var cardID = $(exiledArray).get(0);
		    	var card = fetchCard(cardID);
				exiledArray.splice(0,1);

				var newDiv = $(ui.helper).clone(false)
			      .addClass('card')
			      .addClass('ui-draggable')
			      .removeClass('ui-draggable-dragging')
			      .removeClass('exiledPlaceholder')
			      .attr('id', cardID)
			      .html(outputCardType(cardID))
			      .append("<div class='cardInfoBox'></div>");
			    if(exiledArray.length == 0) { $(".exiledPlaceholder").hide(); }
			    $("#container").append(newDiv);
			    $("#exiledCounter").html(exiledArray.length);			    			

			    $(".cardInfoBox").click(function(event){
					event.stopImmediatePropagation();
					var cardID = $(this).parent().attr("id");
					$("#cardinfo").html(outputCardType(cardID));
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
		    }
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
			ui.draggable.remove();
			if(graveyardArray.length == 0) { $(".graveyardPlaceholder").show(); }			
			graveyardArray.unshift(cardID);
			$("#graveyardCounter").html(graveyardArray.length);

			$(".graveyardPlaceholder")
				.html(outputCardType(cardID))
				.append("<div class='cardInfoBox'></div>");	
			

			$(".cardInfoBox").click(function(event){
				event.stopImmediatePropagation();
				var id = $(graveyardArray).get(0);
				$("#cardinfo").html(outputCardType(id));
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
			ui.draggable.remove();
			if(exiledArray.length == 0) { $(".exiledPlaceholder").show(); }			
			exiledArray.unshift(cardID);
			$("#exiledCounter").html(exiledArray.length);

			$(".exiledPlaceholder")
				.html(outputCardType(cardID))
				.append("<div class='cardInfoBox'></div>");	
			

			$(".cardInfoBox").click(function(event){
				event.stopImmediatePropagation();
				var id = $(exiledArray).get(0);
				$("#cardinfo").html(outputCardType(id));
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