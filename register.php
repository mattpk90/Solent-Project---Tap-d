<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<link rel="stylesheet" type="text/css" href="main.css" />
	<link rel="stylesheet" type="text/css" href="jquery-ui-css.css" />
	<script type='text/javascript' src='jquery.js'></script>
	<script type='text/javascript' src='jquery-ui.js'></script>
	
	<script type='text/javascript'>
	</script>
</head>

<body>
<?php 
$conn=mysql_connect("","8kennm51","hiogro") or die (mysql_error());
mysql_select_db("8kennm51");

if((!isset($_POST["email"])) || (!isset($_POST["password"])))
{	
	echo "You've reached this page with no credentials, please use the sign up form. <br /><br />";
	echo "<a href='index.php'><button name='home' type='button'/>Home</button></a>";
	echo "<a href='signup.html'><button name='home' type='button'/>Sign Up</button></a>";
}else{
	$e = $_POST["email"];
	$p = $_POST["password"];
	
	mysql_query("INSERT INTO users (username, password) VALUES ('$e', '$p')");		

	echo "You have registered. Please log in on the main page. <br /><br />";
	echo "<a href='index.php'><button name='home' type='button'/>Home</button></a>";
}

mysql_close($conn);
?>

</body>
</html>