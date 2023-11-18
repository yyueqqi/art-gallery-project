<?php

include '../function/config.php';

session_start();

    if (isset($_SESSION['logged_in']) && isset($_SESSION['login_username'])) {
        $account_username = $_SESSION['login_username'];

        $profile_sql = "SELECT user_profile FROM `account` WHERE username = '$account_username'";
        $profile_result = $conn->query($profile_sql);
        $profile_result = $conn->query($profile_sql);

        if ($profile_result->num_rows > 0) {
            $profile_data = $profile_result->fetch_assoc();
            $user_profile = $profile_data['user_profile'];
        } 
        else {
            $user_profile = ""; 
        }

        $sql = "SELECT * FROM `payment` WHERE username = '$account_username'";
        $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $user_payment = $result->fetch_assoc();
                $cardType = $user_payment['card_type'];
                $cardID = $user_payment['card_id'];
                $card_fname = $user_payment['fName_card'];
                $card_lname = $user_payment['lName_card'];
                $card_cvv = $user_payment['cvv'];
                $exp_date = $user_payment['exp_date'];
            } 
            else {
                $user_payment = null;
                $cardType = "";
                $cardID = "";
                $card_fname = "";
                $card_lname = "";
                $card_cvv = "";
                $exp_date = "";
            }
    } 
    else {
        echo "<script> alert('Please Log In!');</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Shipping Page</title>
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

<main>
<section class="profile">
    <div class="profile-links">
        <img src="<?php echo $user_profile; ?>" alt="Profile Image">
        <ul>
          <li><a href="../index.php" class="nav-link"><b>Home</b></a></li>
          <li><a href="account.php" class="nav-link"><b>Personal Information</b></a></li>
          <li><a href="shipping.php" class="nav-link active"><b>Shipping Information</b></a></li>
          <li><a href="edit_account.php" class="nav-link"><b>Edit Profile</b></a></li>
          <li><a href="../function/logout.php" class="nav-link logout">Log out</a></li>
        </ul>
    </div>

    <main>
    <section class="shipping">
        <div class="mt-custom">
            <h2> Payment method</h2>
            <form method="post">
                <div class="form-group">
                    <label for="card_type">Card type:</label>
                    <select name="card_type" class="<?php echo $condition ? 'custom-input' : ''; ?>">
                        <option value="" <?php if ($cardType == "") echo "selected"; ?>>Select Card Type</option>
                        <option value="master" <?php if ($cardType == "master") echo "selected"; ?>>Mastercard</option>
                        <option value="visa" <?php if ($cardType == "visa") echo "selected"; ?>>Visa</option>
                    </select>
                </div>
             <div class="combine">
                <div class="form-group">
                    <label for="card_fName">Full name:</label>
                    <input type="text" name="fName_card" class="custom-input" value="<?php echo $card_fname; ?>" required>
                </div>
                <div class="form-group">
                    <label for="card_lName">Last name:</label>
                    <input type="text" name="lName_card" class="custom-input" value="<?php echo $card_lname; ?>" required>
                </div>
             </div>
             <div class="combine">
                <div class="form-group">
                    <label for="card_id">Card id:</label>
                    <input type="text" name="card_id" class="custom-input" value="<?php echo $cardID; ?>" required>
                </div>
                <div class="form-group">
                    <label for="cvv">CVV:</label>
                    <input type="text" name="card_cvv" class="custom-input" value="<?php echo $card_cvv; ?>" required>
                </div>
                <div class="form-group">
                    <label for="exp_date">Expiration Date:</label>
                    <input type="date" name="exp_date" class="custom-input" value="<?php echo $exp_date; ?>" required>
                </div>
             </div>   
                <?php if ($user_payment) : ?>
                    <button type="submit" name="update_payment" class="ship_button">Update</button>
                <?php else : ?>
                    <button type="submit" name="add_payment" class="ship_button">Add</button>
                <?php endif; ?>
            <h4> Address </h4> 
             <div class="combine">
                <div class="form-group">
                    <label for="address_fName">First name:</label>
                    <input type="text" name="fName_address" class="custom-input" value="<?php echo $card_fname; ?>" required>
                </div>
                <div class="form-group">
                    <label for="address_lName">Last name:</label>
                    <input type="text" name="lName_address" class="custom-input" value="<?php echo $card_lname; ?>" required>
                </div>
             </div>
             <div class="combine">
              <div class="form-group">
                    <label for="address_detail">Address:</label>
                    <input type="text" name="address_detail" class="custom-input" value="<?php echo $card_fname; ?>" required>
              </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" name="city" class="custom-input" value="<?php echo $card_lname; ?>" required>
                </div>
             </div>
             <div class="form-group">
                    <label for="zip_code">Zip or postal code:</label>
                    <input type="text" name="zip_code" class="custom-input" value="<?php echo $card_lname; ?>" required>
                </div>
             <div class="combine">
              <div class="form-group">
                    <label for="country">Country:</label>
                    <input type="text" name="country" class="custom-input" value="<?php echo $card_fname; ?>" required>
              </div>
                <div class="form-group">
                    <label for="phone_num">Phone number:</label>
                    <input type="text" name="phone_num" class="custom-input" value="<?php echo $card_lname; ?>" required>
                </div>
             </div>
             <?php if ($user_payment) : ?>
                    <button type="submit" name="update_payment" class="ship_button">Update</button>
                <?php else : ?>
                    <button type="submit" name="add_payment" class="ship_button">Add</button>
                <?php endif; ?>
            </form>
        </div>
    </section>
</main>

<iframe src="footer.html" width="100%" height="300" frameborder="0" scrolling="no"></iframe>
</section>
</body>
</html>

<?php
include 'config.php';

if (isset($_POST['add_payment']) || isset($_POST['update_payment'])) {
    $cardType = $_POST['card_type'];
    $cardID = $_POST['card_id'];
    $card_fname = $_POST['fName_card'];
    $card_lname = $_POST['lName_card'];
    $card_cvv = $_POST['card_cvv'];
    $exp_date = $_POST['exp_date'];

    if ($user_payment) {

        $update_sql = "UPDATE payment SET 
        card_type = '$cardType', 
        card_id = '$cardID', 
        fName_card = '$card_fname', 
        lName_card = '$card_lname', 
        cvv = '$card_cvv', 
        exp_date = '$exp_date'
         WHERE username = '$account_username'";

        if ($conn->query($update_sql) === TRUE) {
            echo "<script> alert('Card updated successfully!');</script>";
        } else {
            echo "Error updating card: " . $update_sql . "<br>" . $conn->error;
        }
    } 
    else {
        // Insert a new payment record
        $insert_sql = "INSERT INTO payment (username, card_type, card_id, fName_card, lName_card, cvv, exp_date) 
        VALUES ('$account_username', '$cardType', '$cardID', '$card_fname', '$card_lname', '$card_cvv', '$exp_date')";

        if ($conn->query($insert_sql) === TRUE) {
            echo "<script> alert('Card added successfully!');</script>";
        } else {
            echo "Error adding card: " . $insert_sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>