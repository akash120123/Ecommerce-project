<?php

include("connection.inc.php");
include("function.inc.php");

$cart_total = 0;
$order_status = 0;
$payment_status = 0;
$pay_type = 'Khalti pay';
$uname = $uemail = '';
$mobile = '';
$product_ids = [];
$product_names = [];
$invoice_numbers = []; // Array for invoice numbers
$order_id = 0;

foreach ($_SESSION['cart'] as $key => $val) {
    $productArr = get_product($con, '', '', $key);
    $product_id = $productArr[0]['id'];
    $price = $productArr[0]['price'];
    $qty = $val['qty'];
    $cart_total = $cart_total + ($price * $qty);
    $product_names[] = $productArr[0]['product_name'];

    // Generate a unique invoice number for each product
    $uniqueId = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
    $invoice_numbers[] = $uniqueId; // Add to invoice number array

    $product_ids[] = $product_id;
}

if (isset($_SESSION['USER_ID'])) {
    $u_id = $_SESSION['USER_ID'];
    $querry = "select * from users where id = '$u_id'";
    $result = mysqli_query($con, $querry);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $uname = $row['name'];
        $uemail = $row['email'];
        $mobile = $row['mobile'];
    }
}

if (isset($_POST['epay-submit'])) {
    $district = get_safe_value($con, $_POST['district']);
    $address = get_safe_value($con, $_POST['address']);
    $special_info = get_safe_value($con, $_POST['special_instructions']);
    $user_id = $_SESSION['USER_ID'];
    $total_price = $cart_total;
    
    if ($payment_status == 0) {
        $payment_status = 1;
    }

    if ($order_status == 0) {
        $order_status = 1;
    }

    $added_on = date('Y-m-d h:i:s');

    // Loop through cart items and insert order and order details
    foreach ($_SESSION['cart'] as $key => $val) {
        $qty = $val['qty'];
        $productArr = get_product($con, '', '', $key);
        $price = $productArr[0]['price'];
        $uniqueId = $invoice_numbers[array_search($key, array_keys($_SESSION['cart']))]; // Match the correct invoice number

        mysqli_query($con, "INSERT INTO `mandala_order` (user_id, districts, address, addr_details, payment_type, total_price,invoice_no,payment_status, order_status, added_on) VALUES ('$user_id', '$district', '$address', '$special_info', '$pay_type', '$total_price','$uniqueId', '$payment_status', '$order_status', '$added_on')");
        $order_id = mysqli_insert_id($con);

        mysqli_query($con, "INSERT INTO `order_detail` (order_id, product_id, qty, price, added_on) VALUES ('$order_id', '$key', '$qty', '$price', '$added_on')");
    }

    // Prepare data for Khalti payment
    $amount = $cart_total * 100; // Khalti requires the amount in paisa (1 unit = 100 paisa)
    $purchase_order_id = implode(', ', $invoice_numbers); // Concatenate invoice numbers into a string
    $purchase_order_name = implode(', ', $product_names); // Concatenate product names into a string
    $name = $uname;
    $email = $uemail;
    $phone = $mobile;

    // Prepare the post fields
    $postFields = array(
        "return_url" => "http://localhost/bca8-proj/mandala/epay-response.php",
        "website_url" => "http://localhost/bca8-proj/mandala/",
        "amount" => $amount,
        "purchase_order_id" => $purchase_order_id,
        "purchase_order_name" => $purchase_order_name,
        "customer_info" => array(
            "name" => $name,
            "email" => $email,
            "phone" => $phone
        )
    );
    
    // Debug the output
    // var_dump($postFields);

    // Encode the data to JSON
    $jsonData = json_encode($postFields);
    // var_dump($jsonData);

    // Initialize cURL
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://a.khalti.com/api/v2/epayment/initiate/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $jsonData,
        CURLOPT_HTTPHEADER => array(
            'Authorization: key live_secret_key_68791341fdd94846a146f0457ff7b455',
            'Content-Type: application/json',
        ),
    ));

    // Execute cURL request
    $response = curl_exec($curl);

    // Error handling
    if (curl_errno($curl)) {
        echo 'Error:' . curl_error($curl);
    } else {
        $responseArray = json_decode($response, true);

        if (isset($responseArray['error'])) {
            echo 'Error: ' . $responseArray['error'];
        } elseif (isset($responseArray['payment_url'])) {
            // Redirect the user to the payment page
            header('Location: ' . $responseArray['payment_url']);
            exit(); // Exit to prevent further code execution after the redirect
        } else {
            echo 'Unexpected response: ' . $response;
        }
    }

    // Close cURL session
    curl_close($curl);
} else {
    echo "Hello";

}
?>
