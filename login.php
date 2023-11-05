<?php 

include 'config.php';

  if(isset($_POST['login'])) {
    $login_username = $_POST['username'];
    $login_password = $_POST['password'];

    $select = "SELECT * FROM `account` WHERE username = '$login_username'";
    
    $result_select = mysqli_query($conn,$select);
    $number = mysqli_num_rows($result_select);
    $row_data = mysqli_fetch_assoc($result_select);
    
       if($number > 0) {
          if(password_verify($login_password,$row_data['user_password'])) {
            echo "<script> alert('login successfully')</script>";
          }
          else {
            echo "<script> alert('fuck')</script>";
          }
      }
      else {
        echo "<script> alert('error')</script>";
      }
  }
?>