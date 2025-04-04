<?php

require('header.php');
// district array
$districts = [
    'Kathmandu',
    'Lalitpur',
    'Bhaktapur',
    'Pokhara',
    'Chitwan',
    'Biratnagar',
    'Dharan',
    'Butwal',
    'Hetauda',
    'Nepalgunj',
    'Dhangadhi',
    'Janakpur',
    'Itahari',
    'Birgunj',
    'Bharatpur'
];

//  prx($_SESSION['cart']);
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    ?>
    <script>
        window.location.href = 'index.php';
    </script>
    <?php
    die();
}

$cart_total = 0;
$product_ids=[];
foreach ($_SESSION['cart'] as $key => $val) {
    $productArr = get_product($con, '', '', $key);
    $product_id=$productArr[0]['id'];
    $price = $productArr[0]['price'];
    $qty = $val['qty'];
    $cart_total = $cart_total + ($price * $qty);

    $product_ids[]= $product_id;
}
$order_status = '';

$uniqueId= substr(hash('sha256',mt_rand().microtime()),0,20);
// echo $uniqueId;
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
                            <span class="breadcrumb-item active">checkout</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Bradcaump area -->
<!-- cart-main-area start -->
<div class="checkout-wrap ptb--100">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="checkout__inner">
                    <div class="accordion-list">
                        <div class="accordion">

                            <?php
                            $accordian__class = 'accordion__title';
                            if (!isset($_SESSION['USER_LOGIN'])) {
                                $accordian__class = 'accordion__hide' ?>
                                <div class="accordion__title">
                                    Checkout Method
                                </div>
                                <div class="accordion__body">
                                    <div class="accordion__body__form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="checkout-method__login">
                                                    <form id="contact-form login-user-form" action="#" method="post">
                                                        <input type="hidden" id="redirect-page" value="checkout">
                                                        <div class="single-contact-form">
                                                            <div class="contact-box name">
                                                                <input type="email" id="login_email" name="email"
                                                                    placeholder="Your Email*" style="width:100%">

                                                            </div>
                                                            <span class="error-message" id="email-login-error"
                                                                style="color:red;"></span>
                                                        </div>
                                                        <div class="single-contact-form">
                                                            <div class="contact-box name">
                                                                <input type="password" id="login_password" name="name"
                                                                    placeholder="Your Password*" style="width:100%">
                                                            </div>
                                                            <span class="error-message" id="password-login-error"
                                                                style="color:red;"></span>
                                                        </div>

                                                        <div class="contact-btn">
                                                            <button type="button" id="login-btn" onclick="user_login()"
                                                                class="fv-btn">Login</button>
                                                        </div>
                                                    </form>
                                                    <div class="form-output">
                                                        <p class="form-messege" id="login-form-msg"></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkout-method__login">
                                                    <form id="contact-form register-user-form" action="#" method="post">
                                                        <input type="hidden" id="redirect-page" value="checkout">
                                                        <div class="single-contact-form">
                                                            <div class="contact-box name">
                                                                <input type="text" name="name" id="name"
                                                                    placeholder="Your Name*" style="width:100%">
                                                                <span class="error-message" id="name-error"
                                                                    style="color:red;"></span>
                                                            </div>
                                                        </div>
                                                        <div class="single-contact-form">
                                                            <div class="contact-box name">
                                                                <input type="text" name="email" id="email"
                                                                    placeholder="Your Email*" style="width:100%">
                                                                <span class="error-message" id="email-error"
                                                                    style="color:red;"></span>
                                                            </div>
                                                        </div>
                                                        <div class="single-contact-form">
                                                            <div class="contact-box name">
                                                                <input type="number" name="mobile" id="mobile"
                                                                    placeholder="Your Mobile*" style="width:100%">
                                                                <span class="error-message" id="mobile-error"
                                                                    style="color:red;"></span>
                                                            </div>
                                                        </div>
                                                        <div class="single-contact-form">
                                                            <div class="contact-box name">
                                                                <input type="password" name="password" id="password"
                                                                    placeholder="Your Password*" style="width:100%">
                                                                <span class="error-message" id="password-error"
                                                                    style="color:red;"></span>
                                                            </div>
                                                        </div>

                                                        <div class="contact-btn">
                                                            <button type="button" onclick="user_register()" class="fv-btn"
                                                                id="register-btn">Register</button>
                                                        </div>
                                                    </form>

                                                    <div class="form-output">
                                                        <p class="form-messege" id="register-form-msg"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php 
                            // coverting array to string product id
                            $product_ids_string = implode(',', $product_ids);
                            $action_url = "epay-request.php?product_ids=" . urlencode($product_ids_string);
                            // echo $action_url;
                            
                            ?>
                           
                            <form id="contact-form" action="<?php echo $action_url ?>" method="post">
                                <div class="accordion__title">
                                    Address Information
                                </div>

                                <div class="accordion__body">
                                    <div class="bilinfo">
                                        <!-- District Dropdown Field -->
                                        <div class="single-contact-form">
                                            <input type="hidden" name="product_ids"
                                                value="<?php echo implode(',', $product_ids); ?>">
                                            <div class="contact-box name">
                                                <select name="district" id="district" style="width:100%">
                                                    <option value="" disabled selected>Select Your District*</option>
                                                    <?php
                                                    foreach ($districts as $district) {
                                                        echo "<option value=\"$district\">$district</option>";
                                                    }
                                                    ?>
                                                </select>
                                                <span class="error-message" id="district-error"
                                                    style="color:red;"></span>
                                            </div>
                                        </div>

                                        <!-- Address Field -->
                                        <div class="single-contact-form">
                                            <div class="contact-box name">
                                                <input type="text" name="address" id="address"
                                                    placeholder="Your Address*" style="width:100%">
                                                <span class="error-message" id="address-error"
                                                    style="color:red;"></span>
                                            </div>
                                        </div>

                                        <!-- Special Instructions Field -->
                                        <div class="single-contact-form">
                                            <div class="contact-box name">
                                                <textarea name="special_instructions" id="special_instructions"
                                                    placeholder="Special Instructions" rows="4"
                                                    style="width:100%"></textarea>
                                                <span class="error-message" id="instructions-error"></span>
                                            </div>
                                        </div>


                                        <div class="form-output">
                                            <p class="form-messege" id="register-form-msg"></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="">
                                    payment information
                                </div>
                                <div class="accordion__body">
                                    <div class="paymentinfo">
                                        <div class="single-method">
                                            COD&nbsp;<input type="radio" name="payment_type" id="cod" value="COD">
                                            &nbsp;&nbsp;ONLINE_PAY<input type="radio" name="payment_type" id="online" value="online_pay">
                                        </div>
                                    </div>
                                </div> -->
                                <!-- Submit Button -->
                                <div class="contact-btn">
                                    <!-- GO BACK Button -->
                                    <button type="button" class="fv-btn" onclick="window.location.href='index.php';">
                                        GO BACK
                                    </button>
                                    <input type="submit" name="epay-submit" class="fv-btn" value="Khalti Pay"
                                        id="submit-btn" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- right side container (Product View) -->
            <div class="col-md-4">
                <div class="order-details">
                    <h5 class="order-details__title">Your Order</h5>
                    <div class="order-details__item">
                        <?php
                        $cart_total = 0;
                        foreach ($_SESSION['cart'] as $key => $val) {

                            $productArr = get_product($con, '', '', $key);
                            $pname = $productArr[0]['product_name'];
                            $mrp = $productArr[0]['mrp'];
                            $price = $productArr[0]['price'];
                            $image = $productArr[0]['image'];
                            $qty = $val['qty'];
                            $cart_total += ($price * $qty);

                            ?>
                            <?echo $pids ?>
                            <div class="single-item">
                                <div class="single-item__thumb">
                                    <img src="<?php echo PRODUCT_IMAGE_SITE_PATH . $image ?>" alt="ordered item">
                                </div>
                                <div class="single-item__content">
                                    <a href="#"><?php echo $pname ?></a>
                                    <span class="price">Rs<?php echo $price * $qty ?></span>
                                </div>
                                <div class="single-item__remove">
                                    <a href="javascript:void(0)" onclick="manage_cart('<?php echo $key ?>','remove')"><i
                                            class="zmdi zmdi-delete"></i></a>
                                </div>

                            </div>
                        <?php } ?>
                    </div>

                    <div class="ordre-details__total">
                        <h5>Order total</h5>
                        <span class="price">Rs<?php echo $cart_total ?></span>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- cart-main-area end -->
<?php require('footer.php'); ?>