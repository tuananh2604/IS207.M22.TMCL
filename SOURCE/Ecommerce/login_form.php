<?php
session_start();
if (isset($_SESSION["uid"])) {
	header("location:profile.php");
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
						<a href="#" ><i class="fa fa-user-o"></i> Please Login</a>
					</li>
					<!-- <ul class="dropdown-menu" style="padding: 0;">
						<div class="panel panel-default" style="width: 300px;margin:0;">
							<div class="panel-heading">
								<h3 class="panel-title">Please sign in</h3>
							</div>
							<div class="panel-body">
								<form accept-charset="UTF-8" role="form" onsubmit="return false" id="login">
									<fieldset>
										<div class="form-group">
											<input class="form-control" placeholder="E-mail" name="email" type="text" type="email" id="email" required>
										</div>
										<div class="form-group">
											<input class="form-control" placeholder="Password" name="password" value="" type="password" id="password" required>
										</div>
										
										<div style="display:flex;justify-content:center">
											<input class="btn primary-btn" type="submit" value="Login">
										</div>
										<div style="text-align:center;margin-top:16px">
											<a href="customer_registration.php?register=1" style="color:#101010; text-decoration:none;">Or Create Account Now</a>
										</div>
									</fieldset>
								</form>
								<div class="panel-footer" id="e_msg"></div>
							</div>
						</div>
					</ul> -->
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
					<div class="col-md-7" style="align-self:center;flex-grow: 1;">
						<div class="header-search">
							<div>
								<input class="input" placeholder="Search here" id="search">
								<button type="button" class="search-btn" id="search_btn" ><i class="fas fa-search" ></i></button>
							</div>
						</div>
					</div>
					<!-- /SEARCH BAR -->

					<!-- ACCOUNT -->
					<div class="col-md-2 clearfix" style="align-self:center;flex-grow: 1;">
						<div class="header-ctn">
							<!-- Cart -->
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

	<p><br/></p>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8" id="signup_msg">
				<!--Alert from signup form-->
			</div>
			<div class="col-md-2"></div>
		</div>
		<div class="section row" style="display: flex;" >
			<div class="container col-md-4">
				<div class="panel panel-primary" style="border-color: #59371e;">
					<div class="panel-heading text-center" style="background-color: #59371e;"><h4 style="margin: 0; color: #fff"><b>Registration</b></h4></div>
					<div class="panel-body">
					
					<form onsubmit="return false" id="login">
						<label for="email">Email</label>
						<input type="email" class="form-control" name="email" id="email" required/>
						<label for="email">Password</label>
						<input type="password" class="form-control" name="password" id="password" required/>
						<p><br/></p>
						<input type="submit" class="btn" style="float:right;background-color: #d10024; color:#fff" Value="Login" >
						<!--If user dont have an account then he/she will click on create account button-->
						<div><a href="customer_registration.php?register=1">Create a new account?</a></div>		
					</form>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
	<?php include_once("footer.php"); ?>
	
</body>
</html>






















