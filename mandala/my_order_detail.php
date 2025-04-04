<?php
require('header.php');
$order_id = get_safe_value($con, $_GET['OD_id']);
?>
<!-- Start Bradcaump area -->
<div class="ht__bradcaump__area"
    style="background: rgba(0, 0, 0, 0) url(images/bg/4.jp) no-repeat scroll center center / cover ;">
    <div class="ht__bradcaump__wrap">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="bradcaump__inner">
                        <nav class="bradcaump-inner">
                            <a class="breadcrumb-item" href="index.php">Home</a>
                            <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                            <span class="breadcrumb-item active">Order Details</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Bradcaump area -->
<!-- wishlist-area start -->
<div class="wishlist-area ptb--100 bg__white">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="wishlist-content">
                    <form action="#">
                        <div class="wishlist-table table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="product-thumbnail">Product Name</th>
                                        <th class="product-name"><span class="nobr">Product Image</span></th>
                                        <th class="product-price"><span class="nobr"> Product Quantity </span></th>
                                        <th class="product-stock-stauts"><span class="nobr"> Product Price </span></th>
                                        <th class="product-stock-stauts"><span class="nobr"> Total Price </span></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $uid = $_SESSION['USER_ID'];
                                    $res = mysqli_query($con, "select distinct(order_detail.id),order_detail.*,products.product_name,products.image from order_detail,products,mandala_order where order_detail.order_id='$order_id' and mandala_order.user_id='$uid' and order_detail.product_id=products.id");

                                    $total_price=0;
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        $total_price=$total_price+($row['qty']*$row['price']);
                                        ?>
                                        <tr>
                                            <td class="product-name"><a href="#"><?php echo $row['product_name']; ?></a>
                                            </td>
                                            <td class="product-thumbnail"><a href="#"><img
                                                        src="<?php echo PRODUCT_IMAGE_SITE_PATH .$row['image'] ?>"
                                                        alt="product img" /></a></td>
                                            <td class="product-name"><a href="#"><?php echo $row['qty']; ?></a></td>
                                            <td class="product-name"><a href="#">Rs <?php echo $row['price']; ?></a></td>
                                            <td class="product-name"><a
                                                    href="#">Rs <?php echo $row['qty'] * $row['price']; ?></a></td>

                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td>Total Price</td> 
                                        <td>Rs <?php echo $total_price; ?></td> 
                                        
                                    </tr>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6">
                                            <div class="wishlist-share">
                                                <h4 class="wishlist-share-title">Share on:</h4>
                                                <div class="social-icon">
                                                    <ul>
                                                        <li><a href="#"><i class="zmdi zmdi-rss"></i></a></li>
                                                        <li><a href="#"><i class="zmdi zmdi-vimeo"></i></a></li>
                                                        <li><a href="#"><i class="zmdi zmdi-tumblr"></i></a></li>
                                                        <li><a href="#"><i class="zmdi zmdi-pinterest"></i></a></li>
                                                        <li><a href="#"><i class="zmdi zmdi-linkedin"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- wishlist-area end -->
<!-- Start Brand Area -->
<div class="htc__brand__area bg__cat--4">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="ht__brand__inner">
                    <ul class="brand__list owl-carousel clearfix">
                        <li><a href="#"><img src="images/brand/1.png" alt="brand images"></a></li>
                        <li><a href="#"><img src="images/brand/2.png" alt="brand images"></a></li>
                        <li><a href="#"><img src="images/brand/3.png" alt="brand images"></a></li>
                        <li><a href="#"><img src="images/brand/4.png" alt="brand images"></a></li>
                        <li><a href="#"><img src="images/brand/5.png" alt="brand images"></a></li>
                        <li><a href="#"><img src="images/brand/5.png" alt="brand images"></a></li>
                        <li><a href="#"><img src="images/brand/1.png" alt="brand images"></a></li>
                        <li><a href="#"><img src="images/brand/2.png" alt="brand images"></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Brand Area -->
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
<!-- End Banner Area -->

<?php
require('footer.php');
?>