
<?php 
require('top.inc.php');

if(isset($_GET['type']) && $_GET['type'] !=''){
   $type = get_safe_value($con, $_GET['type']);
   if($type == 'status'){
      $operation = get_safe_value($con, $_GET['operation']);
      $id = get_safe_value($con, $_GET['id']);
      if($operation == 'Active'){
         $status = '1';
      }else{
         $status = '0';
      }
      $update_status_sql = "UPDATE products SET status='$status' WHERE id='$id'";
      mysqli_query($con, $update_status_sql);
   }

   if($type == 'delete'){
      $id = get_safe_value($con, $_GET['id']);
      $delete_sql = "DELETE FROM products WHERE id='$id'";
      mysqli_query($con, $delete_sql);
   }
}

$sql = "SELECT products.*,categories.categories FROM products,categories where products.categories_id=categories.categories_id ORDER BY products.id ASC";
$res = mysqli_query($con, $sql);

?>

<div class="content pb-0">
   <div class="orders">
      <div class="row">
         <div class="col-xl-12">
            <div class="card">
               <div class="card-body">
                  <h4 class="box-title">Products</h4>
                  <h4 class="box-link"><a href="manage_products.php">Add Product</a></h4>
               </div>
               <div class="card-body--">
                  <div class="table-stats order-table ov-h">
                     <table class="table">
                        <thead>
                           <tr>
                              <th class="serial">#</th>
                              <th>ID</th>
                              <th>CATEGORIES</th>
                              <th>NAME</th>
                              <th>IMAGE</th>
                              <th>MRP</th>                              
                              <th>PRICE</th>
                              <th>QTY</th>
                              <th></th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php 
                           $i = 1;
                           while($row = mysqli_fetch_assoc($res)){?>
                           <tr>
                              <td class="serial"><?php echo $i++; ?></td>
                              <td><?php echo $row['id']; ?></td>
                              <td><?php  echo $row['categories'];
                               
                              ?></td>
                              <td><?php echo $row['product_name']; ?></td>
                              <td><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$row['image']; ?>" alt="img"/></td>
                              <td><?php echo $row['mrp']; ?></td>
                              <td><?php echo $row['price']; ?></td>
                              <td><?php echo $row['qty']; ?></td>
                              <td>
                                 <?php 
                                 if($row['status'] == 1){
                                    echo "<span class='badge badge-complete'><a class='stat-grp' href='?type=status&operation=Inactive&id=".$row['id']."'>Active</a></span>&nbsp";
                                 }else{
                                    echo "<span class='badge badge-pending'><a class='stat-grp' href='?type=status&operation=Active&id=".$row['id']."'>Inactive</a></span>&nbsp";
                                 }
                                 // For edit
                                 echo "&nbsp<span class='badge badge-edit'><a class='stat-grp' href='manage_products.php?type=edit&id=".$row['id']."'>Edit</a></span>&nbsp";

                                 // for delete
                                 echo "&nbsp<span class='badge badge-delete'><a class='stat-grp' href='?type=delete&id=".$row['id']."'>Delete</a></span>";
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
