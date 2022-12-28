<html>
<body>
<?php

$servername= "localhost";
$username= "root";
$password= "root";
$database= "users";

$connection= new mysqli ($servername, $username, $password, $database);
if ($connection->connect_error){
die ("Connection failed: " .$connection->connect_error);
}


    $email = mysqli_real_escape_string($connection, $_GET['Email']); // Set email variable
    $hash = mysqli_real_escape_string($connection, $_GET['Verification']); // Set hash variable

$sql = "SELECT * from register WHERE Email= '$email' AND Verification= '$hash' AND Active='0' ";
$result= $connection->query($sql);

if ($result ->num_rows >= 0 ){

$update = "UPDATE register SET Active = '1' WHERE Email='$email' AND Verification='$hash' ";
	if ($connection ->query($update) === TRUE){
		echo "Changed from 0 to 1";
	}
	else{
		echo "Still 0";
	}

}
else{
echo "Invalid URL or account has been activated";
}

?>
</body>
</html>