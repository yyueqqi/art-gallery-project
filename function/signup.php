<?php

include 'connect.php';
 if(isset($_POST['user_register'])) {
  $user_id = md5(time() . mt_rand(1,1000000));  
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $user_address = $_POST['address'];
  $password = $_POST['password'];
 
if($fname == '' or  $lname == '' or $email == '' or  $user_address == '' or  $password == '') {
    echo "<script> alert('Please inserted')</script>";
}
else {
  $select = "SELECT * FROM `user` WHERE email = '$email'";
  $result_select = mysqli_query($con,$select);
  $number = mysqli_num_rows($result_select);
  if($number > 0) {
    echo "<script> alert('This email have alreday been used')</script>";
  }
  else {
  $encpassword = password_hash($password,PASSWORD_DEFAULT);
  $insert = "INSERT INTO `user` (user_id,fname,lname,email,user_address,user_password) VALUES ('$user_id','$fname','$lname','$email','$user_address','$encpassword')"; 
  $result=mysqli_query($con,$insert);
      if($result) {
        session_start();
        $_SESSION['email'] = $email;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['fname'] = $fname;
        echo "<script> alert('register')</script>";
        header('Location: ../index.php');
        exit;
        // header( "refresh: 2; url=index.php");
       }
       else {
        echo "<script> alert('error')</script>";
       }
}
  
}


}
   
?>