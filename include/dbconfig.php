<?php  
$username='root'; /*Add your Username here*/
$password='root'; /* Add your Password here*/
$database='test'; /*Database name*/
$connection=mysql_connect ('localhost:8888', $username, $password); 
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

// Set the active MySQL database
$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}
?>