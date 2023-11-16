<?php
include '../function/config.php';

if (isset($_GET['artist_id'])) {
    $artist_id = $_GET['artist_id'];

    $query = "SELECT * FROM `artist` WHERE artist_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $artist_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $artist = $result->fetch_assoc();
    } else {
        $artist = null;
    }

    $stmt->close();
} else {
    $artist = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artist Profile Page</title>
    <link rel="stylesheet" href="../style/artistprofile_styles.css?v=5">
</head>

<body>
<?php include('header.php'); ?>
        <main>
            <?php if ($artist) : ?>
                <div class="artist-container">
                    <div class="image">
                        <img src="<?php echo $artist['artist_profile']; ?>" alt="<?php echo $artist['artist_id']; ?>">
                    </div>

                    <div class="text-frame">
                        <h2><?php echo $artist['fName'] . ' ' . $artist['lName']; ?></h2>
                        <p>Date of Birth: <?php echo $artist['dob']; ?></p>
                        <p>Artwork History: <?php echo $artist['artwork_history']; ?></p>
                    </div>
                </div>

                <div class="artwork-history">
                    <h4>Artwork History</h4>
                    <p> <?php echo $artist['artwork_history']; ?></p>
                </div>

            <?php else : ?>
                <p>Artist not found.</p>
            <?php endif; ?>
        </main>
        <?php include('footer.php'); ?>
</body>
</html>
