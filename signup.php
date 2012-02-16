<!DOCTYPE html>
<html>
<head>
	<title>Add Deck</title>
	<link rel="stylesheet" type="text/css" href="main.css" />
	<link rel="stylesheet" type="text/css" href="jquery-ui-css.css" />
	<script type='text/javascript' src='jquery.js'></script>
	<script type='text/javascript' src='jquery-ui.js'></script>
	
	<script type='text/javascript'>	
	$(document).ready(onLoad);

	function onLoad() {
	}
	</script>
</head>

<body>
	<a href="index.html"><button name="home" type="button"/>Home</button></a><br /><br />

	<form>
	<table>
	<tr>	<td>Email:</td> <td><input type="text" id="email" /></td>		</tr>
	<tr>	<td>Password:</td> <td><input type="text" id="password" /></td>	</tr>
	<tr>	<td><button id="register" type="submit"/>Register</button></td>	</tr>
	</table>
	</form>

	<?php
	$conn=mysql_connect("","8kennm51","hiogro") or die (mysql_error());
	mysql_select_db("8kennm51");
	$a = mysql_query("select * from cards");
	
	while($row = mysql_fetch_array($a))
	{
		echo $row["id"]."&nbsp;".$row["name"];
		echo "<br />";
	}

	mysql_close($conn);
	?>
</body>
</html>