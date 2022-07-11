<?php session_start(); ?>
<?php include_once("./templates/top.php"); ?>
<?php include_once("./templates/navbar.php"); ?>
<div class="container-fluid">
  <div class="row">
    
    <?php include "./templates/sidebar.php"; ?>

      <div class="row">
      	<div class="col-10">
      		<h2>Product List</h2>
      	</div>
      	<div class="col-2">
      		<a href="#" data-toggle="modal" data-target="#add_product_modal" class="btn btn-warning btn-sm">Add Product</a>
      	</div>
      </div>
      
      <div class="table-responsive">
        <table class="table table-striped table-sm table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Image</th>
              <th>Original Price</th>
              <th>Price</th>
              <th>Sale</th>
              <th>Quantity</th>
              <th>Rating</th>
              <th>Category</th>
              <th>Brand</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="product_list">
            <!-- <tr>
              <td>1</td>
              <td>ABC</td>
              <td>FDGR.JPG</td>
              <td>122</td>
              <td>eLECTRONCS</td>
              <td>aPPLE</td>
              <td><a class="btn btn-sm btn-info"></a><a class="btn btn-sm btn-danger">Delete</a></td>
            </tr> -->
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>



<!-- Add Product Modal start -->
<div class="modal fade" id="add_product_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="add-product-form" enctype="multipart/form-data">
        	<div class="row">
        		<div class="col-12">
        			<div class="form-group">
		        		<label>Product Name</label>
		        		<input type="text" name="product_name" class="form-control" placeholder="Enter Product Name">
		        	</div>
        		</div>
        		<div class="col-12">
        			<div class="form-group">
		        		<label>Brand Name</label>
		        		<select class="form-control brand_list" name="brand_id">
		        			<option value="">Select Brand</option>
		        		</select>
		        	</div>
        		</div>
        		<div class="col-12">
        			<div class="form-group">
		        		<label>Category Name</label>
		        		<select class="form-control category_list" name="category_id">
		        			<option value="">Select Category</option>
		        		</select>
		        	</div>
        		</div>
        		<div class="col-12">
        			<div class="form-group">
		        		<label>Product Description</label>
		        		<textarea class="form-control" name="product_desc" placeholder="Enter product desc"></textarea>
		        	</div>
        		</div>
            <div class="col-12">
              <div class="form-group">
                <label>Rating ( in range 0 to 5 )</label>
                <input type="number" name="product_rate" class="form-control" placeholder="Enter Rating">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Product Qty</label>
                <input type="number" name="product_qty" class="form-control" placeholder="Enter Product Quantity">
              </div>
            </div>
        		<div class="col-12">
        			<div class="form-group">
		        		<label>Product Original Price</label>
		        		<input type="number" name="product_oriprice" class="form-control oriprice" placeholder="Enter Product Original Price">
		        	</div>
        		</div>
            <div class="col-12">
        			<div class="form-group">
		        		<label>Product Price</label>
		        		<input type="number" name="product_price" class="form-control price" placeholder="Enter Product Price">
		        	</div>
        		</div>
            <div class="col-12">
        			<div class="form-group">
		        		<label>Sale %</label>
		        		<input type="number" name="product_sale" class="form-control sale" placeholder="Enter Product Sale">
		        	</div>
        		</div>
        		<div class="col-12">
        			<div class="form-group">
		        		<label>Product Keywords <small>(eg: apple, iphone, mobile)</small></label>
		        		<input type="text" name="product_keywords" class="form-control" placeholder="Enter Product Keywords">
		        	</div>
        		</div>
        		<div class="col-12">
        			<div class="form-group">
		        		<label>Product Image <small>(format: jpg, jpeg, png)</small></label>
		        		<input type="file" name="product_image" class="form-control">
		        	</div>
        		</div>
        		<input type="hidden" name="add_product" value="1">
        		<div class="col-12">
        			<button type="button" class="btn btn-primary add-product">Add Product</button>
        		</div>
        	</div>
        	
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Add Product Modal end -->

