<?php
    include '../function/config.php';

    $sql = "SELECT * FROM `exhibition`";
    $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $exhibitions = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $exhibitions = array();
        }

    $conn->close();
?>

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
        <h4>Explore boundless creativity at our Bangkok art gallery, a hub of passion for the arts.</h4>
        <h4>Discover a curated blend of local and global expressions, from traditional to contemporary.  </h4>
        <h4>Our online platform invites you to delve into the beauty, inspiration, and stories behind each masterpiece. </h4>
        <h4>Join us in celebrating Bangkok's rich art scene on our website. Welcome to our inspiring journey!</h4>
        <section class="exhibitions">
            <?php foreach ($exhibitions as $exhibition) : ?>
                <div class="exhibition2">
                    <div class="container">
                        <div class="image-ex">
                              <img src="<?php echo $exhibition['exhibition_img']; ?>" alt="<?php echo $exhibition['exhibition_id']; ?>" class="image">
                            <div class="overlay">
                                <div class="text">
                                    <h3>Exhibition Title: <?php echo $exhibition['exhibition_title']; ?></h3>
                                    <p>Date: <?php echo $exhibition['exhibition_date']; ?></p>
                                    <p>Location: <?php echo $exhibition['location']; ?></p>
                                    <button class="buy-ticket">Buy Ticket</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>

    </main>

            </div>
        </section>
    </main>
    
</body>
</html>