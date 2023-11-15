<?php
session_start();

include 'config.php';

    if (isset($_GET['add_to_cart_artwork']))
    $account_username = $_SESSION['login_username'];
    $artwork_id = $_GET['add_to_cart'];
    $quantity = 1;
    $select = "SELECT * FROM 'cart' where username = '$account_usernam' and item_id = '$artwork_id'";
    $result = mysqli_query($conn,$select);
    $num_row = mysqli_num_rows($result);
        if($num_row > 0) {
        echo '<script>alert("already have in CART")</script>';
        echo '<script>window.open("index.php","_self")</script>';
        else {
        $insert = "INSERT INTO'cart'(username, item_id, quantity) VALUES ('$username', '$artwork_id', '$quantity')";
        $result_query = mysqli_query($conn,$insert);
        echo '<script>window.open("index.php","_self")</script>';
        }
    }

    if (isset($_GET['add_to_cart_ticket']))
    $account_username = $_SESSION['login_username'];
    $ticket_id = $_GET['add_to_cart'];
    $quantity = 1;
    $select = "SELECT * FROM 'cart' where username = '$account_usernam' and item_id = '$ticket_id'";
    $result = mysqli_query($conn,$select);
    $num_row = mysqli_num_rows($result);
        if($num_row > 0) {
        echo '<script>alert("already have in CART")</script>';
        echo '<script>window.open("index.php","_self")</script>';
        else {
        $insert = "INSERT INTO'cart'(username, item_id, quantity) VALUES ('$username', '$ticket_id', '$quantity')";
        $result_query = mysqli_query($conn,$insert);
        echo '<script>window.open("index.php","_self")</script>';
        }
    }