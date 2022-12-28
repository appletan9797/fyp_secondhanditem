<?php 
ob_start();
include 'connection.php';
include '../bmainpage/mainpageBlank.php'; 

$id = $_SESSION['User_ID'];


if (isset($_POST['submitChange'])){
	$fname = mysqli_real_escape_string($connection,$_POST['firstname']);
	$lname = mysqli_real_escape_string($connection,$_POST['lastname']);
	$emailAdd =  mysqli_real_escape_string($connection,$_POST['email']);
	$userGender = mysqli_real_escape_string($connection,$_POST['gender']);
	$birthday = mysqli_real_escape_string($connection,$_POST['dob']);
	
	$error = array();
	
	//Validation
	if (empty($fname)){
		$error['fname'] = "*FirstName is required";
	}
	else{
		$fname = test_input($_POST["firstname"]);
	}
	
	if (empty($lname)){
		$error['lname'] = "*LastName is required";
	}
	else{
		$lname=test_input($_POST["lastname"]);
	}
	
	if (empty($emailAdd)){
		$error['email'] = "*Email is required";
	}
	else{
		$emailAdd=test_input($_POST["email"]);
		if (!filter_var($emailAdd, FILTER_VALIDATE_EMAIL) === true){
		$error['email'] = "*Invalid email format";
		}
	}
	
	if (empty($birthday)){
		$error['birthday'] = "*Birthday is required";
	}
	else{
		$birthday=test_input($_POST["dob"]);
		$birthdate = strtotime($_POST["dob"]);
		$today = time();
		$check= $today - $birthdate;
        $years = floor($check)/31536000;
		if ($check <0){
            $error["birthday"] = "*Birthday should not be later than today";
        }
        else if ($years<10){
            $error["birthday"] = "*We do not encourage children who not over 10 access internet";
        }
	}
	
	//the path to store the uploaded image
	if (!empty($_FILES['itempics']['name'])) {
	$tmp_name= $_FILES['itempics']['tmp_name'];
	$imageFileType = pathinfo($_FILES['itempics']['name']);
	$image =  $imageFileType['filename'].'_'.microtime(true).'.'. $imageFileType['extension']; //Set the image name
	$target = "images/" . $image;
	// Allow certain file formats
	$imageFileType = pathinfo($target, PATHINFO_EXTENSION);
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			$error['Filetype'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	}
	if (count($error) ==0){
		(move_uploaded_file($tmp_name, $target));
	}
	}
	
//Insert data	
	if (count($error) == 0){
		if (!empty($_FILES['itempics']['name'])) {
		$sql1 = "UPDATE register SET Email = '$emailAdd', FirstName = '$fname', LastName = '$lname', DOB = '$birthday', Gender = '$userGender', Picture = '$target' WHERE ID = '$id' ";
		if ($connection->query($sql1) === TRUE){
			echo "SUCCESS";
		}
		}
		else{
			$sql2 = "UPDATE register SET Email = '$emailAdd', FirstName = '$fname', LastName = '$lname', DOB = '$birthday', Gender = '$userGender' WHERE ID = '$id' ";
		if ($connection->query($sql2) === TRUE){
			echo "SUCCESS";
		}
		}
}
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

$sql = "SELECT * FROM register WHERE ID = '$id'";
$result = $connection->query ($sql);
if ($result -> num_rows>0){
	while ($row= $result->fetch_assoc()){
		$firstname = $row['FirstName'];
		$lastname= $row['LastName'];
		$email= $row['Email'];
		$password= $row['Password'];
		$gender= $row['Gender'];
		$dob= $row['DOB'];
		$picture= $row['Picture'];
	}
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
<html>
<head>
<title>User Profile Edit</title>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="test.js"></script>
</head>
<body>

<link rel="stylesheet" text="text/css" href="Ecss.css">
<div class="conta"> 
<div class="row-sm-11">
<div class = "panel">
    <div class = "row">
	    <div class = "col-xs-12">
		    <h3 class = "main-title">Edit your profile</h3>
	    </div>
    </div>
    <form method="post" name="myform" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> ">
    <div class = "row">
	<div class = "pictureupload" >
		<img id="delete" src="del.png" alt="image" width="30" height="30" onclick="removeImg(<?php echo $_SESSION['User_ID'];?>)">
		<label for="picture"> <img id="thumbnil3" src="<?php echo $picture;?>" alt="image" width="150" height="150" class="img-thumbnail hidden-xs" id="photo-profile">
	</div>
	<div class = "fileUpload">
	<input id="picture" method="POST" type="file" name="itempics" accept="image/*" onchange="showImage2(this)" class="upload"/>
	
	</div>
		</div>
 <div class = "row">
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
								<td><input type="text" id="fname" name="firstname" value="<?php if(isset($fname)) {echo $fname;} else{echo $firstname;}?>"> 
								<br><span id="error1" class="error"><?php if(isset($error['fname'])) echo $error['fname'];?> </span><span id="fnameError" class="error"></span>
								</td>
							</tr>
							<tr>
								<td>Last Name</td>
								<td><input type="text" id="lname" name="lastname" value="<?php if(isset($lname)) {echo $lname;} else{echo $lastname;}?>"> 
								<br><span id="error2" class="error"> <?php if(isset($error['lname'])) echo $error['lname'];?> </span><span id="lnameError" class="error"></span>
								</td>
							</tr>
							<tr>
								<td>Email</td>
								<td><input type="text" id="email" name="email" value="<?php if(isset($emailAdd)) {echo $emailAdd;} else{echo $email;} ?>">  <br>
								<span id="error3" class="error"> <?php if(isset($error['email'])) echo $error['email'];?> </span><span id="emailError" class="error"></span>
								</td>
							</tr>
							<tr>
								<td>Gender</td>
								<td><input type="radio" name="gender" value="female" <?php if (isset($gender) && $gender=='female') echo 'checked = "checked"'; ?>> Female
                                    <input type="radio" name="gender" value="male" <?php if (isset($gender) && $gender=='male') echo 'checked = "checked"'; ?>> Male &emsp;&emsp;
                                   
                                </td>
							</tr>
							<tr>
								<td>Date of Birth</td>
								<td><input type="date" id="dob" name="dob" value="<?php if(isset($birthday)) {echo $birthday;} else{echo $dob;}?>">
								<br><span id="error4" class="error"> <?php if(isset($error['birthday'])) echo $error['birthday'];?> </span><span id="dobError" class="error"></span>
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
			<input type="submit" id="sub" name="submitChange" value="Submit">
		</form>
	
</div>
</div>
</div>
</div>

</div>

</body>
</html>