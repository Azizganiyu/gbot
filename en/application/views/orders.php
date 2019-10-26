<section class="order-banner">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class='head'><?php echo $bannerHead ?></div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="user-info">
                    <h5><?php echo $user['name'] ?></h5>
                    <h6><?php echo $user['email'] ?></h6>
                </div>
                <hr/>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2">
                <div class=" mt-5 orders">
                    <h5>YOUR ORDERS</h5>
                    <div class="lists">
                        <?php
                        if($orders != false)
                        {
                            foreach($orders as $order){

                        ?>
                        <div class="box">
                            <div class="order-no">
                                #<?php echo $order['invoice'] ?>
                            </div>
                            <div class="order-date">
                            <?php echo date('M d, Y',strtotime($order['date_ordered']))?>
                            </div>

                            <?php
                            $products = json_decode($order['products']);
                            foreach($products as $id => $quantity)
                            {
                                $product = $this->product_model->get_product($id);
                            ?>

                            <div class="items d-flex justify-content-between">
                                <div class="name">
                                    <label>Name</label>
                                    <?php echo $product['name'] ?> 
                                </div>
                                <div class="quantity">
                                    <label>Qty</label>
                                    <?php echo $quantity ?>
                                </div>
                                <div class="price">
                                    <label>Price</label>
                                    &#8358;<?php echo $product['price'] * $quantity ?>
                                </div>
                            </div>
                            <hr>

                            <?php
                            }
                            ?>

                            <div class="payment d-flex justify-content-between">
                                <div class="price">
                                    <h6>Total Price</h6>
                                    &#8358;<?php echo $order['price'] ?>
                                </div>
                                <div class="payment-method">
                                    <h6>Payment Mode</h6>
                                    <?php echo $order['payment_method'] ?>
                                </div>
                            </div>
                            <div class="action d-flex justify-content-between">
                                <button>Pay Now</button>
                                <div class="payment-status"><i class="fa fa-info mr-2"></i><?php echo $order['payment_status'] ?></div>
                            </div>
                        </div>
                        <?php 
                            }
                        }
                        else
                        {
                            echo '<div class="mt-5 text-primary">You have not made any order!</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>