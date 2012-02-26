<?php 
	$conn=mysql_connect("","8kennm51","hiogro") or die (mysql_error());
	mysql_select_db("8kennm51");

	if((!isset($_POST["email"])) || (!isset($_POST["password"])))
	{	
		echo "No values.";

		$select = mysql_query("SELECT * FROM users");

		while($row=mysql_fetch_array($select))
		{
			echo $row['id'];
			echo $row['username'];
			echo $row['password'];
		}
	}else{
		$e = $_POST["email"];
		$p = $_POST["password"];
		
		mysql_query("INSERT INTO users (username, password) VALUES ('$e', '$p')");		

		echo "registered";
	}

	//mysql_query("DELETE FROM users WHERE id='3'");

	mysql_close($conn);
?>