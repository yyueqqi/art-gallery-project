<?php

include '../function/config.php';

session_start();

if (isset($_SESSION['logged_in']) && isset($_SESSION['login_username'])) {
    $account_username = $_SESSION['login_username'];

    $clear_cart_artwork_sql = "DELETE FROM `cart_artwork` WHERE username = '$account_username'";
    $clear_cart_artwork_result = $conn->query($clear_cart_artwork_sql);

    $clear_cart_ticket_sql = "DELETE FROM `cart_ticket` WHERE username = '$account_username'";
    $clear_cart_ticket_result = $conn->query($clear_cart_ticket_sql);

    if ($clear_cart_artwork_result  AND $clear_cart_ticket_result) {
        echo '<script>alert("Order completed! Thank you for your purchase.");</script>';
        echo '<script>window.location.href = "../index.php";</script>';
    } else {
        echo '<script>alert("Error clearing cart: ' . $conn->error . '");</script>';
        echo '<script>window.location.href = "../index.php";</script>';
    }
}
?>