<html>
<head>
<link rel="stylesheet" text="text/css" href="UPcss.css">

</head>
<body>
<?php
ob_start();
include 'connection.php';
include '../bmainpage/mainpageBlank.php';

include_once 'function.php';
$changeID = getValue("UserName") ;
$image = getValue("Picture");
$sql = "SELECT * FROM register WHERE UserName = '$changeID' ";
$result = $connection->query($sql);
if ($result->num_rows > 0) {
	 while($row = $result->fetch_assoc()) {
	$t=$row['Date'];
	 }
}
?>

<form method="post" enctype="multipart/form-data" action="userprofile.php">
<div id="left">
<div class = "profilepanel">
	<span class = "media">
		<div class = "UserAvatar">
			<label for="picture"> <img id="thumbnil3" alt="Profile Pic" src="<?php echo $image;?>" width="140" height="140" class = "UserAvatar" id="photo-profile">
		</div>
	</span>
	<div class = "userprofile">
	
		<h3 class = "userprofile"> <?php echo $changeID ?> </h3>
	</div>
	
		<div class = "userdate">
		<h6 class = "dateJoined"> <img id="" alt="Profile Pic" src="date.png" width="15" height="15" title="Joined date">
		<?php
			$convertDate = date('j F Y', strtotime($t));
			echo "Joined ".$convertDate;
		?>
		</h6>
		</div> 
	</div>
	</div>
		<br>
</form>
</div>
</div>

<div class="tab">
  <button class="tablinks" onclick="SearchPost(event, 'Mine')" id="defaultOpen">My Posts</button>
  <button class="tablinks" onclick="SearchPost(event, 'Fav')">Favourite Posts</button>
</div>

<div id="Mine" class="tabcontent">
<h3>My Post</h3>
 <?php
	$changeID = getValue("UserName") ;
	$sqlSelect= "SELECT * from testing WHERE Seller ='$changeID'";
	$request = $connection-> query($sqlSelect);
	if ($request-> num_rows > 0 ){
		while ($row=$request->fetch_assoc()){
			$id = $row['ID'];
			$itemName = $row['ItemName'];
			$meetingPoint = $row['MeetingPoint'];
			$sqlSelectImage= "SELECT * from itempicture WHERE PostID = '$id' LIMIT 1";
			$result = $connection-> query($sqlSelectImage);
			if ($result -> num_rows>0){
				while ($row= $result->fetch_assoc()){
					$picture = $row['Picture1'];
				}
			}
?>			
					
<div class="col-md-3 col-xs-6">
	<div class="thumbnail" style="height:auto;">
	<?php echo "<a href='../fitemDetail/ItemDetail.php?productid=".$id."'>";?>
	<img class="postImage" src="<?php echo $picture;?>" alt="images" style="width:100%; max-height:150px; height:150px;">
		<div class="caption">
			<h4><?php echo $itemName;?></h4>
			<h5><img id='condition' alt='Not found' src='location.png' title='Location'> <?php echo $meetingPoint;?></h5>
	</a>
		</div>
	</div>
 </div>
 <?php 
		}
	}		
  else{
	  echo "<p id='center'>You did not create any selling post yet. Create one at <a href='../'>here</a></p>";
  } 
 ?>
</div>	


<div id="Fav" class="tabcontent">
<h3>My Favourite Post</h3>
  <?php
  $changeID = getValue("UserName") ;
  $sqlSelect= "SELECT * from fav WHERE User ='$changeID'";
  $request = $connection-> query($sqlSelect);
  if ($request-> num_rows > 0 ){
				while ($row=$request->fetch_assoc()){
					$postID = $row['postID'];
					$sqlCheck = "SELECT * FROM testing WHERE ID = '$postID'";
					$result = $connection-> query($sqlCheck);
					  if ($result-> num_rows > 0 ){
							while ($row=$result->fetch_assoc()){
								$id = $row['ID'];
								$itemName = $row['ItemName'];
								$meetingPoint = $row['MeetingPoint'];
								$sqlSelectImage= "SELECT * from itempicture WHERE PostID = '$id' LIMIT 1";
								$result = $connection-> query($sqlSelectImage);
								if ($result -> num_rows>0){
									while ($row= $result->fetch_assoc()){
										$picture = $row['Picture1'];
									}
								}
							?>
<div class="col-md-3 col-xs-6">
     <div class="thumbnail" style="height:auto;">
		 <?php echo "<a href='../fitemDetail/ItemDetail.php?productid=".$id."'>";?>
		<img class="postImage" src="<?php echo $picture;?>" alt="images" style="width:100%; max-height:150px; height:150px;">
              <div class="caption">
                <h4><?php echo $itemName;?></h4>
                <h5><img id='condition' alt='Not found' src='location.png' title='Location'> <?php echo $meetingPoint;?></h5>
          </a>
                </div>
       </div>
</div> 
<?php
				}
					  }
				}
  }
  else{
	  echo "<p id='center'>You did not follow any post yet, favourite some post that you are interested with.</p>";
  }
  ?>
</div>


<script>
function SearchPost(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>
     
</body>
</html> 