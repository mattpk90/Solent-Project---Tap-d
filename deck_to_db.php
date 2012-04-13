<!DOCTYPE html>
<html>
<head>
	<title>Store Deck</title>
	<link rel="stylesheet" type="text/css" href="main.css" />
	<link rel="stylesheet" type="text/css" href="jquery-ui-css.css" />
	<script type='text/javascript' src='jquery.js'></script>
	<script type='text/javascript' src='jquery-ui.js'></script>
	
	<script type='text/javascript'>	
	$(document).ready(onLoad);

	function onLoad()
	{
		var count = 0;
		for (var i = 0; i < localStorage.length; i++){
		    var card = localStorage.getItem(localStorage.key(i));
		    $("#hi").append(card + "<br />");
		    count++;
		}
		alert(count);
	}
	</script>
</head>

<body>
	<a href="index.php"><button name="home" type="button">Home</button></a>
	<a href='script.html'><button>Paste Deck Script</button></a><br /><br />
	<textarea id="hi" rows="30" cols="60"></textarea>

	
</body>
</html>