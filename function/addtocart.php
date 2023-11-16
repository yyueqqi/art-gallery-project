<?php

include 'config.php';

    if (isset($_GET['add_to_cart_artwork'])){
        global $conn;
        $account_username = $_SESSION['login_username'];
        $artwork_id = $_GET['add_to_cart_artwork'];
        $item_title = " "; 
        $item_type = "Artwork";
        $artwork_price = 0; 
        $quantity = 1;
        $select = "SELECT * FROM `cart` where username = '$account_username' and item_id = '$artwork_id'";
        $result = mysqli_query($conn, $select);
        $num_row = mysqli_num_rows($result);
        if ($num_row > 0) {
            echo '<script>alert("already have in CART")</script>';
            echo '<script>window.open("artworkpage.php","_self")</script>';
        } 
        else {
            $artwork_query = "SELECT artwork_img, artwork_title, price FROM artwork WHERE artwork_id = '$artwork_id'";
            $artwork_result = mysqli_query($conn, $artwork_query);
            $artwork_data = mysqli_fetch_assoc($artwork_result);
            
            $item_img = $artwork_data['artwork_img'];
            $item_title = $artwork_data['artwork_title'];
            $artwork_price = $artwork_data['price'];

            $insert = "INSERT INTO `cart` (username, item_img, item_id, item_title, item_type, price, quantity) VALUES ('$account_username', '$item_img', '$artwork_id', '$item_title', '$item_type', '$artwork_price', '$quantity')";
            $result_query = mysqli_query($conn, $insert);
            
            if ($result_query) {
                echo '<script>alert("Added to cart")</script>';
                echo '<script>window.open("artworkpage.php","_self")</script>';
            } else {
                echo '<script>alert("ERROR!!!")</script>';
                echo '<script>window.open("artworkpage.php","_self")</script>';
            }
        }
    }

    if (isset($_GET['add_to_cart_ticket'])){
        global $conn;
        $account_username = $_SESSION['login_username'];
        $ticket_id = $_GET['add_to_cart_ticket'];
        $item_title = " "; 
        $item_type = "Ticket";
        $ticket_price = 0; 
        $quantity = 1;
        $select = "SELECT * FROM `cart` where username = '$account_username' and item_id = '$ticket_id'";
        $result = mysqli_query($conn, $select);
        $num_row = mysqli_num_rows($result);
        if ($num_row > 0) {
            echo '<script>alert("already have in CART")</script>';
            echo '<script>window.open("exhibitionpage.php","_self")</script>';
        } 
        else {
            $ticket_query = "SELECT exhibition_id, ticket_type, price, ticket_availability FROM ticket WHERE ticket_id = '$ticket_id'";
            $ticket_result = mysqli_query($conn, $ticket_query);
            $ticket_data = mysqli_fetch_assoc($ticket_result);

            $item_exhibition = $ticket_data['exhibition_id'];
            $ticket_type = $ticket_data['ticket_type'];
            $item_type = $ticket_type . " Ticket";
    
            $exhibition_query = "SELECT exhibition_img, exhibition_title FROM exhibition WHERE exhibition_id = '$item_exhibition'";
            $exhibition_result = mysqli_query($conn, $exhibition_query);
            $exhibition_data = mysqli_fetch_assoc($exhibition_result);

            $item_img = $exhibition_data['exhibition_img'];
            $item_title = $exhibition_data['exhibition_title'];
            $ticket_price = $ticket_data['price'];

            $insert = "INSERT INTO `cart` (username, item_img, item_id, item_title, item_type, price, quantity) VALUES ('$account_username', '$item_img', '$ticket_id', '$item_title', '$item_type', '$ticket_price', '$quantity')";
            $result_query = mysqli_query($conn, $insert);
            
            if ($result_query) {
                echo '<script>alert("Added to cart")</script>';
                echo '<script>window.open("exhibitionpage.php","_self")</script>';
            } else {
                echo '<script>alert("ERROR!!!")</script>';
                echo '<script>window.open("exhibitionpage.php","_self")</script>';
            }
        }
    }
?>