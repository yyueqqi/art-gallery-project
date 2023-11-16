<?php

    session_start();
    include '../function/config.php';

    // Fetch cart items from the database
    $sql = "SELECT * FROM cart";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $cart_items = $result->fetch_all(MYSQLI_ASSOC);
    } 
    else {
        $cart_items = array();
    }

    $total = 0;
    foreach ($cart_items as $cart_item) {
        // Determine the item type based on your database structure
        $item_type = $cart_item['item_type'];

        if ($item_type == "Artwork") {
            $total += $cart_item['price'] * $cart_item['quantity'];
        } 
        elseif ($item_type == "vip Ticket" || $item_type == "general Ticket" || $item_type == "student Ticket") {
            $total += $cart_item['price'] * $cart_item['quantity'];
        }
    }

    if (isset($_POST['delete_item'])) {
        $item_id_to_delete = $_POST['item_id'];
        
        // Perform the deletion from the database based on your table structure
        $delete_sql = "DELETE FROM `cart` WHERE item_id = $item_id_to_delete";
        $delete_result = $conn->query($delete_sql);
        
        // You can add additional checks and messages based on the deletion result
        if ($delete_result) {
            echo '<script>alert("Item deleted successfully")</script>';
        } else {
            echo '<script>alert("Error deleting item")</script>';
        }

        // Redirect to refresh the page after deletion
        echo '<script>window.location.href = "cart.php";</script>';
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
    <script src="../script/script.js"></script>
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
                <td class="counter">
                    <span class="down" onClick='decreaseCount(event, this)'>-</span>
                    <input type="text" value="<?php echo $cart_item['quantity']; ?>">
                    <span class="up" onClick='increaseCount(event, this)'>+</span>
                </td>
                <td><?php echo $cart_item['price'] * $cart_item['quantity'] . " ฿"; ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="item_id" value="<?php echo $cart_item['item_id']; ?>">
                        <button type="submit" name="delete_item" class="remove-btn">Remove</button>
                    </form>
                </td>
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
