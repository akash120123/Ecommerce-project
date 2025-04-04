<?php
require("header.php");

$cat_id = 0;
// Check if 'category_id' exists in the query parameters
if (isset($_GET["category_id"])) {
    $cat_id = get_safe_value($con, $_GET["category_id"]);
} else {
    $cat_id = ""; // Set to empty if not present
}

// Check if category ID is empty
if (empty($cat_id)) {
    // If no category ID is provided, fetch all products or a default set
    $get_product = get_product($con); // Adjust this function to return all products
} else {
    // If category ID is provided
    if ($cat_id > 0) {
        $get_product = get_product($con, '', $cat_id); // Fetch products for the specified category
    } else {
        // Handle case where category ID is invalid
        echo '<script>
            alert("Sorry, invalid category.");
            window.location.href = "products.php"; // Redirect to the products page
        </script>';
        exit; // Stop further execution
    }
}

// factet algo rythm for sorting the max and min
$products = [];
$cat_ids = isset($_GET['cat_id']) ? $_GET['cat_id'] : [];
$min_price = isset($_GET['min_price']) ? intval($_GET['min_price']) : 200;
$max_price = isset($_GET['max_price']) ? intval($_GET['max_price']) : 10000;

// Start building the query
$query = "SELECT * FROM products WHERE status = 1";

// Prepare an array to hold conditions
$conditions = [];

// Filter by category IDs
if (!empty($cat_ids)) {
    $cat_ids_str = implode(",", array_map('intval', $cat_ids)); // Sanitize category IDs
    $conditions[] = "categories_id IN ($cat_ids_str)";
}

// Filter by price range
if ($min_price > 0 && $max_price > $min_price) {
    $conditions[] = "price BETWEEN $min_price AND $max_price";
}

// Combine conditions if there are any
if (!empty($conditions)) {
    $query .= " AND " . implode(" AND ", $conditions);
}

// echo $query;

// Execute the query
$result = mysqli_query($con, $query);
// Populate the $products array
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row; // Populate the array
    }
}

?>

