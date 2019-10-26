<section class="wish-banner">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class='head'><?php echo $bannerHead ?></div>
            </div>
        </div>
    </div>
</section>

<section class="mb-5">
    <div class="container-fluid back-shop">
        <a href="<?php echo base_url.'/index.php/store'?>"> <i class="fa fa-caret-left"></i> Continue Shopping</a>
    </div>
<div class="container">
    <div class="row">
        <div class=" col-sm-12 col-md-8 mb-4 wish-items">
            <div class="wish-head">
                <span>ITEMS (<?php echo '<span class="item-no">'.count($this->session->wish).'</span>'; ?>)</span>
            </div>
            <?php 
                if($wish_items != false)
                {

                    foreach($wish_items as $wish_products)
                    { 
                        $url_name = str_replace(" ", "-", $wish_products['name']);
                        ?>
                        <div class="row item">
                            <div class="col-md-3">
                                <div class="box">
                                    <img class="img-thumbnail" src="<?php echo $wish_products['image']; ?>"  alt="No Image" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="box">
                                    <p class="name"><?php echo $wish_products['name']; ?></p>
                                    <div class="detail">
                                        <label class="mr-2">Category:</label><span class="owner"><?php echo $wish_products['category']; ?></span>
                                    </div>
                                    <div class="detail">
                                        <label class="mr-2">Weight: </label><span class="weight"><?php echo $wish_products['weight']; ?></span>
                                    </div>
                                    <div class="detail">
                                        <label class="mr-2">Price: </label><span class="detail"><span> &#8358;</span><?php echo $wish_products['price']; ?></span>
                                    </div>
                                    <div class="buttons d-flex justify-content-between">
                                        <button status="0" id="<?php echo $wish_products['id']; ?>" class="remove_wish">Remove</button>
                                        <a href="<?php echo base_url.'/index.php/store/detail/'.$wish_products['id']; ?>"><button>Add to wish</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?> 
        </div>
    </div>
</div>
</section>