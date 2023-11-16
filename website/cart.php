<?php

session_start();
include '../function/config.php';

// Fetch cart items from the database
$sql = "SELECT * FROM cart";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $cart_items = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $cart_items = array();
}

$total = 0;
foreach ($cart_items as $cart_item) {
    // Determine the item type based on your database structure
    $item_type = $cart_item['item_type'];

    if ($item_type == "Artwork") {
        $total += $cart_item['price'] * $cart_item['quantity'];
    } elseif ($item_type == "Ticket") {
        $total += $cart_item['price'] * $cart_item['quantity'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="../style/cart_styles.css">
</head>
<body>

<header>
    <h1>Shopping Cart</h1>
</header>

<section>
    <table>
        <tr>
            <th>Item</th>
            <th>Item Name</th>
            <th>Type</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Delete</th>
        </tr>

        <?php foreach ($cart_items as $cart_item) : ?>
            <tr>
                <td class="image">
                    <?php
                    // Use $cart_item['item_img'] or a placeholder for the item image
                    echo "<img src=\"{$cart_item['item_img']}\" alt=\"{$cart_item['item_id']}\" width=auto height=\"100\">";
                    ?>
                </td>
                <td><?php echo $cart_item['item_title']; ?></td>
                <td><?php echo $cart_item['item_type']; ?></td>
                <td><?php echo "{$cart_item['price']} ฿"; ?></td>
                <td><?php echo $cart_item['quantity']; ?></td>
                <td><?php echo $cart_item['price'] * $cart_item['quantity'] . " ฿"; ?></td>
                <td><button class="remove-btn">Remove</button></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div class="total-section">
        <strong>Total: $<?php echo $total; ?></strong>
    </div>

    <div class="checkout-section">
        <button class="checkout-btn">Checkout</button>
    </div>
</section>

</body>
</html>
