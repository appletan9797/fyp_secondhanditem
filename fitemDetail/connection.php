<?php
$servername = "localhost";
$username = "root";
$password = "root";
$db = "secondchance_maroontech";

$connection = new mysqli ($servername, $username, $password, $db);

if ($connection->connect_error){
	die ("Connection failed : ".$connection->connect_error);
   }

?>