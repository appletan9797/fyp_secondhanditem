<?php
session_start();
require_once ('connection.php');

function loggedIn(){
	if (isset($_SESSION['User_ID'])){
	return true;
	}
	else{
	return false;
	}
}

function getValue($data){
	require ('connection.php');

	$id = $_SESSION['User_ID'];

	$sql = "SELECT $data FROM register WHERE ID= '$id'";
	$result = $connection -> query($sql);
	$row = $result -> fetch_assoc();

	return $row[$data];
}

?>