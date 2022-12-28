<?php
$servername = "localhost";
$username= "root";
$password="root";
$db="fav";

$connection= new mysqli ($servername,$username,$password, $db);

if ($connection->connect_error){
	die ("Connection failed : ".$connection->connect_error);
}
?>