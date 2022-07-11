<?php
//currency_format number_format($product_price, 0)."₫"
session_start();
function RandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function getIP() {
	if(!isset($_COOKIE["identity"])){
		$identity = RandomString() ;
		setcookie("identity", $identity, time() + (86400 * 7), "/");
	}else{
		$identity=$_COOKIE["identity"];
	}
	return $identity;
}
$ip_add = getIP();
include "db.php";
if(isset($_POST["category"])){
	$category_query = "SELECT * FROM categories";
	$run_query = mysqli_query($con,$category_query) or die(mysqli_error($con));
	
	if(mysqli_num_rows($run_query) > 0){
		while($row = mysqli_fetch_array($run_query)){
			$cid = $row["cat_id"];
			$cat_name = $row["cat_title"];
			echo '
			<div class="input-checkbox">
				<input class="filterCheckbox" type="checkbox" id="c'.$cid.'" cid="'.$cid.'">
				<label for="c'.$cid.'">
					<span></span>
					'.$cat_name.'
				</label>
			</div>';
		}
	}
}
if(isset($_POST["brand"])){
	$brand_query = "SELECT * FROM brands";
	$run_query = mysqli_query($con,$brand_query);
	
	if(mysqli_num_rows($run_query) > 0){
		while($row = mysqli_fetch_array($run_query)){
			$bid = $row["brand_id"];
			$brand_name = $row["brand_title"];
			echo '
			<div class="input-checkbox">
				<input class="filterCheckbox" type="checkbox" id="b'.$bid.'" bid="'.$bid.'">
				<label for="b'.$bid.'">
					<span></span>
					'.$brand_name.'
				</label>
			</div>';
		}
	}
}
if(isset($_POST["page"])){
	$sql = "SELECT * FROM products";
	$run_query = mysqli_query($con,$sql);
	$count = mysqli_num_rows($run_query);
	$pageno = ceil($count/9);
	for($i=1;$i<=$pageno;$i++){
		echo "
			<li><a href='#' page='$i' id='page'>$i</a></li>
		";
	}
}
if(isset($_POST["getProduct"])){
	$limit = 99999;
	if(isset($_POST["setPage"])){
		$pageno = $_POST["pageNumber"];
		$start = ($pageno * $limit) - $limit;
	}else{
		$start = 0;
	}
	$product_query = "SELECT * FROM products p JOIN categories c ON p.product_cat = c.cat_id Order By product_id DESC";
	$run_query = mysqli_query($con,$product_query);
	if(mysqli_num_rows($run_query) > 0){
		while($row = mysqli_fetch_array($run_query)){
			$pro_qty    = $row['product_qty'];
			$pro_rate    = $row['product_rate'];
			$pro_id    = $row['product_id'];
			$pro_cat   = $row['cat_title'];
			$pro_brand = $row['product_brand'];
			$pro_title = $row['product_title'];
			$pro_price = $row['product_price'];
			$pro_oriprice = $row['product_oriprice'];
			$pro_image = $row['product_image'];
			$sale=0;
			if(($pro_oriprice!=0)&($pro_oriprice!=$pro_price)){
				$sale = round((1-($pro_price/$pro_oriprice))*100,0);
			}
			$rate = round($pro_rate * 2) / 2;
			$rateHtml="";
			for($i=1;$i<=5;$i++){
				if($i<=$rate){
					$rateHtml.='<i class="fa fa-star"></i>  ';
				}else if(($i-$rate)==0.5){
					$rateHtml.='<i class="fas fa-star-half-alt"></i>  ';
				}else if(($i-$rate)==0){
					$rateHtml.='<i class="fa fa-star-o"></i>  ';
				}else{
					$rateHtml.='<i class="fa fa-star-o"></i>  ';
				}
			}
			if($pro_qty<=0){
				$proHtml ='
				<div class="col-md-4 col-xs-6">
					<div class="product">
						<div class="product-img">
							<a href="product_detail.php?p_id='.$pro_id.'">
								<img class="gray"  src="product_images/'.$pro_image.'" alt="">
							</a>
							<div class="product-label">';

				if($sale!=0){
					$proHtml.='<span class="sale">'.$sale.'% OFF</span>';
				}
				$proHtml.=
								'<span class="soldout">Sold Out</span>
							</div>
						</div>
						<div class="product-body">
							<p class="product-category">'.$pro_cat.'</p>
							<div style="height:40px;">
								<h3 class="product-name lines-2"><a href="product_detail.php?p_id='.$pro_id.'">'.$pro_title.'</a></h3>
							</div>
							<h4 class="product-price">'.number_format($pro_price, 0)."₫".' <del class="product-old-price">'.number_format($pro_oriprice, 0)."₫".'</del></h4>
							<div class="product-rating">
								'.$rateHtml.'
							</div>
							
						</div>
						
					</div>
				</div>';
				echo $proHtml;
			}else if($sale!=0){
				echo'
				<div class="col-md-4 col-xs-6">
					<div class="product">
						<div class="product-img">
							<a href="product_detail.php?p_id='.$pro_id.'">
								<img src="product_images/'.$pro_image.'" alt="">
							</a>
							<div class="product-label">
								<span class="sale">'.$sale.'% OFF</span>
							</div>
						</div>
						<div class="product-body">
							<p class="product-category">'.$pro_cat.'</p>
							<div style="height:40px;">
								<h3 class="product-name lines-2"><a href="product_detail.php?p_id='.$pro_id.'">'.$pro_title.'</a></h3>
							</div>
							<h4 class="product-price">'.number_format($pro_price, 0)."₫".' <del class="product-old-price">'.number_format($pro_oriprice, 0)."₫".'</del></h4>
							<div class="product-rating">
								'.$rateHtml.'
							</div>
							
						</div>
						<div class="add-to-cart">
							<button class="add-to-cart-btn" pid='.$pro_id.' id="product"><i class="fa fa-shopping-cart"></i> add to cart</button>
						</div>
					</div>
				</div>';
			}else{
				echo '
				<div class="col-md-4 col-xs-6">
					<div class="product" pid='.$pro_id.'>
						<div class="product-img">
							<a href="product_detail.php?p_id='.$pro_id.'">
								<img src="product_images/'.$pro_image.'" alt="">
							</a>
						</div>
						<div class="product-body">
							<p class="product-category">'.$pro_cat.'</p>
							<div style="height:40px;">
								<h3 class="product-name lines-2"><a href="product_detail.php?p_id='.$pro_id.'">'.$pro_title.'</a></h3>
							</div>
							<h4 class="product-price">'.number_format($pro_price, 0)."₫".'</h4>
							<div class="product-rating">
								'.$rateHtml.'
							</div>
							
						</div>
						<div class="add-to-cart">
							<button class="add-to-cart-btn" pid='.$pro_id.' id="product"><i class="fa fa-shopping-cart"></i> add to cart</button>
						</div>
					</div>
				</div>';
			}
			
		}
	}
}
if(isset($_POST["selectFilter"]) || isset($_POST["search"])){

	if(isset($_POST["selectFilter"])){
		$cid = json_decode(stripslashes($_POST["Filter"]["category"]));
		$bid = json_decode(stripslashes($_POST["Filter"]["brand"]));
		$sql = "SELECT * FROM products p JOIN categories c ON p.product_cat = c.cat_id WHERE ";
		if(empty($cid) && empty($bid)){
			$sql.="true";
		}else{
			if(!empty($cid)){
				$sql.="product_cat in ".'('.implode(",",$cid).')'."";
			}
			if( !empty($cid) && !empty($bid) ){
				$sql.=" and ";
			}
			if(!empty($bid)){
				$sql.="product_brand in ".'('.implode(",",$bid).')'." Order By product_id DESC";
			}
		} 
		// echo $sql;
	}
	else {
		$keyword = $_POST["keyword"];
		$sql = "SELECT * FROM products p JOIN categories c ON p.product_cat = c.cat_id WHERE product_keywords LIKE '%$keyword%'  or product_title LIKE '%$keyword%' or product_desc LIKE '%$keyword%' Order By product_id DESC";
	}
	
	$run_query = mysqli_query($con,$sql);
	if(mysqli_num_rows($run_query) > 0){
		if(isset($keyword)){
			echo '<h4>Show '.mysqli_num_rows($run_query).' search result(s) for: "'.$keyword.'" </h4>';
		}
		while($row=mysqli_fetch_array($run_query)){
			$pro_qty    = $row['product_qty'];
				
			$pro_id    = $row['product_id'];
			$pro_cat   = $row['cat_title'];
			$pro_brand = $row['product_brand'];
			$pro_title = $row['product_title'];
			$pro_price = $row['product_price'];
			$pro_oriprice = $row['product_oriprice'];
			$pro_image = $row['product_image'];
			$pro_rate = $row["product_rate"];
			$sale=0;
			if(($pro_oriprice!=0)&($pro_oriprice!=$pro_price)){
				$sale = round((1-($pro_price/$pro_oriprice))*100,0);
			}
			$rate = round($pro_rate * 2) / 2;
			$rateHtml="";
			for($i=1;$i<=5;$i++){
				if($i<=$rate){
					$rateHtml.='<i class="fa fa-star"></i>  ';
				}else if(($i-$rate)==0.5){
					$rateHtml.='<i class="fas fa-star-half-alt"></i>  ';
				}else if(($i-$rate)==0){
					$rateHtml.='<i class="fa fa-star-o"></i>  ';
				}else{
					$rateHtml.='<i class="fa fa-star-o"></i>  ';
				}
			}
			if($pro_qty<=0){
				$proHtml ='
				<div class="col-md-4 col-xs-6">
					<div class="product">
						<div class="product-img">
							<a href="product_detail.php?p_id='.$pro_id.'">
								<img class="gray"  src="product_images/'.$pro_image.'" alt="">
							</a>
							<div class="product-label">';

				if($sale!=0){
					$proHtml.='<span class="sale">'.$sale.'% OFF</span>';
				}
				$proHtml.=
								'<span class="soldout">Sold Out</span>
							</div>
						</div>
						<div class="product-body">
							<p class="product-category">'.$pro_cat.'</p>
							<div style="height:40px;">
								<h3 class="product-name lines-2"><a href="product_detail.php?p_id='.$pro_id.'">'.$pro_title.'</a></h3>
							</div>
							<h4 class="product-price">'.number_format($pro_price, 0)."₫".' <del class="product-old-price">'.number_format($pro_oriprice, 0)."₫".'</del></h4>
							<div class="product-rating">
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fas fa-star-half-alt"></i>
								<i class="fa fa-star-o"></i>
							</div>
							
						</div>
						
					</div>
				</div>';
				echo $proHtml;
			}else if($sale!=0){
				echo'
				<div class="col-md-4 col-xs-6">
					<div class="product">
						<div class="product-img">
							<a href="product_detail.php?p_id='.$pro_id.'">
								<img src="product_images/'.$pro_image.'" alt="">
							</a>
							<div class="product-label">
								<span class="sale">'.$sale.'% OFF</span>
							</div>
						</div>
						<div class="product-body">
							<p class="product-category">'.$pro_cat.'</p>
							<div style="height:40px;">
								<h3 class="product-name lines-2"><a href="product_detail.php?p_id='.$pro_id.'">'.$pro_title.'</a></h3>
							</div>
							<h4 class="product-price">'.number_format($pro_price, 0)."₫".' <del class="product-old-price">'.number_format($pro_oriprice, 0)."₫".'</del></h4>
							<div class="product-rating">
								'.$rateHtml.'
							</div>
							
						</div>
						<div class="add-to-cart">
							<button class="add-to-cart-btn" pid='.$pro_id.' id="product"><i class="fa fa-shopping-cart"></i> add to cart</button>
						</div>
					</div>
				</div>';
			}else{
				echo '
				<div class="col-md-4 col-xs-6">
					<div class="product" pid='.$pro_id.'>
						<div class="product-img">
						<a href="product_detail.php?p_id='.$pro_id.'">
							<img src="product_images/'.$pro_image.'" alt="">
						</a>
						</div>
						<div class="product-body">
							<p class="product-category">'.$pro_cat.'</p>
							<div style="height:40px;">
								<h3 class="product-name lines-2"><a href="product_detail.php?p_id='.$pro_id.'">'.$pro_title.'</a></h3>
							</div>
							<h4 class="product-price">'.number_format($pro_price, 0)."₫".'</h4>
							<div class="product-rating">
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fas fa-star-half-alt"></i>
								<i class="fa fa-star-o"></i>
							</div>
							
						</div>
						<div class="add-to-cart">
							<button class="add-to-cart-btn" pid='.$pro_id.' id="product"><i class="fa fa-shopping-cart"></i> add to cart</button>
						</div>
					</div>
				</div>';
			}
		}
	}else if(isset($keyword)){
		echo '<h4>Show 0 search result(s) for: "'.$keyword.'" </h4>';
	}
	
}
	


