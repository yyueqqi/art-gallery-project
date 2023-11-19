<?php
    include '../function/config.php';

    $sql = "SELECT * FROM `artist`";
    $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $artists = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $artists = array();
        }

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artist Page</title>
    <link rel="stylesheet" href="../style/artistpage_styles.css">
</head>
<body>
    <?php include('header.php'); ?>

    <section class="sub-header">
            <div class="art-text">
                <h1>ARTIST</h1>
                <p>***</p>
            </div>  
        </section>
    <main>
        <div class="sub-heading">
            <span>Represented artists</span>
        </div>
        <p style="font-style: oblique;">"Delve into the captivating world of artists at our gallery. Explore the diverse talents and creative expressions of both emerging and established artists.<br>From painters to sculptors, each artist brings a unique perspective to the canvas of our gallery. Uncover the stories behind their masterpieces<br> and discover the passion that drives their artistic journey."</p>
        <section class="artists">
        <?php foreach ($artists as $artist) : ?>
        
        <div class="artist">

            <div class="artist-profile">
                <a href="artistprofile.php?artist_id=<?php echo $artist['artist_id']; ?>"><img src="<?php echo $artist['artist_profile']; ?>" alt="<?php echo $artist['artist_id']; ?>">
                </a>
            </div> 
            
            <div class="name">
                <p><?php echo $artist['fName'] . ' ' . $artist['lName']; ?></p>
            </div>

        </div>
        <?php endforeach; ?>
        </section>
    </main>
    <?php include('footer.php'); ?>
</body>
</html>
