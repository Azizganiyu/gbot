<header>
    <nav class="top">
        <div class="navbar d-flex justify-content-between">
            <div class="d-flex">
                <div class="title"><span class="gadget">GSTORE-</span><span class="store">CHATBOT</span></div>
            </div>
            <div class="d-flex">
                <!--<button data-toggle="modal" data-target="#logoutModal" title="Logout!" class="sign-out"><i class="ml-2 fa fa-sign-out-alt"></i></button>-->
                <select class="language">
                    <option value="">English</option>
                    <option value="">Pidgin</option>
                    <option value="">Hausa</option>
                </select>
                
                <a href="<?php echo base_url ?>" class="btn btn-sm btn-link site">Back to site</a>
  
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
        <h4 class="modal-title title">Are you sure you want to log out?</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
       <div class="container">
           <div class="row">
               <div class="col-12">
                    <a href="<?php echo base_url.'/index.php/admin/user/logout' ?>" class=" mt-3 submit ml-4 btn btn-danger btn-sm">Logout</a>
               </div>
            </div>
       </div>
      </div>

    </div>
  </div>
</div>