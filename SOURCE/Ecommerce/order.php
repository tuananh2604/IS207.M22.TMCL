<?php
session_start();
if(!isset($_SESSION["uid"])){
	header("location:index.php");
}

if (isset($_POST["order"])) {
    $uid=$_SESSION["uid"];
    include_once("db.php");
    $sql = "SELECT * FROM cart WHERE user_id = '$uid'";
    $query = mysqli_query($con,$sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row=mysqli_fetch_array($query)) {
            $product_id[] = $row["p_id"];
            $qty[] = $row["qty"];
        }
    }
    $product_id_string = implode(",",$product_id);
    $getPriceString="SELECT * FROM products WHERE product_id in (".$product_id_string.") ORDER BY FIELD (product_id,".$product_id_string.")";
    $getPrice=mysqli_query($con,$getPriceString);
    if (mysqli_num_rows($getPrice) > 0) {
        while ($pr=mysqli_fetch_array($getPrice)) {
            $titles[] = $pr["product_title"];
            $prices[] = $pr["product_price"];
            $remain_qty[] = $pr["product_qty"];
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Electro - HTML Ecommerce Template</title>

 		<!-- Google font -->
 		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

 		<!-- Bootstrap -->
 		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>
 		<!-- Font Awesome Icon -->
 		<link rel="stylesheet" href="css/font-awesome.min.css">

 		<!-- Custom stlylesheet -->
 		<link type="text/css" rel="stylesheet" href="style.css"/>


    </head>
	<body>
		
		<!-- BREADCRUMB -->
		<div id="breadcrumb" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<h3 class="breadcrumb-header">Checkout</h3>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /BREADCRUMB -->

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<form action="order_process.php" method="POST">
						<div class="col-md-7">
							<!-- Billing Details -->
							<div class="billing-details">
								<div class="section-title">
									<h3 class="title">Billing Detail</h3>
								</div>
								<?php
									$userSql = "SELECT * FROM user_info WHERE user_id = $uid";
									$userQuery = mysqli_query($con,$userSql);
									if (mysqli_num_rows($userQuery) > 0) {
										$user=mysqli_fetch_array($userQuery) ;
										echo '
										<div class="form-group">
											<input class="form-control input" type="text" name="first-name" placeholder="First Name" value="'.$user["first_name"].'" readonly required>
										</div>
										<div class="form-group">
											<input class="form-control input" type="text" name="last-name" placeholder="Last Name" value="'.$user["last_name"].'" readonly required>
										</div>
										<div class="form-group">
											<input class="form-control input" type="email" name="email" placeholder="Email" value="'.$user["email"].'" readonly required>
										</div>
										<div class="form-group">
											<input class="form-control input" type="text" name="address" placeholder="Address" value="'.$user["address1"].'" required>
										</div>
										<div class="form-group">
											<input class="form-control input" type="tel" name="tel" placeholder="Telephone" value="'.$user["mobile"].'" required>
										</div>';
									}
								?>
							</div>
							<!-- /Billing Details -->
	
	
							<!-- Order notes -->
							<div class="order-notes">
								<textarea class="input" name="note" placeholder="Order Notes"></textarea>
							</div>
							<!-- /Order notes -->
						</div>
	
						<!-- Order Details -->
						<div class="col-md-5 order-details">
							<div class="section-title text-center">
								<h3 class="title">Your Order</h3>
							</div>
							<div class="order-summary">
								<div class="order-col">
									<div><strong>PRODUCT</strong></div>
									<div><strong>TOTAL</strong></div>
								</div>
								<div class="order-products">
									<?php
										$order_total=0;
										for ($i=0; $i < count($product_id); $i++){
											echo '
											<div class="order-col">
											<div><span><strong>'.$qty[$i].' x </strong></span>'.$titles[$i].'</div>
											<div>'.number_format($prices[$i]*$qty[$i], 0)."₫".'</div>
											</div>';
											$order_total+=$prices[$i]*$qty[$i];
										}
									?>
									<!-- <div class="order-col">
										<div><span><strong>1x</strong></span> Product Name Goes Here</div>
										<div>$980.00</div>
									</div> -->
								</div>
								<div class="order-col">
									<div>Shiping</div>
									<div><strong><?php  $order_total+=shiping; echo number_format(shiping, 0)."₫" ?></strong></div>
								</div>
								<div class="order-col">
									<div><strong>TOTAL</strong></div>
									<div><strong class="order-total"><?php echo number_format($order_total, 0)."₫" ?></strong></div>
								</div>
							</div>
							<div class="payment-method">
								<div class="input-radio">
									<input type="radio" name="payment" id="payment-1" value="cod" checked>
									<label for="payment-1">
										<span></span>
										Cash on delivery
									</label>
									<div class="caption">
										<p>Thanh toán sau khi nhận và kiểm tra hàng.</p>
									</div>
								</div>
								<div class="input-radio">
									<input type="radio" name="payment" id="payment-2" disabled>
									<label for="payment-2">
										<span></span>
										Bank transfer (temporately disable)
									</label>
									<div class="caption">
										<p></p>
									</div>
								</div>
								<div class="input-radio">
									<input type="radio" name="payment" id="payment-3" disabled>
									<label for="payment-3">
										<span></span>
										Momo (temporately disable)
									</label>
									<div class="caption">
										<p></p>
									</div>
								</div>
							</div>
							<input type="hidden" name="process_order" value="1">
							<input type="hidden" name="uid" value="<?php echo $uid ?>">
							<input type="hidden" name="shiping" value="<?php echo shiping ?>">
							<input type="hidden" name="total_order" value="<?php echo $order_total ?>">
							<button type="submit" class="primary-btn order-submit">Place order</button>
						</div>
						<!-- /Order Details -->
					</form>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->
	</body>
</html>


<?php
}
?>

















