if(isset($_POST["addToCart"])){
	

	$p_id = $_POST["proId"];
	
	if(isset($_POST["qty"])){
		$qty=$_POST["qty"];
	}else{
		$qty=1;
	}

	if(isset($_SESSION["uid"])){

		$user_id = $_SESSION["uid"];

		$sql = "SELECT * FROM cart WHERE p_id = '$p_id' AND user_id = '$user_id'";
		$run_query = mysqli_query($con,$sql);
		$count = mysqli_num_rows($run_query);
		if($count > 0){
			$sql = "UPDATE cart SET qty=qty+'$qty' WHERE p_id = '$p_id' AND user_id = '$user_id'";
			if(mysqli_query($con,$sql)){
				echo "Product in cart has been Updated..!";
				exit();
			}
		} else {
			$sql = "INSERT INTO `cart`(`p_id`, `ip_add`, `user_id`, `qty`) VALUES ('$p_id','$ip_add','$user_id','$qty')";
			if(mysqli_query($con,$sql)){
				echo "Product has been Added to cart..!";
				exit();
			}
		}
	}else{
		$sql = "SELECT * FROM cart WHERE ip_add = '$ip_add' AND p_id = '$p_id' AND user_id = -1";
		$query = mysqli_query($con,$sql);
		if (mysqli_num_rows($query) > 0) {
			$sql = "UPDATE cart SET qty=qty+'$qty' WHERE ip_add = '$ip_add' AND p_id = '$p_id' AND user_id = -1";
			if(mysqli_query($con,$sql)){
				echo "Product in cart has been Updated..!";
				exit();
			}
		}else{
			$sql = "INSERT INTO `cart`
			(`p_id`, `ip_add`, `user_id`, `qty`) 
			VALUES ('$p_id','$ip_add','-1','$qty')";
			if (mysqli_query($con,$sql)) {
				echo "Product has been Added to cart..!";
				exit();
			}
		}
		
	}
}

