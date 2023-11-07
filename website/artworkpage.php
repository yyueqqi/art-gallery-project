<?php

    include '../function/config.php';

    $sql = "SELECT * FROM artwork";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $artworks = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $artworks = array(); 
    }

    echo json_encode($artworks);

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
                    echo '<a href="../function/logout.php">Log out</a>';
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
            <div class="art-piece">
                <img src="artwork1.jpg" alt="Artwork 1">
                <h3>Artwork Title 1</h3>
                <p>Artist: Artist Name 1</p>
                <p>Price: $100</p>
                <button class="buy-button">Buy Now</button>
            </div>
            
            <div class="art-piece">
                <img src="artwork2.jpg" alt="Artwork 2">
                <h3>Artwork Title 2</h3>
                <p>Artist: Artist Name 2</p>
                <p>Price: $150</p>
                <button class="buy-button">Buy Now</button>
            </div>
            
            <div class="art-piece">
                <img src="artwork3.jpg" alt="Artwork 3">
                <h3>Artwork Title 3</h3>
                <p>Artist: Artist Name 3</p>
                <p>Price: $120</p>
                <button class="buy-button">Buy Now</button>
            </div>

            <div class="art-piece">
                <img src="artwork4.jpg" alt="Artwork 4">
                <h3>Artwork Title 4</h3>
                <p>Artist: Artist Name 3</p>
                <p>Price: $120</p>
                <button class="buy-button">Buy Now</button>
            </div>
        </section>
    </main>

    <script>
    // Function to fetch and display artwork
    function fetchArtwork() {
        // Fetch artwork data from the PHP script
        fetch('fetch_artwork.php')
            .then(response => response.json())
            .then(data => {
                // Code to display artwork data
                const artworkContainer = document.querySelector('.artwork');
                artworkContainer.innerHTML = '';

                data.forEach(artwork => {
                    const artPiece = document.createElement('div');
                    artPiece.className = 'art-piece';

                    // Create elements for artwork details
                    const img = document.createElement('img');
                    img.src = artwork.image_url;
                    img.alt = artwork.title;

                    const title = document.createElement('h3');
                    title.textContent = artwork.title;

                    const artist = document.createElement('p');
                    artist.textContent = 'Artist: ' + artwork.artist;

                    const price = document.createElement('p');
                    price.textContent = 'Price: $' + artwork.price;

                    // Create a Buy Now button or any other action you need
                    const buyButton = document.createElement('button');
                    buyButton.className = 'buy-button';
                    buyButton.textContent = 'Buy Now';

                    // Append elements to the art piece
                    artPiece.appendChild(img);
                    artPiece.appendChild(title);
                    artPiece.appendChild(artist);
                    artPiece.appendChild(price);
                    artPiece.appendChild(buyButton);

                    // Append the art piece to the artwork container
                    artworkContainer.appendChild(artPiece);
                });
            })
            .catch(error => console.error('Error fetching artwork:', error));
    }

    // Call the fetchArtwork function to load artwork when the page loads
    fetchArtwork();
</script>
    
</body>
</html>
