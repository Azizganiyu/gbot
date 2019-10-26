<header>
    <nav>
        <div class="navbar d-flex justify-content-between">
            <div class="d-flex">
                <div class="menu-icon mr-4">
                    <a href="javascript:void(0)" onclick="openSideNav()">
                        <i class="fa fa-bars"></i>
                    </a>
                </div>
                <div class="title"><span class="admin">ADMIN</span><span class="panel">PANEL</span></div>
            </div>
            <div>
                <button data-toggle="modal" data-target="#logoutModal" title="Logout!" class="sign-out"><i class="ml-2 fa fa-sign-out-alt"></i></button>
            </div>
        </div>

        <div class="sidebar">
            <div class="admin-image">
                <img src="<?php echo site_url.'/images/admin/admin.png' ?>" alt="logo">
                <h6 class="mt-2"> Admin </h6>
            </div>
            <div class="add-product">
                <button >THE STORE</button>
            </div>
            <div class="links">
                <ul>
                    <li class="navlink" route="<?php echo base_url.'/index.php/dashboard'?>"><i class="fa fa-tachometer-alt mr-2"></i>Dashboard</li>
                    <li class="navlink" route="<?php echo base_url.'/index.php/user'?>"><i class="fa fa-user mr-2"></i>Users</li>
                    <li class="navlink" route="<?php echo base_url.'/index.php/product'?>"><i class="fab fa-product-hunt mr-2"></i>Products</li>
                    <li class="navlink" route="<?php echo base_url.'/index.php/categories'?>"><i class="fa fa-list-alt mr-2"></i>Categories</li>
                </ul>
            </div>
        </div>

        <div class="page-title mt-3 ml-3">
            <p><?php echo $title; ?></p>
        </div>

    </nav>
</header>

<!-- Logout Modal -->
<div class="modal" id="logoutModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title title">Are you sure you want to log out?</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
       <div class="container">
           <div class="row">
               <div class="col-12">
                    <a href="<?php echo base_url.'/index.php/user/logout' ?>" class=" mt-3 submit ml-4 btn btn-danger btn-sm">Logout</a>
               </div>
            </div>
       </div>
      </div>

    </div>
  </div>
</div>