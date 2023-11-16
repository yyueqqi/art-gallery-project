<?php
include '../function/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../style/login_styles.css">
</head>

<?php include('header.php'); ?>

<body>
    <main>
        <div class="login-container">
            <h1>Login</h1>
            <form method = 'POST'>
                <input type="text" name="username" placeholder="Username" />
                <input type="password" name="password" placeholder="Password" />
                <button type="submit" name="login">Log in</button>
                <a href="signuppage.html" class="signup">Sign up</a>
            </form>   
        </div>
    </main>
</body>
</html>

<?php
    session_start();

    if (isset($_POST['login'])) {
        $login_username = $_POST['username'];
        $login_password = $_POST['password'];
        $sql = "SELECT * FROM `account` WHERE username = '$login_username'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            if(password_verify($login_password,$row['user_password'])) { 
                $_SESSION['logged_in'] = true;
                $_SESSION['login_username'] = $login_username; 
                header('Location: ../index.php');
                exit;
            } 
            else {
                echo "<script> alert('Wrong password!');</script>";
            }
        }       
        else {
            echo "<script> alert('This username doesn\'t exist!');</script>";
            }
        $conn->close();
    }
?>


  