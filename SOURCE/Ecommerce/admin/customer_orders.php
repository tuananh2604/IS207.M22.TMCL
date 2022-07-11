<?php session_start(); ?>
<?php include_once("./templates/top.php"); ?>
<?php include_once("./templates/navbar.php"); ?>
<div class="container-fluid">
  <div class="row">
    
    <?php include "./templates/sidebar.php"; ?>

      <div class="row">
      	<div class="col-10">
      		<h2>Manage Order</h2>
      	</div>
      </div>
      
      <div class="table-responsive">
        <table class="table table-striped table-sm table-bordered" id="orderTable">
			<thead>
				<tr>
					<th></th>
					<th>Customer Name</th>
					<th>Phone</th>
					<th>Address</th>
					<th>Total</th>
					<th>Status</th>
				</tr>
			</thead>
          	<tbody id="customer_order_list">
           
          	</tbody>
        </table>
	</div>


    </main>
  </div>
</div>



<!-- Modal -->

<?php include_once("./templates/footer.php"); ?>



<script type="text/javascript" src="./js/customers.js"></script>