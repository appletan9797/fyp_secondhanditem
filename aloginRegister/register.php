<html>
<head>
<title> Create Account </title>
</head>
<body >
<link rel="stylesheet" text="text/css" href="success.css">
<link rel="stylesheet" text="text/css" href="Rcss.css">
<script type="text/javascript" src="change.js"></script>

<div class="conta">
<div class="col-sm-11">
<?php
$_SESSION['email'] = "";
//echo file_get_contents("http://localhost/finalFYP/bmainpage/mainpageBlank.php");
include '../bmainpage/mainpageBlank.php';
include 'connection.php';
?>

<?php
/* $userErr = $emailErr = $pwErr = $rePWErr = $genderErr = $firstnameErr = $lastnameErr = $birthdayErr = "";
$user = $email = $pw = $rePW = $gender = $firstname = $lastname = $birthday = "";
 */
$hash = md5 (rand(0, 1000));
$error = array();

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if (empty($_POST["username"])){
		$error["username"]= "UserName is required";
	} else {
		$user = test_input($_POST["username"]);
	}

	if (empty($_POST["password"])){
		$error["password"]= "Password is required";
	} else {
		$pw = test_input($_POST["password"]);
	}

	if (empty($_POST["confirmPW"])){
		$error["confirmPW"] = "Confirm Password is required";
	} else {
		$rePW = test_input($_POST["confirmPW"]);
	}

	if (empty($_POST["gender"])){
		$error["gender"] = "Gender is required";
	} else {
		$gender = test_input($_POST["gender"]);
	}

	if (empty($_POST["firstname"])){
		$error["firstname"] = "FirstName is required";
	} else {
		$firstname = test_input($_POST["firstname"]);
	}

	if (empty($_POST["lastname"])){
		$error["lastname"] = "LastName is required";
	} else {
		$lastname = test_input($_POST["lastname"]);
	}

	if (empty($_POST["dob"])){
		$error["birthday"] = "Birthday is required";
	} else {
		$birthday = test_input($_POST["dob"]);
		//$birthday = test_input($_POST["dob"]);
	}

	if (empty($_POST["email"])){
		$error["email"] = "Email is required";
	} else {
		
        //check if email address is well-formed
		$email = test_input($_POST["email"]);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL) === true){
		$error["email"] ="Invalid email format";
		}
}
	
	$sql = "SELECT * from register WHERE Email = '$email'";
	$result = $connection->query($sql);

    //check the email
	if ($result ->num_rows > 0 ){
		$error["email"] = "This email has been registered.";
	}
	//check the username
	if ($result ->num_rows > 0){
			$error["username"] ="This username has been registered.";
	}

		if ($_POST['password'] == $_POST['confirmPW']){
			if (count($error) == 0){
			$sql1 = "INSERT INTO register (Username, Password, confirmPW, Gender, FirstName, LastName, DOB ,Email, Verification, Role,Date) VALUES ('$user', '$pw', '$rePW', '$gender', '$firstname','$lastname','$birthday','$email', '$hash', 'User',Now())";

			if ($connection -> query($sql1) === TRUE) {

				$to = $email;
				$subject = "Signup || Verification";
				$message = "

				Thank you for your signing up.
				Your account has been created, just still one step left to surf our website !

				Click on the link to activate your account: 
				http://chopper.twopiz.com/~wilsandb/SecondChance_MaroonTech/aloginRegister/verify.php?Email=$email&Verification=$hash

				";
				$headers = 'From: rainnie970625@gmail.com'. "\r\n";
				mail ($to, $subject, $message, $headers);
				header('Location:success.php');
			}
			else{
				//echo "Error: " . $sql1 . "<br>" . $connection->error;
			}
			}
		}
		else{
			$error["confirmPW"] = "Password not the same !";

		}
?>
	
<?php
$connection->close();

}
	

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>

<div class = "panel">
    <div class = "row">
	    <div class = "col-xs-12">
		    <h3 class = "main-title">Create Account</h3>
	    </div>
    </div>
    <p><span class="error">* required field.</span></p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> ">
    
    <div class = "row">
	<div class="col-xs-12 col-sm-9 col-md-9">
		<div class="tab-content">
			<div class="tab-pane active" id="tab-personal">
					<table class="table table-hover">
						<tbody>
						    <tr>
								<td>User Name</td>
								<td><input type="text" name="username" id="username" placeholder="Username" > 
								<font color='red'>*</font> <span id="error1" class="error"> <?php if (isset($error["username"])) echo $error["username"]; ?> </span><span class="error" id="usernameErr"></span>
								</td>
							</tr>
							<tr>
								<td>Email</td>
								<td><input type="text" name="email" id="email" placeholder="Email">
								<font color='red'>*</font> <span id="error2" class="error"> <?php if (isset($error["email"])) echo $error["email"]; ?> </span><span class="error" id="emailErr"></span>
								</td>
							</tr>
							<tr>
								<td>Password</td>
								<td><input type="password" name="password" id="password" placeholder="Password">
								<font color='red'>*</font> <span id="error3" class="error"><?php if (isset($error["password"])) echo $error["password"]; ?> </span><span class="error" id="pwErr"></span>
								</td>
							</tr>
							<tr>
								<td>Confirm Password</td>
								<td><input type="password" name="confirmPW" id="confirmPW" placeholder="Confirm Password">
								<font color='red'>*</font> <span id="error4" class="error"> <?php if (isset($error["confirmPW"])) echo $error["confirmPW"]; ?> </span><span class="error" id="confirmPWErr"></span>
								</td>
							</tr>
							<tr>
								<td>Gender</td>
								<td><input type="radio" name="gender" value="female"> Female&emsp;
                                    <input type="radio" name="gender" value="male"> Male &emsp;&emsp;&emsp;
                                    <font color='red'>*</font> <span id="error5" class="error"> <?php if (isset($error["gender"])) echo $error["gender"]; ?> </span><span class="error" id="genderErr"></span>
                                </td>
							</tr>
							<tr>
								<td>First Name</td>
								<td><input type="text" name="firstname" id="firstname" placeholder="Firstname">
								<font color='red'>*</font> <span id="error6" class="error"> <?php if (isset($error["firstname"])) echo $error["firstname"]; ?> </span><span class="error" id="firstnameErr"></span>
								</td>
							</tr>
							<tr>
								<td>Last Name</td>
								<td><input type="text" name="lastname" id="lastname" placeholder="Lastname">
								<font color='red'>*</font> <span id="error7" class="error"><?php if (isset($error["lastname"])) echo $error["lastname"]; ?></span><span class="error" id="lastnameErr"></span>
								</td>
							</tr>
							<tr>
								<td>Date of Birth</td>
								<td><input type="date" name="dob" id="dob" value='<?php if(isset($birthday))echo $birthday; ?> '>&emsp;
								<font color='red'>*</font> <span id="error8" class="error"><?php if (isset($error["birthday"])) echo $error["birthday"]; ?> </span><span class="error" id="birthdayErr"></span>
								</td>
							</tr>
						</tbody>
					</table>
		</span>
        </td>
        </tr>
				</tbody>
				</table>
				<br>
				<br>
			&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input type="submit" name="submit" value="Submit" >
		</form>
		
		<style>
		input {
    border: none;
    background: transparent;
}
		</style>
</div>
</div>
</div>
</div>
</div>
</form>
</body>
<p id="c"> Copyright &copy; Maroon Tech 2017</p>
</html>