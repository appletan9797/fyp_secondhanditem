<?php
include 'connection.php';
$postID= $_GET['item'];

//Here is to get data from database to be shown 
$selectRecord= "SELECT * FROM testing WHERE ID= '$postID'";
$storeRecord = $connection -> query ($selectRecord);

if ($storeRecord -> num_rows>0){
	while ($row = $storeRecord->fetch_assoc()){
		$name = $row['ItemName'];
		$description = $row['ItemDescription'];
		$itemCategory= $row['ItemCategory'];
		$meetingPoint = $row['MeetingPoint'];
		$itemCondition = $row['Conditions'];
		
		$Price = $row['SellingPrice'];
		$AdjustPrice = $row['PriceChangeability'];
		$wantItemCategory = $row['ItemWantedCategory'];
		$wantItemDetail = $row['WantedItemDetail'];
		$exchangeReason = $row['Reason'];
		
		$postIDss = $row['ID'];
		
	}
}
else{
	header('Location: http://www.facebook.com/'); die;
}

$selectImage = "SELECT * FROM itempicture WHERE PostID='$postID'";
$storeImage = $connection->query($selectImage);
if ($storeImage -> num_rows>0){
	while ($row = $storeImage->fetch_assoc()){
		$nameofImage[] = $row['Picture1'];
	}
}


