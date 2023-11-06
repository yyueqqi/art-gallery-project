<?php 
    include 'config.php';
  if(isset($_POST['login'])) {
    $login_username = $_POST['username'];
    $login_password = $_POST['password'];
    $sql = "SELECT * FROM account WHERE username = '$login_username'";
    $result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
    $row = mysqli_fetch_assoc($result);
    if($login_password === row['password']) {
        echo "loginnnn!!!";
    }
    else {
        echo "wrong password";
    }
} else {
  echo "0 results";
}
$conn->close();
  }
?>