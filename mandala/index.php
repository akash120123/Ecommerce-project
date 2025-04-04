<?php require('header.php');

?>


<!-- Start Slider Area -->
<div class="slider__container slider--one bg__cat--3">
    <div class="slide__container slider__activation__wrap owl-carousel">
        <!-- Start Single Slide -->
        <div class="single__slide animation__style01 slider__fixed--height" >
            <div class="container">
                <div class="row align-items__center">
                    <div class="col-md-7 col-sm-7 col-xs-12 col-lg-6">
                        <div class="slide">
                            <div class="slider__inner">
                                <h2>collection <?php date('Y-m-d');?></h2>
                                <h1>WE ARE FASHION <span>Mandala</span> </h1>
                                <div class="cr__btn">
                                    <a href="cart.php">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-5 col-xs-12 col-md-5">
                        <div class="slide__thumb" style="border-radious: 6px;">
                            <img src="images/slider/front-slider.webp" alt="slider images" style="border-radius: 42px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Single Slide -->
        <!-- Start Single Slide -->
        <div class="single__slide animation__style01 slider__fixed--height">
            <div class="container">
                <div class="row align-items__center">
                    <div class="col-md-7 col-sm-7 col-xs-12 col-lg-6">
                        <div class="slide">
                            <div class="slider__inner">
                                <h2>Mandala</h2>
                                <h1>Smooth and Easy</h1>
                                <div class="cr__btn">
                                    <a href="cart.php">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-5 col-xs-12 col-md-5">
                        <div class="slide__thumb">
                            <img src="images/slider/fornt-img/2.png" alt="slider images">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Single Slide -->
    </div>
</div>
<!-- Start Slider Area -->
<!-- Start Category Area -->
<section class="htc__category__area ptb--100">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="section__title--2 text-center">
                    <h2 class="title__line">New Arrivals</h2>
                    <p>Be First to Wear the Best: Check Out Our New Arrivals!</p>
                </div>
            </div>
        </div>
        <div class="htc__product__container">
            <div class="row">
                <div class="product__list clearfix mt--30">
                    <?php
                    $excluded_category_id = 3; // Replace with the category ID you want to exclude
                    
                    $get_product = get_product($con,'10');
                    
                    foreach ($get_product as $list) {
                        if ($list['categories_id'] == $excluded_category_id) {
                            continue; // Skip this product if it belongs to the excluded category
                        }
                        
                        
                        ?>

                        <!-- Start Single Category -->
                        <div class="col-md-4 col-lg-3 col-sm-4 col-xs-12">
                            <div class="category">
                                <div class="ht__cat__thumb">
                                    <a href="products.php?id=<?php echo $list['id']; ?>">
                                        <img src="<?php echo PRODUCT_IMAGE_SITE_PATH . $list['image'] ?>" alt="product images">
                                    </a>
                                </div>
                                <div class="fr__hover__info">
                                    <ul class="product__action">
                                        <li><a href="wishlist.html"><i class="icon-heart icons"></i></a></li>

                                        <li><a href="cart.php"><i class="icon-handbag icons"></i></a></li>

                                        <li><a href="#"><i class="icon-shuffle icons"></i></a></li>
                                    </ul>
                                </div>
                                <div class="fr__product__inner">
                                    <h4><a href="product-details.html"><?php echo $list['product_name'] ?></a></h4>
                                    <ul class="fr__pro__prize">
                                        <li class="old__prize">Rs <?php echo $list['mrp'] ?></li>
                                        <li>RS <?php echo $list['price'] ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- End Single Category -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Category Area -->
<!-- Start Product Area -->
<section class="ftr__product__area ptb--100">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="section__title--2 text-center">
                    <h2 class="title__line">Mandala Specials</h2>
                    <p>We bring premium trends to your doors steps.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="product__list clearfix mt--30">
                <?php
                $included_category_id = 3; // Category ID you want to include
                
                $get_product = get_product($con , '10');
                foreach ($get_product as $list) {
                    if ($list['categories_id'] == $included_category_id) {
                        ?>
                        <!-- Start Single Product -->
                        <div class="col-md-4 col-lg-3 col-sm-4 col-xs-12">
                            <div class="category">
                                <div class="ht__cat__thumb">
                                    <a href="products.php?id=<?php echo $list['id']; ?>">
                                        <img src="<?php echo PRODUCT_IMAGE_SITE_PATH . $list['image'] ?>" alt="product images">
                                    </a>
                                </div>
                                <div class="fr__hover__info">
                                    <ul class="product__action">
                                        <li><a href="wishlist.html"><i class="icon-heart icons"></i></a></li>
                                        <li><a href="cart.php"><i class="icon-handbag icons"></i></a></li>
                                        <li><a href="#"><i class="icon-shuffle icons"></i></a></li>
                                    </ul>
                                </div>
                                <div class="fr__product__inner">
                                    <h4><a href="product-details.html"><?php echo $list['product_name'] ?></a></h4>
                                    <ul class="fr__pro__prize">
                                        <li class="old__prize">Rs <?php echo $list['mrp'] ?></li>
                                        <li>Rs <?php echo $list['price'] ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Product -->
                    <?php
                    } // End if statement
                } // End foreach
                ?>
            </div>
        </div>

    </div>
</section>
<!-- End Product Area -->

<?php require('footer.php'); ?>