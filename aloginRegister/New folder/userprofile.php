<!DOCTYPE html>
<html>
<head>
	<title> User Profile</title>
</head>
<body>
<link rel="stylesheet" text="text/css" href="UPcss.css">

<div class="conta"> 
<div class="row-sm-11">

<?php
include 'connection.php';
include '../bmainpage/mainpageBlank.php';

?>

<script>
function showImage2(fileInput) {
        var files = fileInput.files;
        for (var i = 0; i < files.length; i++) {           
            var file = files[i];
            var imageType = /image.*/;     
            if (!file.type.match(imageType)) {
                continue;
            }           
           var img=document.getElementById("thumbnil3");            
            img.file = file;    
            var reader = new FileReader();
           reader.onload = (function(aImg) { 
                return function(e) { 
                   aImg.src = e.target.result; 
                }; 
            })(img);
           reader.readAsDataURL(file);
        }
}
</script>

<?php
include_once 'function.php';
$changeID = getValue("UserName") ;
$image = getValue("Picture");
$sql = "SELECT * FROM register WHERE UserName = '$changeID' ";
$result = $connection->query($sql);

if (loggedIn()){
    $changeID = getValue("UserName") ;
    $image = getValue("Picture");
}
else{
    $changeID = " ";
    $image = "picture.png";
}
mysqli_close($connection);
?>

<form method="post" enctype="multipart/form-data" action="userprofile.php">
<div class = "profilepanel">
	<span class = "media">
		<div class = "UserAvatar">
			<label for="picture"> <img id="thumbnil3" alt="Profile Pic" src="picture.png" width="150" height="150" class = "UserAvatar" id="photo-profile">
		</div>
	</span>
	<div class = "userprofile">
		<h1 class = "userprofile"> <?php echo $changeID ?> </h1>
	</div>
</div>
	<div class = "image">
		<a class="profileimage" href="SC Image.png"> 
		<img alt="Welcome to Second Chance" src="SC Image" width="162" height="162" >
		</a>
		<figcaption class="caption">
			<h4 class="title">Welcome to Second Chance!</h4>
				<span class="price" title="RM0">RM 0</span>
		</figcaption>
	</div>
</form>
</div>
</div>
<p id="c"> Copyright &copy; Maroon Tech 2017</p>
</body>
</html>