<?php require("header.php");

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
                            <a class="breadcrumb-item" href="index.html">Home</a>
                            <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                            <span class="breadcrumb-item active">shopping cart</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Bradcaump area -->
<!-- cart-main-area start -->
<div class="cart-main-area ptb--100 bg__white">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <form action="#">
                    <div class="table-content table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th class="product-thumbnail">products</th>
                                    <th class="product-name">name of products</th>
                                    <th class="product-price">Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-subtotal">Total</th>
                                    <th class="product-remove">Remove</th>
                                    <th class="product-update">Update</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                                    foreach ($_SESSION['cart'] as $key => $val) {

                                        $productArr = get_product($con, '', '', $key);
                                        $pname = $productArr[0]['product_name'];
                                        $mrp = $productArr[0]['mrp'];
                                        $price = $productArr[0]['price'];
                                        $image = $productArr[0]['image'];
                                        $qty = $val['qty'];
                                        echo $key;
                                        ?>
                                        <tr>
                                            <td class="product-thumbnail"><a href="#"><img
                                                        src="<?php echo PRODUCT_IMAGE_SITE_PATH . $image ?>"
                                                        alt="product img" /></a></td>
                                            <td class="product-name"><a href="#"><?php echo $pname ?></a>
                                                <ul class="pro__prize">
                                                    <li class="old__prize">Rs<?php echo $mrp ?></li>
                                                    <li>Rs<?php echo $price ?></li>
                                                </ul>
                                            </td>
                                            <td class="product-price"><span class="amount">Rs<?php echo $price ?></span></td>
                                            <td class="product-quantity"><input type="number" id="<?php echo $key ?>qty"
                                                    value="<?php echo $qty ?>" /></td>
                                            <td class="product-subtotal">Rs<?php echo $price * $qty ?></td>
                                            <td class="product-remove"><a href="javascript:void(0)"
                                                    onclick="manage_cart('<?php echo $key ?>','remove')"><i
                                                        class="icon-trash icons"></i></a></td>
                                            <td class="product-update"><a href="javascript:void(0)"
                                                    onclick="manage_cart('<?php echo $key ?>','update')"><i
                                                        class="fa fa-refresh icons"></i></a></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    // Display message when cart is empty
                                    echo "<tr><td colspan='6' style='text-align:center;'>Your Cart is Empty</td></tr>";
                                }
                                ?>


                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="buttons-cart--inner">
                                <div class="buttons-cart">
                                    <a href="index.php">Continue Shopping</a>
                                </div>
                                <div class="buttons-cart checkout--btn">

                                    <a href="checkout.php">checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- cart-main-area end -->
<!-- End Banner Area -->
<?php
require("footer.php");
?>