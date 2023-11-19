<?php
    include '../function/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Header Page</title>
   <style>
    
        body {
            background-color: #FAF8F4;
            font-family: 'Times New Roman', Times, serif;
            margin: 0; !important;
            padding: 0;
            position: relative;
        }

        header {
            background-color: #433E36;
            color: #D7CA96;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin:0;
            padding: 0.5px 35px;
            z-index: 999;
        }
        
        .left-header {
            font-size: 25px;
            color: #D7CA96;
            margin: 0;
        }
        
        .right-header {
            display: flex;
            font-size: 17px;
        }
        
        img {
            width: 20px;
            height: 20px;
        }
        
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }
        
        nav ul li {
            margin-right: 30px;
        }
        
        nav a {
            text-decoration: none;
            color: #D7CA96;
        }
        
        nav a:hover {
            color: #555;
        }
    
    </style>
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
                    <li>
                    <?php
                    session_start();
        
                    if (isset($_SESSION['logged_in'])) {
                        echo '<a href="account.php">Account</a>';
                    } else {
                        echo '<a href="loginpage.php">Log in</a>';
                    }
                    ?>
                    </li>
                    <li><a href="cart.php"><img src="../image/cart.png"></a></li>
                </ul>
            </nav>
        </header>

</body>
</html>