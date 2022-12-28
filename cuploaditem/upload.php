<?php ob_start(); ?>
<!-- form's data pass to here for checking, if no error detected, save data to database -->
<?php
include '../bmainpage/mainpageBlank.php';
include 'connection.php';
require_once 'function.php';
if (loggedIn()){
    $userName = getValue("UserName") ;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	//unlink('itemPics[0]');	
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
		if (isset($_POST['rdnPriceChange'])){
			$PriceChange = $_POST['rdnPriceChange'];
		}
	}
	else{
		$total= 0;
		$SellingPrice="N/A";
		$PriceChange="N/A";
	}
			
			//If exchange checkbox checked
	if (isset($_POST['rdnExchange'])){
		$total=$total + 1;
		if (isset ($_POST['catList'])){
			$ItemWanted = $_POST['catList'];
		}
		if (isset($_POST ['wanting'])){
			$ItemDetail =mysqli_real_escape_string($connection, $_POST ['wanting']);
		}
		if (isset($_POST ['why'])){
			$Reason = mysqli_real_escape_string($connection,$_POST['why']);
		}
	}
	else{
		$total= $total -1 ;
		$ItemWanted="N/A";
		$ItemDetail="N/A";
		$Reason="N/A";
	}
			$hash =md5 ( rand(0,1000)); 
			$errors = array();

			
//Validation
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
		
			if(empty ($SellingPrice)){
				$errors["ItemPrice"] = "Please enter the price";
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
			
			if (isset($_FILES['itemPics'])){
				if (!empty($_FILES['itemPics']['tmp_name'][0]) or !empty($_FILES['itemPics']['tmp_name'][1]) or !empty($_FILES['itemPics']['tmp_name'][2]) ){
					foreach($_FILES['itemPics']['name'] as $n => $name) {
						if (!empty($_FILES['itemPics']['tmp_name'][$n])){
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
							}
						}//Do checking if the itemPics[$n] not empty
					}//end for loop
				} // Make sure at least 1 file uploaded
				else{
					$errors['Atleast1']= "Hmm.. Upload one image maybe?";
				}
			}
			
//Check is there any errors. If no, save data to db
	if (count($errors) == 0){
		$sql= "INSERT INTO testing (ItemName, ItemDescription, ItemCategory, MeetingPoint, ItemStatus, Conditions, SellingPrice, PriceChangeability, ExchangeItemCategory, ExchangeDetail, Reason, PostSpecialCode, Seller, Time) VALUES ('$ItemName', '$Description','$Category','$MP','$Status', '$Condition', '$SellingPrice', '$PriceChange', '$ItemWanted', '$ItemDetail', '$Reason', '$hash', '$userName',Now())";
			if ($connection->query($sql) === TRUE){
				//header("Location:previewUploaded.php?id=$hash");
				$sqlSelectID = "SELECT ID FROM testing WHERE PostSpecialCode= '$hash'";
				$request = $connection-> query($sqlSelectID);
				if ($request-> num_rows > 0 ){
					while ($row=$request->fetch_assoc()){
						$PostID = $row['ID'];
					}
				}
						
				foreach($_FILES['itemPics']['name'] as $n => $name) {
				if (!empty($_FILES['itemPics']['tmp_name'][$n])){
					$tmp_name= $_FILES['itemPics']['tmp_name'][$n];
					$image = pathinfo($_FILES['itemPics']['name'][$n]); //Get the info of the image
					$imageName =  $image['filename'].'_'.microtime(true).'.'. $image['extension']; //Set the image name
					$target_path = "../images/" . $imageName;
						
					//Insert data into database if no error found
					move_uploaded_file($tmp_name, $target_path);
					$sqlInsertPicture= "INSERT INTO itempicture (Picture1, PostID) VALUES ('$target_path', '$PostID')";
					if ($connection->query($sqlInsertPicture) === TRUE){
						//Do nothing if no problem with the query
					}
					else{
						echo "error:".$connection->error;
					}
				}// End if for checking whether there is any mistake when storing image data (ERR OK)
				
				}// End for loop for saving picture	
			} //End If of insert query success
			else {
				echo "error:".$connection->error;
			}//End if for the sql query (Insert data to database)
	} //End if for checking is there any error. If no errors found, save data to database.

} //End if for checking request method (if $_POST then do sth

?>


<html>
<head>
<title> Upload Item </title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
</head>
<link rel="stylesheet" type="text/css" href="design.css">
<body>

<script type="text/javascript" src="imagePreview.js"></script>
<script type="text/javascript" src="EnableTextBox.js"></script>
<script type="text/javascript" src="Script.js"></script>

<form action="" method="post" enctype="multipart/form-data">

<div id="Fields">
<div id="Pictures">
<?php if(isset($errors['PickMe'])) echo "<font color='pink'>".$errors['PickMe']. "</font>";?>

<h3 id="uploadImage"> Upload Your Item's Images </h3>
<input id="picture1" method="POST" type="file" name="itemPics[]" accept="image/*" onchange="showMyImage(this)">
<label for='picture1'> <img id='thumbnil1'  src='normal.jpg' alt='image'/> </label>
<input id="picture2" method="POST" type="file" name="itemPics[]" accept="image/*" onchange="showImage(this)">
<label for="picture2"> <img  id="thumbnil2"  src="normal.jpg" alt="image"/> </label> 
<input id="picture3" method="POST" type="file" name="itemPics[]" accept="image/*" onchange="showImage2(this)">
<label for="picture3"> <img  id="thumbnil3"  src="normal.jpg" alt="image"/> </label> 
<br>
<button id="clear" onclick="removeImg(1)">Clear</button> &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
<button id="clear" onclick="removeImg(2)">Clear</button>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
<button id="clear" onclick="removeImg(3)">Clear</button>

