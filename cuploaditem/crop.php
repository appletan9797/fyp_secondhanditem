<!-- form's data pass to here for checking, if no error detected, save data to database -->
<?php
include '../bmainpage/mainpageBlank.php';
include 'connection.php';
require_once 'function.php';
if (loggedIn()){
    $userName = getValue("UserName") ;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	//Save data to variable
			
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
		$sql= "INSERT INTO images (image) VALUES ()";
			if ($connection->query($sql) === TRUE){
				header("Location: previewUploaded.php?id=$hash");
				$sqlSelectID = "SELECT ID FROM post WHERE PostSpecialCode= '$hash'";
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
<input name= "submit" type="Submit" id="btnSubmit" value="Upload">
</form>
</body>
</html>