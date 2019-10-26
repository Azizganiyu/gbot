<section class="store-banner">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class='head'><?php echo $bannerHead ?></div>
            </div>
        </div>
    </div>
</section>
<section class="store products">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 filter">
                <div class="text-secondary mt-4 mb-3">Filter</div>
                <div class="sort-button">
                    
                    <?php $current_url = current_url();?>
                        <form method="post" action="<?php echo $current_url ?>">
                        <input type="text" name="price" value="desc" hidden>
                        <button type="submit" class="mr-5 "><i class="fas fa-money-bill-alt mr-3 mb-3"></i>Price - high</button>
                    </form>
                    <form method="post" action="<?php echo $current_url ?>">
                        <input type="text" name="price" value="asc" hidden>
                        <button type="submit" ><i class="fas fa-money-bill mr-3"></i>price - low</button> 
                    </form>
                </div>
            </div>
</div>
        <div class="row">
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
                                <?php echo $product['name'] ?>
                            </div>
                            <div class="description">
                                <?php echo substr($product['description'], 0, 70)  ?>
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
                            <div class="detail mt-3">
                                <a href="<?php echo base_url.'/index.php/store/detail/'.$product['id']; ?>" class="btn btn-sm btn-danger">More Detail</a>
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