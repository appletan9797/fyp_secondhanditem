<?php
include 'connection.php';

if(isset($_POST['email']) && !empty($_POST['email'])){
	$email = mysqli_real_escape_string($connection, $_POST['email']);
	$sql = "SELECT * FROM register WHERE Email = '$email'";
	$result = $connection->query($sql);
	if ($result->num_rows == 1){
		while ($row = $result->fetch_assoc()){
				$hash= $row['Verification'];
				$to = $email;
				$subject = "Reset Password";
				$message = "

				Click on the link to reset your password: 
				http://localhost/project/reset.php?Email=$email&Verification=$hash

				";

				$headers = 'From: rainnie970625@gmail.com'. "\r\n";
				mail ($to, $subject, $message, $headers);
				header("Location:resetpwsuccess.php");
		}
	}
	else{
		echo "Email Not found";
	}
    


	
}
 
 
?>

<html>
<head>
	<title>Forgot Password</title>

</head>
<body>
<div class="container">
      <?php if(isset($smsg)){ ?><div class="alert alert-success" role="alert"> <?php echo $smsg; ?> </div><?php } ?>
      <?php if(isset($fmsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $fmsg; ?> </div><?php } ?>
      <form class="form-signin" method="POST">
        <h2 class="form-signin-heading">Forgot Password</h2>
        <div class="input-group">
		  
		  <input type="text" name="email" class="form-control" placeholder="Email" required>
		</div>
		<br>
		<br>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Forgot Password</button>
      </form>
</div>
</body>
</html>