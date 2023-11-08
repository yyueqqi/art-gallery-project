<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exhibition page</title>
    <link rel="stylesheet" href="../style/exhibition_styles.css">
</head>

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
                <li><a href="#"><img src="../image/search.png" alt="search.png"></a>
            </ul>
        </nav>
    </header>
    
    <main>
        <h2>Exhibition</h2>
        <br>
        <section class="exhibition">
             <div class="exhibition2">
                 <div class="image-ex">
              <img src="/images/van_gogh.webp" alt="Exhibition 1">
             </div>
               <div class="text-ex">
                <h3>Van Gogh Alive</h3>
                <p>From 31 March 2023</p>
                <p>2nd Floor, The Art Gallery</p>
             </div>
             <button class="buy-ticket">Buy Ticket</button>
             </div>
             <br>
             <div class="exhibition2">
                <div class="image-ex">
             <img src="/images/v" alt="Exhibition 2">
            </div>
              <div class="text-ex">
               <h3>event name</h3>
               <p>date</p>
               <p>location</p>
            </div>
            <button class="buy-ticket">Buy Ticket</button>
            </div>
            <br>
            <div class="exhibition2">
                <div class="image-ex">
             <img src="/images/" alt="Exhibition 3">
            </div>
              <div class="text-ex">
               <h3>event name</h3>
               <p>date</p>
               <p>location</p>
            </div>
            <button class="buy-ticket">Buy Ticket</button>
            </div>
          



       
            </div>
        </section>
    </main>
    
</body>
</html>