if ($_SERVER['REQUEST_METHOD'] == "POST"){
	//Save data to variable
	$ItemName = mysqli_real_escape_string($connection,$_POST['ItemName']);
	$Description = mysqli_real_escape_string($connection,$_POST['ItemDescription']);
	$Category= $_POST['CAtegoryList'];
	$MP = $_POST['MeetingPoint'];
	$Status = $_POST['Status'];
	if (isset($_POST['rdnCondition'])){
		$Condition= $_POST['rdnCondition'];
	}
	$total=0;
	//If sell checkbox checked
	if(isset($_POST['rdnSelling'])){
		$total= $total + 2;
		
		$SellingPrice = mysqli_real_escape_string($connection, $_POST['PriceForSale']);
		$Price= $SellingPrice;
		if (isset($_POST['rdnPriceChange'])){
			$PriceChange = $_POST['rdnPriceChange'];
		}
	}
	else{
		$total= 0;
		$SellingPrice="N/A";
		$Price= $SellingPrice;
		$PriceChange="N/A";
	}
			
	//If exchange checkbox checked
	if (isset($_POST['rdnExchange'])){
		$total=$total + 1;
		if (isset ($_POST['catList'])){
			$ItemWanted = $_POST['catList'];
			$wantItemCategory = $ItemWanted;
		}
		if (isset($_POST ['wanting'])){
			$ItemDetail =mysqli_real_escape_string($connection, $_POST ['wanting']);
			$wantItemDetail = $ItemDetail;
		}
		if (isset($_POST ['why'])){
			$Reason = mysqli_real_escape_string($connection,$_POST['why']);
			$exchangeReason=$Reason;
		}
	}
	else{
		$total= $total -1 ;
		$ItemWanted="N/A";
		$ItemDetail="N/A";
		$Reason="N/A";
		$wantItemCategory = $ItemWanted;
		$wantItemDetail = $ItemDetail;
		$exchangeReason=$Reason;
	}
	$hash =md5 ( rand(0,1000)); 
	
	/* if (isset($_POST['image1'])){
	$image1= $_POST['image1'];
	}
	if (isset($_POST['image1SRC'])){
	$image1src = $_POST['image1SRC'];
	}
	
	if (isset($_POST['image2'])){
	$image2= $_POST['image2'];
	}
	if (isset($_POST['image2SRC'])){
	$image2src = $_POST['image2SRC'];
	}
	
	
	if (isset($_POST['image3'])){
	$image3= $_POST['image3'];
	}
	if (isset($_POST['image3SRC'])){
	$image3src = $_POST['image3SRC'];
	} */
	$errors = array();
	
	//Validation
	/* if (($image1 == "empty")and ($image2 == "empty")) {
		$errors["imageUpload"] = "You should upload one image";
	}
	 */
	if ($total < 1){
		$errors["PickMe"] = "You should at least choose one dealing method. RESELL / BARTER";
	}
	if (empty($ItemName)){
		$errors["ItemName"] = "Please enter item's name";
	}
			
	if (empty ($Description)){
		$errors["ItemDescription"] = "Please enter the description";
	}
			
	if(empty ($Category)){
		$errors["ItemCategory"] = "Please select a category";
	}
	if(empty ($MP)){
		$errors["Location"] = "Please select location ";
	}
	if(empty ($Condition)){
		$errors["ItemCondition"] = "Please select one ";
	}
		
	if(empty($SellingPrice) ){
		$errors["ItemPrice"] = "Please enter the price";
	}
	else {
		if ($SellingPrice != "N/A"){
		if (!is_numeric($SellingPrice)){
			$errors["ItemPrice"] = "Please enter number only";
		}
		else{
			if ($SellingPrice<0){
				$errors["ItemPrice"] = "Please enter positive number";
				}
		}
		}
				
	}
			
	if(empty ($PriceChange)){
		$errors["ChangePrice"] = "Please select one ";
	}
			
	if(empty ($ItemWanted)){
		$errors["WantedItem"] = "Please select one ";
	}
			
	if(empty ($ItemDetail)){
		$errors["ItemDetail"] = "Please enter the wanted item's detail ";
	}
			
	if(empty ($Reason)){
		$errors["Reason"] = "Please enter the reason ";
	}
	
function imageValidation ($pictureName){
	$tmp_name= $_FILES[$pictureName]['tmp_name'];
	$image = pathinfo($_FILES['itemPics']['name']); //Get the info of the image
	$imageName =  $image['filename'].'_'.microtime(true).'.'. $image['extension']; //Set the image name
	$target_path = "../images/".$imageName;
					
	//To check uploaded image filetype 
	$CheckFileType = pathinfo($target_path, PATHINFO_EXTENSION);
	if ($CheckFileType != "jpg" AND $CheckFileType != "jpeg" AND $CheckFileType != "png" AND $CheckFileType != "gif"){
		$errors['fileType'] =  "Only JPG, JPEG, PNG and GIF !";
	}//End if for checking file type 
	else{
	//Check uploaded file size (Not larger than 1000000byte/1MB)
		if($_FILES["itemPics"]["size"][$n] > 1000000){
			$errors['fileSize'] = "*Files size must be less than 1MB";
		} //End if condition of checking file size
	}
}
		//if (!empty($_FILES['itemPics']['tmp_name'][0]) or !empty($_FILES['itemPics']['tmp_name'][1]) or !empty($_FILES['itemPics']['tmp_name'][2]) ){
			//foreach($_FILES['itemPics']['name'] as $n => $name) {
				//if (!empty($_FILES['itemPics']['tmp_name'][$n])){
					/* 
					$tmp_name= $_FILES['itemPics']['tmp_name'][$n];
					$image = pathinfo($_FILES['itemPics']['name'][$n]); //Get the info of the image
					$imageName =  $image['filename'].'_'.microtime(true).'.'. $image['extension']; //Set the image name
					$target_path = "images/" . $imageName;
					
					//To check uploaded image filetype 
					$CheckFileType = pathinfo($target_path, PATHINFO_EXTENSION);
					if ($CheckFileType != "jpg" AND $CheckFileType != "jpeg" AND $CheckFileType != "png" AND $CheckFileType != "gif"){
						$errors['fileType'] =  "Only JPG, JPEG, PNG and GIF !";
					}//End if for checking file type 
					else{
					//Check uploaded file size (Not larger than 1000000byte/1MB)
						if($_FILES["itemPics"]["size"][$n] > 1000000){
							$errors['fileSize'] = "*Files size must be less than 1MB";
						} //End if condition of checking file size
					} */
				//} //End if for checking is user uploaded any picture, if yes, check filetype and size
			//} // End for loop for loop the array
		//} //End if for making sure user at least uploaded one image
		/* else{
			$errors['Atleast1']= "Hmm.. Upload one image maybe?";
		} */
	if (isset($_FILES['itemPics1'])){
		imageValidation('itemPics1');
	}
	if (isset($_FILES['itemPics2'])){
		imageValidation('itemPics2');
	}
	if (isset($_FILES['itemPics3'])){
		imageValidation('itemPics3');
	}
	
//Check is there any errors. If no, update data
	if (count($errors) == 0){
		$updateData= "UPDATE testing SET SellingPrice='$SellingPrice', PriceChangeability='$PriceChange' WHERE ID='$postID'";
					if ($connection->query($updateData) === TRUE){
						echo "SUCCESS";
						
					 	$sqlDelete = "DELETE FROM itempicture WHERE PostID= '$postID'";
						if ($connection->query($sqlDelete) === TRUE){
					foreach($_FILES['itemPics']['name'] as $n => $name) {
						if (!empty($_FILES['itemPics']['tmp_name'][$n])){
						$tmp_name= $_FILES['itemPics']['tmp_name'][$n];
						$image = pathinfo($_FILES['itemPics']['name'][$n]); //Get the info of the image
						$imageName =  $image['filename'].'_'.microtime(true).'.'. $image['extension']; //Set the image name
						$target_path = "../images/" . $imageName;
						
						//Insert data into database if no error found
								
						move_uploaded_file($tmp_name, $target_path);
						$sqlInsertPicture= "INSERT INTO itempicture (Picture1, PostID) VALUES ('$imageName', '$postID')";
						if ($connection->query($sqlInsertPicture) === TRUE){
							//Do nothing if no problem with the query
						}
						else{
							echo "error:".$connection->error;
						}
						} //If got picture uploaded
						}// End for loop for saving picture
					
					} //End If for update query success
					else {
						echo "error update the data:".$connection->error;
					}//End if for the sql query (Insert data to database)
	} //End if for checking is there any error. If no errors found, save data to database.
}//End if for checking request method (if $_POST then do sth
}


