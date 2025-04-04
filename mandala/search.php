<?php
include("header.php");

// Get the search term from the URL and sanitize it
$str = mysqli_real_escape_string($con, $_GET['search_input'] ?? '');

// Check if the search term is empty
if (!empty($str)) {
    $get_product = fuzzy_search($con, $str);
} else {
    // Provide feedback if search term is empty
    echo "<script>alert('Please enter a search term.'); window.location.href='search.php';</script>";
    exit; // Exit to prevent further execution
}
?>

<!-- Start Bradcaump area -->
<div class="ht__bradcaump__area">
    <div class="ht__bradcaump__wrap">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="bradcaump__inner">
                        <nav class="bradcaump-inner">
                            <a class="breadcrumb-item" href="index.html">Home</a>
                            <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                            <span class="breadcrumb-item active">Search</span>
                            <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                            <span class="breadcrumb-item active"><?php echo htmlspecialchars($str); ?></span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Bradcaump area -->

<!-- Start Product Grid -->
<section class="htc__product__grid bg__white ptb--100">
    <div class="container">
        <?php if (count($get_product) > 0) { ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="htc__product__rightidebar"></div>
                    <!-- Start Product View -->
                    <div class="row">
                        <div class="shop__grid__view__wrap">
                            <div role="tabpanel" id="grid-view" class="single-grid-view tab-pane fade in active clearfix">
                                <?php foreach ($get_product as $list) { ?>
                                    <!-- Start Single Category -->
                                    <div class="col-md-4 col-lg-3 col-sm-4 col-xs-12">
                                        <div class="category">
                                            <div class="ht__cat__thumb">
                                                <a href="products.php?id=<?php echo $list['id']; ?>">
                                                    <img src="<?php echo PRODUCT_IMAGE_SITE_PATH . $list['image']; ?>" alt="product images">
                                                </a>
                                            </div>
                                            <div class="fr__hover__info">
                                                <ul class="product__action">
                                                    <li>
                                                        <a href="wishlist.html"><i class="icon-heart icons"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="cart.html"><i class="icon-handbag icons"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><i class="icon-shuffle icons"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="fr__product__inner">
                                                <h4>
                                                    <a href="product-details.html"><?php echo htmlspecialchars($list['product_name']); ?></a>
                                                </h4>
                                                <ul class="fr__pro__prize">
                                                    <li class="old__prize">Rs <?php echo htmlspecialchars($list['mrp']); ?></li>
                                                    <li>Rs <?php echo htmlspecialchars($list['price']); ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div> 
                                    <!-- End Single Category -->
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!-- End Product View -->
                </div>
            </div>
        <?php } else {
            echo "DATA NOT FOUND";
        } ?>
    </div>
</section>
<!-- End Product Grid -->



<!-- Start Banner Area -->
<div class="htc__banner__area">
    <ul class="banner__list owl-carousel owl-theme clearfix">
        <li><a href="product-details.html"><img src="images/banner/bn-3/1.jpg" alt="banner images"></a></li>
        <li><a href="product-details.html"><img src="images/banner/bn-3/2.jpg" alt="banner images"></a></li>
        <li><a href="product-details.html"><img src="images/banner/bn-3/3.jpg" alt="banner images"></a></li>
        <li><a href="product-details.html"><img src="images/banner/bn-3/4.jpg" alt="banner images"></a></li>
        <li><a href="product-details.html"><img src="images/banner/bn-3/5.jpg" alt="banner images"></a></li>
        <li><a href="product-details.html"><img src="images/banner/bn-3/6.jpg" alt="banner images"></a></li>
        <li><a href="product-details.html"><img src="images/banner/bn-3/1.jpg" alt="banner images"></a></li>
        <li><a href="product-details.html"><img src="images/banner/bn-3/2.jpg" alt="banner images"></a></li>
    </ul>
</div>
<!-- End Banner Area -->

<?php require('footer.php'); ?>
