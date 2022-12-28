<?php
include 'connection.php';

$user = $_POST['userID'];

$sql = "UPDATE register SET Picture='picture.png' WHERE ID= '$user'";
  if ($connection->query($sql) === TRUE){
	  //do nothing
} else {
    echo "Error: " . $sql . "<br>" . $connection->error;
}
?>