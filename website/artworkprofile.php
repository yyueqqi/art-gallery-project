<?php
include '../function/config.php';

if (isset($_GET['artwork_id'])) {

    $artwork_id = $_GET['artwork_id'];

    $query = "SELECT artwork.*, artist.fName, artist.lName FROM artwork LEFT JOIN artist ON artwork.artist_id = artist.artist_id WHERE artwork_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $artwork_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $artwork = $result->fetch_assoc();
    } else {
        $artwork = null;
    }

    $stmt->close();
} else {
    $artwork = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artwork Profile Page</title>
    <link rel="stylesheet" href="../style/artworkprofile_styles.css">
</head>

<body>
    <?php include('header.php'); ?>
        <main>
            <?php if ($artwork) : ?>
                <div class="artwork-container">
                    <div class="text-frame">
                        <h4><?php echo $artwork['artwork_title']; ?></h4>
                        <p>Created by <?php echo $artwork['fName'] . ' ' . $artwork['lName']; ?></p>
                        <p><?php echo $artwork['description']; ?></p>
                        <p>Genre: <?php echo $artwork['genre']; ?></p>
                        <p>Scale: <?php echo $artwork['scale']; ?> CM</p>
                    </div>
                    <div class="image">
                        <img src="<?php echo $artwork['artwork_img']; ?>" alt="<?php echo $artwork['artwork_id']; ?>">
                    </div>
                </div>
                    <div class="price">
                        <p>฿<?php echo $artwork['price']; ?></p>
                        <a class="addtocart" href="artworkpage.php?add_to_cart_artwork=<?php echo $artwork['artwork_id'] ?>">ADD TO CART</a>
                    </div>

            <?php else : ?>
            <p>Artwork not found.</p>
            <?php endif; ?>
        </main>
        <?php include('footer.php'); ?>
</body>
</html>
           
