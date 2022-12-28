<?php
include 'connection.php';
//include_once 'function.php';
include '../bmainpage/mainpageBlank.php';

if ($connection->connect_error){
	die ("Connection failed : ".$connection->connect_error);
	}
else {
	
	$sql = "SELECT * FROM testing WHERE ID = ".$_GET['productid'];// Uncomment when link
    //$sql = "SELECT * FROM testing WHERE ID = '1'"; // Delete this link when link
	$request = $connection->query($sql);
			if ($request -> num_rows > 0){
				while ($row=$request->fetch_assoc()){
            $id= $_GET['productid'];
            // $Pic2 = $row['Picture2'];
            // $Pic3 = $row['Picture3'];
            $ItemName = $row['ItemName'];
			$ItemDescription = $row['ItemDescription'];
            $ItemCategory = $row['ItemCategory'];
            $MeetingPoint = $row['MeetingPoint'];
            $ItemStatus = $row['ItemStatus'];
            $SellingPrice = $row['SellingPrice'];
            $ExchangeItem = $row['WantItemName'];
			$Seller = $row['Seller'];
            $ExchangeItemCategory = $row['ExchangeItemCategory'];
            $ExchangeDetail = $row['ExchangeDetail']; 

$sqlSelect= "SELECT * FROM itempicture WHERE PostID='$id'";			
$result = $connection->query($sqlSelect);
if ($result -> num_rows > 0){
				while ($row=$result->fetch_assoc()){
$Pic[] = $row['Picture1'];
				}
}
				}
			}
			else{
				echo "0 result";
			}
	
	require_once 'function.php';
	//session_start();
	$user = getValue('UserName');
	
	$checkFavourite = "SELECT * FROM fav WHERE User='$user' AND postID='$id'";		
	$result2= $connection->query($checkFavourite);
	if ($result2->num_rows > 0) {
    // output data of each row
    while($row = $result2->fetch_assoc()) {
		echo "<input type='hidden' id='checkFav' value='Yes'>";
	}
	}

	
			
}
?>
<script>
window.onload = function(){
	var check = document.getElementById("checkFav").value;
	if (check == "Yes"){
		document.getElementById("image").src="choose.png";
		document.getElementById("count").style.color="red";
	}
	else{
		document.getElementById("image").src="border.png";
		document.getElementById("count").style.color="black";
	}
}
</script>
<html lang="en">
<head>
	<title>Second Chance Resale & Exchange</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="ItemDetailsss.css">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/portfolio-item.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="../dist/js/swiper.min.js"></script>
	

</head>
	
