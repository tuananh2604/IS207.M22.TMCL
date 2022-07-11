<?php
session_start();
if(!isset($_SESSION["uid"])){
	header("location:index.php");
}
$success=true;
if(isset($_POST["process_order"])){
	if($_SESSION["uid"]==$_POST["uid"]){
		extract($_POST);
		include_once("db.php");
		$sql = "SELECT * FROM cart c Join products p On c.p_id=p.product_id WHERE user_id = '$uid'";
		$query = mysqli_query($con,$sql);
		$total=0;
		if (mysqli_num_rows($query) > 0) {
			while ($row=mysqli_fetch_array($query)) {
				if($row["qty"]>0){
					$product_id[] = $row["p_id"];
					$qty[] = $row["qty"];
					$price[] = $row["product_price"];
					$total+=$row["qty"]*$row["product_price"];
				}
			}
			$total+=shiping;
			if($total==$total_order){
				date_default_timezone_set("Asia/Ho_Chi_Minh");
				$datetime = date("Y-m-d H:i:s");
				$log = ["uid"=>$uid,"address"=>$address,"email"=>$email,"tel"=>$tel,"datetime"=>$datetime,"shiping"=>$shiping,"payment"=>$payment,"note"=>$note,"total"=>$total,"product_id"=>$product_id,"qty"=>$qty,"price"=>$price];
				$log = json_encode($log,JSON_UNESCAPED_UNICODE);
				$sql = "INSERT INTO `orders`(`user_id`, `order_address`, `order_mobile`, `shiping`, `status`, `order_date`, `payment`, `note`, `log`,`total`) VALUES ($uid,'$address','$tel',$shiping,'Pending','$datetime','$payment','$note','$log',$total)";
				$query = mysqli_query($con,$sql);
				if($query){
					$o_id = mysqli_insert_id($con);
					for($i=0;$i<count($product_id);$i++){
						$p_id = $product_id[$i];
						$od_qty = $qty[$i];
						$od_price = $price[$i];
						$sql = "INSERT INTO `order_details`( `o_id`, `p_id`, `od_qty`, `od_price`) VALUES ($o_id,$p_id,$od_qty,$od_price)";
						$query = mysqli_query($con,$sql);
						if(!$query){
							$success=false;
						}
					}
					$sql = "DELETE FROM `cart` WHERE user_id = $uid";
					$query = mysqli_query($con,$sql);
					if(!$query){
						$success=false;
					}
	
					$sql = "UPDATE `user_info` SET `mobile`='$tel',`address1`='$address' WHERE user_id = $uid";
					$query = mysqli_query($con,$sql);

					for($i=0;$i<count($product_id);$i++){
						$p_id = $product_id[$i];
						$od_qty = $qty[$i];
						$sql = "UPDATE `products` SET  product_qty = product_qty - $od_qty WHERE product_id = $p_id";
						$query = mysqli_query($con,$sql);
					}
	
				}else{
					$success=false;
				}
			}
			else{
				$success=false;
			}
		}else{
			$success=false;
		}

		
	}else{
		$success=false;
	}
}else{
	$success=false;
}
?>
<html>
  <head>
	<meta charset="UTF-8">
	<script src="https://kit.fontawesome.com/9a62ff02c9.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>
  </head>
    <style>
		body {
			text-align: center;
			padding: 40px 0;
			background: #EBF0F5;
		}
        h1 {
			font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
			font-weight: 900;
			font-size: 40px;
			margin-bottom: 10px;
        }
		.success-title{
			color: #88B04B;
		}
		.error-title{
			color: #b04b4b;
		}
        p {
			color: #404F5E;
			font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
			font-size:20px;
			margin: 0;
        }
      	.success{
			color: #9ABC66;
			font-size: 100px;
			line-height: 200px;
      	}
		.error{
			color: #bc6666;
			font-size: 100px;
			line-height: 200px;
      	}
      	.card {
			background: white;
			padding: 60px;
			border-radius: 4px;
			box-shadow: 0 2px 3px #C8D0D8;
			display: inline-block;
			margin: 0 auto;
      	}
		  .disclaimer{
			  display: none;
		  }
    </style>
    <body>
		<div class="card">
		<?php if($success){ ?>
			<div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
				<i class="fas fa-check success"></i>
			</div>
			<h1 class="success-title">Success</h1> 
			<p>We received your purchase request<br/> we'll be in touch shortly!<br/></p>
			<br/>
			<a href="index.php" class="btn btn-success">Continue Shopping</a>
		<?php }else{ ?>
			<div style="border-radius:200px; height:200px; width:200px; background: #faf5f5; margin:0 auto;">
				<i class="fas fa-exclamation error"></i>
			</div>
			<h1 class="error-title">Something Wrong!</h1> 
			<p><br/> Please try again...<br/></p>
			<br/>
			<a href="index.php" class="btn btn-danger">Back to Home</a>
			<?php } ?>
		</div>
    </body>
</html>