<!-- Edit image Product Modal start -->
<div class="modal fade" id="edit_image_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Image Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="image-modal-msg" style="color:#dc3545"></div>
        <form id="edit-image-form" enctype="multipart/form-data">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <h4><b>Primary Image</b></h4>
                <div class="form-group" >
                  <img  id="primary-img-show" style="display: inline-block; max-height:120px;padding: 4px; border: 1px solid #101010" />
                </div>
                <h4><b>New Primary Image</b></h4>
                <p>Note: a Product has only one primary image, new primary image will replace the old one!</p>
                <!-- input new primary image -->
                <input name="primaryImage" class="form-control" id="input-primary-img" type="file" accept="image/*" onchange="loadPrimaryImg(event)">
                <div class="form-group">
                  <img  id="new-primary-img-show"  style="display: inline-block; max-height:120px;padding: 4px; border: 1px solid #101010" /> <!-- preview a primary image -->
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <h4><b>Extra Images</b></h4>
                <div class="form-group" id="extra-img-show" >
                  
                </div>
                <h4><b>Add Extra Images</b></h4>
                <input name="extraImages[]" class="form-control" id="input-extra-img" type="file" accept="image/*" multiple> <!-- input multi images -->
                <div class="form-group" id="extra-images-list" >
                  <!-- preview images show here -->
                </div>
              </div>
            </div>
            <input id="editImage_pid" type="hidden" name="pid">
            <input type="hidden" name="edit_image" value="1">
            <div class="col-12">
              <button type="button" class="btn btn-primary submit-edit-image">Save Changes</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Edit image Product Modal end -->

<!-- Edit Product Modal start -->
<div class="modal fade" id="edit_product_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="edit-product-form" enctype="multipart/form-data">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="e_product_name" class="form-control" placeholder="Enter Product Name">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Brand Name</label>
                <select class="form-control brand_list" name="e_brand_id">
                  <option value="">Select Brand</option>
                </select>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Category Name</label>
                <select class="form-control category_list" name="e_category_id">
                  <option value="">Select Category</option>
                </select>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Product Description</label>
                <textarea class="form-control" name="e_product_desc" placeholder="Enter product desc"></textarea>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Rating ( in range 0 to 5 )</label>
                <input type="number" name="e_product_rate" class="form-control" placeholder="Enter Rating">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Product Qty</label>
                <input type="number" name="e_product_qty" class="form-control" placeholder="Enter Product Quantity">
              </div>
            </div>
            <div class="col-12">
        			<div class="form-group">
		        		<label>Product Original Price</label>
		        		<input type="number" name="e_product_oriprice" class="form-control oriprice" placeholder="Enter Product Original Price">
		        	</div>
        		</div>
            <div class="col-12">
        			<div class="form-group">
		        		<label>Product Price</label>
		        		<input type="number" name="e_product_price" class="form-control price" placeholder="Enter Product Price">
		        	</div>
        		</div>
            <div class="col-12">
        			<div class="form-group">
		        		<label>Sale %</label>
		        		<input type="number" name="e_product_sale" class="form-control sale" placeholder="Enter Product Sale">
		        	</div>
        		</div>
            <div class="col-12">
              <div class="form-group">
                <label>Product Keywords <small>(eg: apple, iphone, mobile)</small></label>
                <input type="text" name="e_product_keywords" class="form-control" placeholder="Enter Product Keywords">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Product Image <small>(format: jpg, jpeg, png)</small></label>
                <input type="file" name="e_product_image" class="form-control">
                <img class="img-fluid" width="50">
              </div>
            </div>
            <input id="editProduct_pid" type="hidden" name="pid">
            <input type="hidden" name="edit_product" value="1">
            <div class="col-12">
              <button type="button" class="btn btn-primary submit-edit-product">Save Changes</button>
            </div>
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Edit Product Modal end -->

<?php include_once("./templates/footer.php"); ?>


<script>
  var loadPrimaryImg = function(event) {
		var reader = new FileReader();
		reader.onload = function(){
		  var output = document.getElementById('new-primary-img-show');
		  output.src = reader.result;
		};
		reader.readAsDataURL(event.target.files[0]);
  };
  $(function() {
  var imagesPreview = function(input, placeToInsertImagePreview) {
    if (input.files) {
      $(placeToInsertImagePreview).empty();
      var filesAmount = input.files.length;
      console.log(filesAmount);
      for (i = 0; i < filesAmount; i++) {
          var reader = new FileReader();
          reader.onload = function(event) {
            var div = document.createElement('div');
            div.style.display="inline-block";
            div.style.margin="2px";
            div.innerHTML='<img style=" max-height:120px;padding: 4px; border: 1px solid #101010" src="'+event.target.result+'"/>';
            $(placeToInsertImagePreview).append(div);
          }
          reader.readAsDataURL(input.files[i]);
      }
    }

  };

  $('#input-extra-img').on('change', function() {
    imagesPreview(this, 'div#extra-images-list');
  });});
    
</script>
<script type="text/javascript" src="./js/products.js"></script>