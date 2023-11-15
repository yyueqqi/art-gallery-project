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
    <link rel="stylesheet" href="../style/artistprofile_styles.css">
</head>

<body>
<?php include('header.php'); ?>
        <main>
            <?php if ($artist) : ?>
                <div class="artist-profile">
                    <h2><?php echo $artist['fName'] . ' ' . $artist['lName']; ?></h2>
                    <p>Date of Birth: <?php echo $artist['dob']; ?></p>
                    <p>Artwork History: <?php echo $artist['artwork_history']; ?></p>
                </div>
            <?php else : ?>
                <p>Artist not found.</p>
            <?php endif; ?>
        </main>
    <iframe src="footer.html" width="100%" height="300" frameborder="0" scrolling="no"></iframe>
</body>
</html>
