
<section class="detail-banner">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class='head'><?php echo $bannerHead ?></div>
            </div>
        </div>
    </div>
</section>
<section class="product-info">
<div class="container">
        <div class="row">
                <?php
                if($product != false)
                { ?>

                    <div class="col-12 col-md-6">
                        <div class="gallery">
                            <div class="image">
                                <img src="<?php echo $product['image']; ?>" alt="">
                            </div>
                            <div class=" row images">
                            <?php
                                $gallery = explode(',',$product['gallery'] );
                                foreach($gallery as $src)
                                {
                                    if(!empty($src))
                                    {
                                        echo '<div class=" col-6 col-sm-3 thumb">';
                                        echo '<img src="'.$src.'" class="img-thumbnail" alt="No Image" />';
                                        echo '</div>';
                                    }
                                }
                            ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div id="product-info">
                            <div class="row">
                                <div class="col-6">
                                    <div class="name">
                                        <?php echo $product['name'] ?>
                                    </div>
                                    <div class="price">
                                        <sup>₦</sup><?php echo $product['price'] ?>
                                    </div>
                                    <div class="rating">
                                        <?php
                                        $stars = 5;
                                        if($comments != false)
                                        {
                                            $raters = count($comments);
                                            $one = 0;
                                            $two = 0;
                                            $three = 0;
                                            $four = 0;
                                            $five = 0;
                                            foreach($comments as $comment)
                                            {
                                                switch($comment['rating'])
                                                {
                                                    case 1:
                                                        $one++;
                                                        break;
                                                    case 2:
                                                        $two++;
                                                        break;
                                                    case 3:
                                                        $three++;
                                                        break;
                                                    case 4:
                                                        $four++;
                                                        break;
                                                    case 5:
                                                        $five++;
                                                        break;
                                                }
                                            }
                                            $product_rating = round(((1 * $one) + (2 * $two) + (3 * $three) + (4 * $four) + (5 * $five)) / $raters);
                                            for($count = 1; $count <= $product_rating; $count++)
                                            {
                                                echo '<i class="fa fa-star active"></i>';
                                            }
                                            $inactive_star = 5 - $product_rating;
                                            for($count = 1; $count <= $inactive_star; $count++)
                                            {
                                                echo '<i class="fa fa-star"></i>';
                                            }
                                        }
                                        else
                                        {
                                            for($count = 1; $count <= $stars; $count++)
                                            {
                                                echo '<i class="fa fa-star"></i>';
                                            }
                                        }
                                        
                                        ?>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="wish text-right">
                                        <?php
                                            if(array_key_exists($product['id'], $_SESSION['wish']))
                                            {
                                        ?>
                                                <i id="<?php echo $product['id'] ?>" class="add-wish fa fa-heart" status="1" style="cursor:pointer; color:rgb(236, 70, 70);"></i>
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
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-12 description">
                                    <h4>Description</h4>
                                    <hr/>
                                    <div class="info">
                                        <pre><?php echo $product['description'] ?></pre>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12 text-right" id="add-cart">
                                    <form action="<?php echo base_url.'/index.php/store/cart' ?>" method="post">
                                        <button type="button" class="minus"><i class="fa fa-minus"></i></button>
                                        <input type="text" name="quantity" class="qty" readonly="readonly" value="<?php
                                        if(array_key_exists($product['id'], $_SESSION['cart']))
                                        {
                                            echo $_SESSION['cart'][$product['id']];
                                        }
                                        else echo '1';
                                        ?>">
                                        <button type="button" class="add"><i class="fa fa-plus"></i></button>
                                        <input type="text" name="id" value="<?php echo $product['id'] ?>" hidden>
                                        <input type="text" name="status" value="1" hidden>
                                        <input type="submit" name="from_detail" class="mt-2 add-to-cart" value="ADD TO CART">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="comment-list">
                    <div class="comments">
                        <div class="head">
                            <h6>Comments(<?php 
                            if($comments != false)
                            {
                                echo count($comments);
                            }
                            else
                            {
                                echo "0";
                            } ?>)</h6>
                            <hr>
                        </div>
                        <?php
                        if($comments != false)
                        {
                            foreach($comments as $comment)
                            {
                            ?>

                        <div class="list">
                            <div class="row">
                                <div class="col-2 image">
                                    <img class="img-thumbnail" src="/gstore/images/avatar/avatar.png" alt="Image">
                                </div>
                                <div class="col-7 detail">
                                    <div class="rating">
                                        <?php
                                        $rating = $comment['rating'];
                                        for($count = 1; $count <= $rating; $count++)
                                        {
                                            echo '<i class="fa fa-star"></i>';
                                        }

                                        ?>
                                    </div>
                                    <div class="name"><?php echo $comment['name'] ?></div>
                                    <div class="email"><?php echo $comment['email'] ?></div>
                                    <div class="comment"><?php echo $comment['comment'] ?></div>
                                </div>
                                <div class="col-3 date">
                                    <?php echo date('M d, Y',strtotime($comment['date_added']))?>
                                </div>
                            </div>
                        </div>

                            <?php
                                }
                            }
                            else
                            {
                                echo "Be the first to add a comment here!";
                            }
                            ?>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="comment-form">
                    <div class="head">
                        <h6> Comment and rate this product</h6>
                        <hr>
                    </div>
                    <form action="<?php echo base_url.'/index.php/store/add_comment'?>" method="post">
                        <input type="text" name="id" value="<?php echo $product['id'] ?>" hidden/>
                        <div class="form">
                            <input type="text" name="name" required placeholder="Your name"/>
                        </div>
                        <div class="form">
                            <input type="email" name="email" required placeholder="Your Email"/>
                        </div>
                        <div class="form">
                            <textarea name="comment" id="comment" cols="30" rows="10" required placeholder="Enter comment here"></textarea>
                        </div>
                        <div class="rate-system">
                            <h6>Rate this product</h6>
                            <div class="d-flex">
                                <div class="rating">
                                    <label for="star-1" class="star"><i class="fa fa-star"></i></label>
                                    <input type="radio" id="star-1" name="rating" value="1" hidden>

                                    <label for="star-2" class="star"><i class="fa fa-star"></i></label>
                                    <input type="radio" id="star-2" name="rating" value="2" hidden>

                                    <label for="star-3" class="star"><i class="fa fa-star"></i></label>
                                    <input type="radio" id="star-3" name="rating" value="3" hidden>

                                    <label for="star-4" class="star"><i class="fa fa-star"></i></label>
                                    <input type="radio" id="star-4" name="rating" value="4" hidden>

                                    <label for="star-5" class=" active star"><i class="fa fa-star"></i></label>
                                    <input type="radio" id="star-5" name="rating" value="5"checked hidden>
                                </div>
                            </div>
                        </div>
                        <div class="form text-center mt-4">
                            <button type="submit" name="submit">Submit</button>
                        </div>
                        <div class="mt-4" id="targetLayer"></div>
                    </form>
                </div>
            </div>
        </div>
        <?php }?>
    </div>
</section>