<body>
<input type="hidden" id="postId" value=<?php echo $_GET['productid'];?>>
<?php echo $user;?>
<div class="container">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> <?php echo $ItemName?>
                    <small><?php echo $ItemCategory?></small>
                </h1>
            </div>
        </div>

        <div class="row">

			<div class="col-md-2">
                <br>          
				<?php if (isset($Pic[0])){?>
				<img id="sidePic" data-target="#myCarousel" data-slide-to="0" class="active" src="http://localhost/finalFYP/images/<?php echo $Pic[0]?>"><br><br>
				<?php }
				 if (isset($Pic[1])){
				?>
				<img id="sidePic" data-target="#myCarousel" data-slide-to="1"src="http://localhost/finalFYP/images/<?php echo $Pic[1]?>"><br><br>
								 <?php
				 }
				 
				 if (isset($Pic[2])){?>
				<img id="sidePic" data-target="#myCarousel" data-slide-to="2"src="http://localhost/finalFYP/images/<?php echo $Pic[2]?>">
				<?php }
				?>
			</div>

            <div class="col-md-6">
                 <div id="myCarousel" class="carousel slide" data-ride="carousel">
    
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>


            <div class="carousel-inner">
                <div class="item active">
                    <img src="http://localhost/finalFYP/images/<?php echo $Pic[0]?>" alt="Picture1" style="width:auto; max-width:100% height:100%; max-height:100%; min-height:400px;">
                </div>
				<?php 
				 if (isset($Pic[1])){
				?>
                <div class="item">
                    <img src="http://localhost/finalFYP/images/<?php echo $Pic[1]?>" alt="Picture2" style="width:75%; margin-left:60px;">
                </div>
				  <?php
				 }
				
				 if (isset($Pic[2])){?>
                <div class="item">
                    <img src="http://localhost/finalFYP/images/<?php echo $Pic[2]?>" alt="Picture3" style="width:75%; margin-left:60px;">
                </div>
				<?php 
				} 
				?>
            </div>

    
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>

            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
            </a>
            </div>		
		</div>

            <div class="col-md-4">
                <ul class="nav nav-tabs">
                     <?php if($SellingPrice !=="N/A"){?><li class="active"><a data-toggle="tab" href="#home">Buy</a></li><?php } ?>
                    <?php if($ExchangeItemCategory !=="N/A"){?><li><a data-toggle="tab" href="#menu1">Exchange</a></li> <?php }else if($ExchangeItemCategory !=="N/A" and $SellingPrice=="N/A") {?> <li class="active"><a data-toggle="tab" href="#menu1">Exchange</a></li> <?php }?>
                </ul>       
  <?php if($SellingPrice !=="N/A"){?>
                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        <h3>
					        <img id="priceTag" src="images/price tag.jpg" >&emsp;Rm <?php echo $SellingPrice?> <br><br>
					        <img id="location" src="images/location.png" >&emsp;<?php echo $MeetingPoint?><br><br>
					        <img id="user" src="images/user.png">&emsp;<?php echo $Seller?><br><br>
				        </h3>

                        <h3>Description</h3>
                        <p><?php echo nl2br($ItemDescription)?></p>
                       
						<?php 
						require_once 'function.php';
						$loginUser = getValue("UserName");
						if (loggedIn()){
						
						if ($loginUser == $Seller){
						?>
						<button type="button" id="editpage" onclick= "window.location.href='http://localhost/finalFYP/deditItem/editItemPage.php?item=<?php echo $id;?>';" class="btn btn-info btn-block">Edit</button>
						<?php
						}
						else{?>
						 <button type="button" class="btn btn-info btn-block">Buy</button>
						<?php
						}
						}
						?>
					</div>
					<?php } ?>
<?php if($ExchangeItemCategory !=="N/A" and $SellingPrice!=="N/A"){?>
                <div id="menu1" class="tab-pane fade">
                    <h3>
                        <img src="images/exchange.png">&emsp;<?php echo $ExchangeItem?><br><br> 
                        <img src="images/category.png">&emsp;<?php echo $ExchangeItemCategory?><br><br>
						<?php if($SellingPrice == "N/A"){?>
					  <img id="location" src="images/location.png" >&emsp;<?php echo $MeetingPoint?><br><br>
					        <img id="user" src="images/user.png">&emsp;<?php echo $Seller?><br><br>
					<?php }?>
                        Exchange Detail<br>
                    </h3>
					
                    <p><?php echo $ExchangeDetail?></p>
				
                    <button type="button" class="btn btn-info btn-block">Exchange</button>
					
                </div> 
<?php } 
else if($ExchangeItemCategory !=="N/A" and $SellingPrice=="N/A") {?>
 <div id="menu1" class="tab-pane fade in active">
                    <h3>
                        <img src="images/exchange.png">&emsp;<?php echo $ExchangeItem?><br><br> 
                        <img src="images/category.png">&emsp;<?php echo $ExchangeItemCategory?><br><br>
						<?php if($SellingPrice == "N/A"){?>
					  <img id="location" src="images/location.png" >&emsp;<?php echo $MeetingPoint?><br><br>
					        <img id="user" src="images/user.png">&emsp;<?php echo $Seller?><br><br>
					<?php }?>
                        Exchange Detail<br>
                    </h3>
					
                    <p><?php echo $ExchangeDetail?></p>
				
                    <button type="button" class="btn btn-info btn-block">Exchange</button>
					
                </div> 
<?php }?>


			<br>
			<?php 
			$sql = "SELECT * FROM fav WHERE postID =".$_GET['productid'];
			$fav = $connection->query($sql);
			$count = $fav->num_rows;
			?>
				  <button id="btna" class="btn btn-info btn-block" type="button" onclick="change(<?php echo $_GET['productid'];?>, '<?php echo $user;?>')"><img id="image" onchange="changeimg(<?php echo $_GET['productid'];?>)" src="border.png" ><?php echo "<div id='count'>".$count."</div>";?></button> 
					<style>
					#image{
					float:left;
					width:30px;
					height:30px;
					}
					
					#btna{
						background-color:white;
						width:150px;
						margin-left:100px;
					}

					#count{
						color:black;
						font-size:15px;
						margin-top:3px;
						font-weight:bold;
						
					}
					</style>
