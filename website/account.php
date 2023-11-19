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
   <title>Personal Information Page</title>
   <link rel="stylesheet" href="../style/account_styles.css">
</head>

<?php include('header.php'); ?>
<body>
<main>
<section class="profile">
    <div class="profile-links">
        <img src="<?php echo $user_account['user_profile']; ?>" alt="Profile Image">
        <ul>
          <li><a href="../index.php" class="nav-link"><b>Home</b></a></li>
          <li><a href="account.php" class="nav-link active"><b>Personal Information</b></a></li>
          <li><a href="shipping.php" class="nav-link"><b>Shipping Information</b></a></li>
          <li><a href="edit_account.php" class="nav-link"><b>Edit Profile</b></a></li>
          <li><a href="../function/logout.php" class="nav-link logout">Log out</a></li>
        </ul>
    </div>


    <div class="user_account">

            <h3> Personal Information</h3>
            <p><b>Name</b> <div class="text-bar"><?php echo $user_account['fName'] . ' ' . $user_account['lName']; ?></div></p>
            <p><b>Email</b> <div class="text-bar"><?php echo $user_account['email']; ?></div></p>
            <p><b>Date of Birth</b> <div class="text-bar"><?php echo $user_account['dob']; ?></div></p>
            <p><b>Phone number</b><div class="text-bar"> <?php echo $user_account['phone_number']; ?></div></p>

    </div>
</section>
</main>
<?php include('footer.php'); ?>
</body>
</html>
