<?php

require('connection.inc.php');
require('function.inc.php');
require('add_to_cart.inc.php');

// Perform the query and check for errors
$cat_res = mysqli_query($con, "select * from categories where status=1 order by categories asc");

if (!$cat_res) {
    die("Error fetching categories: " . mysqli_error($con)); // Display error if query fails
}

// Fetch all categories into an array to display in the navbar
$cat_arr = array();
while ($row = mysqli_fetch_assoc($cat_res)) {
    $cat_arr[] = $row;
}

// Specify the ID of the category you want
$brand_id = 3; // Replace with the desired category ID
$brand_category = null;

// Find the category by its ID
foreach ($cat_arr as $category) {
    if ($category['categories_id'] == $brand_id) {
        $brand_category = $category;
        break;
    }
}

// Output the specific category, if found
if ($brand_category == null) {
    echo "Category not found.";
} else {
    // Continue with the rest of the code, such as displaying the category name or details
}

// Initialize the cart object and get the total product count
$obj = new add_to_cart();
$totalProduct = $obj->totalProduct();

?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Mandala </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- All css files are included here. -->
    <!-- Bootstrap fremwork main css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Owl Carousel min css -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <!-- This core.css file contents all plugings css file. -->
    <link rel="stylesheet" href="css/core.css">
    <!-- Theme shortcodes/elements style -->
    <link rel="stylesheet" href="css/shortcode/shortcodes.css">
    <!-- Theme main style -->
    <link rel="stylesheet" href="style.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- User style -->
    <link rel="stylesheet" href="css/custom.css">


    <!-- Modernizr JS -->
    <script src="js/vendor/modernizr-3.5.0.min.js"></script>
</head>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <!-- Body main wrapper start -->
    <div class="wrapper">
        <!-- Start Header Style -->
        <header id="htc__header" class="htc__header__area header--one">
            <!-- Start Mainmenu Area -->
            <div id="sticky-header-with-topbar" class="mainmenu__wrap sticky__header">
                <div class="container">
                    <div class="row">
                        <div class="menumenu__container clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-5">
                                <div class="logo">
                                    <a href="index.php"><img src="images/logo/mandala.png" alt="logo images"></a>
                                </div>
                            </div>
                            <div class="col-md-7 col-lg-8 col-sm-5 col-xs-3">
                                <nav class="main__menu__nav hidden-xs hidden-sm">
                                    <ul class="main__menu">
                                        <li class="drop"><a href="index.php">Home</a></li>
                                        <li class="drop"><a href="categories.php?id=<?php echo $brand_category['categories_id'];?>"><?php echo $brand_category['categories']?></a></li>
                                        <li class="drop"><a href="product-grid.php">Product</a>
                                            <ul class="dropdown">
                                                <?php
                                                // $brand_cat=$cat_arr['categories'];
                                                foreach ($cat_arr as $list) { ?>
                                                    <li><a
                                                            href="categories.php?id=<?php echo $list['categories_id'] ?>"><?php echo $list['categories'] ?></a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </li>


                                        <li><a href="contact.php">contact</a></li>
                                    </ul>
                                </nav>

                                <div class="mobile-menu clearfix visible-xs visible-sm">
                                    <nav id="mobile_dropdown">
                                        <ul>

                                            <li><a href="index.php">Home</a></li>
                                            <li class="drop"><a href="#">Product</a>
                                                <ul class="dropdown">
                                                    <li><a href="product-grid.html">Product Grid</a></li>
                                                    <li><a href="product-details.html">Product Details</a></li>
                                                </ul>
                                            </li>
                                            <?php
                                            foreach ($cat_arr as $list) { ?>
                                                <li><a
                                                        href="categories.php?id=<?php echo $list['categories_id'] ?>"><?php echo $list['categories'] ?></a>
                                                </li>
                                            <?php }
                                            ?>
                                            <li><a href="contact.php">contact</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-2 col-sm-6 col-xs-4">
                                <div class="header__right">
                                    <div class="header__search search search__open">
                                        <a href="#"><i class="icon-magnifier icons"></i></a>
                                    </div>
                                    <div class="header__account">
                                        <?php if (isset($_SESSION['USER_LOGIN'])) {


                                            // LOGOUT BTN
                                            echo '<a style="font: size 14px;" href="logout_user.php">Logout</a>';

                                            // MY ORDER BTN
                                            echo '<a style="font: size 10px;" href="my_order.php">Order</a>';

                                        } else {
                                            echo '<a class="my_order_btn" style="font: size 14px;" href="login.php">Login/Register</a>';
                                        }
                                        ?>
                                    </div>
                                    <div class="htc__shopping__cart">
                                        <a class="cart__menu" href="#"><i class="icon-handbag icons"></i></a>
                                        <a href="cart.php"><span
                                                class="htc__qua"><?php echo $totalProduct; ?></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mobile-menu-area"></div>
                </div>
            </div>
            <!-- End Mainmenu Area -->
        </header>
        <!-- End Header Area -->
        <div class="body__overlay"></div>
        <!-- Start Offset Wrapper -->
        <div class="offset__wrapper">
            <!-- Start Search Popap -->
            <div class="search__area">
                <div class="container" >
                    <div class="row" >
                        <div class="col-md-12" >
                            <div class="search__inner">
                                <form action="search.php" method="get">
                                    <input placeholder="Search here... " name="search_input" type="text">
                                    <button type="submit"></button>
                                </form>
                                <div class="search__close__btn">
                                    <span class="search__close__btn_icon"><i class="zmdi zmdi-close"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Search Popap -->
            <!-- Start Cart Panel -->
        </div>