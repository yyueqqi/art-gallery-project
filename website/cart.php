<?php

session_start();
include '../function/config.php';

if (isset($_SESSION['logged_in']) && isset($_SESSION['login_username'])) {
    $account_username = $_SESSION['login_username'];


    $sql_ticket = "SELECT * FROM cart_ticket WHERE username = '$account_username'";
    $result_ticket = $conn->query($sql_ticket);

    $sql_artwork = "SELECT * FROM cart_artwork WHERE username = '$account_username'";
    $result_artwork = $conn->query($sql_artwork);

    $cart_items = array();

    if ($result_ticket->num_rows > 0) {
        $cart_items = array_merge($cart_items, $result_ticket->fetch_all(MYSQLI_ASSOC));
    }

    if ($result_artwork->num_rows > 0) {
        $cart_items = array_merge($cart_items, $result_artwork->fetch_all(MYSQLI_ASSOC));
    }

} 
else {
    echo '<script>alert("Please log in to see your cart!");</script>';
}

$total = 0;
foreach ($cart_items as $cart_item) {
    $item_type = $cart_item['item_type'];

    if ($item_type == "Artwork" || $item_type == "vip Ticket" || $item_type == "general Ticket" || $item_type == "student Ticket") {
        $total += $cart_item['price'] * $cart_item['quantity'];
    }
}

if (isset($_POST['delete_item'])) {
    $item_id_to_delete = $_POST['item_id'];
    $item_type_to_delete = $_POST['item_type'];

    //echo "Item ID: $item_id_to_delete, Item Type: $item_type_to_delete";

    if ($item_type_to_delete == "vip Ticket" || $item_type_to_delete == "general Ticket" || $item_type_to_delete == "student Ticket") {
        $delete_sql = "DELETE FROM `cart_ticket` WHERE item_id = $item_id_to_delete";
        $delete_result = $conn->query($delete_sql);

        if ($delete_result) {
            echo '<script>alert("Item deleted successfully")</script>';
        } else {
            echo '<script>alert("Error deleting item: ' . $conn->error . '")</script>';
        }
    } 
    elseif ($item_type_to_delete == "Artwork") {
        $delete_sql = "DELETE FROM `cart_artwork` WHERE item_id = $item_id_to_delete";
        $delete_result = $conn->query($delete_sql);
        
        if ($delete_result) {
            echo '<script>alert("Item deleted successfully")</script>';
        } else {
            echo '<script>alert("Error deleting item")</script>';
        }
    }
    echo '<script>window.open("cart.php","_self")</script>';
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
<?php include('header.php'); ?>

<main>
    <h1>Shopping Cart</h1>


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

        <?php foreach ($cart_items as $cart_item) : 
                $cart_id = $cart_item['cart_id'];
            ?>
                
                <tr>
                <td class="image">
                    <?php
                    echo "<img src=\"{$cart_item['item_img']}\" alt=\"{$cart_item['item_id']}\" width=auto height=\"150\">";
                    ?>
                </td>
                <td><?php echo $cart_item['item_title']; ?></td>
                <td class="item-type"><?php echo $cart_item['item_type']; ?></td>
                <td class="price"><?php echo "{$cart_item['price']} ฿"; ?></td>
                <td class="counter">
                    <div class="counter-wrapper">
                       <a href="cart.php?decrease=<?php echo $cart_id ?>"><span class="down">-</span></a> 
                        <input type="text" value="<?php echo $cart_item['quantity']; ?>">
                       <a href="cart.php?increase=<?php echo $cart_id ?>"><span class="up">+</span></a> 
                    </div>
                </td>
                <td class="total-price"><?php echo $cart_item['price'] * $cart_item['quantity'] . " ฿"; ?></td>
                <td>
                <form method="post" action="cart.php">
                    <input type="hidden" name="item_id" value="<?php echo $cart_item['item_id']; ?>">
                    <input type="hidden" name="item_type" value="<?php echo $cart_item['item_type']; ?>">
                    <button type="submit" name="delete_item" class="remove-btn">Remove</button>
                </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div class="total-section">
        <strong id="totalAmount">Total: ฿<?php echo $total; ?></strong>
    </div>

    <div class="checkout-section">
        <form method="post" action="order_summary.php">
        <button class="checkout-btn">Checkout</button>
        </form>
    </div>
</section>
</main>

<?php include('footer.php'); ?>
</body>
</html>

<?php
if (isset($_GET['increase'])) {
    $cart_id = $_GET['increase'];

     $select_cart_ticket = "SELECT * FROM `cart_ticket` WHERE cart_id = '$cart_id'";
     $result_ticket = mysqli_query($conn, $select_cart_ticket);
     $row_ticket = mysqli_fetch_assoc($result_ticket);

    $select_cart_artwork = "SELECT * FROM `cart_artwork` WHERE cart_id = '$cart_id'";
    $result_artwork = mysqli_query($conn, $select_cart_artwork);
    $row_artwork = mysqli_fetch_assoc($result_artwork);

    if (!empty($row_ticket)) {
        $quantity = $row_ticket['quantity'] + 1;
        $sql = "UPDATE `cart_ticket` SET `quantity` = '$quantity' WHERE cart_id = '$cart_id'";
        $result = mysqli_query($conn, $sql);
    } 
    elseif (!empty($row_artwork)) {
        $quantity = $row_artwork['quantity'] + 1;
        $sql = "UPDATE `cart_artwork` SET `quantity` = '$quantity' WHERE cart_id = '$cart_id'";
        $result = mysqli_query($conn, $sql);
    }

    echo '<script>window.open("cart.php","_self")</script>';
}

if (isset($_GET['decrease'])) {
    $cart_id = $_GET['decrease'];

    $select_cart_ticket = "SELECT * FROM `cart_ticket` WHERE cart_id = '$cart_id'";
    $result_ticket = mysqli_query($conn, $select_cart_ticket);
    $row_ticket = mysqli_fetch_assoc($result_ticket);

    $select_cart_artwork = "SELECT * FROM `cart_artwork` WHERE cart_id = '$cart_id'";
    $result_artwork = mysqli_query($conn, $select_cart_artwork);
    $row_artwork = mysqli_fetch_assoc($result_artwork);

    if (!empty($row_ticket)) {
        $quantity = $row_ticket['quantity'];
        if ($quantity > 1) {
            $quantity--;
            $sql = "UPDATE `cart_ticket` SET `quantity` = '$quantity' WHERE cart_id = '$cart_id'";
            $result = mysqli_query($conn, $sql);
        }
    } elseif (!empty($row_artwork)) {
        $quantity = $row_artwork['quantity'];
        if ($quantity > 1) {
            $quantity--;
            $sql = "UPDATE `cart_artwork` SET `quantity` = '$quantity' WHERE cart_id = '$cart_id'";
            $result = mysqli_query($conn, $sql);
        }
    }

    echo '<script>window.open("cart.php","_self")</script>';
}


?>
