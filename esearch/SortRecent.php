<?php

include 'Connection.php';


$page= $_GET['page']; //Get the page number from url to show the page

if ($page=="" || $page =="1"){ //If the user first come to page or the page is page 1
	$page1=0; //$page1 will be used as index. Sql search statement we will limit the number of result ($page1, 8) $page1 is starting index, 8 number of result
}
else{
	$page1=($page*5)-5; //Algorithm. If the page is 2 then the starting index will be 2*8 - 8 = 8, 3*8 - 8 =16 .........
}

$id= $_POST["itemID"];
		$sql1 = "SELECT * from testing WHERE ItemCategory ='$id' AND ItemStatus = 'Available' LIMIT $page1,8";
		$request = $connection-> query($sql1);
			if ($request-> num_rows > 0 ){
				while ($row=$request->fetch_assoc()){
					$id = $row['ID'];
					$itemName = $row['ItemName'];
					$condition = $row['Conditions'];
					$meetingPoint = $row['MeetingPoint'];
					$exchange = $row['ExchangeItemCategory'];
					$sell = $row['SellingPrice'];
					
					$sqlSelectImage= "SELECT * from itempicture WHERE PostID = '$id' LIMIT 1";
					$result = $connection-> query($sqlSelectImage);
					if ($result -> num_rows>0){
						while ($row= $result->fetch_assoc()){
							$picture = $row['Picture1'];
						}
					}
					
					echo "<div class='col-sm-4 col-xs-6'>";
						echo "<a href='http://localhost/finalFYP/fitemDetail/itemDetail.php?productid=".$id."'>"; 
						echo "<div class='panel panel-default'>";
							echo "<div class='panel-body'>";
								echo "<img class='related-image' alt='Not found' src=".$picture.">";
								
								echo "<h5 style='font-size:1.2em;'>".$itemName."<br>";
						echo "</a>";
							echo "<div id='left'>";
								echo "<br><img id='condition' alt='Not found' src='tick.png' title='Condition'>  " .$condition ;
								echo "<br><img id='condition' alt='Not found' src='location.png' title='Location'>  " .$meetingPoint."</p>" ;
							echo "</div>";
							echo "<div id='right'>";
								if (($row['ExchangeItemCategory'] != "N/A") AND ($row['SellingPrice'] != "N/A")){
									echo "<img id='exchange' alt='Not found' src='exchange2.jpg' title='Exchangable'> ";
									echo "<img id='sale' alt='Not found' src='sale3.jpg' title='Sell'>";
								}
								else if (($row['ExchangeItemCategory'] != "N/A") AND ($row['SellingPrice'] = "N/A")){
									echo "<img id='exchange' alt='Not found' src='white.png' title='Exchangable'> ";
									echo "<img id='exchange' alt='Not found' src='exchange2.jpg' title='Exchangable'> ";
								}
								else if((($row['ExchangeItemCategory'] = "N/A") AND ($row['SellingPrice'] != "N/A"))){
									echo "<img id='exchange' alt='Not found' src='white.png' title='Exchangable'> ";
									echo "<img id='sale' alt='Not found' src='sale3.jpg' title='Sell'>";
								}
					echo "</div>";
						echo "</div>";
							echo "</div>";
						
					echo "</div>";
				}
			}
			else{
				echo "Sorry, No Result Found";
			}

$id=mysqli_real_escape_string($connection , $_GET['id']);
$sqlCheckNumRow = $sql1 = "SELECT * from testing WHERE ItemCategory ='$id' AND ItemStatus = 'Available'";
$resultNumRow = $connection-> query($sqlCheckNumRow);
$count= $resultNumRow->num_rows;

$a=$count/5;
$a= ceil($a);
echo "<br>";
?>

<!-- This row is for pagination -->
<div class="row">
	<div class='col-sm-5' >
	</div>
	<div class='col-sm-7' >
	
	<!-- This class to design the pagination bar, if result searched, show < and > at the begining and end of page number -->
	<div class="pagination">
	<?php
		if ($resultNumRow-> num_rows > 0 ){
			$page= $_GET['page']; 
			if ($page == 1){
				$c =$page;
			}
			else{
			$c = $page -1 ;
			}
	?>
		<a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?id=<?php echo $id;?>&page=<?php echo $c;?>"> < </a>
	<?php 
		}
	?>
	<?php
		for ($b=1; $b<=$a; $b++){
	?> 
	<a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?id=<?php echo $id;?>&page=<?php echo $b;?>" style="text-decoration:none"><?php echo $b."";?></a><?php }?>

	<?php
		if ($resultNumRow-> num_rows > 0 ){
			$page= $_GET['page']; 
			if ($page == $a){
				$c = $page;
			}
			else{
			$c = $page +1 ;
			}
	?>
<a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?id=<?php echo $id;?>&page=<?php echo $c;?>"> > </a>
	<?php 
	}
	?>

	</div>
	</div>
	</div> <!-- End div for pagination row-->	
