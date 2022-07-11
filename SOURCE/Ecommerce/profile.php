<?php
require "config/constants.php";
session_start();
if(!isset($_SESSION["uid"])){
	$location = "location:index.php";
	if(isset($_GET["search"])){
		$location.="?search=1&keyword=".$_GET["keyword"];
	}
	header($location);
}
?>
<!DOCTYPE html>
<html>
	<head>
	<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Ecommerce</title>

		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" href="css/simple-notify.min.css" />
        <script src="js/simple-notify.min.js"></script>
		<script src="https://kit.fontawesome.com/9a62ff02c9.js" crossorigin="anonymous"></script>
		<script src="js/jquery2.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="main.js"></script>
		<style></style>
	</head>
<body>
	<div class="wait overlay">
		<div class="loader"></div>
	</div>

	<header>
		<!-- TOP HEADER -->
		<div id="top-header">
			<div class="container">
				<ul class="header-links pull-left">
					<li><a href="#"><i class="fa fa-phone"></i> 0338806448</a></li>
					<li><a href="#"><i class="fa fa-envelope-o"></i> 19521228@gm.uit.edu.vn</a></li>
					<li><a href="#"><i class="fa fa-map-marker"></i> KTX khu B</a></li>
				</ul>
				<ul class="header-links pull-right dropdown">
					<li class="dropdown-toggle" data-toggle="dropdown">
						<a href="#" ><i class="fa fa-user-o"></i> <?php echo "Hi, ".$_SESSION["name"]; ?></a>
					</li>
					<ul class="dropdown-menu" style="left:0;right: auto" >
						<li style="display: block; margin:0; text-align: center;"><a href="cart.php" style="text-decoration:none; color:black;padding:12px 16px;"><span class="glyphicon glyphicon-shopping-cart"> Cart</a></li>
						<li style="display: block; margin:0; text-align: center;"><a href="customer_order.php" style="text-decoration:none; color:black;padding:12px 16px;border-top: 1px solid;border-bottom: 1px solid;border-color:#e1e1e1;"><span class="glyphicon glyphicon-list-alt"> Orders</a></li>
						<li style="display: block; margin:0; text-align: center;"><a href="logout.php" style="text-decoration:none; color:black;padding:12px 16px;"><span class="glyphicon glyphicon-log-out"> Logout</a></li>
					</ul>
				</ul>
			</div>
		</div>
		<!-- /TOP HEADER -->

		<!-- MAIN HEADER -->
		<div id="header">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row" style="flex-wrap: wrap;display: flex;justify-content: space-between">
					<!-- LOGO -->
					<div class="col-md-3" style="align-self:center;flex-grow: 1;">
						<div class="header-logo">
							<a href="index.php" class="logo">
								<img src="logo/logo_.png" width="250px" style="padding:16px">
							</a>
						</div>
					</div>
					<!-- /LOGO -->

					<!-- SEARCH BAR -->
					<div class="col-md-6" style="align-self:center;flex-grow: 1;">
						<div class="header-search">
							<div>
								<input class="input" placeholder="Search here" id="search">
								<button type="button" class="search-btn" id="search_btn" ><i class="fas fa-search" ></i></button>
							</div>
						</div>
					</div>
					<!-- /SEARCH BAR -->

					<!-- ACCOUNT -->
					<div class="col clearfix" style="align-self:center;flex-grow: 1;">
						<div class="header-ctn">
							<!-- Cart -->
							<div>
								<a id="viewOrder" view=true>
									<i class="fas fa-list"></i>
									<span>Your Order</span>
								</a>
							</div>
							<div class="dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
									<i class="fa fa-shopping-cart"></i>
									<span>Your Cart</span>
									<div class="qty" id="cartNo"></div>
								</a>
								<div class="cart-dropdown" id="cart_product">
									<!-- <div class="cart-list">
										<div class="product-widget">
											<div class="product-img">
												<img src="./img/product02.png" alt="">
											</div>
											<div class="product-body">
												<h3 class="product-name"><a href="#">product name goes here</a></h3>
												<span class="qty" style="display: inline-block;">3x</span><h4 style="display: inline-block;" class="product-price currency">599000</h4>
											</div>
										</div>
									</div>
									<div class="cart-summary">
										<small>3 Item(s) selected</small>
										<h5>SUBTOTAL: $2940.00</h5>
									</div>
									<div class="cart-btns">
										<a href="cart.php">View Cart</a>
									</div> -->
								</div>
							</div>
							<!-- /Cart -->
						</div>
					</div>
					<!-- /ACCOUNT -->
				</div>
				<!-- row -->
			</div>
			<!-- container -->
		</div>
		<!-- /MAIN HEADER -->
	</header>
	</div>
	

	<p><br/></p>
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<!-- ASIDE -->
				<div id="aside" class="col-md-3">
					<!-- aside Widget -->
					<div class="aside">
						<button class="btn aside-btn collapse-btn" data-target="#get_category">
							<h4 style="margin:0;color:#fff" class="aside-title">Categories <i style="font-size: 14px;" class="fas fa-caret-down"></i></h4>
						</button>
						<div class="checkbox-filter collapse" id="get_category">

							
						</div>
					</div>
					<!-- /aside Widget -->
					<!-- aside Widget -->
					<div class="aside">
						<button class="btn aside-btn collapse-btn" data-target="#get_brand">
							<h4 style="margin:0;color:#fff" class="aside-title">Brands <i style="font-size: 14px;" class="fas fa-caret-down"></i></h4>
						</button>
						<div class="checkbox-filter collapse" id="get_brand">
							
						</div>
					</div>
					<!-- /aside Widget -->
				</div>
				<!-- /ASIDE -->

				<!-- STORE -->
				<div id="store" class="col-md-9">
					<!-- store products -->
					<div class="row" id="get_product">
						<!-- product -->
						
					</div>
					<!-- /store products -->

					
				</div>
				<!-- /STORE -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<br>
	<br>
	<br>
	<br>
	<?php include_once("footer.php"); ?>
<?php
	if(isset($_GET["search"])){
		echo '
		<script>
			console.log("search");
			search("'.$_GET["keyword"].'");
		</script>';
	}else{
		echo '
		<script>
			product();
		</script>';
	}
?>
</body>
</html>
















































