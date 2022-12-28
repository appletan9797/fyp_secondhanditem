<html>
<head>
	<title>User Profile Edit</title>
</head>
<body>
<link rel="stylesheet" text="text/css" href="Ecss.css">

<div class="conta"> 
<div class="row-sm-11">

<?php
$_SESSION['email'] = "";
include 'connection.php';
include '../bmainpage/mainpageBlank.php';
?>

<?php
$email = $firstname = $lastname = $pw = $gender = $birthday = $image = "";
$emailErr = $firstnameErr = $lastnameErr = $pwErr = $genderErr = $birthdayErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if (empty($_POST["email"])){
		$emailErr = "Email is required";
	} else {
		
        //check if email address is well-formed
		$email = test_input($_POST["email"]);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL) === true){
		$emailErr ="Invalid email format";
		}
}

	if (empty($_POST["firstname"])){
		$firstnameErr = "FirstName is required";
	} else {
		$firstname = test_input($_POST["firstname"]);
	}

	if (empty($_POST["lastname"])){
		$lastnameErr = "LastName is required";
	} else {
		$lastname = test_input($_POST["lastname"]);
	}

    if (empty($_POST["password"])){
		$pwErr = "Password is required";
	} else {
		$pw = test_input($_POST["password"]);
	}

	if (empty($_POST["gender"])){
		$genderErr = "Gender is required";
	} else {
		$gender = test_input($_POST["gender"]);
	}

	if (empty($_POST["dob"])){
		$birthdayErr = "Birthday is required";
	} else {
		$birthday = test_input($_POST["dob"]);
	}
	
	$error= array();

	//the path to store the uploaded image
	$tmp_name= $_FILES['itempics']['tmp_name'];
	$imageFileType = pathinfo($_FILES['itempics']['name']);
	$image =  $imageFileType['filename'].'_'.microtime(true).'.'. $imageFileType['extension']; //Set the image name
	$target = "images/" . $image;
	
	//connect to the database
	$db = mysqli_connect("localhost", "root", "root", "testing");
	$sql = "INSERT INTO register (image) VALUES ('$target')";
	mysqli_query($db, $sql); //store the submitted data into the database table: image
	
	// Allow certain file formats
	$imageFileType = pathinfo($target, PATHINFO_EXTENSION);
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			$error['Filetype'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	}

	if (count($error) == 0) {
	//now let's move the uploaded image into the folder: images
	if (move_uploaded_file($tmp_name, $target)) {
		echo "Image uploaded successfully.";
	} 
	else {
		echo "Fail to upload.";
	}
    }
	include_once 'function.php';
	$changeID = getValue("UserName") ;
	$sql1 = "UPDATE register set Email = '$email', FirstName = '$firstname', LastName = '$lastname', Password = '$pw', confirmPW = '$pw', DOB = '$birthday', Gender = '$gender', Picture = '$image' WHERE UserName = '$changeID' ";
	if ($connection->query($sql1)){
		echo "Updated";
	}
	else{
		$connection->error;
	}
}
include_once 'function.php';
	$changeID = getValue("UserName") ;
$sql = "SELECT * FROM register WHERE UserName = '$changeID'";
$result = $connection->query($sql);

    if ($result->num_rows > 0) {
	    while ($row = mysqli_fetch_array($result)) {
		      $email = $row["Email"]; 
		      $firstname = $row["FirstName"];
		      $lastname = $row["LastName"];
		      $pw = $row["Password"];
		      $birthday = $row["DOB"];
		      $gender = $row["Gender"];
		      $picture = $row["Picture"];
	    }
}

mysqli_close($connection);

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
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

<div class = "panel">
    <div class = "row">
	    <div class = "col-xs-12">
		    <h3 class = "main-title">Profile</h3>
	    </div>
    </div>
    <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> ">
    <div class = "row">
	<div class = "pictureupload" >
		<label for="picture"> <img id="thumbnil3" src="picture.png" alt="image" width="150" height="150" class="img-thumbnail hidden-xs" id="photo-profile">
	</div>
	<div class = "fileUpload">
	<input id="picture" method="POST" type="file" name="itempics" accept="image/*" onchange="showImage2(this)" class="upload"/ required>
	</div>
	<div class="col-xs-12 col-sm-9 col-md-9">
		<div class="tab-content">
			<div class="tab-pane active" id="tab-personal">
				<div class="visible-xs">
					<div class="alert alert-warning hidden-print text-center table-alert" style="display: none;">
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-hover">
						<tbody>
							<tr>
								<td>First Name</td>
								<td><input type="text" name="firstname" value='<?php echo  $firstname; ?> '> 
								<span class="error">* <?php echo $firstnameErr; ?> </span>
								</td>
							</tr>
							<tr>
								<td>Last Name</td>
								<td><input type="text" name="lastname" value='<?php echo  $lastname; ?> '> 
								<span class="error">* <?php echo $lastnameErr; ?>
								</td>
							</tr>
							<tr>
								<td>Email</td>
								<td><input type="text" name="email" value='<?php echo  $email; ?> '> 
								<span class="error">* <?php echo $emailErr; ?> </span>
								</td>
							</tr>
							<tr>
								<td>Password</td>
								<td><input type="text" name="password" value='<?php echo  $pw; ?> '> 
								<span class="error">* <?php echo $pwErr; ?> </span>
								</td>
							</tr>
							<tr>
								<td>Gender</td>
								<td><input type="radio" name="gender" value="female" <?php if (isset($gender) && $gender=='female') echo 'checked = "checked"'; ?>> Female
                                    <input type="radio" name="gender" value="male" <?php if (isset($gender) && $gender=='male') echo 'checked = "checked"'; ?>> Male &emsp;&emsp;
                                    <span class="error">* <?php echo $genderErr; ?> </span>
                                </td>
							</tr>
							<tr>
								<td>Date of Birth</td>
								<td><input type="date" name="dob" value='<?php echo  $birthday; ?>'>
								<span class="error">* <?php echo $birthdayErr; ?> </span>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				</span>
				</td>
				</tr>
				</tbody>
				</table>
				<br>
				<br>
			<input type="submit" name="submit" value="Submit">
		</form>
</div>
</div>
</div>
</div>
<p id="c"> Copyright &copy; Maroon Tech 2017</p>
</div>
</body>
</html>