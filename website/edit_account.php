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
   <title>Edit Personal Information Page</title>
   <link rel="stylesheet" href="../style/account_styles.css">
</head>

<body>
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
                  <li><a href="#"><img src="../image/search.png" alt="search.png"></a></li>
              </ul>
          </nav>
      </div>
  </header>
<body>
<main>
<section class="profile">
    <div class="profile-links">
        <img src="<?php echo $user_account['user_profile']; ?>" alt="Profile Image">
        <ul>
          <li><a href="../index.php" class="nav-link"><b>Home</b></a></li>
          <li><a href="account.php" class="nav-link"><b>Personal Information</b></a></li>
          <li><a href="shipping.php" class="nav-link"><b>Shipping Information</b></a></li>
          <li><a href="edit_account.php" class="nav-link active"><b>Edit Profile</b></a></li>
          <li><a href="../function/logout.php" class="nav-link logout">Log out</a></li>
        </ul>
    </div>

    <main>
    <section class="user_edit">
        <div class="mt-custom">
            <h2> Edit Personal Information</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="user_profile">Choose Profile Picture:</label>
                    <input type="file" name="new_user_profile" class="custom-input">
                </div>
                <div class="form-group">
                    <label for="fname">First Name:</label>
                    <input type="text" name="fname" value="<?php echo $user_account['fName']; ?>" class="custom-input">
                </div>
                <div class="form-group">
                    <label for="lname">Last Name:</label>
                    <input type="text" name="lname" value="<?php echo $user_account['lName']; ?>" class="custom-input">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" name="email" value="<?php echo $user_account['email']; ?>" class="custom-input">
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth:</label>
                    <input type="date" name="dob" value="<?php echo $user_account['dob']; ?>" class="custom-input">
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number:</label>
                    <input type="text" name="phone_number" value="<?php echo $user_account['phone_number']; ?>" class="custom-input">
                </div>
                <button type="submit" name="update"class="button">Update</button>
            </form>
        </div>
    </section>
</main>
<iframe src="footer.html" width="100%" height="300" frameborder="0" scrolling="no"></iframe>
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
        // Check if a new file was uploaded
        if (isset($_FILES['new_user_profile']) && !empty($_FILES['new_user_profile']['name'])) {
            // Get the name of the new uploaded image file
            $new_user_profile = $_FILES['new_user_profile']['name'];

            // Get the temporary location of the new uploaded image file
            $temp_new_img = $_FILES['new_user_profile']['tmp_name'];

            // Define the destination directory where the new image will be stored
            $upload_dir = '../account_image/';

            // Specify the path for the new uploaded image
            $new_target_file = $upload_dir . $new_user_profile;

            // Check if the file was successfully moved to the destination directory
            if (move_uploaded_file($temp_new_img, $new_target_file)) {
                $updates = array();
                $updates[] = "user_profile = '$new_target_file'";

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
                        echo "Error updating account: " . $conn->error;
                    }
                } else {
                    echo "<script> alert('No fields to update.');</script>";
                }
            } else {
                echo "<script> alert('Error moving uploaded file to the destination directory.');</script>";
            }
        } else {
            echo "<script> alert('No new file uploaded.');</script>";
        }
    }
}
?>



