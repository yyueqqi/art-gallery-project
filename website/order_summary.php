<?php

include '../function/config.php';

session_start();

if (isset($_SESSION['logged_in']) && isset($_SESSION['login_username'])) {
    $account_username = $_SESSION['login_username'];

    $payment_sql = "SELECT * FROM `payment` WHERE username = '$account_username'";
    $payment_result = $conn->query($payment_sql);
    $payment_data = $payment_result->fetch_assoc();

    function star($input) {
        $prefix = substr($input, 0, 3);
        $suffix = substr($input, -1);
        $result = $prefix . str_repeat('*', 6) . $suffix;
        return $result;
    }

    $address_sql = "SELECT * FROM `address` WHERE username = '$account_username'";
    $address_result = $conn->query($address_sql);
    $address_data = $address_result->fetch_assoc();

    $total_sql = "SELECT SUM(price * quantity) AS total FROM (
        SELECT price, quantity FROM `cart_artwork` WHERE username = '$account_username'
        UNION ALL
        SELECT price, quantity FROM `cart_ticket` WHERE username = '$account_username'
     ) AS combined_cart";

    $total_result = $conn->query($total_sql);

    if ($total_result) {
        $total_data = $total_result->fetch_assoc();
        $total_price = $total_data['total'];
        if ($total_price === null) {
            $total_price = 0;
        }
    } 
    else {
        echo "Error executing query: " . $conn->error . "<br>";
        echo "SQL Query: $total_sql";
        $total_price = 0; 
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary</title>
    <link rel="stylesheet" href="../style/order_summary_styles.css">
</head>
<body>
    <?php include('header.php'); ?>

    <main>
        <section class="order-summary">
            <h6>Order Summary</h6>
            <div class="container">
                <div class="payment-details">
                    <h5>Payment Details</h5>
                    <p><strong>Card Type:</strong> <?php echo $payment_data['card_type']; ?></p>
                    <p><strong>Card ID:</strong> <?php echo star($payment_data['card_id']); ?></p>
                </div>

                <div class="shipping-address">
                    <h5>Shipping Address</h5>
                    <p><strong>Full Name:</strong> <?php echo $address_data['address_fName'] . ' ' . $address_data['address_lName']; ?></p>
                    <p><strong>Address:</strong> <?php echo $address_data['address_detail']; ?></p>
                    <p><strong>City:</strong> <?php echo $address_data['city']; ?></p>
                    <p><strong>Zip Code:</strong> <?php echo $address_data['zip_code']; ?></p>
                    <p><strong>Country:</strong> <?php echo $address_data['country']; ?></p>
                    <p><strong>Phone Number:</strong> <?php echo $address_data['phone_number']; ?></p>
                </div>
            </div>
            <div class="total-amount">
                <h5>Total Amount</h5>

                <p><strong>Total:</strong> ฿<?php echo $total_price; ?></p>
            </div>

            <form method="post" action="order_confirmation_process.php">
                <input type="hidden" name="card_id" value="<?php echo $payment_data['card_id']; ?>">
                <input type="hidden" name="address_details" value="<?php echo $address_data['address_detail']; ?>">
                <div class="btn">
                    <button type="submit" class="confirm-btn">Confirm Order</button>
                </div>
            </form>
        </section>
    </main>

    <?php include('footer.php'); ?>
</body>
</html>
