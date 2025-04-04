<?php 
require('top.inc.php');
$categories = '';
$msg = '';

if(isset($_GET['id']) && $_GET !=''){
   $id = get_safe_value($con,$_GET['id']);
   $res = mysqli_query($con,"select * from categories where categories_id ='$id'");
   
   if(!$res){
      echo "Error: " . mysqli_error($con);
      die();
   }

   $check = mysqli_num_rows($res);
   if($check > 0){
      $row = mysqli_fetch_assoc($res);
      $categories = $row['categories'];
   } else {
      header('location:categories.php');
      die();
   }
}

if(isset($_POST['submit'])){
   $categories = get_safe_value($con,$_POST['categories']);
   
   $res = mysqli_query($con,"select * from categories where categories ='$categories'");
   
   if(!$res){
      echo "Error: " . mysqli_error($con);
      die();
   }

   $check = mysqli_num_rows($res);
   if($check > 0){

      if(isset($_GET['id']) && $_GET['id'] != ''){
         $getData = mysqli_fetch_assoc($res);
         if($id != $getData['categories_id']){
            $msg = "Categories already exists";
         }
      } else {
         $msg = "Categories already exists";
      }

   }

   if($msg == ''){
      if(isset($_GET['id']) && $_GET['id'] != ''){
         $query = "update categories set categories='$categories' where categories_id='$id'";
         $update_res = mysqli_query($con, $query);

         if(!$update_res){
            echo "Update Error: " . mysqli_error($con);
            die();
         }
      } else {
         $query = "insert into categories(categories,status) values('$categories','1')";
         $insert_res = mysqli_query($con, $query);

         if(!$insert_res){
            echo "Insert Error: " . mysqli_error($con);
            die();
         }
      }
      
      header('location:categories.php');
      die();
   }
}

?>

<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Categories</strong><small> Form</small></div>
                        <form  method="post">
                        <div class="card-body card-block">
                           <div class="form-group"><label for="categories"  class=" form-control-label">Categories</label>
                           <input type="text" id="categories" name="categories" value="<?php echo $categories; ?>" placeholder="Enter categories name" class="form-control"required>
                           <button style="margin-top:12px;" id="payment-button" type="submit" class="btn btn-lg btn-info btn-block" name="submit">
                           <span id="payment-button-amount" >Submit</span>
                           </button>
                           <div class="field_error"><?php echo $msg; ?></div>
                        </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            
         </div>
         
<?php 
require('footer.inc.php');
?>