?>

<html>
<head>
<title> Edit Post </title>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

</head>
<link rel="stylesheet" type="text/css" href="design.css">
<body>

<script type="text/javascript" src="imagePreview.js"></script>
<script type="text/javascript" src="EnableTextBox.js"></script>
<script type="text/javascript" src="onloadChange.js"></script>
<form action="" method="post" enctype="multipart/form-data">

<div id="Fields">
<div id="Pictures">
<?php if(isset($errors['PickMe'])) echo "<font color='pink'>".$errors['PickMe']. "</font>";?>

<h3 id="uploadImage"> Upload Your Item's Images </h3>
<input id="picture1" method="POST" type="file" name="itemPics1 accept="image/*" onchange="showMyImage(this)">
<label for='picture1'> <img id='thumbnil1'  src="<?php if (isset($errors['Atleast1'])){echo "normal.jpg";} else{if (isset($nameofImage[0])){echo "../images/".$nameofImage[0];} else{echo "normal.jpg";}}?> " alt='image'/> </label>
<input id="picture2" method="POST" type="file" name="itemPics2" accept="image/*" onchange="showImage(this)">
<label for="picture2"> <img  id="thumbnil2" src="<?php if (isset($errors['Atleast1'])){echo "normal.jpg";} else{if (isset($nameofImage[1])){echo "../images/".$nameofImage[1];} else{echo "normal.jpg";}}?>" alt="image"/> </label> 
<input id="picture3" method="POST" type="file" name="itemPics3" accept="image/*" onchange="showImage2(this)">
<label for="picture3"> <img  id="thumbnil3" src="<?php if (isset($errors['Atleast1'])){echo "normal.jpg";} else{if (isset($nameofImage[2])){echo "../images/".$nameofImage[2];} else{echo "normal.jpg";}}?> " alt="image"/> </label> 
<br>
<button id="clear" onclick="removeImg(1)">Clear</button> &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
<button id="clear" onclick="removeImg(2)">Clear</button>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
<button id="clear" onclick="removeImg(3)">Clear</button>

<?php if(isset($errors['fileType'])) echo $errors['fileType'];?> <br>
<?php if(isset($errors['fileSize'])) echo "<font color='red'>".$errors['fileSize']. "</font>";?> <br>
<?php if(isset($errors['Atleast1'])) echo "<font color='red'>".$errors['Atleast1']. "</font>";?>
</div>

<!-- Here will be the div for item's basic info-->
<h2 id="Words"> Item Information </h2>
<h5 id="MustFilled"> <font color="red">* are fields must be filled </font></h5>
<div id="TextBox">

Item Name:&emsp;&emsp;&emsp;<input type= "text" id="itemName" name="ItemName" placeholder="eg:The Conon" value="<?php if(isset($ItemName)) {echo $ItemName;} else{echo $name;}?>"/> <font color="red">*</font> <?php if(isset($errors['ItemName'])) echo "<font id='try1' color='red'>".$errors['ItemName']. "</font>";?><span class="errorColor" id="itemNameError"></span>
<br>
Item Description:&emsp;<textarea id="ItemDescription" name="ItemDescription" rows=5 cols=50 placeholder="eg:This book looks like new one" ><?php if(isset($Description)) {echo $Description; }else{ echo $description;}?></textarea> <font color="red">*</font><?php if(isset($errors['ItemDescription'])) echo"<font id='try2' color='red'>".$errors['ItemDescription']."</font>";?> <span class="errorColor" id="itemDescriptionError"></span>
<br>
Category:&emsp;&emsp;&emsp;&emsp; <?php include 'category.php' ?>  <font color="red">*</font> <?php if(isset($errors['ItemCategory'])) echo "<font id='try3' color='red'>".$errors['ItemCategory']."</font>";?> <span class="errorColor" id="itemCategoryError"></span>

<script type="text/javascript">
  document.getElementById('CAtegoryList').value = "<?php if(isset($Category)){ echo $Category;} else {echo $itemCategory;}?>";
</script>

<br>
Location:&emsp;&emsp;&emsp;&emsp;<?php include 'datalist.php' ?><font color="red">*</font> <?php if(isset($errors['Location'])) echo "<font id='try4' color='red'>".$errors['Location']."</font>";?><span class="errorColor" id="locationError"></span>
<script type="text/javascript">
  document.getElementById('Location').value = "<?php if(isset($MP)) {echo $MP;} else{ echo $meetingPoint;}?>";
</script>

<br>
Item Status:&emsp;&emsp;&emsp; <?php include 'itemStatus.php'?>
<br>
Condition: &emsp;&emsp;&emsp;
<input type="radio" name="rdnCondition" id="rdnNew" value="New" <?php if((isset($itemCondition) && $itemCondition=='New') or ((isset($Condition) && $Condition=='New'))) echo ' checked="checked"'?>> New
<input type="radio" name="rdnCondition" value="Used" id="rdnUsed" <?php if((isset($itemCondition) && $itemCondition=='Used') or ((isset($Condition) && $Condition=='Used'))) echo ' checked="checked"'?> > Used <font color="red">*</font> 
<?php if(isset($errors['ItemCondition'])) echo "<font id='try5' color='red'>".$errors['ItemCondition']."</font>";?>

</div>

</div>

<hr>
<!-- This part is for the selling part-->
<div id="Fields">
<label id="Words"> <input type="checkbox" name="rdnSelling" value="Selling" id="rdnSelling" onclick="TextBox();" <?php if(isset($_POST['rdnSelling']) && $_POST['rdnSelling']=='Selling') echo ' checked="checked"';?>> 
Resell </label> 
<br>
<div id="TextBox1">
<p id="text1">
Selling Price:&emsp;&emsp;<input type="text" name="PriceForSale" placeholder="eg: RM 35.00" id="Price1" value="<?php if((isset($SellingPrice)) && ($SellingPrice !== 'N/A')) {echo $SellingPrice;} elseif((isset($Price)) && ($Price !== 'N/A')) {echo $Price;}?>" disabled> <font id="fill" color="red" > </font> <span class="errorColor" id="itemPriceError"></span> 
<?php if(isset($errors['ItemPrice'])) echo "<font id='try6' color='red'>".$errors['ItemPrice']."</font>";?> 
<br>
Price are: &emsp;&emsp;&emsp;
<input type="radio" name="rdnPriceChange" value="Negotiable" id="rdnNegotiate"  <?php if((isset($PriceChange) && $PriceChange=='Negotiable')or(isset($AdjustPrice) && $AdjustPrice=='Negotiable')) echo ' checked="checked"'?> disabled > Negotiable 
<input type="radio" name="rdnPriceChange" value="Fixed" id="rdnFixed" <?php if((isset($PriceChange) && $PriceChange=='Fixed') or(isset($AdjustPrice) && $AdjustPrice=='Fixed')) echo ' checked="checked"'?> disabled> Fixed
<font id="fill2" color="red" > </font> 
<?php if(isset($errors['ChangePrice'])) echo "<font id='try7' color='red'>".$errors['ChangePrice']."</font>";?>


</p>
</div>
</div>
<hr>

<!-- This part is for barter -->
<div id="Fields">
<label id="Words"><input type="checkbox" name="rdnExchange" value="Exchange" id="rdnExchange" onclick="TextBox2()" <?php if(isset($_POST['rdnExchange']) && $_POST['rdnExchange']=='Exchange') echo ' checked="checked"';?>> Barter</label>
<br>
<div id="TextBox1">
<p id="text2" >
Wanted Item: &emsp;&emsp; <?php include 'category2Disabled.php'  ?>  <font id="fill3" color="red" ></font> <?php if(isset($errors['WantedItem'])) echo "<font id='try8' color='red'>".$errors['WantedItem']."</font>";?><span class="errorColor2" id="itemWantedCatError"></span>
</script>
<script type="text/javascript">
  document.getElementById('Category').value = "<?php if(isset($ItemWanted)) {echo $ItemWanted;} else{ echo $wantItemCategory;}?>";
</script>

<br>
Item detail: &emsp;&emsp;&emsp;<input type="text" name="wanting" id="Detail" placeholder="eg:Doraemon/ Honda Civic" value="<?php if((isset($ItemDetail)) && $ItemDetail!='N/A') {echo $ItemDetail;} elseif((isset($wantItemDetail)) && $wantItemDetail!='N/A') {echo $wantItemDetail;}?>" disabled > <font id="fill4" color="red" > </font><span class="errorColor" id="itemWantedDetailError"></span>
<?php if(isset($errors['ItemDetail'])) echo "<font id='try9' color='red'>".$errors['ItemDetail']."</font>";?>
<br>
Why exchange it: &emsp;<textarea id="reason" name="why" rows=5 cols=50 disabled placeholder="eg:A gift from friend, want to exchange with something i like" ><?php if((isset($Reason)) && $Reason!='N/A'){ echo $Reason;} elseif((isset($exchangeReason)) && $exchangeReason!='N/A') {echo $exchangeReason;}?></textarea> <font id="fill5" color="red" > </font> <span class="errorColor" id="reasonError"></span>
<?php if(isset($errors['Reason'])) echo "<font id='try10' color='red'>".$errors['Reason']."</font>";?>

<br>
</p>
</div>
</div>
<br>
<input type="hidden" id="sellAvailable" value="<?php echo $Price;?>">
<input type="hidden" id="exchangeAvailable" value="<?php echo $wantItemDetail; ?>">
<input type="hidden" id="image1" value="">
<input type="hidden" id="image2" value="">
<input type="hidden" id="image3" value="">

<input name= "submit" type="Submit" id="btnSubmit" value="Update">
</form>
</body>
</html>