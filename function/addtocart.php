<?php

include 'config.php';

    if (isset($_GET['add_to_cart_artwork'])){
        global $conn;
        $account_username = $_SESSION['login_username'];
        $artwork_id = $_GET['add_to_cart_artwork'];
        $quantity = 1;
        $select = "SELECT * FROM `cart` where username = '$account_username' and item_id = '$artwork_id'";
        $result = mysqli_query($conn,$select);
        $num_row = mysqli_num_rows($result);
            if($num_row > 0) {
            echo '<script>alert("already have in CART")</script>';
            echo '<script>window.open("artworkpage.php","_self")</script>';
            }
            else {
            $insert = "INSERT INTO `cart`(username, item_id, quantity) VALUES ('$account_username', '$artwork_id', '$quantity')";
            $result_query = mysqli_query($conn,$insert);
            if($result_query) {
                echo '<script>alert("Added to cart")</script>';
                echo '<script>window.open("artworkpage.php","_self")</script>';
            }
            else {
                echo '<script>alert("Can not add to cart")</script>';
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
            }
            
            }
        }

    if (isset($_GET['add_to_cart_ticket'])){
    $account_username = $_SESSION['login_username'];
    $ticket_id = $_GET['add_to_cart_ticket'];
    $quantity = 1;
    $select = "SELECT * FROM `cart` where username = '$account_username' and item_id = '$ticket_id'";
    $result = mysqli_query($conn,$select);
    $num_row = mysqli_num_rows($result);
        if($num_row > 0) {
        echo '<script>alert("already have in CART")</script>';
        echo '<script>window.open("index.php","_self")</script>';
        }
        else {
        $insert = "INSERT INTO `cart`(username, item_id, quantity) VALUES ('$account_username', '$ticket_id', '$quantity')";
        $result_query = mysqli_query($conn,$insert);
        echo '<script>window.open("index.php","_self")</script>';
        }
    }