<?php
require("connection.inc.php"); // Include your database connection
$category_ids = isset($_GET['category_ids']) ? $_GET['category_ids'] : [];
$min_price = isset($_GET['min_price']) ? $_GET['min_price'] : null;
$max_price = isset($_GET['max_price']) ? $_GET['max_price'] : null;

// Function to fetch products based on filters
function get_product($con, $category_ids = [], $min_price = null, $max_price = null) {
    $query = "SELECT * FROM products WHERE status = 1";

    if (!empty($category_ids)) {
        $category_ids = implode(",", array_map('intval', $category_ids));
        $query .= " AND categories_id IN ($category_ids)";
    }
    if ($min_price !== null) {
        $query .= " AND price >= " . (float)$min_price;
    }
    if ($max_price !== null) {
        $query .= " AND price <= " . (float)$max_price;
    }

    return mysqli_query($con, $query);
}

$get_product = get_product($con, $category_ids, $min_price, $max_price);

if (mysqli_num_rows($get_product) > 0) {
    while ($product = mysqli_fetch_assoc($get_product)) {
        // Display each product
        echo '<div class="product">';
        echo '<h4>' . htmlspecialchars($product['name']) . '</h4>';
        echo '<p>$' . htmlspecialchars($product['price']) . '</p>';
        echo '</div>';
    }
} else {
    echo '<h1>Sorry, no products available.</h1>';
}
?>
