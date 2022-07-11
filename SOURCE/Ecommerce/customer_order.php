<?php
session_start();
if(!isset($_SESSION["uid"])){
	header("location:index.php");
}
$uid=$_SESSION["uid"];
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Ecommerce</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		
    	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		
		<!-- <script src="main.js"></script> -->
		<link rel="stylesheet" type="text/css" href="style.css"/>
	</head>
<body>
	<div id="breadcrumb" class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<div class="col-md-12">
					<h3 class="breadcrumb-header">Orders</h3>
				</div>
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<div class="section">
			<!-- container -->
			<div class="container">
				<div class="table-responsive">
					<table class="table table-striped table-sm table-bordered " id="orderTable">
						<thead>
							<tr>
								<th></th>
								<th>Time</th>
								<th>Phone</th>
								<th>Address</th>
								<th>Total</th>
								<th>Status</th>
							</tr>
						</thead>
						  <tbody id="customer_order_list">
							<?php
								include "db.php";
								$query = "SELECT * FROM orders o join user_info u on u.user_id=o.user_id Where o.user_id = $uid ORDER BY o.order_id Desc";
								$run_query = mysqli_query($con,$query);
								$orders = [];
								$orders_details=[];
								if (mysqli_num_rows($run_query) > 0) {
									while ($row = mysqli_fetch_array($run_query)) {
										$orders[] = $row;
									}
									foreach ($orders as $order){
										$o_id=$order["order_id"];
										$order_details=[];
										$query = "SELECT * FROM order_details od join products p on od.p_id=p.product_id where od.o_id = $o_id";
										$run_query = mysqli_query($con,$query);
										if (mysqli_num_rows($run_query) > 0) {
											while ($row = mysqli_fetch_array($run_query)) {
												$order_details[] = $row;
											}
										}
										$orders_details[]=$order_details;
									}
								}
								echo '<script>console.log('.json_encode($orders).','.json_encode($orders_details).')</script>';
								for($i=0;$i<count($orders);$i++){
									$order = $orders[$i];
									echo '<script>console.log('.json_encode($order).')</script>';
									$order_details = $orders_details[$i];
									echo '
									<tr>
										<td><button class="btn btn-primary collapse-btn" type="button" data-target="#'.$order["order_id"].'"">+</button></td>
										<td>'.$order["order_date"].'</td>
										<td>'.$order["order_mobile"].'</td>
										<td>'.$order["order_address"].'</td>
										<td>'.number_format(($order["total"]), 0)."₫".'</td>
										<td status = "'.$order["status"].'"><b>'.$order["status"].'</b></td>
									</tr>
									<tr>
										<td colspan="100%">
											<div class="collapse" id="'.$order["order_id"].'">
												<div class="card card-body">
													<div class="row">
														<div class="col shadow" style="background-color: #f3f3f3;margin: 0 12px; border-radius:4px;">
															<h3 style="margin:16px 0">Order infomation</h3>
															<br>
															<div class="row">
																<div class="col-md-12">
																	<div class="d-flex">
																		<p style="flex:3;">Full Name:</p>
																		<p style="flex:6"><b>'.$order["first_name"].' '.$order["last_name"].'</b></p>
																	</div>
																	<div class="d-flex">
																		<p style="flex:3;">Number:</p>
																		<p style="flex:6"><b>'.$order["order_mobile"].'</b></p>
																	</div>
																	<div class="d-flex">
																		<p style="flex:3;">Address:</p>
																		<p style="flex:6"><b>'.$order["order_address"].'</b></p>
																	</div>
																	<div class="d-flex">
																		<p style="flex:3;">Email:</p>
																		<p style="flex:6"><b>'.$order["email"].'</b></p>
																	</div>
																	<div class="d-flex">
																		<p style="flex:3;">Payment:</p>
																		<p style="flex:6"><b>'.$order["payment"].'</b></p>
																	</div>
																	<div class="d-flex">
																		<p style="flex:3;">Shiping:</p>
																		<p style="flex:6"><b>'.$order["shiping"].'</b></p>
																	</div>
																	<div class="d-flex">
																		<p style="flex:3;">Total:</p>
																		<h3 style="flex:6"><b>'.number_format($order["total"], 0)."₫".'</b></h3>
																	</div>
																	<div class="d-flex">
																		<p style="flex:3;">Note:</p>
																		<p style="flex:6"><b>'.$order["note"].'</b></p>
																	</div>
																	
																</div>
																
															</div>
														</div>
														<div class="col" style="margin: 0 12px">
															<h3>Details</h3>
															<table class="table table-striped table-sm">
																<thead>
																	<tr>
																		<th></th>
																		<th>Product Name</th>
																		<th>Price</th>
																		<th>Quantity</th>
																		<th>Total</th>
																	</tr>
																</thead>
																<tbody>';
																for($j=0;$j<count($order_details);$j++){	
																	$order_detail = $order_details[$j];
																	echo '
																	<tr>
																		<td style="width:10%">
																			<a href="product_detail.php?p_id='.$order_detail["p_id"].'">
																				<img width="60px" height="60px" src="product_images/'.$order_detail["product_image"].'">
																			</a>
																		</td>
																		<td style="width:40%">
																			<a href="product_detail.php?p_id='.$order_detail["p_id"].'">
																				'.$order_detail["product_title"].'
																			</a>
																		</td>
																		<td style="width:20%">
																			'.number_format($order_detail["product_price"], 0)."₫".'
																		</td>
																		<td style="width:10%">
																			x'.$order_detail["od_qty"].'
																		</td>
																		<td style="width:20%">
																			'.number_format($order_detail["product_price"]*$order_detail["od_qty"], 0)."₫".'
																		</td>
																	</tr>';
																}
															echo'
																</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
										</td>
									</tr>';
								}
							?>
						</tbody> 
					</table>
				</div>
			</div>
	</div>


	<script>
		$('.collapse-btn').click(function(){
			console.log('a');
			var target = $(this).attr('data-target');
			$(target).collapse('toggle');
		});
	</script>
</body>
</html>
















































