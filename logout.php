<?php
//invalidate cookies by setting them an hour in the past
setcookie("email", "", time()-3600);
setcookie("id", "", time()-3600);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Log Out</title>
	<link rel="stylesheet" type="text/css" href="main.css" />
	<link rel="stylesheet" type="text/css" href="jquery-ui-css.css" />
	<script type='text/javascript' src='jquery.js'></script>
	<script type='text/javascript' src='jquery-ui.js'></script>
	
	<script type='text/javascript'>	
	</script>
</head>

<body>
	<a href="index.php"><button name="home" type="button"/>Home</button></a><br /><br />

	Logged out.
</body>
</html>