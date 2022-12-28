<?php
include 'connection.php';

$postId= $_POST['post'];

$sql = "SELECT * FROM favorite WHERE postID ='$postId'";
			$fav = $connection->query($sql);
			$count = $fav->num_rows;
			echo $count;
?>