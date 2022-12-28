<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$criteria = $_POST['searchItem'];
	if ((isset($criteria)) and ($criteria != "")){
	header ("Location:../esearch/navBarSearch.php?id=$criteria&page=1");
	}
}

?>
<?php
include 'connection.php';
?>

<html>
<head>
    <title>mainpage</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" text="text/css" href="bootstrap.min.css">
    <link rel="stylesheet" text="text/css" href="style.css">
    <link rel="stylesheet" text="text/css" href="shop-homepage.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script src="sidebar.js"></script>

</head>
<body style="margin-top:80px">

<div class="container">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>                       
                </button>               
                <a class="navbar-brand" href="http://localhost/finalFYP/bmainpage/mainpage.php"><img src="SecondChance.png" alt="Logo" style="width:170px;height:25px"></a>
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

							echo "<li value='". $row['Options'] ."'><a href='http://localhost/finalFYP/esearch/successSearch.php?id=".$row['Options']."&page=1'>" .$row['OptionsDisplay'] ."</a></li>" ;
		
							}
						}
						?>
                        </ul>   
                    </li>
                </ul>
            </div>

            <div class="collapse navbar-collapse" id="myNavbar">
                <form action="" method="post" class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" name="searchItem" class="form-control" placeholder="Search Item" required>
                    </div>
                    <input type="submit" class="btn btn-default" value="Search">
                </form>
				<!-- or include -->
                <?php include 'navigate.php';?>
            </div>
        </div>
    </nav>

    <div class="row" >
        <div class="col-md-3 sidebar" style="margin-bottom:10px"> 
            <div class="mini-submenu" style="font-weight:bold;text-align:center;cursor:pointer;display:none;border:1px solid rgba(0, 0, 0, 0.9);border-radius:4px;padding:9px;width:auto">
                District Area
            </div>
            <div class="list-group">
                <span href="#" class="list-group-item active" style="width:auto">
                    District Area
                    <span class="pull-right" id="slide-submenu" style="background:rgba(0, 0, 0, 0.45);display:inline-block;padding:0 8px;border-radius:4px;cursor:pointer">
                        <i class="fa fa-times"></i>
                    </span>
                </span>
                <a href="http://localhost/finalFYP/esearch/place.php?id=JohorBahru&page=1" class="list-group-item">Johor Bahru</a>
                <a  class="list-group-item" href="http://localhost/finalFYP/esearch/place.php?id=Kulai&page=1">Kulai Jaya</a>
                <a class="list-group-item" href="http://localhost/finalFYP/esearch/place.php?id=KotaTinggi&page=1">Kota Tinggi</a>
                <a  class="list-group-item" href="http://localhost/finalFYP/esearch/place.php?id=Kluang&page=1">Kluang</a>
                <a class="list-group-item" href="http://localhost/finalFYP/esearch/place.php?id=Mersing&page=1">Mersing<span class="badge">3</span></a>
                <a  class="list-group-item" href="http://localhost/finalFYP/esearch/place.php?id=Pontian&page=1">Pontian</a>
                <a  class="list-group-item" href="http://localhost/finalFYP/esearch/place.php?id=BatuPahat&page=1">Batu Pahat</a>
                <a  class="list-group-item" href="http://localhost/finalFYP/esearch/place.php?id=Segamat&page=1">Segamat</a>
                <a class="list-group-item" href="http://localhost/finalFYP/esearch/place.php?id=Muar&page=1">Muar</a>
                <a class="list-group-item" href="http://localhost/finalFYP/esearch/place.php?d=Tangkak&page=1">Tangkak</a>
            </div>        
        </div>

        <div class="col-md-9" style="margin-top:80">
            <div class="row carousel-holder">
                <div class="col-xs-12">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner" style="width=600px">
                            <div class="item active">
                                <img class="slide-image" src="image/chevolet.jpg" alt="2004 Chevrolet Impala 4dr Sedan">
                            </div>
                            <div class="item">
                                <img class="slide-image" src="image/furniture.jpg" alt="">
                            </div>
                            <div class="item">
                                <img class="slide-image" src="image/menfashion.png" alt="">
                            </div>
                        </div>
                        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    </div>
                </div>
            </div>

            <div><a href="#">Men's Fashion</a></div>
			 <?php $sql="SELECT * from testing WHERE ItemCategory='MensFashion' LIMIT 4";
                                                   $data=$connection->query($sql);
												   if ($data -> num_rows>0){
													   while ($row = $data->fetch_assoc()){
													$id= $row['ID'];
                                                   $name=$row['ItemName'];
												   $description = $row['ItemDescription'];
												   $price=$row['SellingPrice'];
												   $postId= $row['ID'];
												   
					$selectImage = "SELECT * FROM itempicture WHERE	PostID= '$postId' LIMIT 1";
					$data1=$connection->query($selectImage);
												   if ($data1 -> num_rows>0){
													   while ($row = $data1->fetch_assoc()){
														   $image= $row['Picture1'];
													   }
												   }													   
											   ?> 
											   
               
                    <div class="col-xs-6 col-sm-3">
                        <div class='panel panel-default'>
						<div class='panel-body'>
                            <img class="image" src=<?php echo $image;?> alt="images">
                            <div class="caption">
                                
                                <?php 
                                                   echo "<a href='http://localhost/finalFYP/fitemDetail/itemDetail.php?productid=".$id."'>" .$name. "</a>";
						
											   ?>      
                                
                                <p> <?php echo $description;?></p>
                          <p><?php echo "RM".$price ?></p>  </div>
                        </div></div>
                    </div>

                    <?php   }
												   }?>
          
				

            <div><a href="#">Women's Fashion</a></div>
					   
                <div class="row" class="col-xs-12 col-sm-9">
                    <div class="col-xs-6 col-sm-3">
                        <div class="thumbnail">
                            <img src="http://placehold.it/320x150" alt="">
                            <div class="caption">
                                <h4 class="pull-right">$84.99</h4>
                                <h4><a href="#">Fourth Product</a>
                                </h4>
                                <p>This is a short description. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>
                        </div>
                    </div>

            
                </div>
            </div>
    </div>
</div>

<footer>
    <div class="container text-center">
        <div class="col-xs-12 col-md-12" style="font-size:13px">
            <a href="#"><span class="label label-info">About Us</span></a> |
            <a href="#"><span class="label label-info">Rule</span></a> |
            <a href="#"><span class="label label-info">Shop Safely</span></a> |
            <a href="#"><span class="label label-info">Contact Us</span></a> |
            <a href="#"><span class="label label-info">Term</span></a> |
            <a href="#"><span class="label label-info">FAQ</span></a> |
            <a href="#"><span class="label label-info">Rule</span></a> |
            <a href=""><i class="fa fa-facebook-square fa-3x" id="social"></i></a> |
	        <a href=""><i class="fa fa-instagram fa-3x" id="social"></i></a>
            <p>© 2017 Second Chance.<p>
       </div>
    </div>


</footer>

</body>        
</html>