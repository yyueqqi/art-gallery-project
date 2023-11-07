<?php
    include '../function/config.php';

    $sql = "SELECT artwork.*, artist.fName, artist.lName FROM artwork LEFT JOIN artist ON artwork.artist_id = artist.artist_id";
    $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $artworks = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $artworks = array();
        }

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artwork Page</title>
    <link rel="stylesheet" href="../style/artworkpage_styles.css">
</head>

<header>
    <div class="left-header">
        <p>The Art Gallery</p>
    </div>
    <div class="right-header">
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="artistpage.php">Artists</a></li>
                <li><a href="artworkpage.php">Artwork</a></li>
                <li><a href="#">Exhibition</a></li>
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
        <h2>Artwork in our gallery</h2>
        <section class="artwork">
            <?php foreach ($artworks as $artwork) : ?>
                <div class="art-piece">
                    <img src="<?php echo $artwork['image_path']; ?>" alt="<?php echo $artwork['artwork_title']; ?>">
                    <h3><?php echo $artwork['artwork_title']; ?></h3>
                    <p>Artist: <?php echo $artwork['fName'] . ' ' . $artwork['lName']; ?></p>
                    <p>Description: $<?php echo $artwork['description']; ?></p>
                    <p>Price: $<?php echo $artwork['price']; ?></p>
                    <button class="buy-button">Buy Now</button>
                </div>
                <?php endforeach; ?>
        </section>
    </main>

</body>
</html>
