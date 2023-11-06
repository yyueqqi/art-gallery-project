<?php 
    include 'config.php';

    if (isset($_POST['login'])) {
        $login_username = $_POST['username'];
        $login_password = $_POST['password'];
        $sql = "SELECT * FROM account WHERE username = '$login_username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($login_password == $row['user_password']) { // Corrected the variable name
              header('Location: ../index.php');
              exit;
            } else {
              echo "<script> alert('Wrong password!');</script>";
            }
        } else {
            echo "0 results";
        }
        $conn->close();
    }
?>
