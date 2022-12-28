<?php
include 'connection.php';

$postId= $_POST['post'];
$user = $_POST['userID'];

$sql = "DELETE FROM fav WHERE User= '$user' AND postID='$postId'";
  if ($connection->query($sql) === TRUE){
	  //do nothing
} else {
    echo "Error: " . $sql . "<br>" . $connection->error;
}
?>