<html>
<head>
<title> Paging </title>
</head>
<body>
<?php  
$server= "localhost";
$user="root";
$pw="root";
$db="testing";

$connection = new mysqli($server, $user, $pw, $db);
if ($connection ->connect_error){
	die ("Connection failed :" .$connection -> connect_error);
}

$page= $_GET['page'];

if ($page=="" || $page =="1"){
	$page1=0;
}
else{
	$page1=($page*5)-5;
}

$sql = "SELECT * from testing LIMIT $page1,5";
$result = $connection-> query($sql);
if ($result -> num_rows>0){
	while ($row = $result ->fetch_assoc()){
		echo $row['ID']. " ".$row['ItemName'];
		echo "<br>";
	}
}

// Counting number of result and set the page at here
$sql1 = "SELECT * from testing";
$result1 = $connection-> query($sql1);
$count= $result1->num_rows;

$a=$count/5;
$a= ceil($a);
echo "<br>";

for ($b=1; $b<=$a; $b++){
	?> <a href="paging.php?page=<?php echo $b;?>" style="text-decoration:none"><?php echo $b."";?></a><?php
}

?>

</body>
</html>