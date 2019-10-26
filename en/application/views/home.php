<section class="home-banner">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 offset-md-6">
                <div class='head'>Gadget Store</div>
                <div class='sub-head'>Try out our chatbot system to make your purchases</div>
                <button class="route" route="<?php echo base_url.'/index.php/chatbot'; ?>">GET STARTED</button>
            </div>
        </div>
    </div>
</section>
<section class="featured products">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12">
                <div class="header">
                    OUR TOP PRODUCTS
                </div>
            </div>
        </div>
        <hr>
        <div class="row mt-5">
            <?php
            if($products != false)
            {
                foreach($products as $product)
                {
            ?>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="box">
                        <img src="<?php echo $product['image'] ?>" alt="<?php echo $product['name'] ?>">
                        <div class="product-details">
                            <div class="name mb-3">
                                <a href="<?php echo base_url.'/index.php/store/detail/'.$product['id']; ?>"><?php echo $product['name'] ?></a>
                            </div>
                            <div class="description">
                                <?php echo $product['description'] ?>
                            </div>
                            <div class="col-4">
                                <hr/>
                            </div>
                            <div class=" d-flex justify-content-between action mb-3">
                                <div class="wish">
                                    <?php
                                        if(!isset($_SESSION['wish']))
                                        {
                                            $_SESSION['wish'] = [];
                                        }
                                        if(array_key_exists($product['id'], $_SESSION['wish']))
                                        {
                                    ?>
                                            <i id="<?php echo $product['id'] ?>" class=" add-wish fa fa-heart" status="1" style="color:rgb(236, 70, 70);"></i>
                                    <?php 
                                        }
                                        else
                                        { 
                                    ?>
                                            <i id="<?php echo $product['id'] ?>" class=" add-wish fa fa-heart" status="0"></i>
                                    <?php 
                                        }
                                    ?>
                                </div>
                                <div class="cart">
                                    <?php
                                        if(!isset($_SESSION['cart']))
                                        {
                                            $_SESSION['cart'] = [];
                                        }
                                        if(array_key_exists($product['id'], $_SESSION['cart']))
                                        {
                                    ?>
                                            <a href="javascript:void" id="<?php echo $product['id'] ?>" status="1" style="color:rgb(236, 70, 70);" class="add-cart"> In cart </a>
                                    <?php 
                                        }
                                        else
                                        { 
                                    ?>
                                            <a href="javascript:void" id="<?php echo $product['id'] ?>" status="0" class="add-cart"> Add to cart </a>
                                    <?php 
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="price">
                            <sup>₦</sup><?php echo $product['price'] ?>
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
</section>
