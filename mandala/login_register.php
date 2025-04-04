<?php
require('connection.inc.php');
require('function.inc.php');


$email = get_safe_value($con,$_POST['email']);
$password = get_safe_value($con,$_POST['password']);

$res=mysqli_query($con,"select * from users where email='$email' and password='$password'");
$check_user = mysqli_num_rows($res);

if($check_user>0){
    $rows=mysqli_fetch_assoc($res);
    echo "valid";
    $_SESSION['USER_LOGIN']='yes';
    $_SESSION['USER_ID']=$rows['id'];
    $_SESSION['USER_NAME']=$rows['name'];
   
    
}else{
    echo "wrong";
}


?>