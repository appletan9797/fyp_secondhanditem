<?php 
include 'connection.php';
$userID = $_POST["user"];

$sqlSelect = "SELECT * FROM testing WHERE Seller = '$userID'";
$result = $connection->query($sqlSelect);
if ($result->num_rows > 0) {
	 while($row = $result->fetch_assoc()) {
		$itemName = $row['ItemName'];
		$description = $row['ItemDescription'];
		
		echo $itemName;
		echo $description;
	 }
}
else{
	echo "NO result found";
}

?>
