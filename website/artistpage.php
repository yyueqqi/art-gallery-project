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
        <?php foreach ($artists as $artist) : ?>
        <div class="artist">
                <img src="<?php echo $artist['artist_profile']; ?>" alt="<?php echo $artist['artist_id']; ?>">
                <p>Artist Name: <?php echo $artist['fName'] . ' ' . $artist['lName']; ?></p>
                <p>Date of Birth: <?php echo $artist['dob']; ?></p>
                <p>Artwork History: <?php echo $artist['artwork_history']; ?></p>
            </a>
        </div>
        <?php endforeach; ?>
    </section>
    </main>

</body>
</html>
