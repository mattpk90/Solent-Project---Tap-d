<?php
//cookies must be set before any header output
if((!isset($_POST["email"])) || (!isset($_POST["password"])))
{
	echo "You have reached this page with no credentials.";
	echo "<a href='index.php'><button name='home' type='button'/>Home</button></a>";
}
else{
$email = $_POST['email'];
$password = $_POST['password'];


$conn=mysql_connect("","8kennm51","hiogro") or die (mysql_error());
mysql_select_db("8kennm51");

//select user row based on login credentials
$sql = mysql_query("SELECT * FROM users WHERE username = '$email' AND password = '$password'");
$count = mysql_num_rows($sql);
$row1 = mysql_fetch_array($sql);
$id = $row1[id];
$expire=time()+60*60*24*30; //set cookie expiration time

if((mysql_num_rows($sql)) == 0) //if no results, incorrect login/no such user
{
	echo "Login details incorrect.";
}
else
{
	setcookie("email", "$email", $expire);
	setcookie("id", "$id", $expire);
	header ("Location: index.php");
}
include "./functions.php";
mysql_close();
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Log In</title>
	<link rel="stylesheet" type="text/css" href="main.css" />
	<link rel="stylesheet" type="text/css" href="jquery-ui-css.css" />
	<script type='text/javascript' src='jquery.js'></script>
	<script type='text/javascript' src='jquery-ui.js'></script>
	
	<script type='text/javascript'>	
	</script>
</head>

<body>
</body>
</html>