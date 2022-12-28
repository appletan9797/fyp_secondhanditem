<?php
include 'connection.php';
//include '../bmainpage/mainpageBlank.php';


$postID= $_GET['item'];

//After submit button clicked
if ($_SERVER['REQUEST_METHOD'] == "POST"){
	$image1 = $_POST['item1'];
	$image2 = $_POST['item2'];
	$image3 = $_POST['item3'];
	
	$newImage1 = $_POST['newitem1'];
	$newImage2 = $_POST['newitem2'];
	$newImage3 = $_POST['newitem3'];
	
	//$empty = $_POST['empty'];
	
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
	
	if ($image1 !== "normal.jpg"){
	$sqlSelect = "SELECT * FROM itempicture WHERE Picture1 = '$image1'";
	$resultImage = $connection -> query($sqlSelect);
		if ($resultImage-> num_rows > 0){
			while($row = $resultImage->fetch_assoc()){
			$itemID = $row['ID']; 
			echo "<script> alert('The number is'+document.getElementById('image1').value);</script>";
		}
		}
	}
		/* else{
		echo "NO result"; 
		//echo "<script> alert('No result');</script>";
		} */
		
	if ($image2 !== "normal.jpg"){	
	$sqlSelect = "SELECT * FROM itempicture WHERE Picture1 = '$image2'";
	$resultImage = $connection -> query($sqlSelect);
		if ($resultImage-> num_rows > 0){
			while($row = $resultImage->fetch_assoc()){
			$itemID2 = $row['ID'];
		}
		}
	}
		/* else{
		echo "NO result";
		} */
		
	if ($image3 !== "normal.jpg"){
	$sqlSelect = "SELECT * FROM itempicture WHERE Picture1 = '$image3'";
	$resultImage = $connection -> query($sqlSelect);
		if ($resultImage-> num_rows > 0){
			while($row = $resultImage->fetch_assoc()){
			$itemID3 = $row['ID']; 
			//echo "<script> alert(document.getElementById('image1').value);</script>";
		}
		}
	}
	
	/* if (($newImage1 =="normal.jpg") and ($newImage2 =="normal.jpg") and ($newImage3 =="normal.jpg")){
		$errors["noImage"] = "At least upload one image";
	} */
	if (((isset ($newImage1)) and ($newImage1 == "normal.jpg")) or ($image1 == "normal.jpg")){
		if (((isset ($newImage2)) and ($newImage2 == "normal.jpg")) or ($image2 == "normal.jpg")){
			if (((isset ($newImage3)) and ($newImage3 == "normal.jpg")) or ($image3 == "normal.jpg")){
				$errors["noImage"] = "At least upload one image";
			}
		}
	}
		/* else{
		echo "NO result"; 
		//echo "<script> alert('No result');</script>";
		} */
	
	/*  if (($image1 !== "normal.jpg") and ($newImage1 == "normal.jpg")) {
		$sqlDelete = "DELETE FROM itempicture WHERE Picture1='$image1'";
		if ($connection-> query($sqlDelete) === TRUE){
			echo "<script> alert('Deleted'); </script>";
			
		}
		else {
			echo "<script> alert('Error'.$connection->error); </script>;";
			
		}
	}
	 
	  if (($image2 !== "normal.jpg") and ($newImage2 == "normal.jpg")) {
		$sqlDelete = "DELETE FROM itempicture WHERE Picture1='$image2'";
		if ($connection-> query($sqlDelete) === TRUE){
			echo "<script> alert('Deleted'); </script>";
		}
		else {
			echo "<script> alert('Error'.$connection->error); </script>;";
			
		}
	}
	
	 if (($image3 !== "normal.jpg") and ($newImage3 == "normal.jpg")) {
		$sqlDelete = "DELETE FROM itempicture WHERE Picture1='$image3'";
		if ($connection-> query($sqlDelete) === TRUE){
			echo "<script> alert('Deleted'); </script>";
			
		}
		else {
			echo "<script> alert('Error'.$connection->error); </script>;";
			
		}
	} */
	
	
	if ((isset($_FILES['itemPics1'])) and (!empty($_FILES['itemPics1']['tmp_name']))){
					$imageErrors = array();
					$tmp_name= $_FILES['itemPics1']['tmp_name'];
					$image = pathinfo($_FILES['itemPics1']['name']); //Get the info of the image
					$imageName =  $image['filename'].'_'.microtime(true).'.'. $image['extension']; //Set the image name
					$target_path = "../images/".$imageName;
					$data1 = $target_path;
					//To check uploaded image filetype 
					$CheckFileType = pathinfo($target_path, PATHINFO_EXTENSION);
					if ($CheckFileType != "jpg" AND $CheckFileType != "jpeg" AND $CheckFileType != "png" AND $CheckFileType != "gif"){
						$imageErrors['fileType'] =  "Only JPG, JPEG, PNG and GIF !";
					}//End if for checking file type 
					else{
					//Check uploaded file size (Not larger than 1000000byte/1MB)
						if($_FILES["itemPics1"]["size"]> 1000000){
							$imageErrors['fileSize'] = "*Files size must be less than 1MB";
						} //End if condition of checking file size
					}
					if (count($imageErrors) == 0){
						move_uploaded_file($tmp_name, $target_path);
						if (isset ($itemID)){
						//if ($image1 !== "normal.jpg"){
						$sqlInsertPicture= "UPDATE itempicture SET Picture1='$target_path' WHERE ID ='$itemID'";
						if ($connection->query($sqlInsertPicture) === TRUE){
							//Do nothing if no problem with the query
					
						}
						else{
							echo "error:".$connection->error;
						}
						//}
					}
						else{
							$sqlInsert= "INSERT INTO itempicture (Picture1, PostID) VALUES ('$target_path','$postID')";
							if ($connection->query($sqlInsert) === TRUE){
							//Do nothing if no problem with the query
							}
							else{
								echo "error:".$connection->error;
							}
						}
						}
	}

if ((isset($_FILES['itemPics2'])) and (!empty($_FILES['itemPics2']['tmp_name']))){
	$imageErrors = array();
		$tmp_name= $_FILES['itemPics2']['tmp_name'];
					$image = pathinfo($_FILES['itemPics2']['name']); //Get the info of the image
					$imageName =  $image['filename'].'_'.microtime(true).'.'. $image['extension']; //Set the image name
					$target_path = "../images/" . $imageName;
					$data2 = $target_path;
					//To check uploaded image filetype 
					$CheckFileType = pathinfo($target_path, PATHINFO_EXTENSION);
					if ($CheckFileType != "jpg" AND $CheckFileType != "jpeg" AND $CheckFileType != "png" AND $CheckFileType != "gif"){
						$imageErrors['fileType'] =  "Only JPG, JPEG, PNG and GIF !";
					}//End if for checking file type 
					else{
					//Check uploaded file size (Not larger than 1000000byte/1MB)
						if($_FILES["itemPics2"]["size"] > 1000000){
							$imageErrors['fileSize'] = "*Files size must be less than 1MB";
						} //End if condition of checking file size
					}
					if (count($imageErrors) == 0){
						move_uploaded_file($tmp_name, $target_path);
						if (isset ($itemID2)){
						//if ($image2 !== "normal.jpg"){
						$sqlInsertPicture2= "UPDATE itempicture SET Picture1='$target_path' WHERE ID ='$itemID2'";
						if ($connection->query($sqlInsertPicture2) === TRUE){
							//Do nothing if no problem with the query
					
						}
						else{
							echo "error:".$connection->error;
						}
						//}
					}
						else{
							$sqlInsert2= "INSERT INTO itempicture (Picture1, PostID) VALUES ('$target_path','$postID')";
							if ($connection->query($sqlInsert2) === TRUE){
							//Do nothing if no problem with the query
							}
							else{
								echo "error:".$connection->error;
							}
						}
						}
	}
	
	if ((isset($_FILES['itemPics3'])) and (!empty($_FILES['itemPics3']['tmp_name']))){
					$imageErrors = array();
					$tmp_name= $_FILES['itemPics3']['tmp_name'];
					$image = pathinfo($_FILES['itemPics3']['name']); //Get the info of the image
					$imageName =  $image['filename'].'_'.microtime(true).'.'. $image['extension']; //Set the image name
					$target_path = "../images/".$imageName;
					$data3 = $target_path;
					//To check uploaded image filetype 
					$CheckFileType = pathinfo($target_path, PATHINFO_EXTENSION);
					if ($CheckFileType != "jpg" AND $CheckFileType != "jpeg" AND $CheckFileType != "png" AND $CheckFileType != "gif"){
						$imageErrors['fileType'] =  "Only JPG, JPEG, PNG and GIF !";
					}//End if for checking file type 
					else{
					//Check uploaded file size (Not larger than 1000000byte/1MB)
						if($_FILES["itemPics3"]["size"]> 1000000){
							$imageErrors['fileSize'] = "*Files size must be less than 1MB";
						} //End if condition of checking file size
					}
					if (count($imageErrors) == 0){
						move_uploaded_file($tmp_name, $target_path);
						if (isset ($itemID3)){
						//if ($image3 !== "normal.jpg"){
						$sqlInsertPicture3= "UPDATE itempicture SET Picture1='$target_path' WHERE ID ='$itemID3'";
						if ($connection->query($sqlInsertPicture3) === TRUE){
							//Do nothing if no problem with the query
					
						}
						else{
							echo "error:".$connection->error;
						}
						//}
						}
						else{
							$sqlInsert3= "INSERT INTO itempicture (Picture1, PostID) VALUES ('$target_path','$postID')";
							if ($connection->query($sqlInsert3) === TRUE){
							//Do nothing if no problem with the query
							}
							else{
								echo "error:".$connection->error;
							}
						}
						}
}
	
//Check is there any errors. If no, update data
	if (count($errors) == 0){
		 if (($image1 !== "normal.jpg") and ($newImage1 == "normal.jpg")) {
		$sqlDelete = "DELETE FROM itempicture WHERE Picture1='$image1'";
		if ($connection-> query($sqlDelete) === TRUE){
			echo "<script> alert('Deleted'); </script>";
			
		}
		else {
			echo "<script> alert('Error'.$connection->error); </script>;";
			
		}
	}
	 
	  if (($image2 !== "normal.jpg") and ($newImage2 == "normal.jpg")) {
		$sqlDelete = "DELETE FROM itempicture WHERE Picture1='$image2'";
		if ($connection-> query($sqlDelete) === TRUE){
			echo "<script> alert('Deleted'); </script>";
		}
		else {
			echo "<script> alert('Error'.$connection->error); </script>;";
			
		}
	}
	
	 if (($image3 !== "normal.jpg") and ($newImage3 == "normal.jpg")) {
		$sqlDelete = "DELETE FROM itempicture WHERE Picture1='$image3'";
		if ($connection-> query($sqlDelete) === TRUE){
			echo "<script> alert('Deleted'); </script>";
			
		}
		else {
			echo "<script> alert('Error'.$connection->error); </script>;";
			
		}
	}
		$updateData= "UPDATE testing SET ItemName='$ItemName', ItemDescription='$Description', ItemCategory='$Category', MeetingPoint='$MP', Conditions='$Condition', SellingPrice='$SellingPrice', PriceChangeability='$PriceChange', ExchangeItemCategory='$ItemWanted', ExchangeDetail='$ItemDetail', Reason='$Reason' WHERE ID='$postID'";
					if ($connection->query($updateData) === TRUE){
						echo "SUCCESS";
					}
					else {
						echo "error update the data:".$connection->error;
					}//End if for the sql query (Insert data to database)
	} //End if for checking is there any error. If no errors found, save data to database.
}//End if for checking request method (if $_POST then do sth

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
		$wantItemCategory = $row['ExchangeItemCategory'];
		$wantItemDetail = $row['ExchangeDetail'];
		$exchangeReason = $row['Reason'];
		
		$postIDss = $row['ID'];
		
	}
}
// else{
	// header('Location: http://www.facebook.com/'); die;
