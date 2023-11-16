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
    <link rel="stylesheet" href="../style/artistpage_styles.css?v=5">
</head>
<body>
    <?php include('header.php'); ?>
    
    <main>
            <div class="art-text">
                <h1>Our Artists</h1>
                <p>***</p>
            </div>  
    </main>
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
    <?php include('footer.php'); ?>
</body>
</html>