<!-- Start Bradcaump area -->
<div class="ht__bradcaump__area"
    style="background: rgba(0, 0, 0, 0) url(images/bg/banner.png) no-repeat scroll center center / cover ;">
    <div class="ht__bradcaump__wrap">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="bradcaump__inner">
                        <nav class="bradcaump-inner">
                            <a class="breadcrumb-item" href="index.html">Home</a>
                            <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                            <span class="breadcrumb-item active">Products</span>
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
        <div class="row">
            <div class="col-lg-9 col-lg-push-3 col-md-9 col-md-push-3 col-sm-12 col-xs-12">
                <div class="htc__product__rightidebar">
                    <div class="htc__grid__top">
                        <!-- Start List And Grid View -->
                        <ul class="view__mode" role="tablist">
                            <li role="presentation" class="grid-view active">
                                <a href="#grid-view" role="tab" data-toggle="tab"><i class="zmdi zmdi-grid"></i></a>
                            </li>
                            <li role="presentation" class="list-view">
                                <a href="#list-view" role="tab" data-toggle="tab"><i
                                        class="zmdi zmdi-view-list"></i></a>
                            </li>
                        </ul>
                        <!-- End List And Grid View -->
                    </div>

                    <!-- Start Product View -->
                    <div class="row">
                        <div class="shop__grid__view__wrap">
                            <div role="tabpanel" id="grid-view"
                                class="single-grid-view tab-pane fade in active clearfix">
                                <!-- Check if products are available -->
                                <?php if (!empty($products)): ?>
                                    <!-- Start Single Product -->
                                    <?php foreach ($products as $product): ?>
                                        <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                                            <div class="category">
                                                <div class="ht__cat__thumb">
                                                    <a href="products.php?id=<?php echo $product['id']; ?>">
                                                        <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.htmlspecialchars($product['image']); ?>"
                                                            alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                                                    </a>
                                                </div>
                                                <div class="fr__hover__info">
                                                    <ul class="product__action">
                                                        <li><a href="wishlist.html"><i class="icon-heart icons"></i></a></li>
                                                        <li><a href="cart.html"><i class="icon-handbag icons"></i></a></li>
                                                        <li><a href="#"><i class="icon-shuffle icons"></i></a></li>
                                                    </ul>
                                                </div>
                                                <div class="fr__product__inner">
                                                    <h4><a
                                                            href="product-details.php?id=<?php echo $product['id']; ?>"><?php echo htmlspecialchars($product['product_name']); ?></a>
                                                    </h4>
                                                    <ul class="fr__pro__prize">
                                                        <li class="old__prize">
                                                            Rs<?php echo htmlspecialchars($product['mrp']); ?></li>
                                                        <li>Rs<?php echo htmlspecialchars($product['price']); ?></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <!-- End Single Product -->
                                <?php else: ?>
                                    <div class="col-xs-12">
                                        <p>No products available.</p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div role="tabpanel" id="list-view" class="single-grid-view tab-pane fade clearfix">
                                <div class="col-xs-12">
                                    <div class="ht__list__wrap">
                                        <!-- Check if products are available -->
                                        <?php if (!empty($products)): ?>
                                            <!-- Start List Product -->
                                            <?php foreach ($products as $product): ?>
                                                <div class="ht__list__product">
                                                    <div class="ht__list__thumb">
                                                        <a href="product-details.php?id=<?php echo $product['id']; ?>"><img
                                                                src="<?php echo PRODUCT_IMAGE_SITE_PATH.htmlspecialchars($product['image']); ?>"
                                                                alt="<?php echo htmlspecialchars($product['product_name']); ?>"></a>
                                                    </div>
                                                    <div class="htc__list__details">
                                                        <h2><a
                                                                href="product-details.php?id=<?php echo $product['id']; ?>"><?php echo htmlspecialchars($product['product_name']); ?></a>
                                                        </h2>
                                                        <ul class="pro__prize">
                                                            <li class="old__prize">
                                                                Rs<?php echo htmlspecialchars($product['mrp']); ?></li>
                                                            <li>Rs<?php echo htmlspecialchars($product['price']); ?></li>
                                                        </ul>
                                                        <ul class="rating">
                                                            <li><i class="icon-star icons"></i></li>
                                                            <li><i class="icon-star icons"></i></li>
                                                            <li><i class="icon-star icons"></i></li>
                                                            <li class="old"><i class="icon-star icons"></i></li>
                                                            <li class="old"><i class="icon-star icons"></i></li>
                                                        </ul>
                                                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                                                        <div class="fr__list__btn">
                                                            <a class="fr__btn" href="cart.html">Add To Cart</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                            <!-- End List Product -->
                                        <?php else: ?>
                                            <div class="col-xs-12">
                                                <p>No products available.</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Product View -->
                </div>
            </div>


            <div class="col-lg-3 col-lg-pull-9 col-md-3 col-md-pull-9 col-sm-12 col-xs-12 smt-40 xmt-40">
                <div class="htc__product__leftsidebar">
                    <!-- Start Best Sell Area -->
                    <div class="htc__recent__product">
                        <h2 class="title__line--4">Filter Products</h2>
                        <form id="category-filter-form" action="product-grid.php" method="GET">
                            <!-- Filter By Categories -->
                            <div class="htc__category__filter">
                                <h3>Filter By Categories</h3>
                                <ul>
                                    <?php
                                    // Fetch categories from the database
                                    $category_res = mysqli_query($con, "SELECT * FROM categories WHERE status=1 ORDER BY categories ASC");
                                    while ($category = mysqli_fetch_assoc($category_res)) {
                                        echo '<li><input type="checkbox" name="cat_id[]" value="' . $category['categories_id'] . '" id="category' . $category['categories_id'] . '">';
                                        echo '<label for="category' . $category['categories_id'] . '">' . $category['categories'] . '</label></li>';
                                    }
                                    ?>
                                </ul>
                            </div>

                            <!-- Filter By Price Range -->
                            <div class="htc__price__filter">
                                <h3>Filter By Price</h3>
                                <div class="price-slider">
                                    <label for="price-range">Price Range:</label>

                                    <!-- Min Price Input -->
                                    <input type="number" name="min_price" id="min-price-input" min="0" max="10000"
                                        step="100" value="200">
                                    <span id="min-price-error" style="color:red; display:none;">Minimum price must be at
                                        least 0.</span>

                                    <!-- Max Price Input -->
                                    <input type="number" name="max_price" id="max-price-input" min="500" max="10000"
                                        step="100" value="1000">
                                    <span id="max-price-error" style="color:red; display:none;">Maximum price must be
                                        greater than 500.</span>

                                    <!-- Display the Price Range -->
                                    <div id="price-range-label">
                                        <span id="min-price-label">$200</span> - <span id="max-price-label">$1000</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Apply Filter Button -->
                            <button type="button" id="applyFilter" class="btn btn-primary">Apply Filter</button>
                        </form>
                    </div>
                    <!-- End Best Sell Area -->
                </div>
            </div>
        </div>
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
<!-- End Banner Area -->
<?php
require("footer.php");
?>