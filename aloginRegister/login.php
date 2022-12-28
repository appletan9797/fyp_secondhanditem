<?php ob_start(); ?>
<html>
<head>
<title> Login </title>
</head>
<body>
<body>
<link rel="stylesheet" text="text/css" href="Lcss.css">
<div class="conta">
<div class="col-sm-11">
<?php
//echo file_get_contents("http://localhost/finalFYP/bmainpage/mainpageBlank.php");
//echo file_get_contents("http://localhost/finalFYP/bmainpage/function.php");
include '../bmainpage/mainpageBlank.php';
include_once 'function.php';
include 'connection.php';
?>
<?php
// $userErr = $pwErr = "";
// $user = $pw = "";
$error = array();


if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if (empty($_POST["username"])){
		$error["username"]= "Enter your username";
	} else {
		$user = test_input($_POST["username"]);
	}
	if (empty($_POST["password"])){
		$error["password"]= "Enter your password";
	} else {
		$pw = test_input($_POST["password"]);
	}

	if (isset($_POST["RememberMe"]) && $_POST["RememberMe"]!="") {
		setcookie ("Username",$_POST["username"],time()+ (60 * 60 * 7));
		setcookie ("Password",$_POST["password"],time()+ (60 * 60 * 7));

	} else {
				if(isset($_COOKIE["Username"])) {
					setcookie ("Username", "");
				}
				if(isset($_COOKIE["password"])) {
					setcookie ("password", "");
				}
			}
		if (count($error) == 0){
		//$sql = "SELECT * FROM register WHERE UserName = '$user' and Password = '$pw'";
		$sql = "SELECT * FROM register WHERE UserName = '$user'";
		$result = $connection -> query($sql);
		if ($result -> num_rows == 1){
			$row = $result->fetch_assoc();
			$userid = $row['ID'] ;
			$password = $row['Password'];
			if ($password == $pw) {
				$_SESSION["User_ID"] = $userid;
				header("Location:../bmainpage/mainpage.php");
			}
			else {
				$wrong= "Incorrect password";
			}
		}
		else{
			$wrong="Username not registered";
		}
			/* if ($result -> num_rows == 1){
				$row = $result->fetch_assoc();
				$userid = $row['ID'] ;
				$_SESSION["User_ID"] = $userid;
				header("Location:http://chopper.twopiz.com/~wilsandb/SecondChance_MaroonTech/bmainpage/mainpage.php");
			} 
			else {
				$wrongInput['wrong']= "Wrong PW or Name";
			} */
		}
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
		    <h3 class = "main-title">Login</h3>
			
	    </div>
    </div>
    <p><font color='red'>* required field.</font></p>
	
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    
    <div class = "row">
	<div class="col-xs-12 col-sm-9 col-md-9">
		<div class="tab-content">
			<div class="tab-pane active" id="tab-personal">
			
					<table class="table table-hover">
					<?php if(isset($wrong)){echo "<font color='red'>".$wrong."</font>";} ?>
						<tbody>
						    <tr>
								<td>User Name</td>
								<td><input type="text" name="username" id="name" placeholder="Username" value="<?php if (isset($user)) echo $user;?>">
								<font color='red'>* <span id="error1" class="error"> <?php if (isset($error["username"])) echo $error["username"]; ?> </span><span class="error" id="usernameErr"></span></font>
								</td>
							</tr>
							<tr>
								<td>Password</td>
								<td><input type="password" name="password" placeholder="Password">
								<font color='red'>* <span id="error3" class="error"><?php if (isset($error["password"])) echo $error["password"]; ?> </span><span class="error" id="pwErr"></span></font>
								</td>
							</tr>
							
						</tbody>
					</table>
					<td><a href="forgot.php">Forgot Password</a></td>
		</span>
        </td>
        </tr>
				</tbody>
				</table>
				<br>
				<br>
			&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input type="submit" name="submit" value="Submit" >
		</form>
</div>
</div>
</div>
</div>
</div>
</form>
</div>
</div>
</body>
</html>