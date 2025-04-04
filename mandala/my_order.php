<?php
require('header.php');

?>
<!-- Start Bradcaump area -->
<div class="ht__bradcaump__area"
    style="background: rgba(0, 0, 0, 0) url(images/bg/4.jg) no-repeat scroll center center / cover ;">
    <div class="ht__bradcaump__wrap">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="bradcaump__inner">
                        <nav class="bradcaump-inner">
                            <a class="breadcrumb-item" href="index.html">Home</a>
                            <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                            <span class="breadcrumb-item active">My Order</span>
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
                                        <th class="product-thumbnail">Order ID</th>
                                        <th class="product-name"><span class="nobr">Order Date</span></th>
                                        <th class="product-price"><span class="nobr"> Address </span></th>
                                        <th class="product-stock-stauts"><span class="nobr"> Payment Type </span></th>
                                        <th class="product-stock-stauts"><span class="nobr"> Payment Status </span></th>
                                        <th class="product-stock-stauts"><span class="nobr"> Order Status </span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $uid = $_SESSION['USER_ID'];
                                    // echo $uid;
                                    $sql_query="select mandala_order.*,order_status.name as order_status_str from mandala_order,order_status where mandala_order.user_id='$uid' and order_status.id=mandala_order.order_status";
                                    echo $sql_query;
                                    $res = mysqli_query($con,$sql_query );
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        
                                        ?>
                                        
                                        <tr>

                                            <td class="product-add-to-cart"><a
                                                    href="my_order_detail.php?OD_id=<?php echo $row['id']; ?>"><?php echo $row['id']; ?></a>
                                            </td>
                                            <td class="product-name"><a href="#"><?php echo $row['added_on']; ?></a></td>
                                            <td class="product-name"><a href="#">
                                                    <?php
                                                    echo "District : " . $row['districts'] . "<br>";
                                                    echo "Address : " . $row['address'] . "<br>";

                                                    ?>
                                                </a></td>
                                            <td class="product-name"><a href="#"><?php echo $row['payment_type']; ?></a>
                                            </td>
                                            <td class="product-name"><a href="#"><?php echo $row['payment_status']; ?></a>
                                            </td>
                                            <td class="product-name"><a href="#"><?php echo $row['order_status_str']; ?></a>
                                            </td>

                                        </tr>
                                    <?php } ?>

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