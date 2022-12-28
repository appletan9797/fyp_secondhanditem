<!DOCTYPE html>

<?php
include 'connection.php';
?>

<html>
<head>
    <title>mainpage</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" text="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" text="text/css" href="css/style.css">
    <link rel="stylesheet" text="text/css" href="css/shop-homepage.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/sidebar.js"></script>

</head>
<body>

<div class="container">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>                       
                </button>               
                <a class="navbar-brand" href="#"><img src="image/SecondChance.png" alt="Logo" style="width:170px;height:25px"></a>
                <ul class="btn navbar-btn" style="box-shadow:none"><style>.dropdown-toggle:hover{text-decoration:none;}</style>
                    <li class="dropdown" style="list-style-type:none;margin:0;padding:0">   
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Categories<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Men's Fashion</a></li>
                            <li><a href="#">Women's Fashion</a></li>
                            <li><a href="#">Furniture & Home</a></li>
                            <li><a href="#">Electronics & Gadgets</a></li>
                            <li><a href="#">Cars & Motorbikes</a></li>
                            <li><a href="#">Health & Beauty</a></li>
                            <li><a href="#">Books & Stationery</a></li>
                            <li><a href="#">Others</a></li>
                        </ul>   
                    </li>
                </ul>
            </div>

            <div class="collapse navbar-collapse" id="myNavbar">
                <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search Item">
                    </div>
                    <button type="submit" class="btn btn-default">Search</button>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#"><span class="glyphicon glyphicon-tag"></span> Sell</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Log In</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="row">
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
                <a href="#" class="list-group-item" href="#">Johor Bahru</a>
                <a href="#" class="list-group-item" href="#">Kulai Jaya</a>
                <a href="#" class="list-group-item" href="#">Kota Tinggi</a>
                <a href="#" class="list-group-item" href="#">Kluang</a>
                <a href="#" class="list-group-item" href="#">Mersing<span class="badge">14</span></a>
                <a href="#" class="list-group-item" href="#">Pontian</a>
                <a href="#" class="list-group-item" href="#">Batu Pahat</a>
                <a href="#" class="list-group-item" href="#">Segamat</a>
                <a href="#" class="list-group-item" href="#">Muar</a>
                <a href="#" class="list-group-item" href="#">Ledang</a>
            </div>        
        </div>

        <div class="col-md-9">
            
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