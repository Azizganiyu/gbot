<section class="checkout-banner">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class='head'><?php echo $bannerHead ?></div>
            </div>
        </div>
    </div>
</section>
<a href="<?php echo base_url.'/index.php/store' ?>" class=" mt-5 ml-5 btn btn-sm btn-secondary"> <i class="fa fa-caret-left mr-2"></i> Back to store</a>
<section>
    <div class="container checkout">
    <form method="post" action="<?php echo base_url ?>/index.php/store/checkout">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="payment-method">
                    <h6 class="header">PAYMENT METHOD</h6>
                    <div class=" box d-flex justify-content-between">
                        <div class="option">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" name="method" value="bank" id="Bank-transact" type="radio">
                                <label class="custom-control-label text-secondary" for="Bank-transact"> Bank Transaction </label>
                            </div>
                        </div>
                        <div class="option">
                            <div class="custom-control custom-radio">
                                <input checked class="custom-control-input" name="method" value="gateway" id="gate-way" type="radio">
                                <label class="custom-control-label text-secondary" for="gate-way"> Gate Way</label>
                            </div>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="shipping-details mt-5">
                    <h6 class="header">SHIPPING DETAILS</h6>
                    <div class="box">
                        <div class="form">
                            <label for="name">Full Name</label>
                            <input required type="text" id="name" name="name" readonly value="<?php echo $user['name']; ?>" placeholder="Enter your full name">
                        </div>
                        <div class="form">
                            <label for="email">Email</label>
                            <input required type="email" id="email" name="email" readonly value="<?php echo $user['email']; ?>" placeholder="Enter your email address">
                        </div>
                        <div class="form">
                            <label for="state">State</label>
                            <select required name="state" id="state">
                                <option><?php echo $d_details['state']; ?></option>
                            </select>
                        </div>
                        <div class="form">
                            <label for="city">City/LGA</label>
                            <div class="text-danger"><?php echo form_error('city');?></div>
                            <select required name="city" id="city">
                                <option><?php echo $d_details['city']; ?></option>
                            </select>
                        </div>
                        <div class="form">
                            <label for="address">Address</label>
                            <div class="text-danger"><?php echo form_error('city');?></div>
                            <input required type="text" id="address" name="address" value="<?php
                                echo $d_details['address'];
                            ?>" placeholder="e.g no. 123 Ikeja street">
                        </div>
                        <div class="form">
                            <label for="phone">Phone Number</label>
                            <div class="text-danger"><?php echo form_error('phone');?></div>
                            <input required type="text" id="phone" name="phone" value="<?php
                                echo $d_details['phone'];
                            ?>" placeholder="e.g 07082869535">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="order-summary">
                    <h6 class="header">ORDER SUMMARY</h6>
                    <div class="box">
                        <?php
                        $total_price = 0;
                        if($cart_items != false)
                        {
                            foreach($cart_items as $cart_products)
                            {
                        ?>
                        <div class="details d-flex justify-content-between">
                            <div class="image">
                                <h6>Image</h6>
                                <img class="img-thumbnail" src="<?php echo $cart_products['image']; ?>"  alt="No Image" >
                            </div>
                            <div class="name">
                                <h6>Name</h6>
                                <p class="name"><?php echo $cart_products['name']; ?></p>
                            </div>
                            <div class="price">
                                <h6>Price</h6>
                                <p> &#8358;<?php echo $cart_products['price']; ?></p>
                            </div>
                            <div class="qty text-center">
                                <h6>Quantity</h6>
                                <p>x<?php echo $this->session->cart[$cart_products['id']]; ?></p>
                            </div>
                            <div class="total">
                                <h6>Total</h6>
                                <p><span>&#8358;</span><?php echo $cart_products['price']*$this->session->cart[$cart_products['id']]; ?>.00 </p>
                            </div>
                        </div>
                        <?php
                                $total_price += $cart_products['price'] * $this->session->cart[$cart_products['id']];
                            }
                        }
                        ?>
                        <div class=" text-center over-all-total">
                            <p> &#8358;<?php  echo $total_price ?>.00 </p>
                            <input type="text" name="price" value="<?php  echo $total_price ?>" hidden>
                        </div>
                    </div>
                </div>
                <div class="submit text-center">
                    <button type="submit" <?php if(count($this->session->cart) == 0){echo 'disabled'; } ?>>Continue</button>
                </div>
            </div>
        </div>
    </form>
    </div>
</section>