<?php
include '../function/config.php';

    session_start();

    if (isset($_SESSION['logged_in']) && isset($_SESSION['login_username'])) {
        $account_username = $_SESSION['login_username'];

        $sql = "SELECT * FROM `account` WHERE username = '$account_username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user_account = $result->fetch_assoc();
        } 
        else {
            $user_account = null;
        }
    } 
    else {

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login Page</title>
   <link rel="stylesheet" href="../style/account_styles.css">
</head>

<header>
   <div class="left-header">
       <p>The Art Gallery</p>
   </div>
   <div class "right-header">
       <nav>
           <ul>
               <li><a href="../index.php">Home</a></li>
               <li><a href="artistpage.php">Artists</a></li>
               <li><a href="artworkpage.php">Artwork</a></li>
               <li><a href="exhibitionpage.php">Exhibition</a></li>
               <li><a href="account.php">Account</a></li>
               <li><a href="#"><img src="../image/search.png" alt="search.png"></a>
           </ul>
       </nav>
   </header>
<body>
<main>
<section class="profile">
    <div class="profile-links">
        <img src="../image/dummy.png" alt="">
        <h2> Welcome <?php echo $user_account['username']; ?></p></h2>
        <li><a href="../index.php">Home</a></li>
        <li><a href="account.php">Personal Information</a></li>
        <li><a href="#">Payment Method</a></li>
        <li><a href="edit_account.php">Edit Profile</a></li>
        <li><a href="../function/logout.php">Log out</a></li>
    </div>


    <div class="user_account">
        <div class="mt-custom">
            <h2> Personal Information</h2>
            <p>Name: <?php echo $user_account['fName'] . ' ' . $user_account['lName']; ?></p>
            <p>Email: <?php echo $user_account['email']; ?></p>
            <p>Date of Birth: <?php echo $user_account['dob']; ?></p>
            <p>Phone number: <?php echo $user_account['phone_number']; ?></p>
        </div>
    </div>
</section>
</main>

</body>
</html>
