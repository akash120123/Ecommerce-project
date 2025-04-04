<?php
require('top.inc.php');

$sql = "select * from users order by id desc";
$res = mysqli_query($con, $sql);

?>

<div class="content pb-0">
   <div class="orders">
      <div class="row">
         <div class="col-xl-12">
            <div class="card">
               <div class="card-body">
                  <h4 class="box-title">Order Master </h4>

               </div>
               <div class="card-body--">
                  <div class="table-stats order-table ov-h">
                     <table class="table ">
                        <thead>
                           <tr>
                              <th>Order ID</th>
                              <th>Order Date</th>
                              <th>Address</th>
                              <th>Payment Type</th>
                              <th>Payment Status</th>
                              <th>Order Status</th>
                              <th></th>
                           </tr>
                        </thead>
                        <tbody>

                           <?php
                           $res = mysqli_query($con, "SELECT 
                                       mandala_order.*, 
                                       order_status.name AS order_status_str, 
                                       payment_status.name AS payment_status_str 
                                    FROM 
                                       mandala_order, order_status, payment_status 
                                    WHERE 
                                       order_status.id = mandala_order.order_status 
                                       AND payment_status.id = mandala_order.payment_status");
                           while ($row = mysqli_fetch_assoc($res)) {
                              ?>
                              <tr>

                                 <td class="product-add-to-cart"><a
                                       href="order_master_detail.php?OD_id=<?php echo $row['id']; ?>"><?php echo $row['id']; ?></a>
                                 </td>
                                 <td><?php echo $row['added_on']; ?></td>
                                 <td> <?php
                                 echo "District : " . $row['districts'] . "<br>";
                                 echo "Address : " . $row['address'] . "<br>";

                                 ?></td>
                                 <td><?php echo $row['payment_type']; ?></td>
                                 <td><?php echo $row['payment_status_str']; ?></td>
                                 <td><?php echo $row['order_status_str']; ?></td>

                                 <td>
                                    <?php

                                    // for delete
                                    echo "&nbsp<span class='badge badge-delete'><a class='stat-grp' href='?type=delete&id=" . $row['id'] . "'>Delete</a></span>";

                                    ?>
                                 </td>
                              </tr>
                           <?php } ?>
                        </tbody>
                     </table>
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