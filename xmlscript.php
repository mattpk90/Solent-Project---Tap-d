<?php
$conn=mysql_connect("aquarius.solent.ac.uk/","8kennm51","hiogro");

mysql_select_db("8kennm51");

$a = mysql_query("select * from cards");

while($row = mysql_fetch_array($a))
  {
  echo $row['id'] . " " . $row['name'];
  echo "<br />";
  }

mysql_close($conn);

?>