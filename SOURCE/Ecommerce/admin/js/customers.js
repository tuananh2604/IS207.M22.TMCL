$(document).ready(function(){

	getCustomers();
	getCustomerOrders();

	function getCustomers(){
		$.ajax({
			url : '../admin/classes/Customers.php',
			method : 'POST',
			data : {GET_CUSTOMERS:1},
			success : function(response){
				
				var resp = $.parseJSON(response);
				if (resp.status == 202) {

					var customersHTML = "";

					$.each(resp.message, function(index, value){

						customersHTML += '<tr>'+
									          '<td>#</td>'+
									          '<td>'+value.first_name+' '+value.last_name+'</td>'+
									          '<td>'+value.email+'</td>'+
									          '<td>'+value.mobile+'</td>'+
									          '<td>'+value.address1+'</td>'+
									       '</tr>'

					});

					$("#customer_list").html(customersHTML);

				}else if(resp.status == 303){

				}

			}
		})
		
	}

	function getCustomerOrders(){
		$.ajax({
			url : '../admin/classes/Customers.php',
			method : 'POST',
			data : {GET_CUSTOMER_ORDERS:1},
			success : function(response){
				
				var resp = $.parseJSON(response);
				if (resp.status == 202) {
					console.log(resp);
					var orders = resp.orders;
					var orders_details = resp.orders_details;
					var customerOrderHTML = "";

					for (var i = 0; i < orders.length; i++){
						var order = orders[i];
						var order_details = orders_details[i];
						customerOrderHTML +='<tr>'+
												'<td><button class="btn btn-primary collapse-btn" type="button" data-target="#'+order.order_id+'"">+</button></td>'+
												'<td>'+ order.first_name +' '+order.last_name +'</td>'+
												'<td>'+ order.order_mobile +'</td>'+
												'<td>'+ order.order_address +'</td>'+
												'<td>'+ vnd(order.total) +'</td>'+
												'<td class="row" style="margin:0; align-items:center; justify-content:center;">'+
														'<select class="form-control status_list col-sm-6 selectStatus" style="font-size:12px;padding-left:2px;" > '+
															'<option value="'+order.status+'">'+order.status+'</option>'+
															'<option value="Complete">Complete</option>'+
															'<option value="Shiping">Shiping</option>'+
															'<option value="Cancel">Cancel</option>'+
															'<option value="Pending">Pending</option>'+
														'</select>'+ 
														'<button class="btn btn-success col-sm-4 update-status" style="margin-left:6px;" o_id="'+order.order_id+'" >Save</button>'+
												'</td>'+
											'</tr>'+
											'<tr>'+
												'<td colspan="100%">'+
													'<div class="collapse" id="'+order.order_id+'">'+
														'<div class="card card-body">'+
															`
															<div class="row">
																<div class="col-md-4 shadow" style="background-color: #f3f3f3;margin: 0 12px; border-radius:4px;">
																	<h3 style="margin:16px 0">order infomation</h3>
																	<br>
																	<div class="row">
																		<div class="col-md-12">
																			<div class="d-flex">
																				<p style="flex:3;">Id:</p>
																				<p style="flex:6"><b>`+order.order_id +`</b></p>
																			</div>
																			<div class="d-flex">
																				<p style="flex:3;">Time:</p>
																				<p style="flex:6"><b>`+order.order_date +`</b></p>
																			</div>
																			<div class="d-flex">
																				<p style="flex:3;">Full Name:</p>
																				<p style="flex:6"><b>`+order.first_name +' '+order.last_name+`</b></p>
																			</div>
																			<div class="d-flex">
																				<p style="flex:3;">Number:</p>
																				<p style="flex:6"><b>`+order.order_mobile+`</b></p>
																			</div>
																			<div class="d-flex">
																				<p style="flex:3;">Address:</p>
																				<p style="flex:6"><b>`+order.order_address+`</b></p>
																			</div>
																			<div class="d-flex">
																				<p style="flex:3;">Email:</p>
																				<p style="flex:6"><b>`+order.email+`</b></p>
																			</div>
																			<div class="d-flex">
																				<p style="flex:3;">Payment:</p>
																				<p style="flex:6"><b>`+order.payment+`</b></p>
																			</div>
																			<div class="d-flex">
																				<p style="flex:3;">Shiping:</p>
																				<p style="flex:6"><b>`+order.shiping+`</b></p>
																			</div>
																			<div class="d-flex">
																				<p style="flex:3;">Total:</p>
																				<h3 style="flex:6"><b>`+vnd(order.total)+`</b></h3>
																			</div>
																			<div class="d-flex">
																				<p style="flex:3;">Note:</p>
																				<p style="flex:6"><b>`+order.note+`</b></p>
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
																		<tbody>`;
																		for (var j = 0; j < order_details.length; j++){
																			var order_detail = order_details[j];
																			customerOrderHTML +=
																			`
																			<tr>
																				<td style="width:10%">
																					<img width="60px" height="60px" src="../product_images/`+order_detail.product_image+`">
																				</td>
																				<td style="width:40%">
																					`+order_detail.product_title+`
																				</td>
																				<td style="width:20%">
																					`+vnd(order_detail.product_price)+`
																				</td>
																				<td style="width:10%">
																					x`+order_detail.od_qty+`
																				</td>
																				<td style="width:20%">
																					`+vnd(order_detail.product_price*order_detail.od_qty)+`
																				</td>
																			</tr>
																			`;
																		}
												customerOrderHTML +=
																		`</tbody>
																	</table>
																</div>
															</div>
														</div>
													</div>
												</td>
											</tr>`;

					};

					
					$("#customer_order_list").html(customerOrderHTML);
					
					
					var select = $(".selectStatus");
					select.each(function(){
						// console.log($(this).find(":selected"));
						$(this).css("color", $(this).find(":selected").css("color"));
						$(this).css("background-color",$(this).find(":selected").css("backgroundColor"));
					})
					select.change(function(){
						// console.log($(this).find(":selected"));
						$(this).css("color", $(this).find(":selected").css("color"));
						$(this).css("background-color",$(this).find(":selected").css("backgroundColor"));
					})
					

					$('.collapse-btn').click(function(){
						console.log('a');
						var target = $(this).attr('data-target');
						$(target).collapse('toggle');
					});
					$(".update-status").click(function(){
						var status = $(this).prev().find(":selected").text();
						var oid= $(this).attr("o_id");
						$.ajax({
							url : '../admin/classes/Customers.php',
							method : 'POST',
							data : {update_order_status:1,o_id:oid,status:status},
							success : function(response){
								console.log($.parseJSON(response).message);
								new Notify ({
									title: $.parseJSON(response).message,
									autoclose: true,
									status: 'success',
									autotimeout: 3000
								});
							}})
								
						});

				}else if(resp.status == 303){
					$("#customer_order_list").html(resp.message);
				}

			}
		});
		
		
	}

	$('.collapse-btn').click(function(){
		console.log('a');
		var target = $(this).attr('data-target');
		$(target).collapse('toggle');
	});
	function vnd(money){
		return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(money);
	}
});