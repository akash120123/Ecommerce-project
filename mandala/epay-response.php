<?php
include("connection.inc.php");
include("function.inc.php");

// Define constants for API URL and authorization key
define('KHALTI_API_URL', 'https://a.khalti.com/api/v2/epayment/lookup/');
define('KHALTI_AUTH_KEY', 'key live_secret_key_68791341fdd94846a146f0457ff7b455');

// Get the pidx, purchase_order_id, and purchase_order_name from the GET parameters
$pidx = $_GET['pidx'] ?? null;
$purchaseId = $_GET['purchase_order_id'] ?? ''; // String of IDs, assumed to be comma-separated
$product_name = $_GET['purchase_order_name'] ?? ''; // String for the product names

echo "Purchase Order IDs: $purchaseId<br>";
echo "Product Name: $product_name<br>";

// Function to perform cURL request to Khalti API
function fetchKhaltiResponse($pidx)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => KHALTI_API_URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode(['pidx' => $pidx]),
        CURLOPT_HTTPHEADER => array(
            'Authorization: ' . KHALTI_AUTH_KEY,
            'Content-Type: application/json',
        ),
    ));

    $response = curl_exec($curl);

    // Check for cURL errors
    if ($response === false) {
        echo 'Error fetching data from Khalti API: ' . curl_error($curl) . '<br>';
        curl_close($curl);
        return null; // Return null on error
    }

    curl_close($curl);
    return json_decode($response, true); // Decode and return the response as an array
}

// Make sure pidx is present before proceeding
if ($pidx) {
    $responseArray = fetchKhaltiResponse($pidx);

    if ($responseArray) {
        // Print the response for debugging
        echo "<h4>Khalti API Response:</h4>";
        echo "<pre>";
        print_r($responseArray);
        echo "</pre>";

        // Extract the status from the API response
        $status = $responseArray['status'] ?? null;

        // Use the purchase_order_id from the GET request instead of the response
        $invoice_no = $purchaseId;

        if ($invoice_no && $status) {
            echo "Invoice No: " . htmlspecialchars($invoice_no) . "<br>";
            echo "Transaction Status: " . htmlspecialchars($status) . "<br>";

            // Split the purchase_order_id into an array, assuming it's comma-separated
            $purchaseIdsArray = explode(', ', $invoice_no);

            // Loop through each purchase ID and update the database accordingly
            foreach ($purchaseIdsArray as $id) {
                // Example SQL update query based on the transaction status
                if ($status === 'Completed') {
                    $sql = "UPDATE `mandala_order` SET payment_status = '2' WHERE invoice_no = '$id'";
                    echo "Updating `mandala_order` $id to success.<br>";
                    $_SESSION['transaction_msg'] = '<script>
                        Swal.fire({
                            icon: "success",
                            title: "Transaction successful.",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    </script>';

                    unset($_SESSION['cart']);
                    header("Location: index.php");
                } elseif ($status === 'Expired' || $status === 'User canceled') {
                    $sql = "UPDATE `mandala_order` SET payment_status = '3' WHERE invoice_no = '$id'";
                    echo "Updating order $id to failed.<br>";
                    $_SESSION['transaction_msg'] = '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Transaction failed.",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    </script>';
                    // unset($_SESSION['cart']);
                    header("Location: checkout.php");
                } else {
                    $sql = "UPDATE `mandala_order` SET payment_status = '1', order_status = '1' WHERE invoice_no = '$id'";
                    echo "Updating order $id to pending.<br>";
                    $_SESSION['transaction_msg'] = '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Transaction failed.",
                        showConfirmButton: false,
                        timer: 1500
                    });
                </script>';
                // unset($_SESSION['cart']);
                    header("Location: index.php");
                }

                // Execute the SQL query
                if (mysqli_query($con, $sql)) {
                    echo "Order ID $id updated successfully.<br>";
                } else {
                    echo "Error updating order ID $id: " . mysqli_error($con) . "<br>";
                }
            }
        } else {
            echo "Warning: 'purchase_order_id' or 'status' is not present in the response.<br>";
        }
    } else {
        echo 'No data found from the Khalti API.<br>';
    }
} else {
    echo "No pidx parameter found in the URL";
}
?>