function product(page=1){
	$.ajax({
		url	:	"action.php",
		method:	"POST",
		data	:	{getProduct:1,setPage:1,pageNumber:page},
		success	:	function(data){
			// $("#get_product").html(data);
			if(data)
				$("#get_product").html(data);
			else
				$("#get_product").html("<h3>No product Show...!</h3>");
		}
	})
}		
function search(keyword = $("#search").val()){
	$("#get_product").html("<h3>Loading...</h3>");
	$.ajax({
		url		:	"action.php",
		method	:	"POST",
		data	:	{search:1,keyword:keyword},
		success	:	function(data){ 
			$("#get_product").html(data);
			if($("body").width() < 480){
				$("body").scrollTop(683);
			}
			console.log(keyword);
		}
	})
}
function productDetail(){
	if($("#get-productDetail").length){
		id=$("#get-productDetail").attr("p_id");
		$.ajax({
			url	:	"action.php",
			method:	"GET",
			data	:	{productDetail:1,p_id:id},
			success	:	function(data){
				$("#get-productDetail").html(data);
				//nouislider template
				(function($) {
					"use strict"
				
					// Mobile Nav toggle
					$('.menu-toggle > a').on('click', function (e) {
						e.preventDefault();
						$('#responsive-nav').toggleClass('active');
					})
				
					// Fix cart dropdown from closing
					$('.cart-dropdown').on('click', function (e) {
						e.stopPropagation();
					});
				
					/////////////////////////////////////////
				
					// Products Slick
					$('.products-slick').each(function() {
						var $this = $(this),
								$nav = $this.attr('data-nav');
				
						$this.slick({
							slidesToShow: 4,
							slidesToScroll: 1,
							autoplay: true,
							infinite: true,
							speed: 300,
							dots: false,
							arrows: true,
							appendArrows: $nav ? $nav : false,
							responsive: [{
							breakpoint: 991,
							settings: {
							  slidesToShow: 2,
							  slidesToScroll: 1,
							}
						  },
						  {
							breakpoint: 480,
							settings: {
							  slidesToShow: 1,
							  slidesToScroll: 1,
							}
						  },
						]
						});
					});
				
					// Products Widget Slick
					$('.products-widget-slick').each(function() {
						var $this = $(this),
								$nav = $this.attr('data-nav');
				
						$this.slick({
							infinite: true,
							autoplay: true,
							speed: 300,
							dots: false,
							arrows: true,
							appendArrows: $nav ? $nav : false,
						});
					});
				
					/////////////////////////////////////////
				
					// Product Main img Slick
					$('#product-main-img').slick({
					infinite: true,
					speed: 300,
					dots: false,
					arrows: true,
					fade: true,
					asNavFor: '#product-imgs',
				  });
				
					// Product imgs Slick
				  $('#product-imgs').slick({
					slidesToShow: 3,
					slidesToScroll: 1,
					arrows: true,
					centerMode: true,
					focusOnSelect: true,
						centerPadding: 0,
						vertical: true,
					asNavFor: '#product-main-img',
						responsive: [{
						breakpoint: 991,
						settings: {
									vertical: false,
									arrows: false,
									dots: true,
						}
					  },
					]
				  });
				
					// Product img zoom
					var zoomMainProduct = document.getElementById('product-main-img');
					if (zoomMainProduct) {
						$('#product-main-img .product-preview').zoom();
					}
				
					/////////////////////////////////////////
				
					// Input number
					
				
					// Price Slider
					var priceSlider = document.getElementById('price-slider');
					if (priceSlider) {
						noUiSlider.create(priceSlider, {
							start: [1, 999],
							connect: true,
							step: 1,
							range: {
								'min': 1,
								'max': 999
							}
						});
				
						priceSlider.noUiSlider.on('update', function( values, handle ) {
							var value = values[handle];
							handle ? priceInputMax.value = value : priceInputMin.value = value
						});
					}
				
				})(jQuery);
				$('.input-number').each(function() {
					var $this = $(this),
					$input = $this.find('input[type="number"]').val(1),
					up = $this.find('.qty-up'),
					down = $this.find('.qty-down'),
					max = $this.attr("max");

			
					down.on('click', function () {
						var value = parseInt($input.val()) - 1;
						value = value < 1 ? 1 : value;
						$input.val(value);
						$input.change();
					})
			
					up.on('click', function () {
						var value = parseInt($input.val()) ;
						console.log(value);
						if(isNaN(value)){
							$input.val(1);
							$input.change();
						}else if(value < max){
							$input.val(value+1);
							$input.change();
						}else if(value>=max){
							new Notify ({
								title: 'Maximum value',
								autoclose: true,
								status: 'error',
								autotimeout: 3000,
								customClass: 'toast',
								distance:0
							})
						}
					})
				});
			}
		})
	}
}

