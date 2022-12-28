<html>
<head>
<title> Account </title>
</head>
<body>

<?php
include 'navigation.php';
require 'connection.php';
require_once 'function.php';
?>

<?php

if (!loggedIn()){
	//header ("location:login.php");
}
?>

<h1>
<?php
echo getValue("UserName");
?>
</h1>

</body>
</html>