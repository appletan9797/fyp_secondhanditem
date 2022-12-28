<?php

include 'connection.php';
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
<link rel="stylesheet" text="text/css" href="http://chopper.twopiz.com/~wilsandb/SecondChance_MaroonTech/esearch/css/esearchstylenew.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"> </script> 
<script src="sortSearchedData.js"> </script>


<?php
$id=mysqli_real_escape_string($connection , $_GET['id']); //Get the id that passed from main page to be used as criteria to search data
$method = mysqli_real_escape_string($connection , $_GET['method']);
if (strpos($method, 'Sell') !== false) {
    $criteria= "SellingPrice";
}
else{
    $criteria = "ExchangeItemCategory";
}
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
	//echo file_get_contents("http://localhost/finalFYP/bmainpage/sidebar.php");
	include '../bmainpage/sidebar.php';
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
		<h2>Search Result for: <?php echo $id;?></h2>
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
					<button id="btnRecent" value="<?php echo $id;?>" onclick="window.location.href='navBarRecent.php?itemID=<?php echo $id;?>&page=1';"><img id='recent' alt='Not found' src='recent.png' title='Latest Post'></button>
			<input type="hidden" id="PageNo" value="<?php echo $page; ?>">
		<!--	<button id="btnCondition" value="<?php echo $id;?>" onclick="SortByConditionUsed(this.value)"><img id='condition2' alt='Not found' src='used.jpg' title='Condition'></button>
			<button id="btnCondition2" value="<?php echo $id;?>" onclick="SortByConditionNew(this.value)"><img id='condition2' alt='Not found' src='new.jpg' title='Condition'></button>-->
			</p><!-- <br id="break"> -->
		</div>
	</div>
	
	<!--<div id='outside'>  Div for the border of searched result -->
	<div class="row" id="SearchedDataAppear"> <!-- This row is for displaying search result -->
		<?php 
			$sql1 = "SELECT * from post WHERE ItemName LIKE '%$id%' AND ".$criteria." != 'N/A' AND ItemStatus='Available' ORDER BY Time DESC LIMIT $page1,8";
		$request = $connection-> query($sql1);
			if ($request-> num_rows > 0 ){
				while ($row=$request->fetch_assoc()){
					$id = $row['ID'];
					$itemName = $row['ItemName'];
					$condition = $row['Conditions'];
					$meeting = $row['MeetingPoint'];
					$exchange = $row['ExchangeItemCategory'];
					$sell = $row['SellingPrice'];
					if ($sell !== "N/A"){
					    $condition = "RM".$sell;
					}
					else{
					    $condition="For Exchange";
					}
					$sqlSelectImage= "SELECT * from itempicture WHERE PostID = '$id' LIMIT 1";
					$result = $connection-> query($sqlSelectImage);
					if ($result -> num_rows>0){
						while ($row= $result->fetch_assoc()){
							$picture = $row['Picture1'];
						}
					}
					
					$sql5 = "SELECT * FROM categoryoptions WHERE Options = '$meeting'";
                                    $request5 = $connection->query($sql5);
                                    if ($request5 -> num_rows > 0){
                                         while($row=$request5->fetch_assoc()){
                                            $meetingPoint = $row['OptionsDisplay'];
                                        }
                                    }
					echo "<div class='col-sm-3 col-xs-6'>";
						echo "<a href='../fitemDetail/ItemDetail.php?productid=".$id."'>"; 
						echo "<div class='panel panel-default'>";
							echo "<div class='panel-body'>";
								echo "<img class='related-image' alt='Not found' src=".$picture.">";
								
								echo "<h5 style='font-size:1.2em;'>".$itemName."<br>";
						
						echo "<div id='left'>";
							if ((isset($condition)) and ($condition == "For Exchange")){
								echo "<h6><img id='condition' alt='Not found' src='price tag.jpg' title='For exchange only' style='width:15px; height:15px;'>  " .$condition."</h6>" ;
							}
							else if (((isset($exchange)) and ($exchange !== "N/A")) and ((isset($sell)) and ($sell !== "N/A"))){
							    echo "<h6><img id='condition' alt='Not found' src='price tag.jpg' title='Sell and Exchangeable' style='width:15px; height:15px;'>  " .$condition."</h6>" ;
							}
							else{
							    echo "<h6><img id='condition' alt='Not found' src='price tag.jpg' title='Selling Price' style='width:15px; height:15px;'>  " .$condition."</h6>" ;
							}
						/*	if (isset($condition2)){
								echo "<h6><img id='condition' alt='Not found' src='tick.png' title='Exchangeable'>  " .$condition2."</h6>" ;
							}*/
								echo "<h6><img id='condition' alt='Not found' src='location.png' title='Location'>  " .$meetingPoint."</h6></p>" ;
							echo "</div>";
						/*	echo "<div id='right'>";
							if (($exchange !== "N/A") AND ($sell !== "N/A")){
									echo "<img id='exchange' alt='Not found' src='exchange2.png' title='Exchangable'> ";
									echo "<img id='sale' alt='Not found' src='sale3.jpg' title='Sell'>";
								}
								else if (($exchange !== "N/A") AND ($sell == "N/A")){
									echo "<img id='exchange' alt='Not found' src='white.png' title='Exchangable'> ";
									echo "<img id='exchange' alt='Not found' src='exchange2.png' title='Exchangable'> ";
								}
								else if((($exchange == "N/A") AND ($sell !== "N/A"))){
									echo "<img id='exchange' alt='Not found' src='white.png' title='Exchangable'> ";
									echo "<img id='sale' alt='Not found' src='sale3.jpg' title='Sell'>";
								}
								
					echo "</div>";*/
						echo "</div>";
							echo "</div>";
						
					echo "</div>";
echo "</a>";
				}
			}
			else{
				echo "<p id='center' >Sorry, No Result Found </p>";
			}
		?>
	</div><!-- End div for search result row -->
	<!-- </div>End div for outside -->
</div>
</div>
<style>
a 
{ 
color: inherit;
 } 
</style>

<!-- Counting number of result and set the page at here -->
<?php
$id=mysqli_real_escape_string($connection , $_GET['id']);
$sqlCheckNumRow = "SELECT * from post WHERE (".$criteria." != 'N/A' AND ItemName LIKE '%$id%' AND ItemStatus='Available')";
$resultNumRow = $connection-> query($sqlCheckNumRow);
$count= $resultNumRow->num_rows;

$a=$count/8;
$a= ceil($a);
echo "<br>";
?>

<!-- This row is for pagination -->
<div class="row">
	<div class= "col-md-6 col-xs-4"></div> 

	
	<!-- This class to design the pagination bar, if result searched, show < and > at the begining and end of page number -->
	<div class="pagination" class="col-md-4 col-xs-4">
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
		<a href="navBarSearch.php?id=<?php echo $id;?>&page=<?php echo $c;?>"> < </a>
	<?php 
		}
	?>
	<?php
		for ($b=1; $b<=$a; $b++){
	?> 
	<a href="navBarSearch.php?id=<?php echo $id;?>&page=<?php echo $b;?>" style="text-decoration:none"><?php echo $b."";?></a><?php }?>

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
	<a href="navBarSearch.php?id=<?php echo $id;?>&page=<?php echo $c;?>"> > </a>
	<?php 
	}
	?>

	</div>
</div> <!-- End div for pagination row-->

<?php include '../bmainpage/footer.php';?>
	</div><!-- End div for container -->

</body>
</html>