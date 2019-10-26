<section class="cart-banner">
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
        <div class=" col-sm-12 col-md-8 mb-4 cart-items">
            <div class="cart-head">
                <span>ITEMS (<?php echo '<span class="item-no">'.count($this->session->cart).'</span>'; ?>)</span>
            </div>
            <?php 
                $total_price = 0;
                if($cart_items != false)
                {

                    foreach($cart_items as $cart_products)
                    { 
                        $url_name = str_replace(" ", "-", $cart_products['name']);
                        ?>
                        <div class="row item">
                            <div class="col-md-3">
                                <div class="box">
                                    <img class="img-thumbnail" src="<?php echo $cart_products['image']; ?>"  alt="No Image" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="box">
                                    <p class="name"><?php echo $cart_products['name']; ?></p>
                                    <div class="detail">
                                        <label class="mr-2">Category:</label><span class="owner"><?php echo $cart_products['category']; ?></span>
                                    </div>
                                    <div class="detail">
                                        <label class="mr-2">Weight: </label><span class="weight"><?php echo $cart_products['weight']; ?></span>
                                    </div>
                                    <div class="detail">
                                        <label class="mr-2">Qty:</label><span class="quantity"><?php echo $this->session->cart[$cart_products['id']]; ?></span>
                                    </div>
                                    <div class="detail">
                                        <label class="mr-2">Unit Price: </label><span class="detail"><span> &#8358;</span><?php echo $cart_products['price']; ?></span>
                                    </div>
                                    <div class="buttons">
                                        <button status="0" id="<?php echo $cart_products['id']; ?>" price="<?php echo $cart_products['price']*$this->session->cart[$cart_products['id']]; ?>" class="remove_cart">Remove</button>
                                        <a href="<?php echo base_url.'/index.php/store/detail/'.$cart_products['id']; ?>"><button>Edit</button></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="box">
                                    <p class="per-total-price"><span>&#8358;</span><?php echo $cart_products['price']*$this->session->cart[$cart_products['id']]; ?> </p>
                                </div>
                            </div>
                        </div>
                        <?php
                        $total_price += $cart_products['price'] * $this->session->cart[$cart_products['id']];
                    }
                }
                ?> 
        </div>
            
        <div class=" col-sm-12 col-md-4 cart-summary">
            <div class = "box">
                <div>
                    <h3>Order summary</h3>
                </div>
                <p class="text-muted">Delivery and additional costs are calculated based on the values you have entered.</p>
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Order subtotal</td>
                                <th><span>&#8358;</span><?php echo '<span class="sub-total">'.$total_price.'</span>'; ?></th>
                            </tr>
                            <tr>
                                <td>Delivery and handling</td>
                                <th>Free<?php $delivery = 0 ?></th>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <th><span>&#8358;</span><?php echo '<span class="total">'.($total_price + $delivery).'</span>'; ?></th>
                            </tr>
                        </tbody>
                    </table>
                    <a href="<?php echo base_url.'/index.php/store/checkout'?>"><button class="checkout" <?php if(count($this->session->cart) == 0){echo 'disabled'; } ?>> Checkout </button></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>