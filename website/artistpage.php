<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artist Page</title>
    <link rel="stylesheet" href="../style/artistpage_styles.css">
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
                    <li><a href="artistpage.html">Artists</a></li>
                    <li><a href="artworkpage.php">Artwork</a></li>
                    <li><a href="#">Exhibition</a></li>
                    <li>
                    <?php
                    session_start();
    
                        if (isset($_SESSION['logged_in'])) {
                            echo '<a href="../function/logout.php">Log out</a>';
                        }
                        else {
                            echo '<a href="loginpage.php">Log in</a>';
                        }
                    ?>
                    </li>
                    <li><a href="#"><img src="../image/search.png" alt="search.png"></a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <main>
        <h2>Our Artists</h2>
        <section class="artists">
            <div class="artist">
                <a href="artist_profile.html">
                    <img src="../image/artist1.jpeg" alt="Artist 1">
                    <p>Reyneir Llane</p>
                </a>
            </div>
            
            <div class="artist">
                <a href="artist_profile.html">
                    <img src="artist2.jpg" alt="Artist 2">
                    <p>Artist Name 2</p>
                </a>
            </div>
            
            <div class="artist">
                <a href="artist_profile.html">
                    <img src="artist3.jpg" alt="Artist 3">
                    <p>Artist Name 3</p>
                </a>
            </div>

            <div class="artist">
                <a href="artist_profile.html">
                    <img src="artist4.jpg" alt="Artist 4">
                    <p>Artist Name 4</p>
                </a>
            </div>
        </section>
    </main>
</body>
</html>
