
 <?php

 function pr($arr){
    echo "<pre>";
    print_r($arr);

 }
 function prx($arr){
    echo "<pre>";
    print_r($arr);
    die();
 }

//  function get_safe_value($con,$str){
//    if($str!=''){
//         $str = trim($str);
//        return mysqli_real_escape_string($con,$str);
//    }
// }
function get_safe_value($con, $str) {
   if (is_array($str)) {
       // If it's an array, trim each element and escape them
       return array_map(function($item) use ($con) {
           return mysqli_real_escape_string($con, trim($item));
       }, $str);
   } elseif ($str != '') {
       // If it's a string, just trim and escape it
       return mysqli_real_escape_string($con, trim($str));
   }
   return ''; // Return an empty string if $str is empty
}



function get_product($con, $limit = '', $cat_id = '', $product_id = '') {
   $sql = "SELECT products.*, categories.categories 
           FROM products, categories 
           WHERE products.status = 1 ";
   
   // Append category filter if present
   if ($cat_id != '') {
       $sql .= " AND products.categories_id = $cat_id ";
   }

   // Append product ID filter if present
   if ($product_id != '') {
       $sql .= " AND products.id = $product_id ";
   }

   // Ensure category join
   $sql .= " AND products.categories_id = categories.categories_id ";
   
   // Order by product ID descending
   $sql .= " ORDER BY products.id DESC";
   
   // Add LIMIT if specified
   if ($limit !== '') {
       $limit = intval($limit);
       $sql .= " LIMIT $limit";
   }

   $res = mysqli_query($con, $sql);

   $data = array();
   
   // Check if the query was successful
   if ($res) {
       while ($row = mysqli_fetch_assoc($res)) {
           $data[] = $row; // Add each row to the data array
       }
   } else {
       echo "Error fetching products: " . mysqli_error($con);
   }

   return $data; // Return the populated data array
}



function fuzzy_search($con, $search_term) {
   $sql = "SELECT id, product_name, description, image, mrp, price FROM products WHERE status = 1;";
   $threshold = 5; // Decrease the threshold
   $matches = [];
   $res = mysqli_query($con, $sql);

   if ($res) {
       $search_terms = explode(' ', strtolower(trim($search_term))); // Split the search term
       while ($row = mysqli_fetch_assoc($res)) {
           $product_name = strtolower(trim($row['product_name']));
           $product_desc = strtolower(trim($row['description']));

           // Calculate Levenshtein distance for each search term
           $match_found = false;
           foreach ($search_terms as $search) {
               $product_name_distance = levenshtein($search, $product_name);
               $product_desc_distance = levenshtein($search, $product_desc);

               // Debug output
               // echo "Checking: " . $product_name . " (distance: " . $product_name_distance . ") for search: " . $search . "<br>";

               // Check for close Levenshtein distance
               if (
                   $product_name_distance <= $threshold || 
                   $product_desc_distance <= $threshold || 
                   strpos($product_name, $search) !== false || 
                   strpos($product_desc, $search) !== false
               ) {
                   $match_found = true;
                   break; // No need to check further if a match is found
               }
           }

           if ($match_found) {
               $matches[] = $row;
           }
       }
   }

   echo "Total products found: " . count($matches) . "<br>";
   return $matches;
}



 ?>