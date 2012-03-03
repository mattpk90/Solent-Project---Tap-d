<?php
function db()
{	
	$conn=mysql_connect("","8kennm51","hiogro") or die (mysql_error());
	mysql_select_db("8kennm51");
}

/*function nav()
{
	//checks if username AND admin cookies are set, means admin is logged on so includes navigation for admins
	if ((isset($_COOKIE["username"])) && (isset($_COOKIE["admin"])))
	{ include("navadmin.php"); }
	else if (isset($_COOKIE["username"])) //checks if username is set, so includes navigation for users
	{ include("nav.php"); }
	else // nothing set so user not logged in
	{ include("navlogout.php"); }
}*/

function panel()
{
	if (!isset($_COOKIE['email'])) //checks if username is not set
	{
		echo "<form class='panelForm' name='loginform' onsubmit='return validate()' method='post' action='login.php'> 
		Email: <input name='email' type='text'/> 
		Password: <input name='password' type='password' size='8'/> 
		<input id='submit' type='submit' value='Log In'/></form>
		<a class='panelRegister' href='signup.html'><button name='register'>Register</button></a>";
	} 
	else //else it is set, so include username and logout button
	{ 
		echo "<a href='logout.php'><button type='button'>Log out</button></a>&nbsp;&nbsp;
		Logged on as:&nbsp;".$_COOKIE['email']."&nbsp;&nbsp";
	}
}

?>

