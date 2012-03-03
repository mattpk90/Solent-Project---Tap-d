<!DOCTYPE html>
<html>
<head>
	<title>Database Manager</title>
	<link rel="stylesheet" type="text/css" href="main.css" />
	<link rel="stylesheet" type="text/css" href="jquery-ui-css.css" />
	<script type='text/javascript' src='jquery.js'></script>
	<script type='text/javascript' src='jquery-ui.js'></script>
	
	<script type='text/javascript'>
	</script>
</head>

<body>
<a href="index.php"><button name="home" type="button"/>Home</button></a><br /><br />
<?php 
$conn=mysql_connect("","8kennm51","hiogro") or die (mysql_error());
mysql_select_db("8kennm51");

$select = mysql_query("SELECT * FROM users");

echo "Users Table <br />";
while($row=mysql_fetch_array($select))
{
	echo $row['id']." ";
	echo $row['username']." ";
	echo $row['password']."<br />";
}
echo "<br /><br />";

echo "Cards Table";
echo "<div id='cardTableList'>";
$cards = mysql_query("SELECT * FROM cards");
while($row1=mysql_fetch_array($cards))
{
	echo $row1['id']." ";
	echo $row1['userid']." ";
	echo $row1['name']." ";
	echo $row1['cost']." ";
	echo $row1['type']." ";
	echo $row1['text']." ";
	echo $row1['power']." ";
	echo $row1['toughness']."<br />";
}
echo "</div>";

//mysql_query("UPDATE users SET password='aloevera' WHERE id='1'");	
//mysql_query("INSERT INTO cards (userid, name, cost, type, text) 
	//VALUES ('1', 'Cancel', '1UU', 'Instant', 'Counter target spell.')");		
//mysql_query("DELETE FROM users WHERE id !='1'");


mysql_close($conn);
?>

</body>
</html>