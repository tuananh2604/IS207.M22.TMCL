$(document).ready(function(){

	var productList;

	

	function getProducts(){
		$.ajax({
			url : '../admin/classes/Products.php',
			method : 'POST',
			data : {GET_PRODUCT:1},
			success : function(response){
				//console.log(response);
				var resp = $.parseJSON(response);
				if (resp.status == 202) {

					var productHTML = '';

					productList = resp.message.products;

					if (productList) {
						$.each(resp.message.products, function(index, value){
							var sale=0;
							if((value.product_oriprice!=0)&(value.product_oriprice!=value.product_price)){
								sale = parseInt((1-(value.product_price/value.product_oriprice))*100);
							}
							productHTML += '<tr>'+
								              '<td style="width:2%">'+''+'</td>'+
								              '<td style="width:30%">'+ value.product_title +'</td>'+
								              '<td style="width:7%"><img width="60" height="60" src="../product_images/'+value.product_image+'"></td>'+
								              '<td style="width:7%">'+ value.product_oriprice +'</td>'+
								              '<td style="width:7%">'+ value.product_price +'</td>'+
								              '<td style="width:3%">'+  sale +'%</td>'+
								              '<td style="width:7%">'+ value.product_qty +'</td>'+
								              '<td style="width:3%">'+ value.product_rate +'</td>'+
								              '<td style="width:7%">'+ value.cat_title +'</td>'+
								              '<td style="width:7%">'+ value.brand_title +'</td>'+
								              '<td style="width:25%">'+
												'<a pid="'+value.product_id+'" class="btn btn-sm btn-primary edit-image" style="color:#fff;"> <span style="display:none;">'+value.product_image+'</span><i class="fas fa-image"></i></a>&nbsp;'+
												'<a class="btn btn-sm btn-info edit-product" style="color:#fff;"><span style="display:none;">'+JSON.stringify(value)+'</span><i class="fas fa-pencil-alt"></i></a>&nbsp;'+
												'<a pid="'+value.product_id+'" class="btn btn-sm btn-danger delete-product" style="color:#fff;"><i class="fas fa-trash-alt"></i></a>'+
											  '</td>'+
								            '</tr>';

						});

						$("#product_list").html(productHTML);
					}

					


					var catSelectHTML = '<option value="">Select Category</option>';
					$.each(resp.message.categories, function(index, value){

						catSelectHTML += '<option value="'+ value.cat_id +'">'+ value.cat_title +'</option>';

					});

					$(".category_list").html(catSelectHTML);

					var brandSelectHTML = '<option value="">Select Brand</option>';
					$.each(resp.message.brands, function(index, value){

						brandSelectHTML += '<option value="'+ value.brand_id +'">'+ value.brand_title +'</option>';

					});

					$(".brand_list").html(brandSelectHTML);

				}
			}

		});
	}

	getProducts();

	$(".add-product").on("click", function(){

		$.ajax({

			url : '../admin/classes/Products.php',
			method : 'POST',
			data : new FormData($("#add-product-form")[0]),
			contentType : false,
			cache : false,
			processData : false,
			success : function(response){
				console.log(response);
				// var resp = $.parseJSON(response);
				if (response.status == 202) {
					$("#add-product-form").trigger("reset");
					$("#add_product_modal").modal('hide');
					getProducts();
					alert(response.message);
					// window.location.href = "index.php";
					//window.location = '../admin/classes/Products.php';
				}else if(response.status == 303){
					// window.location.href = "products.php";
					alert(response.message);
					
				}
			}

		});

	});
	$('#edit_image_modal').on('hidden.bs.modal', function(){
		$("#edit-image-form").trigger("reset");
		$("#new-primary-img-show").attr('src',"");
		$('div#extra-images-list').empty();
	});
	$(document.body).on('click', '.edit-image', function(){

		// console.log($(this).attr("pid"));
		var pid=$(this).attr("pid");
		$('#primary-img-show').attr("src",'../product_images/'+$(this).find('span').text());
		$.ajax({

			url : '../admin/classes/Products.php',
			method : 'POST',
			data : {getProductImage:1,pid:pid},
			
			success : function(response){
				resp = $.parseJSON(response);
				console.log(resp);
				$('#extra-img-show').empty();
				if(resp.message.length>0){
		
					var extraImgHTML='';
					for(var i=0;i<resp.message.length;i++){
						extraImgHTML+=
						'<div class="one-extra-img" style="display: inline-block;">'+
							'<img style=" max-height:120px;padding: 4px; border: 1px solid #101010" src="../product_images/'+resp.message[i]['img_name']+'"/>'+
							'<label style="display:block"><input type="checkbox" name="del_extra_img[]" value = "'+resp.message[i]['img_id']+'">Delete</label>'+
						'</div>';
					}
					$('#extra-img-show').html(extraImgHTML);
				}else{
					var extraImgHTML='<p>There is no Extra Image of this product!</p>';
					$('#extra-img-show').html(extraImgHTML);
				}
			}
		});
		$('#editImage_pid').val(pid);
		$("#edit_image_modal").modal('show');

	});
	$(".submit-edit-image").on('click', function(){

		$.ajax({

			url : '../admin/classes/Products.php',
			method : 'POST',
			data : new FormData($("#edit-image-form")[0]),
			contentType : false,
			cache : false,
			processData : false,
			success : function(response){
				console.log(response);
				var resp = $.parseJSON(response);
				if (resp.primaryImg.status == 202 && resp.extraImg.status == 202 && resp.deleteImg.status == 202) {
					$("#edit-image-form").trigger("reset");
					$("#edit_product_modal").modal('hide');
					getProducts();
					alert("Update Images success...!")
					window.location.href = "products.php";
				}else if(resp.primaryImg.status == 303 ){
					alert(esp.primaryImg.message);
				}else if(resp.extraImg.status == 303 ){
					alert(resp.extraImg.message);
				}else if(resp.deleteImg.status == 303 ){
					alert(resp.deleteImg.message);
				}
			}

		});


	});

	$(document.body).on('click', '.edit-product', function(){

		console.log($(this).find('span').text());

		var product = $.parseJSON($.trim($(this).find('span').text()));

		console.log(product);

		$("input[name='e_product_name']").val(product.product_title);
		$("select[name='e_brand_id']").val(product.brand_id);
		$("select[name='e_category_id']").val(product.cat_id);
		$("textarea[name='e_product_desc']").val(product.product_desc);
		$("input[name='e_product_qty']").val(product.product_qty);
		$("input[name='e_product_rate']").val(product.product_rate);
		$("input[name='e_product_oriprice']").val(product.product_oriprice);
		$("input[name='e_product_price']").val(product.product_price);
		$("input[name='e_product_sale']").val(parseInt(100-(product.product_price/product.product_oriprice)*100));
		$("input[name='e_product_keywords']").val(product.product_keywords);
		$("input[name='e_product_image']").siblings("img").attr("src", "../product_images/"+product.product_image);
		$("input#editProduct_pid").val(product.product_id);
		$("#edit_product_modal").modal('show');

	});

	$(".submit-edit-product").on('click', function(){

		$.ajax({

			url : '../admin/classes/Products.php',
			method : 'POST',
			data : new FormData($("#edit-product-form")[0]),
			contentType : false,
			cache : false,
			processData : false,
			success : function(response){
				console.log(response);
				var resp = $.parseJSON(response);
				if (resp.status == 202) {
					$("#edit-product-form").trigger("reset");
					$("#edit_product_modal").modal('hide');
					getProducts();
					alert(resp.message);
					window.location.href = "products.php";
				}else if(resp.status == 303){
					alert(resp.message);
				}
			}

		});


	});

	$(document.body).on('click', '.delete-product', function(){

		var pid = $(this).attr('pid');
		if (confirm("Are you sure to delete this item ?")) {
			$.ajax({

				url : '../admin/classes/Products.php',
				method : 'POST',
				data : {DELETE_PRODUCT: 1, pid:pid},
				success : function(response){
					console.log(response);
					var resp = $.parseJSON(response);
					if (resp.status == 202) {
						getProducts();
					}else if (resp.status == 303) {
						alert(resp.message);
					}
				}

			});
		}
		

	});
	//chang sale input when price change
	$('.price').on('input', function () {
		
		var oriprice = parseInt($(this).parent().parent().prev().find('.oriprice').val());
		var price = parseInt($(this).val());
		var sale = -1;
		if(oriprice>=price && price>=0){
			sale=parseInt(100-(price/oriprice)*100);
		}
		$(this).parent().parent().next().find('.sale').val(sale);
	})
	//chang price input when sale change
	$('.sale').on('input', function () {
		
		var oriprice = parseInt($(this).parent().parent().prev().prev().find('.oriprice').val());
		var sale = parseInt($(this).val());
		var price = 0;
		if(oriprice>=0 && sale>=0 && sale<=100){
			price=parseInt(oriprice-oriprice*sale/100);
		}
		$(this).parent().parent().prev().find('.price').val(price);
	})

});