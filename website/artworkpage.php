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
    
    
    <section class="sub-header">
            <div class="art-text">
                <h1>ARTWORK</h1>
                <p>***</p>
            </div>  
    </section>
    <main>
        <div class="sub-heading">
            <span>Explore our artworks</span>
        </div>
        <p style="font-style: oblique;">"Embark on a visual journey through our curated art collection. Discover captivating pieces that tell stories through vibrant colors<br> and intricate details. From contemporary to classical, our gallery showcases a spectrum of artistic expressions."</p>
        <div class="artwork">
            <?php foreach ($artworks as $artwork) : ?>
                <div class="art-piece">
                    <a href="artworkprofile.php?artwork_id=<?php echo $artwork['artwork_id']; ?>">
                        <div class="image">
                                <img src="<?php echo $artwork['artwork_img']; ?>" alt="<?php echo $artwork['artwork_id']; ?>">
                            <div class="text-fade">
                                <div class="text">
                                    <h3><?php echo $artwork['artwork_title']; ?></h3>
                                    <p>By <?php echo $artwork['fName'] . ' ' . $artwork['lName']; ?></p>
                                    <p>฿<?php echo $artwork['price']; ?></p>
                                    <a class='addtocart' href="
                                    <?php
                                        if (!isset($_SESSION['logged_in']) || !isset($_SESSION['login_username'])) {
                                            echo 'javascript:void(0);" onclick="alert(\'Please log in before buying items.\'); window.location.href=\'loginpage.php\';';
                                        } else {
                                            echo 'artworkpage.php?add_to_cart_artwork=' . $artwork['artwork_id'];
                                        }
                                    ?>" >ADD TO CART</a>
                                </div>
                            </div>
                        </div>        
                    
                </div>
                <?php endforeach; ?>
        </div>
    </main>
    <?php include('footer.php'); ?>
</body>
</html>