//Count User cart item
if (isset($_POST["count_item"])) {
	//When user is logged in then we will count number of item in cart by using user session id
	if (isset($_SESSION["uid"])) {
		$sql = "SELECT COUNT(*) AS count_item FROM cart WHERE user_id = $_SESSION[uid] and user_id > 0";
	}else{
		//When user is not logged in then we will count number of item in cart by using users unique ip address
		$sql = "SELECT COUNT(*) AS count_item FROM cart WHERE ip_add = '$ip_add' AND user_id < 0";
	}
	
	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_array($query);
	echo $row['count_item'];
	echo '<script>console.log('.$ip_add.')</script>';
	exit();
}
//Count User cart item

//Get Cart Item From Database to Dropdown menu
if (isset($_POST["Common"])) {

	if (isset($_SESSION["uid"])) {
		//When user is logged in this query will execute
		$sql = "SELECT * FROM cart c join products p On c.p_id=p.product_id WHERE c.user_id='$_SESSION[uid]' ORDER BY c.id DESC";
	}else{
		//When user is not logged in this query will execute
		$sql = "SELECT * FROM cart c join products p On c.p_id=p.product_id WHERE c.ip_add='$ip_add' AND c.user_id < 0 ORDER BY c.id DESC";
	}
	$query = mysqli_query($con,$sql);
	if (isset($_POST["getCartItem"])) {
		//display cart item in dropdown menu
		$cartHtml = '
		<div class="cart-list">';
		$n=0;
		$total=0;
		$count = mysqli_num_rows($query);
		if ($count > 0) {
			while ($row=mysqli_fetch_array($query)) {
				$n++;
				$cart_id = $row["id"];
				$product_id = $row["product_id"];
				$product_title = $row["product_title"];
				$product_price = $row["product_price"];
				$product_image = $row["product_image"];
				$cart_item_id = $row["id"];
				$qty = $row["qty"];
				$total+=$qty*$product_price;
				// echo '
				// 	<div class="row">
				// 		<div class="col-md-1">'.$n.'</div>
				// 		<div class="col-md-3"><img class="img-responsive" src="product_images/'.$product_image.'" /></div>
				// 		<div class="col-md-6">'.$product_title.'</div>
				// 		<div class="col-md-2">'.CURRENCY.''.$product_price.'</div>
				// 	</div>';
				$cartHtml .='
					<div class="product-widget">
						<div class="product-img">
							<img src="product_images/'.$product_image.'" alt="">
						</div>
						<div class="product-body">
							<h3 class="product-name lines-2" style="height:auto;"><a href="product_detail.php?p_id='.$product_id.'">'.$product_title.'</a></h3>
							<span class="qty" style="display: inline-block;">'.$qty.'x</span><h4 style="display: inline-block;" class="product-price">'.number_format($product_price, 0)."₫".'</h4>
						</div>
						<button class="delete removeCartItem_instance" remove_id="'.$cart_id.'"><i class="fa fa-close"></i></button>
					</div>';
			}
		}
		$cartHtml.= '
		</div>
		<div class="cart-summary">
			<small>'.$n.' Item(s) selected</small>
			<h5>SUBTOTAL:    '.number_format($total, 0)."₫".'</h5>
		</div>';
		if(!isset($_SESSION["uid"])){
			$cartHtml.='<div class="cart-btns">
							<button id="viewCart" class="btn">View Cart</button>
						</div>';
		}else{
			$cartHtml.='<div class="cart-btns">
							<button id="viewCart" class="btn" view=true>View Cart</button>
						</div>';
		}
		
		
		echo json_encode(["status"=>202,"cartHtml"=>$cartHtml,"count"=>$count]);
	}
	if (isset($_POST["checkOutDetails"])) {
		if (mysqli_num_rows($query) > 0) {
			$n=0;
			while ($row=mysqli_fetch_array($query)) {
				$n++;
				$product_id = $row["product_id"];
				$product_title = $row["product_title"];
				$product_price = $row["product_price"];
				$product_image = $row["product_image"];
				$cart_item_id = $row["id"];
				$qty = $row["qty"];
				$remain = $row["product_qty"];

				echo '
				<div class="d-sm-flex justify-content-between my-4 pb-4 border-bottom cartItem">
					<div class="media d-block d-sm-flex text-center text-sm-left" style="flex:7;">
						<a class="cart-item-thumb mx-auto mr-sm-4" href="product_detail.php?p_id='.$product_id.'"><img src="product_images/'.$product_image.'" alt="Product"></a>
						<div class="media-body pt-3">
							<h3 class="product-card-title font-weight-semibold border-0 pb-0"><a href="product_detail.php?p_id='.$product_id.'">'.$product_title.'</a></h3>
							<div class="font-size-lg pt-2 price" style="color: #D10024;font-size: 22px;" value="'.$product_price.'">'.number_format($product_price, 0)."₫".'</div>
						</div>
					</div>
					<div class="pt-2 pt-sm-0 pl-sm-3 mx-auto mx-sm-0 text-center text-sm-left" style="max-width: 10rem;"  style="flex:3;">
						<div class="form-group mb-2">
							<label for="quantity1">Quantity</label>
							<div class="add-to-cart">
								<div class="qty-label">
									<div class="input-number" max="'.$remain.'">
										<input class="qty" type="number" value="'.$qty.'" cartItemid="'.$cart_item_id.'" onKeypress="event.preventDefault();">
										<span class="qty-up cart-qty-up">+</span>
										<span class="qty-down cart-qty-down">-</span>
									</div>
								</div>
							</div>
						</div>
						<button class="btn btn-outline-secondary btn-sm btn-block mb-2 updateCartItem" type="button" update_id="'.$cart_item_id.'">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw mr-1">
								<polyline points="23 4 23 10 17 10"></polyline>
								<polyline points="1 20 1 14 7 14"></polyline>
								<path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
							</svg>Update cart
						</button>
						<button class="btn btn-outline-danger btn-sm btn-block mb-2 removeCartItem" type="button" remove_id="'.$cart_item_id.'">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 mr-1">
								<polyline points="3 6 5 6 21 6"></polyline>
								<path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
								<line x1="10" y1="11" x2="10" y2="17"></line>
								<line x1="14" y1="11" x2="14" y2="17"></line>
							</svg>Remove
						</button>
					</div>
				</div>';
			}
		}else{
			echo "cart empty";
			exit();
		}
	}
	
	
}

