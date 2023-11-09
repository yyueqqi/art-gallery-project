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
   <title>Edit Profile</title>
   <link rel="stylesheet" href="../style/account_styles.css">
</head>

<header>
   <div class="left-header">
       <p>The Art Gallery</p>
   </div>
   <div class="right-header">
       <nav>
           <ul>
               <li><a href="../index.php">Home</a></li>
               <li><a href="artistpage.php">Artist</a></li>
               <li><a href="artworkpage.php">Artwork</a></li>
               <li><a href="exhibitionpage.php">Exhibition</a></li>
               <li><a href="account.php">Account</a></li>
               <li><a href="#"><img src="../image/search.png" alt="search.png"></a>
           </ul>
       </nav>
   </div>
</header>

<body>
    
<section class="profile">
    <div class="profile-links">
        <img src="../image/dummy.png" alt="">
        <h2> Welcome <?php echo $user_account['username']; ?></p></h2>
        <li><a href="../index.php">Home</a></li>
        <li><a href="account.php">Personal Information</a></li>
        <li><a href="#">Payment Method</a></li>
        <li><a href="#">Edit Profile</a></li>
        <li><a href="../function/logout.php">Log out</a></li>
    </div>

    <main>
    <section class="user_account">
        <div class="mt-custom">
            <h2> Edit Personal Information</h2>
            <form method="post">
                <div class="form-group">
                    <label for="fname">First Name:</label>
                    <input type="text" name="fname" value="<?php echo $user_account['fName']; ?>">
                </div>
                <div class="form-group">
                    <label for="lname">Last Name:</label>
                    <input type="text" name="lname" value="<?php echo $user_account['lName']; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" name="email" value="<?php echo $user_account['email']; ?>">
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth:</label>
                    <input type="date" name="dob" value="<?php echo $user_account['dob']; ?>">
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number:</label>
                    <input type="text" name="phone_number" value="<?php echo $user_account['phone_number']; ?>">
                </div>
                <button type="submit" name="update">Update</button>
            </form>
        </div>
    </section>
</main>
</section>
</body>
</html>


<?php
include '../function/config.php';

session_start();

if (isset($_SESSION['logged_in']) && isset($_SESSION['login_username'])) {
    $account_username = $_SESSION['login_username'];
    $account_password = $_SESSION['login_password'];

    if (isset($_POST['update'])) {
        $updates = array();
        
        if (!empty($_POST['fname'])) {
            $new_fName = $_POST['fname'];
            $updates[] = "fName = '$new_fName'";
        }
        if (!empty($_POST['lname'])) {
            $new_lName = $_POST['lname'];
            $updates[] = "lName = '$new_lName'";
        }
        if (!empty($_POST['dob'])) {
            $new_dob = $_POST['dob'];
            $updates[] = "dob = '$new_dob'";
        }
        if (!empty($_POST['email'])) {
            $new_email = $_POST['email'];
            $updates[] = "email = '$new_email'";
        }
        if (!empty($_POST['phone_number'])) {
            $new_phone_number = $_POST['phone_number'];
            $updates[] = "phone_number = '$new_phone_number'";
        }

        if (!empty($updates)) {
            $update_fields = implode(', ', $updates);
            $sql = "UPDATE `account` SET $update_fields WHERE username = '$account_username'";
    
            if ($conn->query($sql) === TRUE) {
                echo "<script> alert('Account updated successfully!');</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "<script> alert('No fields to update.');</script>";
        }
    }
}

?>
