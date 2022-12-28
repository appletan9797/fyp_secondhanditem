<?php
include 'connection.php';

$postId= $_POST['post'];
$user = $_POST['userID'];

$sql = "INSERT INTO fav (postID, User) VALUES ('$postId', '$user')";
  if ($connection->query($sql) === TRUE){
	  //do nothing
} else {
    echo "Error: " . $sql . "<br>" . $connection->error;
}
?>