function toast(msg,type="error"){
	new Notify ({
		title: msg,
		autoclose: true,
		status: type,
		autotimeout: 1500,
		customClass: 'toast',
		distance:0
	})
}

$(document).ready(function(){
	cat();
	brand();
	productDetail();
	//cat() is a funtion fetching category record from database whenever page is load
	function cat(){
		$.ajax({
			url	:	"action.php",
			method:	"POST",
			data	:	{category:1},
			success	:	function(data){
				$("#get_category").html(data);
				if($('body').width() >=992){
					$("#get_category").collapse('show');
				}
			}
		})
	}
	//brand() is a funtion fetching brand record from database whenever page is load
	function brand(){
		$.ajax({
			url	:	"action.php",
			method:	"POST",
			data	:	{brand:1},
			success	:	function(data){
				$("#get_brand").html(data);
				if($('body').width() >=992){
					$("#get_brand").collapse('show');
				}
			}
		})
	}
	//product() is a funtion fetching product record from database whenever page is load
		



	/*	when page is load successfully then there is a list of categories when user click on category we will get category id and 
		according to id we will show products
	*/
	
	

	$("body").delegate('.filterCheckbox','change',function(){
		var categories=[];
		var brands=[];
		$('.filterCheckbox').each(function(){
			if($(this).is(":checked")){
				if($(this).attr('cid')!='undefined' && $(this).attr('cid') !=false && $(this).attr('cid') != null){
					categories.push($(this).attr('cid'));
				}else if($(this).attr('bid')!='undefined' && $(this).attr('bid') !=false && $(this).attr('bid') != null){
					brands.push($(this).attr('bid'));
				}
			}
		});
		$("#get_product").html("<h3>Loading...</h3>");
		$.ajax({
			url		:	"action.php",
			method	:	"POST",
			data	:	{selectFilter:1,Filter:{category:JSON.stringify(categories),brand:JSON.stringify(brands)}},
			success	:	function(data){
				$("#get_product").html(data);
				$('html, body').animate({
                    scrollTop: $("#store").offset().top
                }, 500);
			}
		})
	
	})

	/*	when page is load successfully then there is a list of brands when user click on brand we will get brand id and 
		according to brand id we will show products
	*/

	/*
		At the top of page there is a search box with search button when user put name of product then we will take the user 
		given string and with the help of sql query we will match user given string to our database keywords column then matched product 
		we will show 
	*/
	
	$("#search_btn").click(function(e){
		e.preventDefault();
		if(window.location.href!="index.php" && window.location.href!="profile.php"){
			keyword = $("#search").val();
			window.location.href="index.php?search=1&keyword="+keyword;
		}
		search();
	})
	$("#search").on('keyup', function (e) {
		e.preventDefault();
		if (e.key === 'Enter' || e.keyCode === 13) {
			if(window.location.href!="index.php" && window.location.href!="profile.php"){
				keyword = $("#search").val();
				window.location.href="index.php?search=1&keyword="+keyword;
			}
			search();
		}
		
	})
	//end


	/*
		Here #login is login form id and this form is available in index.php page
		from here input data is sent to login.php page
		if you get login_success string from login.php page means user is logged in successfully and window.location is 
		used to redirect user from home page to profile.php page
	*/
	$("#login").on("submit",function(event){
		event.preventDefault();
		$(".overlay").show();
		$.ajax({
			url	:	"login.php",
			method:	"POST",
			data	:$("#login").serialize(),
			success	:function(data){
				if(data == "login_success"){
					window.location.href = "profile.php";
				}else{
					$("#e_msg").html(data);
					$(".overlay").hide();
				}
			}
		})
	})
	//end

	//Get User Information before checkout
	$("#signup_form").on("submit",function(event){
		event.preventDefault();
		$(".overlay").show();
		$.ajax({
			url : "register.php",
			method : "POST",
			data : $("#signup_form").serialize(),
			success : function(data){
				$(".overlay").hide();
				if (data == "register_success") {
					window.location.href = "profile.php";
				}else{
					$("#signup_msg").html(data);
				}
				
			}
		})
	})
	//Get User Information before checkout end here

	//Add Product into Cart with quantity 1
	$("body").delegate("#product","click",function(event){
		var pid = $(this).attr("pid");
		event.preventDefault();
		$(".overlay").show();
		$.ajax({
			url : "action.php",
			method : "POST",
			data : {addToCart:1,proId:pid},
			success : function(data){
				getCartItem();
				$('.overlay').hide();
				new Notify ({
					title: data,
					autoclose: true,
					status: 'success',
					autotimeout: 3000,
					customClass: 'toast',
					distance:0
				})
			}
		})
	})
	//Add Product into Cart End Here

	//Add Product into Cart with custom Quantity
	$("body").delegate("#add-to-cart","click",function(){
		var pid = $(this).attr("p_id");
		var qty = $("#input-quantity").val();
		var remain=parseInt($(".input-number").attr("max"));
		console.log(remain);
		if(remain>=qty&&remain>0&&qty>0&&qty!=""){
			$(".overlay").show();
			$.ajax({
				url : "action.php",
				method : "POST",
				data : {addToCart:1,proId:pid,qty:qty},
				success : function(data){
					getCartItem();
					$('.overlay').hide();
					new Notify ({
						title: data,
						autoclose: true,
						status: 'success',
						autotimeout: 3000,
						customClass: 'toast',
						distance:0
					})
					
				}
			})
		}else if(remain<=0){
			alert("Out of stock!");
		}else if(qty>remain){
			alert("Reached the maximum quantity available for this item! Try agian");
		}else if(qty<0||qty==""){
			alert("Invalid Quantity");
		}
	})

	//Add Product into Cart with custom Quantity End


	//Count user cart items funtion
	
	//Count user cart items funtion end

	//Fetch Cart item from Database to dropdown menu
	getCartItem();
	function getCartItem(){
		$.ajax({
			url : "action.php",
			method : "POST",
			data : {Common:1,getCartItem:1},
			success : function(response){
				$(".overlay").show();
				response = JSON.parse(response);
				$("#cart_product").html(response.cartHtml);
				$("#cartNo").html(response.count);
				$(".removeCartItem_instance").click(function(event){
					var remove_id = $(this).attr("remove_id");
					console.log(remove_id);
					$.ajax({
						url	:	"action.php",
						method	:	"POST",
						data	:	{removeItemFromCart:1,rid:remove_id},
						success	:	function(data){
							getCartItem();
						}
					})
				})
				$("#viewCart").on("click touchend", function(){
					console.log("viewcart");
					if($(this).attr("view")){
						window.location.href='cart.php';
					}else{
						new Notify ({
							title: 'Please Login to use this feature...',
							autoclose: true,
							status: 'error',
							autotimeout: 1500,
							customClass: 'toast',
							distance:0
						})
					}
					return false;
				});
				$(".overlay").hide();
			}
		})
	}
	
	//Fetch Cart item from Database to dropdown menu

	/*
		Whenever user change qty we will immediate update their total amount by using keyup funtion
		but whenever user put something(such as ?''"",.()''etc) other than number then we will make qty=1
		if user put qty 0 or less than 0 then we will again make it 1 qty=1
		('.total').each() this is loop funtion repeat for class .total and in every repetation we will perform sum operation of class .total value 
		and then show the result into class .net_total
	*/
	//Change Quantity end here 

	/*
		whenever user click on .remove class we will take product id of that row 
		and send it to action.php to perform product removal operation
	*/
	checkOutDetails();
	$("body").delegate(".removeCartItem","click",function(event){
		var remove_id = $(this).attr("remove_id");
		console.log(remove_id);
		$.ajax({
			url	:	"action.php",
			method	:	"POST",
			data	:	{removeItemFromCart:1,rid:remove_id},
			success	:	function(data){
				new Notify ({
					title: data,
					autoclose: true,
					status: 'success',
					autotimeout: 3000,
					customClass: 'toast',
					distance:0
				})
				checkOutDetails();
			}
		})
	})
	/*
		whenever user click on .update class we will take product id of that row 
		and send it to action.php to perform product qty updation operation
	*/
	$("body").delegate(".updateCartItem","click",function(event){
		var qty = $(this).parent().find(".qty").val();
		var id = $(this).attr("update_id");
		console.log(qty);
		$.ajax({
			url	:	"action.php",
			method	:	"POST",
			data	:	{updateCartItem:1,update_id:id,qty:qty},
			success	:	function(data){
				new Notify ({
					title: data,
					autoclose: true,
					status: 'success',
					autotimeout: 3000,
					customClass: 'toast',
					distance:0
				})
				checkOutDetails();
			}
		})


	})
	net_total();
	/*
		checkOutDetails() function work for two purposes
		First it will enable php isset($_POST["Common"]) in action.php page and inside that
		there is two isset funtion which is isset($_POST["getCartItem"]) and another one is isset($_POST["checkOutDetials"])
		getCartItem is used to show the cart item into dropdown menu 
		checkOutDetails is used to show cart item into Cart.php page
	*/
	function checkOutDetails(){
	 $('.overlay').show();
		$.ajax({
			url : "action.php",
			method : "POST",
			data : {Common:1,checkOutDetails:1},
			success : function(data){
				$('.overlay').hide();
				if(data!="cart empty"){
					$("#cart_checkout").html(data);
					$("#checkout-form").html(`<button class="btn btn-primary btn-block" type="submit" name="order" value="1">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card mr-2">
													<rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
													<line x1="1" y1="10" x2="23" y2="10"></line>
												</svg>Proceed to Checkout
											</button>`);
					$('.input-number').each(function() {
						var $this = $(this),
						$input = $this.find('input[type="number"]'),
						up = $this.find('.cart-qty-up'),
						down = $this.find('.cart-qty-down'),
						max = $this.attr("max");
	
				
						down.on('click', function () {
							var value = parseInt($input.val()) - 1;
							value = value < 1 ? 1 : value;
							$input.val(value);
							$input.change();
						})
				
						up.on('click', function () {
							var value = parseInt($input.val()) ;
							console.log(value);
							if(isNaN(value)){
								$input.val(1);
								$input.change();
							}else if(value < max){
								$input.val(value+1);
								$input.change();
							}else if(value>=max){
								new Notify ({
									title: 'Maximum value',
									autoclose: true,
									status: 'error',
									autotimeout: 3000,
									customClass: 'toast',
									distance:0
								})
							}
						})
					});
					net_total();
				}else{
					$("#cart_checkout").html("");
					
					net_total();
				}
			}
		})
	}
	/*
		net_total function is used to calcuate total amount of cart item
	*/
	function net_total(){
		var net_total = 0;
		$('.cartItem').each(function(){
			var price  = $(this).find('.price').attr("value");
			var qty = $(this).find('.qty').val();
			net_total += price * qty;
		})
		$('#cartTotal').html(new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(net_total));
	}

	//remove product from cart

	page();
	function page(){
		$.ajax({
			url	:	"action.php",
			method	:	"POST",
			data	:	{page:1},
			success	:	function(data){
				$("#pageno").html(data);
			}
		})
	}
	$("body").delegate("#page","click",function(){
		var pn = $(this).attr("page");
		$.ajax({
			url	:	"action.php",
			method	:	"POST",
			data	:	{getProduct:1,setPage:1,pageNumber:pn},
			success	:	function(data){
				$("#get_product").html(data);
			}
		})
	})
	$("#prevPage").click(function(){
		var pageNo = $(this).val();
		if(pageNo>1){
			product(pageNo);
			$(this).val(pageNo-1);
			$('#nextPage').val(pageNo-1);
		}
		document.body.scrollTop = 0;
		document.documentElement.scrollTop = 0;
	})
	$("#nextPage").click(function(){
		var pageNo = $(this).val();
		if(pageNo>1){
			product(pageNo);
			$(this).val(pageNo+1);
			$('#nextPage').val(pageNo+1);
		}
		document.body.scrollTop = 0;
		document.documentElement.scrollTop = 0;
	})
	// Input number
	$('.collapse-btn').click(function(){
		var target = $(this).attr('data-target');
		$(target).collapse('toggle');
	});
	
	$("#viewOrder").on("click touchend", function(){
		console.log("viewOrder");
		if($(this).attr("view")){
			window.location.href='customer_order.php';
		}else{
			new Notify ({
				title: 'Please Login to use this feature...',
				autoclose: true,
				status: 'error',
				autotimeout: 1500,
				customClass: 'toast',
				distance:0
			})
		}
		return false;
	});
	$(".cart-dropdown").click(function(e){
		e.stopPropagation();
	});
	$(".dropdown-menu").click(function(e){
		e.stopPropagation();
	});

	

})




















