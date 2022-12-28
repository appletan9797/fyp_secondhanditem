<html>
<head>
<title>Reset Password</title>
</head>
<body>
<link rel="stylesheet" text="text/css" href="success.css">

<div class="conta">
<div class="col-sm-11">

<?php

include 'connection.php';
echo file_get_contents("http://localhost/finalFYP/bmainpage/mainpageBlank.php");

if (isset($_POST['password'])){
  $pw = $_POST['password'];


if (isset($_POST['confirmPW'])){
  $rePW = $_POST['confirmPW'];


$email = $_GET['Email'];
if ( $pw == $rePW ) {
  $sql = "UPDATE register set Password = '$pw', confirmPW = '$rePW' WHERE Email = '$email' ";

}
if ($connection->query($sql) === TRUE) {
    header('Location:return.php');
} else {
    echo "Error updating record: " . $connection->error;
}
}
}

?>

<div class="container">

      <form class="form-signin" method="POST">
        <h2 class="form-signin-heading"> Password </h2>
        <div class="input-group">
		  
		  <input type="text" name="password" class="form-control" placeholder="Password" required>
		</div>
    <h2 class="form-signin-heading"> Confirm Password </h2>
        <div class="input-group">
      
      <input type="text" name="confirmPW" class="form-control" placeholder="Confirm Password" required>
    </div>
		<br>
		<br>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
      </form>
</div>
</div>
</div>
</body>
</html>