//Remove Item From cart
if (isset($_POST["removeItemFromCart"])) {
	$remove_id = $_POST["rid"];
	if (isset($_SESSION["uid"])) {
		$sql = "DELETE FROM cart WHERE id = '$remove_id' AND user_id = '$_SESSION[uid]'";
		$success="Product is removed from cart";
	}else{
		$sql = "DELETE FROM cart WHERE id = '$remove_id' AND ip_add = '$ip_add' and user_id=-1" ;
		$success="";
	}
	if(mysqli_query($con,$sql)){
		echo $success;
		exit();
	}
}


//Update Item From cart
if (isset($_POST["updateCartItem"])) {
	$update_id = $_POST["update_id"];
	$qty = $_POST["qty"];
	if (isset($_SESSION["uid"])) {
		$sql = "UPDATE cart SET qty='$qty' WHERE id = '$update_id' AND user_id = '$_SESSION[uid]'";
	}else{
		$sql = "UPDATE cart SET qty='$qty' WHERE id = '$update_id' AND ip_add = '$ip_add'";
	}
	if(mysqli_query($con,$sql)){
		echo "Product is updated";
		exit();
	}
}
if(isset($_GET["productDetail"])){
	$p_id=$_GET["p_id"];

	// get img list
	$sql = "SELECT img_name FROM images WHERE p_id= '$p_id' ";
	$query=mysqli_query($con,$sql);
	$imgList=[];
	if (mysqli_num_rows($query) > 0) {
		while ($row=mysqli_fetch_array($query)) {
			$imgList[]=$row['img_name'];
		}
	}
	
	$sql = "SELECT * FROM products JOIN brands on products.product_brand = brands.brand_id JOIN categories ON products.product_cat = categories.cat_id WHERE product_id= '$p_id' ";
	$query=mysqli_query($con,$sql);
	if (mysqli_num_rows($query) > 0) {
		$row=mysqli_fetch_array($query);

		array_unshift($imgList , $row['product_image']);
		if(count($imgList)==2 || count($imgList)==3){
			$imgList = array_merge($imgList,$imgList);
		}

		$carouselHTML='';
		for($i=0; $i < count($imgList);$i++){
			$carouselHTML.=
			'<div class="product-preview">
				<img src="product_images/'.$imgList[$i].'" alt="">
			</div>';
		}
		
		$rate = round($row["product_rate"] * 2) / 2;
		$rateHtml="";
		for($i=1;$i<=5;$i++){
			if($i<=$rate){
				$rateHtml.='<i class="fa fa-star"></i>  ';
			}else if(($i-$rate)==0.5){
				$rateHtml.='<i class="fas fa-star-half-alt"></i>  ';
			}else if(($i-$rate)==0){
				$rateHtml.='<i class="fa fa-star-o"></i>  ';
			}else{
				$rateHtml.='<i class="fa fa-star-o"></i>  ';
			}
		}


		$keywords=trim($row["product_keywords"], " ");
		$keywords = explode(",",$keywords);
		$kw="";
		foreach ($keywords as $keyword) {
			$kw.='<li><a>'.$keyword.'</a>,</li>';
		}
		$sale=0;
		if(($row["product_oriprice"]!=0)&($row["product_oriprice"]!=$row["product_price"])){
			$sale = round((1-($row["product_price"]/$row["product_oriprice"]))*100,0);
		}
		if($sale!=0){
			$priceHtml='
				<h3 class="product-price">'.number_format($row["product_price"], 0)."₫".' <del class="product-old-price">'.number_format($row["product_oriprice"], 0)."₫".'</del></h3>
				<span class="product-available">'.$sale.'% OFF</span>';
		}
		else{
			$priceHtml='<h3 class="product-price">'.number_format($row["product_price"], 0)."₫".'</h3>';
		}
		$remain=$row["product_qty"];
		if($remain>0){
			$addtocartHtml='
			<div class="add-to-cart">
				<div class="qty-label">
					Qantity : 
					<div class="input-number" max="'.$remain.'">
						<input type="number" id="input-quantity" onKeypress="event.preventDefault();">
						<span class="qty-up">+</span>
						<span class="qty-down">-</span>
					</div>
				</div>
				<button class="add-to-cart-btn" id="add-to-cart" p_id="'.$p_id.'"><i class="fa fa-shopping-cart"></i> add to cart</button>
			</div>';
			$remainHtml=$remain;
		}else{
			$addtocartHtml='';
			$remainHtml='Out of stock';
		}
		

		echo '
		<div class="col-md-5 col-md-push-2">
			<div id="product-main-img">
				'.$carouselHTML.'
			</div>
		</div>
		<!-- /Product main img -->

		<!-- Product thumb imgs -->
		<div class="col-md-2  col-md-pull-5">
			<div id="product-imgs">
				'.$carouselHTML.'
			</div>
		</div>
		<!-- /Product thumb imgs -->

		<!-- Product details -->
		<div class="col-md-5">
			<div class="product-details">
				<h2 class="product-name">'.$row["product_title"].'</h2>
				<div>
					<div class="product-rating">
						'.$rateHtml.'
					</div>
					<p style="display:inline-block;color:#D10024;font-weight:500;">'.$row["product_rate"].'/5</p>
				</div>
				<div>
					'.$priceHtml.'
				</div>
				<p class="lines-3" style="margin-top:24px">'.str_replace("\n","<br>",$row["product_desc"]).'</p>
				
				<ul class="product-links">
					<li>Category:</li>
					<li><a>'.$row["cat_title"].'</a></li>
				</ul>
				<ul class="product-links">
					<li>Manufacturer:</li>
					<li><a>'.$row["brand_title"].'</a></li>
				</ul>
				<ul class="product-links">
					<li>Keyword:</li>
					'.$kw.'
				</ul>
				<ul class="product-links">
					<li>Remain:</li>
					<li><a>'.$remainHtml.'</a></li>
				</ul>
				'.$addtocartHtml.'

				<ul class="product-links">
					<li>Share:</li>
					<li><a"><i class="fa fa-facebook"></i></a></li>
					<li><a"><i class="fa fa-twitter"></i></a></li>
					<li><a"><i class="fa fa-google-plus"></i></a></li>
					<li><a"><i class="fa fa-envelope"></i></a></li>
				</ul>

			</div>
		</div>
		<!-- /Product details -->

		<!-- Product tab -->
		<div class="col-md-12">
			<div id="product-tab">
				<!-- product tab nav -->
				<ul class="tab-nav">
					<li class="active"><a data-toggle="tab" href="#tab1">Description</a></li>
				</ul>
				<!-- /product tab nav -->

				<!-- product tab content -->
				<div class="tab-content">
					<!-- tab1  -->
					<div id="tab1" class="tab-pane fade in active">
						<div class="row">
							<div class="col-md-12">
								<p>'.str_replace("\n","<br>",$row["product_desc"]).'</p>
							</div>
						</div>
					</div>
					<!-- /tab1  -->
				</div>
				<!-- /product tab content  -->
			</div>
		</div>
		';
	}else{
		echo '<h2>No Product Found!</h2>';
	}
}



?>






