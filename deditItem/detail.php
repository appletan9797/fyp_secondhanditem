<?php session_start();?>
<html>
<head> 
<title> DETAIL </title>
</head>
<link rel="stylesheet" type="text/css" href="DetailCss.css">
<body>

<div id="head">

<?php
include 'navigation.php';
?>
</div>

<?php

$servername = "localhost";
$username= "root";
$password="root";
$db="testing";

$connection= new mysqli ($servername,$username,$password, $db);


if ($connection->connect_error){
	die ("Connection failed : ".$connection->connect_error);
   }
else{
   $id= $_GET['id'];
   $sql1 = "SELECT * from testing WHERE ID= '$id' ";
			$request = $connection-> query($sql1);
			if ($request-> num_rows > 0 ){
				while ($row=$request->fetch_assoc()){
				echo "<div id= 'UpperPart'>";
					// echo "<div id='MainImage'>";
						// echo "<img id='newimagesize' src= 'images/".$row['Picture']. "' >";
					// echo "</div>";
					
					echo "<div id= 'ItemDetail'>";
						echo "<br> Item Name: " .$row['ItemName'] ;
						echo "<br> Selling Price : RM" .$row['SellingPrice'];
						echo "<br> Exchange with:" .$row['WantedItemDetail'];
						echo "<br> Item Description: &emsp;&emsp; "."<textarea id='ItemDescription' rows=5 cols=30 disabled>" .$row['ItemDescription']. "</textarea>" ;
					echo "</div>";
				echo "</div>";
	$sqlSelectImage= "SELECT * from itempicture WHERE PostID = '$id'";
						$result = $connection-> query($sqlSelectImage);
						if ($result -> num_rows>0){
							while ($row= $result->fetch_assoc()){	
							$array = array();
							$array[] = $row;
							print_r($array);
							
							//echo "<img src= 'images/".$array[0]['Picture1']."'>";
							}
						}							
				// echo "<div id='OtherImages'>";
					// echo "&emsp;<img id='thumbnil2' src= 'images/".$row['Picture2']. "' > &emsp;&emsp;";
					// echo "<img id='thumbnil2' src= 'images/".$row['Picture3']. "' >";
				// echo "</div>";
				}
			}
}  
   ?>
   
<div id="bottom2">
<p align="center" id="Copyright">Copyright &copy; 2017 Maroon Tech </p>
<?php include 'bottomNavigate.php' ?>
</div>

</body>
</html>