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
	shuffle = function(v){
	    for(var j, x, i = v.length; i; j = parseInt(Math.random() * i), x = v[--i], v[i] = v[j], v[j] = x);
	    return v;
	};
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
		$("#cardinfo").html(outputCardType(id));
		$("#buttonsDiv").show();
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
				$(".graveyardPlaceholder").removeClass(graveyardArray[0]);
				$(".graveyardPlaceholder").addClass(graveyardArray[1]);				

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
				$(".exiledPlaceholder").removeClass(exiledArray[0]);
				$(".exiledPlaceholder").addClass(exiledArray[1]);	

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
					.removeClass()
			      	.addClass('card')
			      	.addClass('ui-draggable')		      
			      	.attr('id', cardID)
			      	.html(outputCardType(cardID))
			      	.append("<div class='cardInfoBox'></div>");
			    if(libraryArray.length == 0) { $(".libraryPlaceholder").hide(); }
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
			    	.html(outputCardType(cardID))
			    	.append("<div class='cardInfoBox'></div>");
			    if(graveyardArray.length == 0){ 
			    	$(".graveyardPlaceholder").removeClass(cardID);
			    }
			    else if(graveyardArray.length >= 2){
			    	$(".graveyardPlaceholder").addClass(graveyardArray[0]);

			    }
			    $("#container").append(newDiv);
			    $("#graveyardCounter").html(graveyardArray.length);									

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
			      	.html(outputCardType(cardID))
			      	.append("<div class='cardInfoBox'></div>");
			    if(exiledArray.length == 0){ 
			    	$(".exiledPlaceholder").hide();
			    	$(".exiledPlaceholder").removeClass(cardID); 
			    }
			    else if(exiledArray.length > 1){
			    	$(".exiledPlaceholder").addClass(exiledArray[0]);
			    }
			    $("#container").append(newDiv);
			    $("#exiledCounter").html(exiledArray.length);			    			

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
				var id = $(this).parent().attr("id");
				$("#cardinfo").removeClass();
				$("#cardinfo").addClass(id);
				$("#cardinfo").html(outputCardType(id));
				$("#buttonsDiv").show();
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

			$(".graveyardPlaceholder")
				.addClass(cardID)
				.html(outputCardType(cardID))
				.append("<div class='cardInfoBox'></div>");	
			
			$(".cardInfoBox").click(function(event){
				event.stopImmediatePropagation();
				var id = graveyardArray[0];
				$("#cardinfo").removeClass();
				$("#cardinfo").addClass(id);
				$("#cardinfo").html(outputCardType(id));
				$("#buttonsDiv").show();
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

			$(".exiledPlaceholder")
				.addClass(cardID)
				.html(outputCardType(cardID))
				.append("<div class='cardInfoBox'></div>");	
			
			$(".cardInfoBox").click(function(event){
				event.stopImmediatePropagation();
				var id = exiledArray[0];
				$("#cardinfo").removeClass();
				$("#cardinfo").addClass(id);
				$("#cardinfo").html(outputCardType(id));
				$("#buttonsDiv").show();
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

function sendToFront(){
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
			$(".graveyardPlaceholder").html(outputCardType(graveyardArray[1])).append("<div class='cardInfoBox'></div>");
			$(".graveyardPlaceholder").addClass(graveyardArray[1]);
			
			$(".cardInfoBox").click(function(event){
				event.stopImmediatePropagation();
				var id = graveyardArray[0];
				$("#cardinfo").addClass(id);
				$("#cardinfo").html(outputCardType(id));
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
			$(".exiledPlaceholder").html(outputCardType(exiledArray[1])).append("<div class='cardInfoBox'></div>");
			$(".exiledPlaceholder").addClass(exiledArray[1]);
			
			$(".cardInfoBox").click(function(event){
				event.stopImmediatePropagation();
				var id = exiledArray[0];
				$("#cardinfo").addClass(id);
				$("#cardinfo").html(outputCardType(id));
				$("#buttonsDiv").show();
			});
		}
		exiledArray.splice(0,1);
		$("#exiledCounter").html(exiledArray.length);
		$(".exiledPlaceholder").removeClass(id);
	}
	
	libraryArray.unshift(id);
	$("#libCounter").html(libraryArray.length);
	$("#cardinfo").html("");
	$("#cardinfo").removeClass();
	$("#buttonsDiv").hide();
}

function sendToBack(){
	$(".libraryPlaceholder").show();
	var id = $("#cardinfo").attr('class');
	if($("#"+id).hasClass("card")){
		$("#"+id).remove();
		$("#cardinfo").removeClass();
	}
	else if($(".graveyardPlaceholder").hasClass(id)){
		if(graveyardArray.length==1){ 
			$(".graveyardPlaceholder").hide();
			$("#cardinfo").removeClass();
		}
		else if(graveyardArray.length>1){
			$(".graveyardPlaceholder").html(outputCardType(graveyardArray[1])).append("<div class='cardInfoBox'></div>");
			$(".cardInfoBox").click(function(event){
				event.stopImmediatePropagation();
				var id = $(graveyardArray).get(0);
				$("#cardinfo").removeClass();
				$("#cardinfo").addClass(id);
				$("#cardinfo").html(outputCardType(id));
				$("#buttonsDiv").show();
			});
		}
		graveyardArray.splice(0,1);
		$("#graveyardCounter").html(graveyardArray.length);
		$(".graveyardPlaceholder").removeClass();
	}
	else if($(".exiledPlaceholder").hasClass(id)){
		if(exiledArray.length==1){ 
			$(".exiledPlaceholder").hide();
			$("#cardinfo").removeClass();
		}
		else if(exiledArray.length>1){
			$(".exiledPlaceholder").html(outputCardType(exiledArray[1])).append("<div class='cardInfoBox'></div>");
			$(".cardInfoBox").click(function(event){
				event.stopImmediatePropagation();
				var id = $(exiledArray).get(0);
				$("#cardinfo").removeClass();
				$("#cardinfo").addClass(id);
				$("#cardinfo").html(outputCardType(id));
				$("#buttonsDiv").show();
			});
		}
		exiledArray.splice(0,1);
		$("#exiledCounter").html(exiledArray.length);
		$(".exiledPlaceholder").removeClass();
	}

	libraryArray.push(id);
	$("#libCounter").html(libraryArray.length);
	$("#cardinfo").html("");
	$("#cardinfo").removeClass();
	$("#buttonsDiv").hide();
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