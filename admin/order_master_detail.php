<?php
require('top.inc.php');
$order_id = get_safe_value($con, $_GET['OD_id']);
if(isset($_POST['update-order-status'])){
   $status_update=$_POST['update-order-status'];
   $status_change_query = "Update `mandala_order` set order_status='$status_update' where `mandala_order`.id='$order_id'";
   mysqli_query( $con, $status_change_query) ;
 
}

?>

<div class="content pb-0">
   <div class="orders">
      <div class="row">
         <div class="col-xl-12">
            <div class="card">
               <div class="card-body">
                  <h4 class="box-title">Order Details </h4>

               </div>
               <div class="card-body--">
                  <div class="table-stats order-table ov-h">
                     <table class="table ">
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
                              // var_dump($order_id);
                              // var_dump($order_id); // Should output the order ID, like int(108)

                           $order_sql = "SELECT DISTINCT od.id, od.*, p.product_name, p.image, mo.districts, mo.address, mo.addr_details
                           FROM order_detail od
                           JOIN products p ON od.product_id = p.id
                           JOIN mandala_order mo ON od.order_id = mo.id
                           WHERE od.order_id = '$order_id'";
                           // echo $order_sql;
                           // error_reporting(E_ALL);
                           // ini_set('display_errors', 1);
                           $res = mysqli_query($con, $order_sql);
                           // print_r(value: $res);
                           if (!$res) {
                              die("Query failed: " . mysqli_error($con)); // Show error if query fails
                           }

                           if (mysqli_num_rows($res) == 0) {
                              echo "No records found.<br>"; // Check for no results
                           }
                           $total_price = 0;
                           $address_details = '';
                           $address_footnotes = '';
                           // var_dump($res);
                           while ($row = mysqli_fetch_assoc($res)) {
                              $total_price = $total_price + ($row['qty'] * $row['price']);
                              if (empty($address_details) || empty($address_footnotes)) {
                                 $address_details = "District: " . $row['districts'] . " , " . "Location: " . $row['address'] . "<br>";
                                 $address_footnotes = $row['addr_details'];
                              }
                              ?>
                              <tr>
                                 <td class="product-name"><a href="#"><?php echo $row['product_name']; ?></a>
                                 </td>
                                 <td class="product-thumbnail"><a href="#"><img
                                          src="<?php echo PRODUCT_IMAGE_SITE_PATH . $row['image'] ?>"
                                          alt="product img" /></a></td>
                                 <td class="product-name"><a href="#"><?php echo $row['qty']; ?></a></td>
                                 <td class="product-name"><a href="#"><?php echo $row['price']; ?></a></td>
                                 <td class="product-name"><a href="#"><?php echo $row['qty'] * $row['price']; ?></a></td>

                              </tr>
                           <?php } ?>
                           <tr>
                              <td colspan="3"></td>
                              <td>Total Price</td>
                              <td><?php echo $total_price; ?></td>

                           </tr>

                        </tbody>
                     </table>
                     <div id="address_details">
                        <strong>Customer Address : </strong>
                        <?php

                        echo $address_details . "<br>";

                        ?>
                        <strong>Customer Footnotes : </strong>
                        <?php

                        echo $address_footnotes . "<br>";

                        ?>
                        <strong>ORDER STATUS : </strong>
                        <?php

                        $order_status_querry = "SELECT order_status.name FROM mandala_order JOIN order_status ON mandala_order.order_status = order_status.id WHERE mandala_order.id = $order_id";
                        $order_status_arr = mysqli_fetch_assoc(mysqli_query($con, $order_status_querry));
                        // var_dump($order_status_arr);
                        echo ' ' . $order_status_arr["name"];
                        ?>
                        <div>
                           <form action="" method="post">
                              <select name="update-order-status" id="" class="form-control">
                                 <option>Select order status</option>
                                 <?php
                                 $res = mysqli_query($con,"select * from order_status");
                                 
                                 while ($row = mysqli_fetch_assoc($res)) {
                                    // var_dump($row);
                                    if($row['id']==$categories_id){
                                       echo "<option selected value=".$row['id']." $selected>".$row['name']."</option>";
                                    }else{
                                       echo "<option value=".$row['id']." $selected>".$row['name']."</option>";
                                    }
                                    
                                }


                                 ?>
                              </select>
                              <input type="submit" name="submit_status" value="Submit" class="form-control">
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<?php
require('footer.inc.php');
?>