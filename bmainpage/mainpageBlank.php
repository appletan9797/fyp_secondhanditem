<?php
if (isset($_POST['searching'])){
	$criteria = $_POST['searchItem'];
	if ((isset($criteria)) and ($criteria != "")){
		header ("Location:../esearch/navBarSearch.php?id=$criteria&page=1");
	}
}
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" text="text/css" href="http://localhost/finalFYP/bmainpage/bootstrap.min.css">
    <link rel="stylesheet" text="text/css" href="style.css">
    <link rel="stylesheet" text="text/css" href="shop-homepage.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <script src="http://localhost/finalFYP/bmainpage/jquery.min.js"></script>
    <script src="http://localhost/finalFYP/bmainpage/bootstrap.min.js"></script>
    <script src="sidebar.js"></script>
</head>
<body style="margin-top:80px;">
<div class="container">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container-fluid"> <!-- add fluid to prevent the navigation bar from enlarging-->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>                       
                </button>               
                <a class="navbar-brand" href="http://localhost/finalFYP/bmainpage/mainpage.php"><img src="http://localhost/finalFYP/bmainpage/SecondChance.png" alt="Logo" style="width:170px;height:25px"></a>
                <ul class="btn navbar-btn" style="box-shadow:none"><style>.dropdown-toggle:hover{text-decoration:none;}</style>
                    <li class="dropdown" style="list-style-type:none;margin:0;padding:0">   
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Categories<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                      <?php
						include 'Connection.php' ;

						$sql= "SELECT * FROM categoryoptions WHERE CategoryID=1";
						$request= $connection->query($sql);
						if ($request-> num_rows>0){
							while ($row= $request->fetch_assoc()){
							echo "<li value='". $row['Options'] ."'><a href='../esearch/successSearch.php?id=".$row['Options']."&page=1'>" .$row['OptionsDisplay'] ."</a></li>" ;
							}
						}
						?>
                        </ul>   
                    </li>
                </ul>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <form method="post" action="" class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" name="searchItem" class="form-control" placeholder="Search Item" required>
                    </div>
                    <input type="submit" name="searching" class="btn btn-default" value="Search">
                </form>
                <?php include 'navigate.php';?>
            </div>
        </div>
    </nav>
</div>
</body>        
</html>