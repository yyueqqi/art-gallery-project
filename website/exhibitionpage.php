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
        <section class="exhibitions">
        <?php foreach ($exhibitions as $exhibition) : ?>
            <div class="exhibition2">
            <div class="image-ex">
                <img src="<?php echo $exhibition['exhibition_img']; ?>" alt="<?php echo $exhibition['exhibition_id']; ?>">
            </div>
            <div class="text-ex">
                <h3>Exhibition Title: <?php echo $exhibition['exhibition_title']; ?></h3>
                <p>Date: <?php echo $exhibition['exhibition_date']; ?></p>
                <p>Location: <?php echo $exhibition['location']; ?></p>
            </div>
            </a>
            <button class="buy-ticket">Buy Ticket</button>
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