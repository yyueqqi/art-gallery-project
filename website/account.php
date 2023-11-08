<?php
include '../function/config.php';

if (isset($_SESSION['user_id'])) {
    $login_userid = $_SESSION['user_id']; // Use the user_id from the session, not from POST

    $sql = "SELECT fName, lName, email, dob, phone_number FROM account WHERE user_id = $login_userid";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $account = $result->fetch_assoc(); // Fetch a single user's details
    } else {
        $account = array();
    }
}

$conn->close();
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
    
<section class="profile">
    <div class="profile-links">
        <img src="../image/dummy.png" alt="">
        <h2> User Name</h2>
        <li><a href="#">Home</a></li>
        <li><a href="#">Personal Information</a></li>
        <li><a href="#">Payment Method</a></li>
        <li><a href="#">Contact</a></li>
    </div>

    <div class="mt-custum">
    
        <div class="details">
            
            <p>Name: <?php echo $account['fName'] . ' ' . $account['lName']; ?></p>
            <p>Email: <?php echo $account['email']; ?></p>
            <p>Date of Birth: <?php echo $account['dob']; ?></p>
            <p>Phone number: <?php echo $account['phone_number']; ?></p>
            
        </div> 
    </div>
</section>

</body>
</html>
