<?php
include "db.php";

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
#Login script is begin here
#If user given credential matches successfully with the data available in database then we will echo string login_success
#login_success string will go back to called Anonymous funtion $("#login").click() 
if(isset($_POST["email"]) && isset($_POST["password"])){
	$email = mysqli_real_escape_string($con,$_POST["email"]);
	$password = md5($_POST["password"]);
	$sql = "SELECT * FROM user_info WHERE email = '$email' AND password = '$password'";
	$run_query = mysqli_query($con,$sql);
	$count = mysqli_num_rows($run_query);
	//if user record is available in database then $count will be equal to 1
	if($count == 1){
		$row = mysqli_fetch_array($run_query);
		$uid = $row["user_id"];
		$_SESSION["uid"] = $row["user_id"];
		$_SESSION["name"] = $row["last_name"];
		$ip_add = getIP();

		// //check have item in cart 
		// //if have cart in account delete temp cart
		// //else append temp cart to account
		// $sql = "SELECT * FROM cart WHERE user_id = $uid";
		// $run_query = mysqli_query($con,$sql);
		// $count = mysqli_num_rows($run_query);
		// if($count>0){
		// 	$sql = "DELETE FROM cart WHERE ip_add = '$ip_add' and user_id = -1";
		// 	mysqli_query($con,$sql);
		// }else{
		// 	$sql = "UPDATE `cart` SET `user_id`= $uid WHERE `user_id`= -1 and ip_add = '$ip_add'";
		// 	mysqli_query($con,$sql);
		// }

		// add temp cart to account
		//update qty of exist cart item
		$sql = "UPDATE `cart` a SET a.qty=a.qty+(SELECT b.qty FROM cart b where b.user_id=-1 and b.ip_add = '$ip_add' and b.p_id=a.p_id) WHERE a.`user_id`= '$uid' and a.p_id IN (select p_id FROM cart where user_id = -1 and ip_add = '$ip_add')";
		mysqli_query($con,$sql);
		//update user_id of temp cart item
		$sql = "UPDATE `cart` SET `user_id`= '$uid' WHERE `user_id`= -1 and ip_add = '$ip_add' and p_id not IN (select p_id FROM cart where user_id = '$uid')";
		mysqli_query($con,$sql);
		//delete temp cart
		$sql = "DELETE FROM cart WHERE ip_add = '$ip_add' and user_id = -1";
		mysqli_query($con,$sql);
		echo "login_success";
		exit();
	}else{
		echo "<span style='color:red;'>Wrong email or password...!</span>";
		exit();
	}
	
}

?>