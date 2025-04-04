<?php
require('top.inc.php');

// Initialize variables with empty values
$product_name = $categories_id = $mrp = $selling_price = $qty = $short_desc = $description = $meta_title = $meta_desc=$meta_keyword = $status = '';
$image = '';
$image_required='required';
$msg = ''; // Initialize $msg variable

// Check if ID is passed in URL for edit
$id = '';
if(isset($_GET['id']) && $_GET['id'] != ''){
   $image_required='';
   $id = get_safe_value($con, $_GET['id']);
   
   // Fetch existing product details
   $sql = "SELECT * FROM products WHERE id='$id'";
   $res = mysqli_query($con, $sql);

   // Check if the query ran successfully
   if(!$res) {
      // Display SQL error if query fails
      echo "SQL Error: " . mysqli_error($con);
      die();
   } else {
      if(mysqli_num_rows($res) > 0){
         $row = mysqli_fetch_assoc($res);
         // Initialize variables with fetched data
         $product_name = $row['product_name'];
         $categories_id = $row['categories_id'];
         $mrp = $row['mrp'];
         $selling_price = $row['price'];
         $qty = $row['qty'];
         $short_desc = $row['short_desc'];
         $description = $row['description'];
         $meta_title = $row['meta_title'];
         $meta_desc = $row['meta_desc'];
         $meta_keyword = $row['meta_keyword'];
      } else {
         // Redirect if no product is found with the given ID
         header('location:products.php');
         die();
      }
   }
}


if(isset($_POST['submit'])){
    $product_name = get_safe_value($con, $_POST['product_name']);
    $categories_id = get_safe_value($con, $_POST['categories_id']);
    $mrp = get_safe_value($con, $_POST['mrp']);
    $selling_price = get_safe_value($con, $_POST['selling_price']);
    $qty = get_safe_value($con, $_POST['qty']);
    $short_desc = get_safe_value($con, $_POST['short_desc']);
    $description = get_safe_value($con, $_POST['description']);
    $meta_title = get_safe_value($con, $_POST['meta_title']);
    $meta_desc = get_safe_value($con, $_POST['meta_desc']);
    $meta_keyword = get_safe_value($con, $_POST['meta_keyword']);

    // Check if product already exists
    $res = mysqli_query($con, "SELECT * FROM products WHERE product_name='$product_name';");
    $check = mysqli_num_rows($res);
    if (!$res) {
      // If the query failed, display the error message
      echo "SQL Error: " . mysqli_error($con);
  } else {
    if($check > 0){
        if($id != ''){
            $getData = mysqli_fetch_assoc($res);
            if($id != $getData['id']){
                $msg = "Product already exists";
            }
        } else {
            $msg = "Product already exists";
        }
    }
   }

   //  validating image files
   if($_FILES['image']['type'] != '' && $_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg' && $_FILES['image']['type'] != 'image/webp'){
      $msg = "Plese select only PNG,JPG,JPEG or Webp format image files. THANK YOU.. ";
   }


    if($msg == ''){
        if(isset($_GET['id']) && $_GET['id'] != ''){
         if($_FILES['image']['name'] !=''){
            $image = rand(1111111111,99999999).'_'.$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image);
            $update_sql=" UPDATE products SET 
                categories_id='$categories_id', 
                product_name='$product_name', 
                mrp='$mrp', 
                price='$selling_price', 
                qty='$qty', 
                image='$image', 
                short_desc='$short_desc', 
                description='$description', 
                meta_title='$meta_title', 
                meta_desc='$meta_desc',
                meta_keyword='$meta_keyword', 
                status='$status' 
                WHERE id='$id'";
         }else{
            $update_sql=" UPDATE products SET 
            categories_id='$categories_id', 
            product_name='$product_name', 
            mrp='$mrp', 
            price='$selling_price', 
            qty='$qty', 
            short_desc='$short_desc', 
            description='$description', 
            meta_title='$meta_title', 
            meta_desc='$meta_desc',
            meta_keyword='$meta_keyword', 
            status='$status' 
            WHERE id='$id'";
         }
         mysqli_query($con,$update_sql);

            
        } else {

            $image = rand(1111111111,99999999).'_'.$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image);

            // Insert new product
            mysqli_query($con, "INSERT INTO products (categories_id, product_name, mrp, price, qty, image, short_desc, description, meta_title, meta_desc,meta_keyword, status) 
                VALUES ('$categories_id', '$product_name', '$mrp', '$selling_price', '$qty', '$image', '$short_desc', '$description', '$meta_title', '$meta_desc','$meta_keyword', '$status')");
          }
        header('location:products.php');
        die();
  
   }
}
?>

<div class="content pb-0">
   <div class="orders">
      <div class="row">
         <div class="col-xl-12">
            <div class="card">
               <div class="card-body">
                  <h4 class="box-title">Add Product</h4>
               </div>
               <div class="card-body--">
                  <form method="POST" enctype="multipart/form-data">
                     <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $product_name ?>" required>
                     </div>
                     
                     <div class="form-group">
                        <label for="categories_id">Category</label>
                        <select class="form-control" id="categories_id" name="categories_id" required>
                           <option value="">Select Category</option>
                           <?php
                           $cat_res = mysqli_query($con, "SELECT * FROM categories WHERE status=1 ORDER BY categories ASC");
                           while ($row = mysqli_fetch_assoc($cat_res)) {
                               $selected = ($categories_id == $row['categories_id']) ? 'selected' : '';
                               echo "<option value=".$row['categories_id']." $selected>".$row['categories']."</option>";
                           }
                           ?>
                        </select>
                     </div>

                     <div class="form-group">
                        <label for="mrp">MRP</label>
                        <input type="number" class="form-control" id="mrp" name="mrp" value="<?php echo $mrp ?>" required>
                     </div>

                     <div class="form-group">
                        <label for="selling_price">Selling Price</label>
                        <input type="number" class="form-control" id="selling_price" name="selling_price" value="<?php echo $selling_price ?>" required>
                     </div>

                     <div class="form-group">
                        <label for="qty">Quantity</label>
                        <input type="number" class="form-control" id="qty" name="qty" value="<?php echo $qty ?>" required>
                     </div>

                     <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control"  id="image" name="image" <?php echo $image_required?>>
                     </div>

                     <div class="form-group">
                        <label for="short_desc">Short Description</label>
                        <textarea class="form-control" id="short_desc" name="short_desc" required><?php echo $short_desc ?></textarea>
                     </div>

                     <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" required><?php echo $description ?></textarea>
                     </div>

                     <div class="form-group">
                        <label for="meta_title">Meta Title</label>
                        <input type="text" class="form-control" id="meta_title" name="meta_title" value="<?php echo $meta_title ?>">
                     </div>

                     <div class="form-group">
                        <label for="meta_desc">Meta Description</label>
                        <textarea class="form-control" id="meta_desc" name="meta_desc"><?php echo $meta_desc ?></textarea>
                     </div>
                     <div class="form-group">
                        <label for="meta_keyword">Meta Description</label>
                        <textarea class="form-control" id="meta_keyword" name="meta_keyword"><?php echo $meta_keyword ?></textarea>
                     </div>

                     <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                           <option value="1" <?php if($status == 1) echo 'selected'; ?>>Active</option>
                           <option value="0" <?php if($status == 0) echo 'selected'; ?>>Inactive</option>
                        </select>
                     </div>

                     <button type="submit" class="btn btn-primary" name="submit">Add Product</button>
                     <div class="field_error"><?php echo $msg ?></div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<?php require('footer.inc.php'); ?>