<script>
function change(postNo,user){
	
	var logo = document.getElementById("image").src;

		if( logo.indexOf('border.png') >= 0){
			document.getElementById("image").src="choose.png";
			document.getElementById("count").style.color="red";
			$.ajax({
            url: "update.php",
            type: "POST",
            data: { 'post': postNo,'userID':user},                   
            success: function()
                        {
                             //                            
                        }
        });
		}
		else{
			document.getElementById("image").src="border.png";
			document.getElementById("count").style.color="black";
			$.ajax({
            url: "delete.php",
            type: "POST",
            data: { 'post': postNo,'userID':user},                   
            success: function()
                        {
                            // alert(data);                                
                        }
        });
		}
		
		$.ajax({
            url: "changeCount.php",
            type: "POST",
            data: { 'post': postNo,'userID':user},                   
            success: function(data)
                        {
                              $("#count").html(data);                               
                        }
        });
		
		
}

</script>
				
            </div>            
        </div>
        
        <div class = "row">
        <div class = "col-lg-8">
            <div class="well"> 
                <h4>Leave a comment</h4> 
                    <form role="form" class="clearfix"> 
                <div class="col-md-12 form-group">
                    <label class="sr-only" for="email">Comment</label>
                    <textarea class="form-control" id="comment" placeholder="Comment"></textarea>
                </div>
 
                <div class="col-md-12 form-group text-right">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                    </form>
            </div>
        </div>
        </div>
        
        

        <div class="row">
            <div class="col-lg-12">
                <h2><span>You may also interested</span></h2>
            </div>
        <?php 

            $sqlSelectImage= "SELECT * from testing WHERE ItemCategory = '$ItemCategory' ";
			$result1  = $connection-> query($sqlSelectImage);
				if ($result1 -> num_rows>0 ){
				while ($row= $result1->fetch_assoc()){
					$id = $row['ID'];
					$name=$row['ItemName'];
					$price=$row['SellingPrice'];
					$sqlSelect= "SELECT * FROM itempicture WHERE PostID='$id' LIMIT 1";			
					$result = $connection->query($sqlSelect);
					if ($result -> num_rows > 0){
						while ($row=$result->fetch_assoc()){
							$otherPic = $row['Picture1'];
						}
					}
                    echo "<div class='col-sm-3 col-xs-6'>";
                        echo "<a href='http://localhost/finalFYP/fitemDetail/temDetail.php?productid=".$id."'>";
                            echo "<div class='panel panel-default'>";
                                echo "<div class='panel-body'>";
                                echo "<img class='related-image' src='".$otherPic."'>";
                                echo "<h5>".$name."</h5>";
                                if ($price == "N/A"){
                                echo "<h5>EXCHANGEBLE</h5>";
								}
								else{
									echo "<h5>Rm ".$price."</h5>";
								}
                                
                        echo "</div>";
                    echo "</div>";
                        echo "</a>";
            echo "</div>";
            }
            }
?>
            
        </div>

        <hr>
	
	<script>
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        spaceBetween: 30
    });
    </script>

    <footer>
         <div class="row">
            <div class="col-lg-12">
                <p>Copyright &copy; Maroon Tech 2017</p>
            </div>
        </div>

    </footer>

</div>

    <script src="js/jquery.js"></script>

    <script src="js/bootstrap.min.js"></script>
    

</body>
</html>