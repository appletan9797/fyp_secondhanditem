<body style="background-color: #f6d3ff;">
<link rel="stylesheet" text="text/css" href="success.css">

<div class="conta">
<div class="col-sm-11">
<?php
session_start();
session_destroy();
header("Location:http://localhost/finalFYP/bmainpage/mainpage.php");
?>
