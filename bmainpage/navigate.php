<?php include 'function.php';?>
<ul class="nav navbar-nav navbar-right">
<?php
if (loggedIn()){
	$active= getValue("Active");
	if ($active == 1){
		$page= "normal.php";
?>
<li><a href="http://localhost/finalFYP/cuploaditem/upload.php"><span class="glyphicon glyphicon-tag"></span> Sell</a></li>
<?php 
}
else{
?>
<li><a href="http://localhost/finalFYP/bmainpage/normal.php"><span class="glyphicon glyphicon-tag"></span> Sell</a></li>
<?php
}
?>
<?php
if (getValue("Role") == "Admin"){
?>
<li><a href = "admin.php"><span class="glyphicon glyphicon-tag"></span> Admin Panel </a></li>
<?php
}
?>
<li><a href = "http://localhost/finalFYP/aloginRegister/logout.php"> <span class="glyphicon glyphicon-log-in"></span> Log Out</a></li>
<?php
}
else{
	?>
                    <li><a href="http://localhost/finalFYP/aloginRegister/register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                    <li><a href="../aloginRegister/login.php"><span class="glyphicon glyphicon-log-in"></span> Log In</a></li>
                </ul>			
	<?php
}
?>
</ul>