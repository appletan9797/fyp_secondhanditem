<?php

include 'Connection.php';
?>
<?php
include '../bmainpage/mainpageBlank.php';
?>


<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<link rel="stylesheet" text="text/css" href="style.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"> </script> 
<script src="sortSearchedData.js"> </script>


<?php
$id=mysqli_real_escape_string($connection , $_GET['id']); //Get the id that passed from main page to be used as criteria to search data
$page= $_GET['page']; //Get the page number from url to show the page


if ($page=="" || $page =="1"){ //If the user first come to page or the page is page 1
	$page1=0; //$page1 will be used as index. Sql search statement we will limit the number of result ($page1, 8) $page1 is starting index, 8 number of result
}
else{
	$page1=($page*8)-8; //Algorithm. If the page is 2 then the starting index will be 2*8 - 8 = 8, 3*8 - 8 =16 .........
}
?>

<!-- Everything store in this container -->
<div class="container"> 
	<!-- This row will be used to show user what they have searched -->
	<div class="row">
	<div class='col-sm-2' >
	<?php 
	echo file_get_contents("http://localhost/finalFYP/bmainpage/sidebar.php");
	?>
	</div>
	<div class='col-sm-1'>
	</div>
<div class='col-sm-9' >
	<div class="row">
		<div class='col-sm-8' >
		<?php
		$sqlSearchName = "SELECT * FROM categoryoptions WHERE Options ='$id'";
		$requestSearchData = $connection-> query($sqlSearchName);
			if ($requestSearchData-> num_rows > 0 ){
				while ($row=$requestSearchData->fetch_assoc()){
					$SearchResult = $row['OptionsDisplay'];
				}
			}
		?>
		<h2>Search Result for: <?php echo $SearchResult;?></h2>
		</div>
		<div class='col-sm-2' >
		</div>
	</div>

	<!-- This row used to show the sorting criteria -->
	<div class="row">
		<div class='col-sm-8' >
		</div>
		<div class='col-sm-4' > 
			<p>Sort By 
			<button id="btnRecent" value="<?php echo $id;?>" onclick="SortData(this.value);"><img id='recent' alt='Not found' src='recent.png' title='Latest Post'></button>
			<input type="hidden" id="PageNo" value="<?php echo $page; ?>">
			<button id="btnCondition" value="<?php echo $id;?>" onclick="SortByConditionUsed(this.value)"><img id='condition2' alt='Not found' src='used.jpg' title='Condition'></button>
			<button id="btnCondition2" value="<?php echo $id;?>" onclick="SortByConditionNew(this.value)"><img id='condition2' alt='Not found' src='New.jpg' title='Condition'></button>
			</p><!-- <br id="break"> -->
		</div>
	</div>
	
	<div id='outside'> <!-- Div for the border of searched result -->
	<div class="row" id="SearchedDataAppear"> <!-- This row is for displaying search result -->
		<?php 
		$sql1 = "SELECT * from testing WHERE MeetingPoint ='$id' AND ItemStatus = 'Available' LIMIT $page1,8";
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
				echo "<p id='center' >Sorry, No Result Found </p>";
			}
		?>
	</div><!-- End div for search result row -->
	</div><!-- End div for outside -->
</div>
</div>
<br><br><br><br><br>

<!-- Counting number of result and set the page at here -->
<?php
$id=mysqli_real_escape_string($connection , $_GET['id']);
$sqlCheckNumRow = "SELECT * from testing WHERE MeetingPoint ='$id' AND ItemStatus = 'Available'";
$resultNumRow = $connection-> query($sqlCheckNumRow);
$count= $resultNumRow->num_rows;

$a=$count/8;
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
		<a href="place.php?id=<?php echo $id;?>&page=<?php echo $c;?>"> < </a>
	<?php 
		}
	?>
	<?php
		for ($b=1; $b<=$a; $b++){
	?> 
	<a href="place.php?id=<?php echo $id;?>&page=<?php echo $b;?>" style="text-decoration:none"><?php echo $b."";?></a><?php }?>

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
	<a href="place.php?id=<?php echo $id;?>&page=<?php echo $c;?>"> > </a>
	<?php 
	}
	?>

	</div>
	</div>
	</div> <!-- End div for pagination row-->
	<div class="row">
	<div class='col-sm-12' >
	<?php include '../bmainpage/footer.php';?>
	</div>
	</div>
	
</div> <!-- End div for container -->
</body>
</html>