<?php if(isset($errors['fileType'])) echo "<font color='red'>".$errors['fileType']. "</font>";?> <br>
<?php if(isset($errors['fileSize'])) echo "<font color='red'>".$errors['fileSize']. "</font>";?> <br>
<?php if(isset($errors['Atleast1'])) echo "<font color='red'>".$errors['Atleast1']. "</font>";?>
</div>

<!-- Here will be the div for item's basic info-->
<h2 id="Words"> Item Information </h2>
<h5 id="MustFilled"> <font color="red">* are fields must be filled </font></h5>
<div id="TextBox">

<table>
<tr>
<td>
Item Name:&emsp;&emsp;&emsp;
</td>
<td><input type= "text" id="itemName" name="ItemName" placeholder="eg:The Conon" value="<?php if(isset($ItemName)) echo $ItemName;?>"/> <font color="red">*</font> <?php if(isset($errors['ItemName'])) echo "<font id='try1' color='red'>".$errors['ItemName']. "</font>";?><span class="errorColor" id="itemNameError"></span> 
</td>
</tr>
<tr>
<td>
Item Description:&emsp;</td>
<td>
<textarea id="ItemDescription" name="ItemDescription" rows=5 cols=50 placeholder="eg:This book looks like new one" ><?php if(isset($Description)) echo $Description;?></textarea> <font color="red">*</font><?php if(isset($errors['ItemDescription'])) echo"<font id='try2' color='red'>".$errors['ItemDescription']."</font>";?> <span class="errorColor" id="itemDescriptionError"></span>
</td>
</tr>
Category:&emsp;&emsp;&emsp;&emsp; <?php include 'category.php' ?>  <font color="red">*</font> <?php if(isset($errors['ItemCategory'])) echo "<font id='try3' color='red'>".$errors['ItemCategory']."</font>";?> <span class="errorColor" id="itemCategoryError"></span>

<script type="text/javascript">
  document.getElementById('CAtegoryList').value = "<?php if(isset($Category)) echo $Category;?>";
</script>

<br>
Location:&emsp;&emsp;&emsp;&emsp;<?php include 'datalist.php' ?><font color="red">*</font> <?php if(isset($errors['Location'])) echo "<font id='try4' color='red'>".$errors['Location']."</font>";?><span class="errorColor" id="locationError"></span>
<script type="text/javascript">
  document.getElementById('Location').value = "<?php if(isset($MP)) echo $MP;?>";
</script>

<br>
Item Status:&emsp;&emsp;&emsp; <?php include 'itemStatus.php'?>
<br>
Condition: &emsp;&emsp;&emsp;
<input type="radio" name="rdnCondition" id="rdnNew" value="New" <?php if(isset($Condition) && $Condition=='New') echo ' checked="checked"'?>> New
<input type="radio" name="rdnCondition" value="Used" id="rdnUsed" <?php if(isset($Condition) && $Condition=='Used') echo ' checked="checked"'?> > Used <font color="red">*</font> 
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
Selling Price:&emsp;&emsp;<input type="text" name="PriceForSale" placeholder="eg: RM 35.00" id="Price1" disabled value="<?php if((isset($SellingPrice)) && ($SellingPrice != 'N/A')) echo $SellingPrice;?>" > <font id="fill" color="red" > </font> <span class="errorColor" id="itemPriceError"></span> 
<?php if(isset($errors['ItemPrice'])) echo "<font id='try6' color='red'>".$errors['ItemPrice']."</font>";?> 
<br>
Price are: &emsp;&emsp;&emsp;
<input type="radio" name="rdnPriceChange" value="Negotiable" id="rdnNegotiate"  <?php if(isset($PriceChange) && $PriceChange=='Negotiable') echo ' checked="checked"'?> disabled > Negotiable 
<input type="radio" name="rdnPriceChange" value="Fixed" id="rdnFixed" <?php if(isset($PriceChange) && $PriceChange=='Fixed') echo ' checked="checked"'?>disabled > Fixed
<input type= "hidden" id="condition" value="<?php if(isset($_POST['rdnPriceChange'])) echo $_POST['rdnPriceChange']; ?>">
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
<script type="text/javascript">
  document.getElementById('Category').value = "<?php if(isset($ItemWanted)) echo $ItemWanted;?>";
</script>

<br>
Item detail: &emsp;&emsp;&emsp;<input type="text" name="wanting" id="Detail" placeholder="eg:Doraemon/ Honda Civic" value="<?php if((isset($ItemDetail)) && $ItemDetail!='N/A') echo $ItemDetail;?>" disabled > <font id="fill4" color="red" > </font><span class="errorColor" id="itemWantedDetailError"></span>
<?php if(isset($errors['ItemDetail'])) echo "<font id='try9' color='red'>".$errors['ItemDetail']."</font>";?>
<br>
Why exchange it: &emsp;<textarea id="reason" name="why" rows=5 cols=50 disabled placeholder="eg:A gift from friend, want to exchange with something i like" ><?php if((isset($Reason)) && $Reason!='N/A') echo $Reason;?></textarea> <font id="fill5" color="red" > </font> <span class="errorColor" id="reasonError"></span>
<?php if(isset($errors['Reason'])) echo "<font id='try10' color='red'>".$errors['Reason']."</font>";?>
<br>
</p>
</div>
</div>
<br>
<input name= "submit" type="Submit" id="btnSubmit" value="Upload">
</table>
</form>
</body>
</html>