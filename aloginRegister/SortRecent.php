<?php

include 'connection.php';


$page= $_GET['page']; //Get the page number from url to show the page

if ($page=="" || $page =="1"){ //If the user first come to page or the page is page 1
	$page1=0; //$page1 will be used as index. Sql search statement we will limit the number of result ($page1, 8) $page1 is starting index, 8 number of result
}
else{
	$page1=($page*8)-8; //Algorithm. If the page is 2 then the starting index will be 2*8 - 8 = 8, 3*8 - 8 =16 .........
}

$id= $_POST["itemID"];
		$sql1 = "SELECT * from post WHERE(ItemCategory = '$id' AND ItemStatus = 'Available') OR (MeetingPoint = '$id' AND ItemStatus='Available') ORDER BY Time DESC LIMIT $page1,8 ";
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
					
					echo "<div class='col-sm-3 col-xs-6'>";
						echo "<a href='../fitemDetail/ItemDetail.php?productid=".$id."'>"; 
						echo "<div class='panel panel-default'>";
							echo "<div class='panel-body'>";
								echo "<img class='related-image' alt='Not found' src=".$picture.">";
								
								echo "<h5 style='font-size:1.2em;'>".$itemName."<br>";
						
							echo "<div id='left'>";
								echo "<br><img id='condition' alt='Not found' src='tick.png' title='Condition'>  " .$condition ;
								echo "<br><img id='condition' alt='Not found' src='location.png' title='Location'>  " .$meetingPoint."</p>" ;
							echo "</div>";
							echo "<div id='right'>";
								if (($row['ExchangeItemCategory'] != "N/A") AND ($row['SellingPrice'] != "N/A")){
									echo "<img id='exchange' alt='Not found' src='exchange2.png' title='Exchangable'> ";
									echo "<img id='sale' alt='Not found' src='sale3.jpg' title='Sell'>";
								}
								else if (($row['ExchangeItemCategory'] != "N/A") AND ($row['SellingPrice'] = "N/A")){
									echo "<img id='exchange' alt='Not found' src='white.png' title='Exchangable'> ";
									echo "<img id='exchange' alt='Not found' src='exchange2.png' title='Exchangable'> ";
								}
								else if((($row['ExchangeItemCategory'] = "N/A") AND ($row['SellingPrice'] != "N/A"))){
									echo "<img id='exchange' alt='Not found' src='white.png' title='Exchangable'> ";
									echo "<img id='sale' alt='Not found' src='sale3.jpg' title='Sell'>";
								}
								
					echo "</div>";
						echo "</div>";
							echo "</div>";
						
					echo "</div>";
echo "</a>";
				}
			}
			else{
				echo "<p id='center' >Sorry, No Result Found</p>";
			}
		?>
