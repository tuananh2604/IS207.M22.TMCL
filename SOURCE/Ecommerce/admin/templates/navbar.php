 <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Umori Cosmetic</a>
  <ul class="navbar-nav px-3 col-md-2">
    <li class="nav-item text-nowrap" style="display:flex;justify-content:space-evenly;">
    	<?php
    		if (isset($_SESSION['admin_id'])) {
    			?>
					<a class="nav-link" href="../admin/register.php">Register New Admin</a>
    				<a class="nav-link" href="../admin/admin-logout.php">Sign out</a>
    			<?php
    		}else{
    			$uriAr = explode("/", $_SERVER['REQUEST_URI']);
    			$page = end($uriAr);
    			if ($page === "login.php") {
    				
    			}else{
    				?>
	    				<a class="nav-link" href="../admin/login.php">Login</a>
	    			<?php
    			}


    			
    		}

    	?>
      
    </li>
  </ul>
</nav>