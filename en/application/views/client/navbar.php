<?php 
    if(!isset($_SESSION['cart']))
    {
        $_SESSION['cart'] =  [];
    }
    
    if(!isset($_SESSION['wish']))
    {
        $_SESSION['wish'] =  [];
    }
    
?>
<header>
    <nav class="top">
        <div class="navbar d-flex justify-content-between">
            <div class="d-flex">
                <div class="title">
                    <a href="<?php echo base_url ?>"><span class="gadget">G</span><span class="store">STORE</span></a>
                </div>
            </div>
            <div class="d-flex">
                <!--<button data-toggle="modal" data-target="#logoutModal" title="Logout!" class="sign-out"><i class="ml-2 fa fa-sign-out-alt"></i></button>-->
                <select class="language">
                    <option value="">English</option>
                    <option value="">Pidgin</option>
                </select>
                
                <?php echo form_open('store/view');?>
                    <input type="text" name="search" class="search" placeholder="Enter search key">
                </form>
                <!--<button class="search-icon">
                    <i class="fa fa-search"></i>
                </button>-->
            </div>
        </div>
    </nav>
    <nav class="bottom">
        <div class="navbar d-flex justify-content-between">
            <div class="menu-icon mt-2">
                <a href="javascript:void(0)" onclick="openSideNav()">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
            <div class="links">
                <ul>
                    <li class="navlink"><a href="<?php echo base_url ?>">Home</a></li>
                    <li class="navlink"><a href="<?php echo base_url.'/index.php/store'?>">Store</a></li>
                    <li class="navlink category"><a href="javascript:void">Categories<i class=" ml-2 fas fa-angle-down"></i></a></li>
                    <li class="navlink"><a href="#">About</a></li>
                </ul>
            </div>
            <div class="d-flex">

                <div class="mr-5 dropdown">
                    <button type="button" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user"></i>
                    </button>
                    <div class="dropdown-menu">
                        <?php
                        if(!$this->session->logged_in || $this->session->logged_in == false)
                        {
                            echo '<a class="dropdown-item" href="'.base_url.'/index.php/users">Sign in</a>';
                        }
                        else
                        {
                            echo '<a class="dropdown-item" href="'.base_url.'/index.php/store/orders">My orders</a>';
                            echo '<hr/>';
                            echo '<a class="dropdown-item" data-toggle="modal" data-target="#logoutModal" href="#">Sign out</a>';
                        }
                    ?>
                    </div>
                </div>
                <div class="shopping-wish mr-5">
                    <a href="<?php echo base_url.'/index.php/store/view_wish' ?>"><i class="fa fa-heart"></i></a>
                    <div class="wish-count"><?php echo count($_SESSION['wish']); ?></div>
                </div>
                <div class="shopping-cart mr-4">
                    <a href="<?php echo base_url.'/index.php/store/view_cart' ?>"><i class="fa fa-shopping-cart"></i></a>
                    <div class="cart-count"><?php echo count($_SESSION['cart']); ?></div>
                </div>

            </div>
        </div>

        <div class="categories-link d-flex justify-content-between">
            <a href="<?php echo base_url.'/index.php/store' ?>" class='link text-light'>All</a>
            <?php
            if($categories != false)
            {
                foreach($categories as $category)
                { 
                    $link = base_url.'/index.php/store/view/'.$category['name'];
                    echo "<a href='{$link}' class='link text-light'>{$category['name']}</a>";
                }
            }
            ?>
        </div>

        <div class="sidebar">

        <div class="row">
            <div class="links text-center col-6">
                <a href="<?php echo base_url ?>">Home</a>
                <a href="<?php echo base_url.'/index.php/store'?>">Store</a>
                <a href="#">About</a>
            </div>
            <div class="links cats col-6">
                <div class="header">
                    <h6>CATEGORIES</h6>
                </div>
            <?php
            if($categories != false)
            {
                foreach($categories as $category)
                { 
                    $link = base_url.'/index.php/store/view/'.$category['name'];
                    echo "<a href='{$link}' class='link text-light'>{$category['name']}</a>";
                }
            }
            ?>
            </div>
        </div>
            
        </div>
    </nav>
</header>

<!-- Logout Modal -->
<div class="modal" id="logoutModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h6 class="modal-title title">Are you sure you want to log out?</h6>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
       <div class="container">
           <div class="row">
               <div class=" d-flex col-12">
                    <form action="<?php echo base_url ?>/index.php/users/logout" method="post">
                        <div class="mb-3">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" name="od_logout" value="yes" id="od_logout" type="checkbox">
                                <label class="custom-control-label text-secondary" for="od_logout"> Logout from all other devices </label>
                            </div>
                            </div>
                        <input type="submit" class="btn btn-secondary btn-sm" name="logout" value="Logout">
                    </form>
                    <div class="ml-4" id="targetLayer"></div>
               </div>
            </div>
       </div>
      </div>

    </div>
  </div>
</div>

