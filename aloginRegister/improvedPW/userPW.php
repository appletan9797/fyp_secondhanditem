<?php 
ob_start();
include 'connection.php';
include '../bmainpage/mainpageBlank.php'; 

//Select password from db to check 
$id = $_SESSION['User_ID'];
	$sqlCheck = "SELECT * FROM register WHERE ID = '$id'";
	$result = $connection->query ($sqlCheck);
	if ($result -> num_rows>0){
		while ($row= $result->fetch_assoc()){
			$oripassword= $row['Password'];
		}
	}
if ($_SERVER['REQUEST_METHOD'] == "POST"){
	$error = array();
	
	if (empty($_POST["oldpassword"])){
		$error["oldpassword"]= "*Enter your old password, please?";
	} else {
		$password = test_input($_POST["oldpassword"]);
		if ($password !== $oripassword){
		$error["oldpassword"]= "*Old password not match";
		}
	}
	
	if (empty($_POST["password"])){
		$error["password"]= "*Enter your new password, please?";
	} else {
		$newpassword = test_input($_POST["password"]);
		if(strlen($newpassword) <8) {
        $error["password"] = "*At least 8 characters!";
		}
		else if (!preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,}$/', $newpassword)){
			$error["password"] =  "*Password should contain number, uppercase character, lowercase character and symbol";
		}
	}

	
	if (empty($_POST["repassword"])){
		$error["repassword"]= "*Confirm your new password, please?";
	} else {
		$repassword = test_input($_POST["repassword"]);
		if ((isset($newpassword)) and ($newpassword !== $repassword)){
			$error["repassword"]= "*Confirm password not match";
		}
	}
	
	if (count($error) == 0){
		$sqlUpdate = "UPDATE register SET Password = '$newpassword'， confirmPW= '$repassword' WHERE ID= '$id'";
		if ($connection->query($sqlUpdate) === TRUE){
						echo "SUCCESS";
					}
					else {
						echo "error update the data:".$connection->error;
	}
	}
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>
<html>
<head>
<title>User Profile Edit</title>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
<script type="text/javascript" src="changePW.js"></script>
<link rel="stylesheet" text="text/css" href="editPW.css">
<div class="conta"> 
<div class="row-sm-11">
<div class = "panel">
    <div class = "row">
	    <div class = "col-xs-12">
		    <h3 class = "main-title">Change your password</h3>
	    </div>
    </div>
    <form method="post"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> ">
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
								<td>Old Password</td>
								<td><input type="password" id="oldpw" name="oldpassword" value="<?php if((!isset($error['oldpassword'])) and (isset($_POST["oldpassword"]))) echo $password;?>"> 
								<br><font id="oldPW1" color="red" class="error"> <?php if(isset($error['oldpassword'])) echo $error['oldpassword'];?> </font> <span id="error1" class="error"> </span>
								<input type="hidden" id="oriPW" value="<?php echo $oripassword;?>">
								</td>
							</tr>
							
						<tr>
								<td>New Password</td>
								<td><input type="password" id="newpw" name="password" onchange="analyze(password)" value="<?php if((!isset($error['password'])) and (isset($_POST["password"]))) echo $newpassword;?>" onchange="appear()"> 
								<br><font id="newPW1" color="red" class="error"><?php if(isset($error['password'])) echo $error['password'];?> </font><span id="error2" class="error"> </span>

								</td>
							</tr>
				
							<tr>
								<td>Confirm Password</td>
								<td><input type="password" id="confirm" name="repassword"> 
								<br><span id="rePW1" class="error"><?php if(isset($error['repassword'])) echo $error['repassword'];?> </span><span id="error3" class="error"> </span>
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