// }


$selectImage = "SELECT * FROM itempicture WHERE PostID='$postID'";
$storeImage = $connection->query($selectImage);
if ($storeImage -> num_rows>0){
	while ($row = $storeImage->fetch_assoc()){
		$nameofImage[] = $row['Picture1'];
	}
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
<?php if(isset($errors['noImage'])) echo "<font color='pink'>".$errors['noImage']. "</font>";?>

<h3 id="uploadImage"> Upload Your Item's Images </h3>
<input id="picture1" method="POST" type="file" name="itemPics1" accept="image/*" onchange="showMyImage(this)">
<label for='picture1'> <img id='thumbnil1' src="<?php if (isset($errors['Atleast1'])){echo "normal.jpg";} else{if (isset($nameofImage[0])){echo $nameofImage[0];}else{echo "normal.jpg";}}?>" alt='image'/> </label>
<input id="picture2" method="POST" type="file" name="itemPics2" accept="image/*" onchange="showImage(this)">
<label for="picture2"> <img  id="thumbnil2" src="<?php if (isset($errors['Atleast1'])){echo "normal.jpg";} else{if (isset($nameofImage[1])){echo $nameofImage[1]; } else{echo "normal.jpg";}}?>" alt="image"/> </label> 
<input id="picture3" method="POST" type="file" name="itemPics3" accept="image/*" onchange="showImage2(this)">
<label for="picture3"> <img  id="thumbnil3" src="<?php if (isset($errors['Atleast1'])){echo "normal.jpg";} else{if (isset($nameofImage[2])){echo $nameofImage[2]; } else{echo "normal.jpg";}}?> " alt="image"/> </label> 
<br>
<button id="clear1" onclick="removeImg(1)">Clear</button> &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
<button id="clear2" onclick="removeImg(2)">Clear</button>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
<button id="clear3" onclick="removeImg(3)">Clear</button>

<!-- Onload store original image src -->
<input type="hidden" id="image1" name="item1" value="<?php if (isset($nameofImage[0])) {echo $nameofImage[0];} else{echo 'normal.jpg';}?>">
<input type="hidden" id="image2" name="item2" value="<?php if (isset($nameofImage[1])) {echo $nameofImage[1];} else{echo 'normal.jpg';}?>">
<input type="hidden" id="image3" name="item3" value="<?php if (isset($nameofImage[2])) {echo $nameofImage[2];} else{echo 'normal.jpg';}?>">

<!-- On submit store new image src -->
<input type="hidden" id="newImage1" name="newitem1" value="">
<input type="hidden" id="newImage2" name="newitem2" value="">
<input type="hidden" id="newImage3" name="newitem3" value="">

<!--<input type="hidden" id="empty" name="empty" value=""> -->

<?php if(isset($errors['fileType'])) echo $errors['fileType'];?> <br>
<?php if(isset($errors['fileSize'])) echo "<font color='red'>".$errors['fileSize']. "</font>";?> <br>
<?php if(isset($errors['Atleast1'])) echo "<font color='red'>".$errors['Atleast1']. "</font>";?>
<?php if(isset($imageErrors['fileSize'])) echo "<font color='red'>".$imageErrors['fileSize']. "</font>";?>

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
<input name= "submit" type="Submit" id="btnSubmit" value="Update">
</form>
</body>
</html>