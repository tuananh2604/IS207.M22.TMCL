<?php 
session_start();
/**
 * 
 */
class Customers
{
	
	private $con;

	function __construct()
	{
		include_once("Database.php");
		$db = new Database();
		$this->con = $db->connect();
	}

	public function getCustomers(){
		$query = $this->con->query("SELECT * FROM `user_info`");
		$ar = [];
		if (@$query->num_rows > 0) {
			while ($row = $query->fetch_assoc()) {
				$ar[] = $row;
			}
			return ['status'=> 202, 'message'=> $ar];
		}
		return ['status'=> 303, 'message'=> 'no customer data'];
	}


	public function getCustomersOrder(){
		$query = $this->con->query("SELECT * FROM orders o join user_info u on u.user_id=o.user_id ORDER BY o.order_id Desc");
		$orders = [];
		if ($query->num_rows > 0) {
			while ($row = $query->fetch_assoc()) {
				$orders[] = $row;
			}
			$orders_details=[];
			foreach ($orders as &$order){
				$o_id=$order["order_id"];
				$order_details=[];
				$query = $this->con->query("SELECT * FROM order_details od join products p on od.p_id=p.product_id where od.o_id = $o_id");
				if ($query->num_rows > 0) {
					while ($row = $query->fetch_assoc()) {
						$order_details[] = $row;
					}
				}
				$orders_details[]=$order_details;
			}
			return ['status'=> 202, 'orders'=> $orders, "orders_details"=>$orders_details];
		}else{
			return ['status'=> 303, 'message'=> 'no orders yet'];
		}
		// return ['status'=> 202, 'message'=> $ar];
	}
	public function deleteCustomer($cid=null){
		if ($cid != null) {
			$q = $this->con->query("DELETE FROM user_info WHERE user_id = '$cid'");
			if ($q) {
				return ['status'=> 202, 'message'=> 'Removed user'];
			}else{
				return ['status'=> 202, 'message'=> 'Failed to run query'];
			}
			
		}else{
			return ['status'=> 303, 'message'=>'Invalid user id'];
		}

	}
	public function updateStatus($o_id=null,$status=null){
		if($o_id!=null&&$status!=null){
			$q = $this->con->query("UPDATE orders set `status` = '".$status."' Where order_id = ".$o_id);
			if ($q) {
				return ['status'=> 202, 'message'=> 'update status at orderId '.$o_id];
			}else{
				return ['status'=> 202, 'message'=> 'Failed to run query'];
			}
		}

	}
	

}


/*$c = new Customers();
echo "<pre>";
print_r($c->getCustomers());
exit();*/

if (isset($_POST["GET_CUSTOMERS"])) {
	if (isset($_SESSION['admin_id'])) {
		$c = new Customers();
		echo json_encode($c->getCustomers());
		exit();
	}
}

if (isset($_POST["GET_CUSTOMER_ORDERS"])) {
	if (isset($_SESSION['admin_id'])) {
		$c = new Customers();
		echo json_encode($c->getCustomersOrder());
		exit();
	}
}
if (isset($_POST["update_order_status"])) {
	if(isset($_POST["o_id"])&&isset($_POST["status"])){
		$o_id = $_POST["o_id"];
		$status = $_POST["status"];
		$c = new Customers();
		echo json_encode($c->updateStatus($o_id,$status));
	}else{
		return ['status'=> 303, 'message'=>'empty orderId or Status'];
	}

}

?>