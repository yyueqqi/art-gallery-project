<?php
session_start();
    include '../function/config.php';
    include '../function/addtocart.php';
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
<body>
    <?php include('header.php'); ?>
    
    <main>
        <h2>Artwork in our gallery</h2>
        <section class="artwork">
            <?php foreach ($artworks as $artwork) : ?>
                <div class="art-piece">
                    <a href="artworkprofile.php?artwork_id=<?php echo $artwork['artwork_id']; ?>">
                        <div class="image">
                                <img src="<?php echo $artwork['artwork_img']; ?>" alt="<?php echo $artwork['artwork_id']; ?>">
                            <div class="text-fade">
                                <div class="text">
                                    <h3><?php echo $artwork['artwork_title']; ?></h3>
                                    <p>By <?php echo $artwork['fName'] . ' ' . $artwork['lName']; ?></p>
                                    <p>Price: $<?php echo $artwork['price']; ?></p>
                                    <a class='addtocart' href="artworkpage.php?add_to_cart_artwork=<?php echo $artwork['artwork_id'] ?>">ADD TO CART</a>
                                </div>
                            </div>
                        </div>        
                    
                </div>
                <?php endforeach; ?>
        </section>
    </main>


    <footer>
        <div class="footer-info">
            <div>
                <h4>OPEN HOURS:</h4>
                <p>Tuesday - Sunday 11AM - 6PM</p>
                <p>Close on Monday and Public Holidays</p>
                <h4>For more information:</h4>
                <p><a href="mailto:info@theart.gallery">info@theart.gallery</a></p>
            </div>

            <div>
                <h4>TEL:</h4>
                <p>090-276-7007 (Chanikarn)</p>
                <p>095-894-4145 (Kanyarat)</p>
            </div>

            <div>
                <h4>ADDRESS:</h4>
                <p>345/25-26 The Headquarters,
                Intaraporn Rd., Plubpla, Wang Thonglang, Bangkok, Thailand 10310</p>
            </div>
        </div>
    </footer>
</body>
</html>
